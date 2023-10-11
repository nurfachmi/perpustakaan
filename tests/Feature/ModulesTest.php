<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('can\'t access modules page (unauthenticated)', function () {
    $response = get(route('modules.index'));

    $response->assertStatus(302);
    $response->assertRedirectToRoute('login');
});

test('can access modules page (authenticated)', function (User $user) {
    actingAs($user);

    $response = get(route('modules.index'));

    $response->assertStatus(200);
    $response->assertViewIs('pages.module.index');
    $response->assertSeeText('Modules');
})->with('user_admin');
