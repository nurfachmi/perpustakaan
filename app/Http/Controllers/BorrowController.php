<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowStoreRequest;
use App\Models\Borrow;
use App\Models\Card;
use Illuminate\Http\Request;

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
            // cek sedang meminjam atau tidak
            $card = Card::firstWhere('number', $request->number);
            $cek = Borrow::whereBelongsTo($card->user)->whereNull('return_at')->first();
            if ($cek) throw new \Exception('Ada peminjaman yang sedang berjalan');
            // END of cek sedang meminjam atau tidak

            $borrow = new Borrow();
            $borrow->user_id = $card->user->getKey();
            $borrow->save();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrow $borrow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrow $borrow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrow $borrow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrow $borrow)
    {
        //
    }
}
