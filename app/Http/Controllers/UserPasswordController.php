<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\WelcomeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserPasswordController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            $data['title'] = 'Set Password for ' . $user->name;
            $data['user'] = $user;
        } catch (\Throwable $th) {
            Log::error(
                $th->getMessage(),
                [
                    'action' => 'Set password user',
                    'data' => $user ?? null
                ]
            );
            return to_route('users.index')->withToastError($th->getMessage());
        }

        return view('pages.user.set-password', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);
        try {
            DB::beginTransaction();
            $user->password = bcrypt($request->password);
            if (is_null($user->email_verified_at)) {
                $user->email_verified_at = now();
                $user->notify(new WelcomeNotification($user));
            }
            $user->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error(
                $th->getMessage(),
                [
                    'action' => 'Set password user',
                    'data' => $user ?? null
                ]
            );

            return to_route('users.reset.show', $user->getKey())->withToastError($th->getMessage());
        }

        return to_route('users.index')->withToastSuccess('Password set successfully!');
    }
}
