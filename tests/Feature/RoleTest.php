<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('can\'t access roles page (unauthenticated)', function () {
    $response = get(route('roles.index'));

    $response->assertStatus(302);
    $response->assertRedirectToRoute('login');
});

test('can access roles page (authenticated)', function (User $user) {
    actingAs($user);

    $response = get(route('roles.index'));

    $response->assertStatus(200);
    $response->assertViewIs('pages.role.index');
    $response->assertSeeText('Roles');
})->with('user_admin');
