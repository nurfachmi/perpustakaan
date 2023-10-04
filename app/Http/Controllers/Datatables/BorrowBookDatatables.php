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
    public function __invoke(Request $request, Borrow $borrow)
    {
        $data = BorrowBook::where('borrow_id', $borrow->getKey());
        return DataTables::of($data)->toJson();
    }
}
