<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('can\'t access members page (unauthenticated)', function () {
    $response = get(route('members.index'));

    $response->assertStatus(302);
    $response->assertRedirectToRoute('login');
});

test('can access members page (authenticated)', function (User $user) {
    actingAs($user);

    $response = get(route('members.index'));

    $response->assertStatus(200);
    $response->assertViewIs('pages.member.index');
    $response->assertSeeText('Members');
})->with('user_pustakawan');
