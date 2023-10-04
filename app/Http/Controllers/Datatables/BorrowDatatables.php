<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BorrowDatatables extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = Borrow::with('user')->orderBy('start_at')->orderBy('return_at');
        return DataTables::of($data)
            ->addColumn('name', function ($row) {
                $url = route('borrows.borrow_books.index', $row->getKey());
                return "<a href='$url'>" . $row->user->name . " / " . $row->user->card->number . "</a>";
            })
            ->addColumn('status', function ($row) {
                if (empty($row->return_at)) return "Active";
                return "Done";
            })
            ->addColumn('late_days', function ($row) {
                return $row->late_days;
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->whereHas('user', function ($user) use ($keyword) {
                    $user->where('name', 'like', "%$keyword%")
                        ->orWhereHas('card', function ($card) use ($keyword) {
                            $card->where('number', 'like', "%$keyword%");
                        });
                });
            })
            ->rawColumns(['name'])
            ->toJson();
    }
}
