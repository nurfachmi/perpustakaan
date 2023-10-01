<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Card;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private $title = 'User';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = str($this->title)->plural();
        return view('pages.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'New ' . $this->title;
        $data['roles'] = Role::select('id', 'name')->whereNot('name', User::ROLE_ANGGOTA)->get();
        return view('pages.user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = fake()->word();
            $user->remember_token = Password::getRepository()->create($user);
            $user->save();
            $user->assignRole($request->role);

            $card = new Card();
            $card->user_id = $user->getKey();
            $card->number = str($user->getKey())->padLeft(5, '0');
            $card->start_date = now();
            $card->end_date = now()->addYear();
            $card->save();
            DB::commit();
            $user->notify(new NewUserNotification($user));
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error(
                $th->getMessage(),
                [
                    'action' => 'Store user',
                    'data' => $request->all()
                ]
            );
            return to_route('users.index')->withToastError($th->getMessage());
        }

        return to_route('users.index')->withToastSuccess($this->title . ' created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return self::edit($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $data['title'] = 'Edit ' . $this->title;
        $data['user'] = $user;
        $data['roles'] = Role::select('id', 'name')->whereNot('name', User::ROLE_ANGGOTA)->get();
        return view('pages.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            $user->name = $request->name;
            $user->email = $request->email;
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
                $user->remember_token = Password::getRepository()->create($user);
            }
            $user->save();
            $user->syncRoles($request->role);
            DB::commit();

            if (is_null($user->email_verified_at)) {
                $user->notify(new NewUserNotification($user));
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error(
                $th->getMessage(),
                [
                    'action' => 'Delete user',
                    'data' => $user
                ]
            );
            return to_route('users.index')->withToastError($th->getMessage());
        }
        return to_route('users.index')->withToastSuccess($this->title . ' updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();
            $user->delete();
            DB::commit();

            return response()->json([
                'msg' => $this->title . ' deleted successfully!'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error(
                $th->getMessage(),
                [
                    'action' => 'Delete user',
                    'data' => $user
                ]
            );

            return response()->json([
                'msg' => $th->getMessage()
            ]);
        }

    }
}
