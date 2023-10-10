<?php

use App\Models\User;

dataset('user_admin', function () {
    return yield function () {
        $user = User::factory()->create();
        $user->assignRole(User::ROLE_ADMINISTRATOR);

        return $user;
    };
});

dataset('user_pustakawan', function () {
    return yield function () {
        $user = User::factory()->create();
        $user->assignRole(User::ROLE_PUSTAKAWAN);

        return $user;
    };
});
