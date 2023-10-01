<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Roles';
        return view('pages.role.index', $data);
    }
}
