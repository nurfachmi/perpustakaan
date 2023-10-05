<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Book;

class BookController extends Controller
{
    private $title = "Book";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = str($this->title)->plural();
        return view("pages.book.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = str($this->title)->plural();
        $data['category'] = Category::all();
        return view("pages.book.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $book = new Book();
        $book->title = $request->title;
        $book->isbn = $request->isbn;
        $book->author = $request->author;
        $book->category_id = $request->category;
        $book->save();

        return to_route('books.index')->withToastSuccess($this->title . ' created successfully!');
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
        $data['title'] = 'Edit ' . $this->title;
        $data['book'] = $book;
        $data['category'] = Category::all();
        return view('pages.book.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $book->title = $request->title;
        $book->isbn = $request->isbn;
        $book->author = $request->author;
        $book->category_id = $request->category;
        $book->save();

        return to_route('books.index')->withToastSuccess($this->title . ' updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json([
                'msg' => $this->title . ' deleted successfully!'
            ], 200);
    }
}
