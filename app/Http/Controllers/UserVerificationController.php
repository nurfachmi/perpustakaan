<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerificationUserRequest;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($email, $token)
    {
        try {
            DB::beginTransaction();

            $user = User::whereEmail($email)->first();

            if (!$user) {
                throw new \Exception('Pengguna tidak ditemukan.');
            }

            if ($user->remember_token != $token) {
                throw new \Exception('Token tidak ditemukan.');
            }

            $data['email'] = $email;
            $data['token'] = $token;

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage(), [
                'action' => '[GET] Verifikasi user',
                'user' => $user ?? null
            ]);

            return to_route('login')->withToastError('Oops! ' . $th->getMessage());
        }

        return view('pages.auth.set-password', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VerificationUserRequest $request, $email, $token)
    {
        try {
            DB::beginTransaction();

            $user = User::firstWhere('email', $email);

            if (!$user) {
                throw new \Exception('Pengguna tidak ditemukan.');
            }

            if ($user->remember_token != $token) {
                throw new \Exception('Token tidak ditemukan.');
            }

            $user->email_verified_at = now();
            $user->remember_token = null;
            $user->password = bcrypt($request->password);
            $user->save();
            DB::commit();
            $user->notify(new WelcomeNotification($user));
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage(), [
                'action' => '[POST] Verifikasi user',
                'user' => $user ?? null
            ]);

            return to_route('user-verification.index', [$email, $token])->withToastError('Oops! ' . $th->getMessage());
        }

        return to_route('login')->withToastSuccess('Congratulation! Your account is ready');
    }
}
