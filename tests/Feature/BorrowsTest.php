<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('can\'t access borrows page (unauthenticated)', function () {
    $response = get(route('borrows.index'));

    $response->assertStatus(302);
    $response->assertRedirectToRoute('login');
});

test('can access borrows page (authenticated)', function (User $user) {
    actingAs($user);

    $response = get(route('borrows.index'));

    $response->assertStatus(200);
    $response->assertViewIs('pages.borrow.index');
    $response->assertSeeText('Borrowing Books');
})->with('user_admin');
