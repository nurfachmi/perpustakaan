<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\BorrowBook;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BorrowBookDatatables extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Borrow $borrow)
    {
        $data = BorrowBook::with(['borrow', 'book'])->where('borrow_id', $borrow->getKey())->orderByDesc('updated_at');
        return DataTables::of($data)
        ->editColumn('return_at', function ($row) {
            return $row->return_at ? 'Returned' : '-';
        })
        ->addColumn('title', function ($row) {
            return $row->book->title;
        })
        ->toJson();
    }
}
