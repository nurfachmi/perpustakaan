<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Nwidart\Modules\Facades\Module;

class ModuleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        $data['title'] = 'Modules';
        return view('pages.module.index', $data);
    }

    public function store(Request $request)
    {
        try {
            $module = Module::find($request->module);

            if (!$module) {
                throw new \Exception($request->module . ' module not found');
            }

            if ($module->isEnabled()) {
                $module->disable();
                $status = 'disabled';
            } else {
                $module->enable();
                $status = 'enabled';
            }
        } catch (\Throwable $th) {
            Log::error(
                $th->getMessage(),
                [
                    'action' => 'Update module status',
                    'data' => $request->module
                ]
            );

            return to_route('modules.index')->withToastError($th->getMessage());
        }

        return to_route('modules.index')->withToastSuccess($module->getName() . ' module ' . $status . ' successfully');
    }
}
