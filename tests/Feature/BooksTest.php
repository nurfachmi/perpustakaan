<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('can\'t access books page (unauthenticated)', function () {
    $response = get(route('books.index'));

    $response->assertStatus(302);
    $response->assertRedirectToRoute('login');
});

test('can access books page (authenticated)', function (User $user) {
    actingAs($user);

    $response = get(route('books.index'));

    $response->assertStatus(200);
    $response->assertViewIs('pages.book.index');
    $response->assertSeeText('Data Buku');
})->with('user_admin');
