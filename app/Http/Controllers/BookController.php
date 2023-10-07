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

    private $title = "Buku";
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Data ' . $this->title;
        return view("pages.book.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = $this->title . ' Baru';
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

        return to_route('books.index')->withToastSuccess($this->title . ' berhasil disimpan');
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
        $data['title'] = 'Ubah ' . $this->title;
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

        return to_route('books.index')->withToastSuccess($this->title . ' berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json([
            'msg' => $this->title . ' berhasil dihapus'
        ], 200);
    }
}
