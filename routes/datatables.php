<?php

use App\Http\Controllers\Datatables\MemberDatatables;
use App\Http\Controllers\Datatables\ModuleDatatables;
use App\Http\Controllers\Datatables\RoleDatatables;
use App\Http\Controllers\Datatables\UserDatatables;
use Illuminate\Support\Facades\Route;

Route::get('roles', RoleDatatables::class)->name('roles');
Route::get('users', UserDatatables::class)->name('users');
Route::get('modules', ModuleDatatables::class)->name('modules');
Route::get('members', MemberDatatables::class)->name('members');