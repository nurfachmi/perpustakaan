<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleDatatables extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = Role::latest('created_at');
        return DataTables::of($data)
            ->editColumn('name', function ($row) {
                return "<a href='" . route('permissions.index', $row->getKey()) . "'>" . $row->name . "</a>";
            })
            ->rawColumns(['name'])
            ->toJson();
    }
}
