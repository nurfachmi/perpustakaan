<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nwidart\Modules\Facades\Module;
use Yajra\DataTables\DataTables;

class ModuleDatatables extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $modules = Module::all();
        $data = [];
        foreach ($modules as $key => $module) {
            array_push($data, [
                'name' => $key
            ]);
        }

        return DataTables::of($data)
            ->addColumn('enabled', function ($row) {
                $status = self::status($row['name']) ? '✅' : '❌';
                return $status;
            })
            ->addColumn('action', function ($row) {
                $module = Module::find($row['name']);
                $data['status'] = self::status($row['name']);
                $data['module'] = $module->getName();

                return view('pages.module.action', $data);
            })
            ->rawColumns(['enabled', 'action'])
            ->toJson();
    }

    private function status($module) {
        $status = Module::isEnabled($module) ? true : false;
        return $status;
    }
}
