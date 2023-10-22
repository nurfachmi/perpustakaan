<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MemberDatatables extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = User::role(User::ROLE_ANGGOTA)->orderBy('name');
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $data = [
                    'edit_url'     => route('members.edit', ['member' => $row->getKey()]),
                    'delete_url'   => route('members.destroy', ['member' => $row->getKey()]),
                    'redirect_url' => route('members.index'),
                    'send_card_url' => route('members.send.card', ['member' => $row->getKey()]),
                    'name'         => $row->name,
                    'resource'     => 'members',
                    'custom_links' => []
                ];

                array_push($data['custom_links'], ['label' => 'Set Password', 'url' => route('users.reset.show', ['user' => $row->getKey()]), 'name' => 'users.reset.show']);

                return view('components.datatable-action', $data);
            })
            ->editColumn('name', function ($row) {
                return "<a href='" . route('members.show', $row->getKey()) . "' title='Detail' alt='Detail'>$row->name</a>";
            })
            ->addColumn('kartu', function ($row) {
                return $row->card->number;
            })
            ->rawColumns(['name', 'action'])
            ->toJson();
    }
}
