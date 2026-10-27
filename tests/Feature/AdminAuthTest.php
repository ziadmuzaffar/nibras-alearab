<?php

use App\Models\User;

test('unauthenticated users are redirected from protected admin routes to login', function () {
    $this->get('/admin/dashboard')->assertRedirect(route('admin.login'));
    $this->get('/admin/categories')->assertRedirect(route('admin.login'));
    $this->get('/admin/products')->assertRedirect(route('admin.login'));
    $this->get('/admin/users')->assertRedirect(route('admin.login'));
});

test('inactive authenticated user is logged out and redirected to login', function () {
    $user = User::factory()->create([
        'is_active' => false,
    ]);

    $response = $this->actingAs($user)->get(route('admin.dashboard'));

    $response->assertRedirect(route('admin.login'));
    $this->assertGuest();
});

test('authenticated user visiting login page is redirected to dashboard', function () {
    $user = User::factory()->create([
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->get(route('admin.login'));

    $response->assertRedirect(route('admin.dashboard'));
});
