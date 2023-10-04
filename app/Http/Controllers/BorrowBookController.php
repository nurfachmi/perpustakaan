<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\BorrowBook;
use Illuminate\Http\Request;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BorrowBook $borrowBook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BorrowBook $borrowBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BorrowBook $borrowBook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BorrowBook $borrowBook)
    {
        //
    }
}
