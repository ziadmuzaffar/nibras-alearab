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

test('login page renders with Arabic translations and RTL by default', function () {
    $response = $this->get(route('admin.login'));

    $response->assertOk();
    $response->assertSee('dir="rtl"', false);
    $response->assertSee('lang="ar"', false);
    $response->assertSee(__('login.page_title'));
    $response->assertSee(__('login.submit_button'));
});

test('login page switches to English and renders with LTR and English translations', function () {
    $response = $this->withSession(['locale' => 'en'])->get(route('admin.login'));

    $response->assertOk();
    $response->assertSee('dir="ltr"', false);
    $response->assertSee('lang="en"', false);
    $response->assertSee('Sign In');
    $response->assertSee('Admin Panel Login');
});
