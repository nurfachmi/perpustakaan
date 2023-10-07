<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Book;
use App\Traits\Randomizer;

class BookController extends Controller
{
    use Randomizer;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = __('buku.title.index');
        return view("pages.book.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = __('buku.title.create');
        $data['category'] = Category::all();
        return view("pages.book.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookStoreRequest $request)
    {
        $book = Book::create($request->validated());

        if (is_null($request->isbn)) $this->createISBN($book);

        return to_route('books.index')->withToastSuccess(__('buku.flash.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return self::edit($book);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $data['title'] = __('buku.title.edit');
        $data['book'] = $book;
        $data['category'] = Category::all();
        return view('pages.book.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
        $book->update($request->validated());

        return to_route('books.index')->withToastSuccess(__('buku.flash.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json([
            'msg' => __('buku.flash.destroy')
        ], 200);
    }
}
