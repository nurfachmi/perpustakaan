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
        $query = Book::orderBy('title');
        return DataTables::of($query)
        ->addColumn('action', function ($row) {
                $data = [
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
                    ],
                    [
                     'label' => 'Delete',
                     'url' => route('books.destroy', ['book' => $row->getKey()]),
                     'books' => 'books.destroy'
                    ]
                );

                return view('components.datatable-action', $data);
            })
            ->toJson();
    }
}
