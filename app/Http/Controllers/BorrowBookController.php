<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\BorrowBook;
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
    public function store(Request $request, Borrow $borrow)
    {
        try {
            DB::beginTransaction();

            // cek keberadaan buku
            // $book = Book::firstWhere([
            //     'isbn' => $request->isbn
            // ]);
            // if (!$book) throw new \Exception('Book not found');
            // END of cek keberadaan buku

            // cek selesai atau belum
            if ($borrow->return_at) throw new \Exception('Borrowing is over. No action further.');

            if (empty($borrow->start_at)) {
                // proses peminjaman
                $borrow->borrow_books()->create([
                    'isbn' => $request->isbn
                ]);
                $borrow->increment('books_borrowed');

                $text = 'Book scanned successfully';
            } else {
                // proses pengembalian
                $book = BorrowBook::query()
                    ->whereNull('return_at')
                    ->where([
                        'borrow_id' => $borrow->getKey(),
                        'isbn' => $request->isbn
                    ])
                    ->first();
                if (!$book) throw new \Exception('Book not found');

                $book->return_at = now();
                $book->save();
                $book->borrow()->increment('books_returned');

                $text = 'Book returned successfully';
            }
            DB::commit();

            return redirect()->back()->withToastSuccess($text);
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
