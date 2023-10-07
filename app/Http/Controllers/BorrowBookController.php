<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowBookStoreRequest;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\BorrowBook;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BorrowBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Borrow $borrow)
    {
        $data['title'] = 'Borrow #' . str($borrow->getKey())->padLeft(5, 0);
        $data['borrow'] = $borrow;
        return view('pages.borrow.book.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BorrowBookStoreRequest $request, Borrow $borrow)
    {
        try {
            DB::beginTransaction();

            // cek keberadaan buku
            $book = Book::firstWhere([
                'isbn' => $request->number
            ]);
            if ($book) {
                if (empty($borrow->start_at)) {
                    // proses peminjaman
                    $borrow->borrow_books()->create([
                        'isbn' => $request->number
                    ]);
                    $borrow->increment('books_borrowed');

                    $text = 'Book scanned successfully';
                } else {
                    // proses pengembalian
                    $book = BorrowBook::query()
                        ->whereNull('return_at')
                        ->where([
                            'borrow_id' => $borrow->getKey(),
                            'isbn' => $request->number
                        ])
                        ->first();
                    if (!$book) throw new \Exception('Book not found');

                    $book->return_at = now();
                    $book->save();
                    $book->borrow()->increment('books_returned');

                    $text = 'Book returned successfully';

                }
                DB::commit();

                return to_route('borrows.borrow_books.index', $borrow->getKey())->withToastSuccess($text);
            }
            // END of cek keberadaan buku

            // cek kesesuaian kartu
            $card = Card::firstWhere('number', $request->number);
            if ($borrow->user()->isNot($card->user)) throw new \Exception('Member card number doesn\'t fit');
            // END of cek kesesuaian kartu

            // konfirmasi peminjaman buku
            if ($card and !$borrow->start_at) {
                // handle jika buku masih kosong
                if ($borrow->borrow_books->count() < 1) throw new \Exception('Anda belum menginput buku sama sekali');
                // END of handle jika buku masih kosong

                $borrow->start_at = now();
                $borrow->end_at = now()->addDays(config('perpustakaan.borrow_days'));
                $borrow->save();
                $text = 'Borrowing Books started';
            } else if ($card and $borrow->start_at) {
                $borrow->return_at = now();
                $borrow->save();
                $text = 'Borrowing ends successfully';
            }
            DB::commit();

            return to_route('borrows.borrow_books.index', $borrow->getKey())->withToastSuccess($text);
            // END of konfirmasi pengembalian buku

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error(
                $th->getMessage(),
                [
                    'action' => 'Store borrow book',
                    'data' => $request->all()
                ]
            );

            return to_route('borrows.borrow_books.index', $borrow->getKey())->withToastError($th->getMessage());
        }
    }
}
