<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Portfolio;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Portfolio::query()->delete();

        $portfolios = [
            [
                'title' => [
                    'ar' => 'تصميم وتنفيذ علب فاخرة لمجموعة عطور ملكية',
                    'en' => 'Design & Production of Luxury Boxes for a Royal Perfume Collection',
                ],
                'client_name' => [
                    'ar' => 'دار الطيب الملكي للعطور',
                    'en' => 'Dar Al-Teeb Royal Perfumes',
                ],
                'category_slug' => 'luxury-packaging-boxes',
                'image' => 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=800&q=80',
                'description' => [
                    'ar' => 'مشروع متكامل شمل تصميم وتصنيع علب مغناطيسية صلبة مع بطانة مخملية مخصصة لزجاجات العطور وطباعة بصمة ذهبية بارزة على ورق ناعم الملمس.',
                    'en' => 'A turnkey project encompassing the design and manufacturing of rigid magnetic boxes with custom velvet inserts for perfume bottles and raised gold foil stamping on soft-touch paper.',
                ],
            ],
            [
                'title' => [
                    'ar' => 'إنتاج كراتين شحن وهوية التغليف لمتجر إلكتروني',
                    'en' => 'Corrugated Shipping Boxes & Packaging Identity for E-Commerce Store',
                ],
                'client_name' => [
                    'ar' => 'متجر شمس للتجارة الإلكترونية',
                    'en' => 'Shams E-Commerce Store',
                ],
                'category_slug' => 'luxury-packaging-boxes',
                'image' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&w=800&q=80',
                'description' => [
                    'ar' => 'تصنيع 10,000 كرتون شحن مضلع بثلاثة مقاسات مختلفة مع طباعة شعار المتجر من الداخل والخارج لتقديم تجربة فتح صندوق مبتكرة للعملاء.',
                    'en' => 'Production of 10,000 corrugated shipping boxes across three sizes with interior and exterior brand printing to deliver an engaging unboxing experience.',
                ],
            ],
            [
                'title' => [
                    'ar' => 'بطاقات أعمال قطنية فاخرة مع حواف مذهبة',
                    'en' => 'Luxury Cotton Business Cards with Gilded Gold Edges',
                ],
                'client_name' => [
                    'ar' => 'مكتب التميمي للمحاماة والاستشارات',
                    'en' => 'Al-Tamimi Law & Consultancy Firm',
                ],
                'category_slug' => 'business-cards',
                'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80',
                'description' => [
                    'ar' => 'تنفيذ بطاقات أعمال من الورق القطني الفاخر 600 جرام بتقنية اللتربرس الغائر مع تذهيب الحواف يدوياً باللون الذهبي اللامع للشركاء والمحامين.',
                    'en' => 'Crafted 600gsm pure cotton business cards featuring deep letterpress debossing and hand-gilded metallic gold edges for senior partners and attorneys.',
                ],
            ],
            [
                'title' => [
                    'ar' => 'أكياس تسوق كرافت بيئية لسلسلة مقاهي عصرية',
                    'en' => 'Eco-Friendly Kraft Shopping Bags for a Specialty Coffee Chain',
                ],
                'client_name' => [
                    'ar' => 'سلسلة مقاهي إكسير البن',
                    'en' => 'Elixir Coffee Roasters',
                ],
                'category_slug' => 'paper-and-fabric-bags',
                'image' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=800&q=80',
                'description' => [
                    'ar' => 'تزويد سلسلة المقاهي بأكياس تسوق ورقية صديقة للبيئة من ورق الكرافت البني بمقابض مجدولة وقاعدة مدعمة قادرة على حمل أكواب القهوة والمخبوزات بأمان.',
                    'en' => 'Supplied eco-friendly brown kraft paper bags with twisted handles and reinforced bases engineered to safely carry specialty coffee cups and bakery items.',
                ],
            ],
            [
                'title' => [
                    'ar' => 'طباعة وتجليد التقارير السنوية وبروفايل الشركة',
                    'en' => 'Annual Financial Reports & Hardcover Company Profile Printing',
                ],
                'client_name' => [
                    'ar' => 'مجموعة الراجحي الاستثمارية',
                    'en' => 'Al-Rajhi Investment Group',
                ],
                'category_slug' => 'books-and-catalogues',
                'image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=800&q=80',
                'description' => [
                    'ar' => 'طباعة التقرير المالي والسنوي لعام 2025 بتجليد حراري فاخر (Hardcover) مع لمسات سبوت يو في وسلفنة ناعمة للغلاف وألوان أوفست دقيقة.',
                    'en' => 'Printed and bound the 2025 annual financial report with luxury hardcover binding, Spot UV highlights, soft-touch cover lamination, and high-precision offset colors.',
                ],
            ],
            [
                'title' => [
                    'ar' => 'ملصقات منتجات مقاومة للماء والزيوت لعلامة مستحضرات تجميل',
                    'en' => 'Water & Oil Resistant Product Labels for a Natural Cosmetics Brand',
                ],
                'client_name' => [
                    'ar' => 'لورين للعناية الطبيعية',
                    'en' => 'Laurene Natural Skincare',
                ],
                'category_slug' => 'labels-and-stickers',
                'image' => 'https://images.unsplash.com/photo-1572375992501-4b0892d50c69?auto=format&fit=crop&w=800&q=80',
                'description' => [
                    'ar' => 'طباعة وقص ليزري دقيق لاستيكرات فينيل مقاومة للرطوبة والزيوت مع لمعان مطفي وفويل وردي ذهبي (Rose Gold) للعبوات الزجاجية.',
                    'en' => 'Precision laser-cut waterproof and oil-resistant vinyl labels finished with matte lamination and Rose Gold foil stamping for glass skincare jars.',
                ],
            ],
            [
                'title' => [
                    'ar' => 'تجهيز أجنحة المعرض ورول اب للمؤتمر السنوي للتقنية',
                    'en' => 'Exhibition Booths & Roll-Up Displays for Annual Tech Summit',
                ],
                'client_name' => [
                    'ar' => 'الاتحاد السعودي للابتكار التقني',
                    'en' => 'Saudi Tech Innovation Federation',
                ],
                'category_slug' => 'banners-and-rollups',
                'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80',
                'description' => [
                    'ar' => 'تصنيع وطباعة 50 ستاند رول اب عالي الدقة بدون لمعان مع جدران العرض البوب اب (Pop-up) لتجهيز الصالة الرئيسية للمؤتمر والمعرض المصاحب.',
                    'en' => 'Produced and printed 50 anti-glare high-resolution roll-up stands and pop-up backdrop walls to outfit the main conference hall and exhibition floor.',
                ],
            ],
            [
                'title' => [
                    'ar' => 'دروع تكريم كريستالية فاخرة بحفر ليزري ثلاثي الأبعاد',
                    'en' => 'Luxury 3D Laser-Engraved Crystal Recognition Trophies',
                ],
                'client_name' => [
                    'ar' => 'جائزة التميز الوطنية',
                    'en' => 'National Excellence Award',
                ],
                'category_slug' => 'promotional-gifts',
                'image' => 'https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?auto=format&fit=crop&w=800&q=80',
                'description' => [
                    'ar' => 'تصميم وتصنيع 80 درعاً كريستالياً نقياً بدرجة K9 مع حفر ليزري داخلي لشعار الجائزة وأسماء المكرمين مع تقديمها في علب قطيفة ملكية فاخرة.',
                    'en' => 'Designed and fabricated 80 pure K9 optical crystal trophies with internal 3D laser engraving of the award emblem and honoree names in royal velvet boxes.',
                ],
            ],
        ];

        foreach ($portfolios as $portfolioData) {
            $category = Category::where('slug', $portfolioData['category_slug'])->first();
            unset($portfolioData['category_slug']);

            $portfolioData['category_id'] = $category?->id;

            Portfolio::create($portfolioData);
        }
    }
}
