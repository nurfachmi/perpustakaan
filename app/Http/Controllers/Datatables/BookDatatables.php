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
        $query = Book::all();
        return DataTables::of($query)
        ->addColumn('action', function ($row) {
                $data = [
                    'edit_url'     => route('books.edit', ['book' => $row->getKey()]),
                    'delete_url'   => route('books.destroy', ['book' => $row->getKey()]),
                    'redirect_url' => route('books.index'),
                    'name'         => $row->title,
                    'resource'     => 'books',
                    'custom_links' => []
                ];

                array_push($data['custom_links'],
                    [
                     'label' => 'Edit',
                     'url' => route('books.edit', ['book' => $row->getKey()]),
                     'books' => 'books.index'
                    ]
                );

                return view('components.datatable-action', $data);
            })
            ->toJson();
    }
}
