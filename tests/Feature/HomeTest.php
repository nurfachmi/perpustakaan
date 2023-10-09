<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('can\'t access home page (unauthenticated)', function () {
    $response = get(route('home'));

    $response->assertStatus(302);
    $response->assertRedirectToRoute('login');
});

test('can access home page (authenticated)', function () {
    $user = User::factory()->create();

    actingAs($user);

    $response = get(route('home'));

    $response->assertStatus(200);
    $response->assertViewIs('pages.home');
    $response->assertSeeText('Home');
});
