<?php

use App\Models\Product;
use App\Models\QuoteRequest;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'is_active' => true,
    ]);
});

test('unauthenticated users cannot access quote requests management', function () {
    $this->get(route('admin.quote-requests.index'))->assertRedirect(route('admin.login'));
    $this->get(route('admin.quote-requests.create'))->assertRedirect(route('admin.login'));
});

test('admin can view quote requests index page', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.quote-requests.index'));

    $response->assertOk();
    $response->assertViewIs('pages.admin.quote-requests.index');
    $response->assertViewHas(['quoteRequests', 'stats', 'products']);
});

test('admin can view create quote request form', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.quote-requests.create'));

    $response->assertOk();
    $response->assertViewIs('pages.admin.quote-requests.create');
    $response->assertViewHas(['products', 'statuses']);
});

test('admin can store a new quote request', function () {
    $product = Product::first();

    $payload = [
        'customer_name' => 'محمد عبدالله الأحمد',
        'phone' => '0509988776',
        'email' => 'mohammed@example.com',
        'product_id' => $product?->id,
        'quantity' => 1500,
        'status' => 'pending',
        'notes' => 'طلب تسعير علب فاخرة مع تشطيب مذهب.',
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.quote-requests.store'), $payload);

    $response->assertRedirect(route('admin.quote-requests.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('quote_requests', [
        'customer_name' => 'محمد عبدالله الأحمد',
        'phone' => '0509988776',
        'quantity' => 1500,
    ]);
});

test('admin can view single quote request details', function () {
    $quote = QuoteRequest::first() ?? QuoteRequest::create([
        'customer_name' => 'عميل تجريبي',
        'phone' => '0501112233',
        'status' => 'pending',
    ]);

    $response = $this->actingAs($this->admin)->get(route('admin.quote-requests.show', $quote));

    $response->assertOk();
    $response->assertViewIs('pages.admin.quote-requests.show');
    $response->assertViewHas(['quoteRequest', 'relatedRequests', 'statuses']);
});

test('admin can view edit form and update quote request', function () {
    $quote = QuoteRequest::first() ?? QuoteRequest::create([
        'customer_name' => 'عميل تجريبي للتعديل',
        'phone' => '0551234567',
        'status' => 'pending',
    ]);

    $editResponse = $this->actingAs($this->admin)->get(route('admin.quote-requests.edit', $quote));
    $editResponse->assertOk();
    $editResponse->assertViewIs('pages.admin.quote-requests.edit');

    $updatePayload = [
        'customer_name' => 'الاسم بعد التعديل',
        'phone' => '0559998877',
        'email' => 'updated@example.com',
        'product_id' => $quote->product_id,
        'quantity' => 2000,
        'status' => 'contacted',
        'notes' => 'تم التواصل وتعديل الكمية.',
    ];

    $response = $this->actingAs($this->admin)
        ->put(route('admin.quote-requests.update', $quote), $updatePayload);

    $response->assertRedirect(route('admin.quote-requests.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('quote_requests', [
        'id' => $quote->id,
        'customer_name' => 'الاسم بعد التعديل',
        'status' => 'contacted',
        'quantity' => 2000,
    ]);
});

test('admin can quick update status of quote request', function () {
    $quote = QuoteRequest::first() ?? QuoteRequest::create([
        'customer_name' => 'عميل تغيير الحالة',
        'phone' => '0551112222',
        'status' => 'pending',
    ]);

    $response = $this->actingAs($this->admin)
        ->patch(route('admin.quote-requests.update-status', $quote), [
            'status' => 'completed',
        ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('quote_requests', [
        'id' => $quote->id,
        'status' => 'completed',
    ]);
});

test('admin can delete quote request', function () {
    $quote = QuoteRequest::create([
        'customer_name' => 'عميل للحذف',
        'phone' => '0599999999',
        'status' => 'pending',
    ]);

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.quote-requests.destroy', $quote));

    $response->assertRedirect(route('admin.quote-requests.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('quote_requests', [
        'id' => $quote->id,
    ]);
});
