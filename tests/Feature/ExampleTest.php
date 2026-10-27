<?php

test('unauthenticated users are redirected to login when visiting admin', function () {
    $response = $this->get('/admin');

    $response->assertRedirect(route('admin.login'));
});

test('authenticated users can access admin dashboard', function () {
    $user = \App\Models\User::factory()->create([
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->get(route('admin.dashboard'));

    $response->assertStatus(200);
});
