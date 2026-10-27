<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'علب التغليف الفاخر والشحن',
                'slug' => 'luxury-packaging-boxes',
                'icon' => 'fa-solid fa-box-open',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'كروت شخصية وبطاقات عمل',
                'slug' => 'business-cards',
                'icon' => 'fa-solid fa-id-card',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'أكياس ورقية وقماشية فاخرة',
                'slug' => 'paper-and-fabric-bags',
                'icon' => 'fa-solid fa-bag-shopping',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'كتب وكتالوجات ومجلات',
                'slug' => 'books-and-catalogues',
                'icon' => 'fa-solid fa-book-open',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'ستيكرات ولواصق المنتجات',
                'slug' => 'labels-and-stickers',
                'icon' => 'fa-solid fa-tags',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'مطبوعات تجارية ومراسلات',
                'slug' => 'corporate-stationery',
                'icon' => 'fa-solid fa-print',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'بنرات ورول اب وستاندات عرض',
                'slug' => 'banners-and-rollups',
                'icon' => 'fa-solid fa-flag',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'دروع وهدايا دعائية تذكارية',
                'slug' => 'promotional-gifts',
                'icon' => 'fa-solid fa-gift',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'أختام رسمية ومعتمدة',
                'slug' => 'official-stamps',
                'icon' => 'fa-solid fa-stamp',
                'order' => 9,
                'is_active' => false,
            ],
        ];

        foreach ($categories as $data) {
            Category::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
