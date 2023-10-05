<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowDestroyRequest;
use App\Http\Requests\BorrowStoreRequest;
use App\Http\Requests\BorrowUpdateRequest;
use App\Models\Borrow;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Borrowing Books';
        return view('pages.borrow.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'New Borrowing Books';
        return view('pages.borrow.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BorrowStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            // cek sedang meminjam atau tidak
            $card = Card::with('user')->firstWhere('number', $request->number);
            $cek = Borrow::whereBelongsTo($card->user)->whereNull('return_at')->first();
            if ($cek) throw new \Exception('Ada peminjaman yang sedang berjalan');
            // END of cek sedang meminjam atau tidak

            $borrow = new Borrow();
            $borrow->user_id = $card->user->getKey();
            // $borrow->start_at = now();
            // $borrow->end_at = now()->addDays(config('perpustakaan.borrow_days'));
            $borrow->save();
            DB::commit();

            return to_route('borrows.borrow_books.index', $borrow->getKey())->withToastSuccess('Please scan the books');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error(
                $th->getMessage(),
                [
                    'action' => 'New borrow',
                    'data' => $request->all()
                ]
            );
            return to_route('borrows.create')->withToastError($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BorrowUpdateRequest $request, Borrow $borrow)
    {
        try {
            DB::beginTransaction();
            // cek kesesuaian kartu
            $card = Card::firstWhere('number', $request->number);
            if ($borrow->user()->isNot($card->user)) throw new \Exception('Member card number doesn\'t fit');
            // END of cek kesesuaian kartu

            if (empty($borrow->start_at)) {
                // proses peminjaman
                $borrow->start_at = now();
                $borrow->end_at = now()->addDays(config('perpustakaan.borrow_days'));
                $borrow->save();
                DB::commit();
                return to_route('borrows.index', $borrow->getKey())->withToastSuccess('Borrowing Books success');
            } else {
                // proses pengembalian
                $borrow->return_at = now();
                $borrow->save();
                DB::commit();
                return to_route('borrows.borrow_books.index', $borrow->getKey())->withToastSuccess('Borrowing ends successfully');
            }


        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error(
                $th->getMessage(),
                [
                    'action' => 'Update borrowing',
                ]
            );

            return redirect()->back()->withToastError($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BorrowDestroyRequest $request, Borrow $borrow)
    {
        try {
            DB::beginTransaction();

            // cek kesesuaian kartu
            $card = Card::with('user')->firstWhere('number', $request->number);
            if ($borrow->user()->isNot($card->user)) throw new \Exception('Member card number doesn\'t fit');
            // END of cek kesesuaian kartu

            $borrow->borrow_books()->delete();
            $borrow->delete();
            DB::commit();

            return to_route('borrows.index')->withToastSuccess('Deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error(
                $th->getMessage(),
                [
                    'action' => 'Delete borrowing',
                ]
            );

            return redirect()->back()->withToastError($th->getMessage());
        }
    }
}
