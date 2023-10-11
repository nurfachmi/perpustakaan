<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('can\'t access users page (unauthenticated)', function () {
    $response = get(route('users.index'));

    $response->assertStatus(302);
    $response->assertRedirectToRoute('login');
});

test('can access users page (authenticated)', function (User $user) {
    actingAs($user);

    $response = get(route('users.index'));

    $response->assertStatus(200);
    $response->assertViewIs('pages.user.index');
    $response->assertSeeText('Users');
})->with('user_admin');
