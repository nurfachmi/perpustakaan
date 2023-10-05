<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BookDatatables extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $query = Book::with("category")->orderBy('title');
        return DataTables::of($query)
        ->addColumn('action', function ($row) {
                $data = [
                    'edit_url'     => route('books.edit', ['book' => $row->getKey()]),
                    'delete_url'   => route('books.destroy', ['book' => $row->getKey()]),
                    'redirect_url' => route('books.index'),
                    'name'         => $row->title,
                    'resource'     => 'members',
                ];

                return view('components.datatable-action', $data);
            })
            ->editColumn('title', function ($row) {
                return "<a href='" . route('books.show', $row->getKey()) . "' title='Detail' alt='Detail'>$row->title</a>";
            })
            ->addColumn('category_id', function ($row) {
                return $row->category->category_name; // Access the author's name from the relationship
            })
            ->rawColumns(["title"])
            ->toJson();
    }
}
