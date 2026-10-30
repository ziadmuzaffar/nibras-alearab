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
                'name' => [
                    'ar' => 'علب التغليف الفاخر والشحن',
                    'en' => 'Luxury Packaging & Shipping Boxes',
                ],
                'slug' => 'luxury-packaging-boxes',
                'icon' => 'fa-solid fa-box-open',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'كروت شخصية وبطاقات عمل',
                    'en' => 'Business & Visiting Cards',
                ],
                'slug' => 'business-cards',
                'icon' => 'fa-solid fa-id-card',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'أكياس ورقية وقماشية فاخرة',
                    'en' => 'Luxury Paper & Fabric Bags',
                ],
                'slug' => 'paper-and-fabric-bags',
                'icon' => 'fa-solid fa-bag-shopping',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'كتب وكتالوجات ومجلات',
                    'en' => 'Books, Catalogues & Magazines',
                ],
                'slug' => 'books-and-catalogues',
                'icon' => 'fa-solid fa-book-open',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'ستيكرات ولواصق المنتجات',
                    'en' => 'Product Labels & Stickers',
                ],
                'slug' => 'labels-and-stickers',
                'icon' => 'fa-solid fa-tags',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'مطبوعات تجارية ومراسلات',
                    'en' => 'Corporate Stationery & Prints',
                ],
                'slug' => 'corporate-stationery',
                'icon' => 'fa-solid fa-print',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'بنرات ورول اب وستاندات عرض',
                    'en' => 'Banners, Roll-Ups & Display Stands',
                ],
                'slug' => 'banners-and-rollups',
                'icon' => 'fa-solid fa-flag',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'دروع وهدايا دعائية تذكارية',
                    'en' => 'Trophies & Promotional Gifts',
                ],
                'slug' => 'promotional-gifts',
                'icon' => 'fa-solid fa-gift',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'أختام رسمية ومعتمدة',
                    'en' => 'Official Certified Stamps',
                ],
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
