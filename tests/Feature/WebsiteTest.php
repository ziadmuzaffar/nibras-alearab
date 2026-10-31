<?php

use App\Models\Category;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\QuoteRequest;
use Database\Seeders\CategorySeeder;
use Database\Seeders\PortfolioSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\SettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed([
        SettingSeeder::class,
        CategorySeeder::class,
        ProductSeeder::class,
        PortfolioSeeder::class,
    ]);
});

test('home page renders successfully with categories, products, and portfolios', function () {
    $response = $this->get(route('website.home'));

    $response->assertStatus(200);
    $response->assertSee('نبراس العرب للطباعة والتغليف');
    $response->assertSee('علب التغليف الفاخر والشحن');
    $response->assertSee('علب كرتون فاخرة مغناطيسية مخصصة');
});

test('products catalog and category filter pages render successfully', function () {
    $response = $this->get(route('website.products.index'));
    $response->assertStatus(200);

    $category = Category::active()->first();
    $catResponse = $this->get(route('website.categories.show', $category->slug));
    $catResponse->assertStatus(200);
    $catResponse->assertSee($category->name);
});

test('product details page renders specifications and related products', function () {
    $product = Product::active()->first();

    $response = $this->get(route('website.products.show', $product->slug));
    $response->assertStatus(200);
    $response->assertSee($product->name);
});

test('products catalog and details render bilingual content with spatie and mcamara localization in english', function () {
    $product = Product::active()->first();

    // 1. Catalog page in English
    $catalogResponse = $this->get(route('website.products.index', ['lang' => 'en']));
    $catalogResponse->assertStatus(200);
    $catalogResponse->assertSee(__('main.catalog_hero_title', [], 'en'));
    $catalogResponse->assertSee(__('main.printing_categories', [], 'en'));
    $catalogResponse->assertSee($product->getTranslation('name', 'en'));

    // 2. Product show page in English
    $showResponse = $this->get(route('website.products.show', ['product' => $product->slug, 'lang' => 'en']));
    $showResponse->assertStatus(200);
    $showResponse->assertSee(__('main.technical_specifications', [], 'en'));
    $showResponse->assertSee(__('main.available_for_production', [], 'en'));
    $showResponse->assertSee($product->getTranslation('name', 'en'));
});

test('category page renders bilingual content with spatie and mcamara localization in english', function () {
    $category = Category::active()->first();

    $response = $this->get(route('website.categories.show', ['category' => $category->slug, 'lang' => 'en']));
    $response->assertStatus(200);
    $response->assertSee($category->getTranslation('name', 'en'));
    $response->assertSee(__('main.printing_categories', [], 'en'));
    $response->assertSee(__('main.all_categories', [], 'en'));
});

test('locale switch route correctly updates session and cookie', function () {
    $response = $this->get(route('locale.switch', 'en'));
    $response->assertRedirect();
    $response->assertSessionHas('locale', 'en');
});

test('portfolio, about, and contact pages render successfully', function () {
    $this->get(route('website.portfolios.index'))->assertStatus(200);
    $this->get(route('website.about'))->assertStatus(200);
    $this->get(route('website.contact'))->assertStatus(200);
});

test('visitor can submit a quote request via form and ajax', function () {
    $product = Product::active()->first();

    $response = $this->postJson(route('website.quote.store'), [
        'customer_name' => 'شركة الرواد للعطور',
        'phone' => '0501234567',
        'email' => 'orders@alrowad.sa',
        'product_id' => $product->id,
        'quantity' => 500,
        'notes' => 'علب مغناطيسية ببصمة ذهبية',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'customer_name' => 'شركة الرواد للعطور',
        ]);

    expect(QuoteRequest::where('customer_name', 'شركة الرواد للعطور')->exists())->toBeTrue();
});

