<?php

use App\Models\Category;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\SettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed([
        SettingSeeder::class,
        CategorySeeder::class,
    ]);

    $this->admin = User::factory()->create([
        'is_active' => true,
    ]);
});

test('admin categories index page renders with mcamara and spatie translations from main.php in arabic and english', function () {
    $category = Category::first();

    // 1. In Arabic
    $responseAr = $this->actingAs($this->admin)->get(route('admin.categories.index', ['lang' => 'ar']));
    $responseAr->assertOk();
    $responseAr->assertSee(__('main.categories_management', [], 'ar'));
    $responseAr->assertSee(__('main.total_categories', [], 'ar'));
    $responseAr->assertSee($category->getTranslation('name', 'ar'));

    // 2. In English
    $responseEn = $this->actingAs($this->admin)->get(route('admin.categories.index', ['lang' => 'en']));
    $responseEn->assertOk();
    $responseEn->assertSee(__('main.categories_management', [], 'en'));
    $responseEn->assertSee(__('main.total_categories', [], 'en'));
    $responseEn->assertSee($category->getTranslation('name', 'en'));
});

test('admin category create page displays bilingual name inputs and translations from main.php', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.categories.create', ['lang' => 'en']));
    $response->assertOk();
    $response->assertSee(__('main.add_new_category', [], 'en'));
    $response->assertSee(__('main.category_name_ar', [], 'en'));
    $response->assertSee(__('main.category_name_en', [], 'en'));
});

test('admin can create category with bilingual names using spatie translatable', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
        'name' => 'علب مخصصة فاخرة',
        'name_en' => 'Luxury Custom Boxes',
        'slug' => 'luxury-custom-boxes',
        'icon' => 'box',
        'order' => 10,
        'is_active' => 1,
    ]);

    $response->assertRedirect(route('admin.categories.index'));

    $created = Category::where('slug', 'luxury-custom-boxes')->first();
    expect($created)->not->toBeNull();
    expect($created->getTranslation('name', 'ar'))->toBe('علب مخصصة فاخرة');
    expect($created->getTranslation('name', 'en'))->toBe('Luxury Custom Boxes');
});

test('admin category edit page renders bilingual inputs and category show renders translations', function () {
    $category = Category::first();

    // 1. Edit page
    $editResponse = $this->actingAs($this->admin)->get(route('admin.categories.edit', ['category' => $category, 'lang' => 'en']));
    $editResponse->assertOk();
    $editResponse->assertSee(__('main.edit_category', [], 'en'));
    $editResponse->assertSee($category->getTranslation('name', 'ar'));
    $editResponse->assertSee($category->getTranslation('name', 'en'));

    // 2. Show page
    $showResponse = $this->actingAs($this->admin)->get(route('admin.categories.show', ['category' => $category, 'lang' => 'en']));
    $showResponse->assertOk();
    $showResponse->assertSee(__('main.category_details', [], 'en'));
    $showResponse->assertSee(__('main.category_info_detailed', [], 'en'));
    $showResponse->assertSee($category->getTranslation('name', 'ar'));
    $showResponse->assertSee($category->getTranslation('name', 'en'));
});

test('admin can update category with new translations', function () {
    $category = Category::first();

    $response = $this->actingAs($this->admin)->put(route('admin.categories.update', $category), [
        'name' => 'علب محدثة',
        'name_en' => 'Updated Boxes',
        'slug' => $category->slug,
        'icon' => 'fa-solid fa-boxes-stacked',
        'order' => 5,
        'is_active' => 1,
    ]);

    $response->assertRedirect(route('admin.categories.index'));

    $category->refresh();
    expect($category->getTranslation('name', 'ar'))->toBe('علب محدثة');
    expect($category->getTranslation('name', 'en'))->toBe('Updated Boxes');
});

