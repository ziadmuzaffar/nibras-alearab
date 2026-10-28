<?php

use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'is_active' => true,
    ]);
});

test('unauthenticated users cannot access reports or dashboard', function () {
    $this->get(route('admin.reports.index'))->assertRedirect(route('admin.login'));
    $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
});

test('admin can view dashboard with live metrics and charts data', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

    $response->assertOk();
    $response->assertViewIs('pages.admin.dashboard');
    $response->assertViewHas([
        'totalQuotes',
        'pendingQuotes',
        'inProgressQuotes',
        'completedQuotes',
        'totalProducts',
        'recentQuotes',
        'last7Days',
        'statusBreakdown',
    ]);
});

test('admin can view reports index page with KPIs and chart feeds', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.reports.index'));

    $response->assertOk();
    $response->assertViewIs('pages.admin.reports.index');
    $response->assertViewHas([
        'totalQuotes',
        'pendingQuotes',
        'totalQuantity',
        'conversionRate',
        'trendData',
        'statusBreakdown',
        'topProductsData',
        'categoryDemandData',
        'topProductsList',
        'detailedQuotes',
    ]);
});

test('admin can filter reports by period presets and status', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.reports.index', [
        'period' => 'last_7_days',
        'status' => 'pending',
    ]));

    $response->assertOk();
    $response->assertViewHas('period', 'last_7_days');
    $response->assertViewHas('statusFilter', 'pending');
});

test('admin can export filtered reports to CSV', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.reports.export', [
        'period' => 'this_month',
    ]));

    $response->assertOk();
    $this->assertStringContainsString('text/csv', $response->headers->get('Content-Type'));
    $this->assertStringContainsString('attachment;', $response->headers->get('Content-Disposition'));
});
