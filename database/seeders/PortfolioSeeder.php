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
        $portfolios = [
            [
                'title' => 'تصميم وتنفيذ علب فاخرة لمجموعة عطور ملكية',
                'client_name' => 'دار الطيب الملكي للعطور',
                'category_slug' => 'luxury-packaging-boxes',
                'image' => 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=800&q=80',
                'description' => 'مشروع متكامل شمل تصميم وتصنيع علب مغناطيسية صلبة مع بطانة مخملية مخصصة لزجاجات العطور وطباعة بصمة ذهبية بارزة على ورق ناعم الملمس.',
            ],
            [
                'title' => 'إنتاج كراتين شحن وهوية التغليف لمتجر إلكتروني',
                'client_name' => 'متجر شمس للتجارة الإلكترونية',
                'category_slug' => 'luxury-packaging-boxes',
                'image' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&w=800&q=80',
                'description' => 'تصنيع 10,000 كرتون شحن مضلع بثلاثة مقاسات مختلفة مع طباعة شعار المتجر من الداخل والخارج لتقديم تجربة فتح صندوق مبتكرة للعملاء.',
            ],
            [
                'title' => 'بطاقات أعمال قطنية فاخرة مع حواف مذهبة',
                'client_name' => 'مكتب التميمي للمحاماة والاستشارات',
                'category_slug' => 'business-cards',
                'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80',
                'description' => 'تنفيذ بطاقات أعمال من الورق القطني الفاخر 600 جرام بتقنية اللتربرس الغائر مع تذهيب الحواف يدوياً باللون الذهبي اللامع للشركاء والمحامين.',
            ],
            [
                'title' => 'أكياس تسوق كرافت بيئية لسلسلة مقاهي عصرية',
                'client_name' => 'سلسلة مقاهي إكسير البن',
                'category_slug' => 'paper-and-fabric-bags',
                'image' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=800&q=80',
                'description' => 'تزويد سلسلة المقاهي بأكياس تسوق ورقية صديقة للبيئة من ورق الكرافت البني بمقابض مجدولة وقاعدة مدعمة قادرة على حمل أكواب القهوة والمخبوزات بأمان.',
            ],
            [
                'title' => 'طباعة وتجليد التقارير السنوية وبروفايل الشركة',
                'client_name' => 'مجموعة الراجحي الاستثمارية',
                'category_slug' => 'books-and-catalogues',
                'image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=800&q=80',
                'description' => 'طباعة التقرير المالي والسنوي لعام 2025 بتجليد حراري فاخر (Hardcover) مع لمسات سبوت يو في وسلفنة ناعمة للغلاف وألوان أوفست دقيقة.',
            ],
            [
                'title' => 'ملصقات منتجات مقاومة للماء والزيوت لعلامة مستحضرات تجميل',
                'client_name' => 'لورين للعناية الطبيعية',
                'category_slug' => 'labels-and-stickers',
                'image' => 'https://images.unsplash.com/photo-1572375992501-4b0892d50c69?auto=format&fit=crop&w=800&q=80',
                'description' => 'طباعة وقص ليزري دقيق لاستيكرات فينيل مقاومة للرطوبة والزيوت مع لمعان مطفي وفويل وردي ذهبي (Rose Gold) للعبوات الزجاجية.',
            ],
            [
                'title' => 'تجهيز أجنحة المعرض ورول اب للمؤتمر السنوي للتقنية',
                'client_name' => 'الاتحاد السعودي للابتكار التقني',
                'category_slug' => 'banners-and-rollups',
                'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80',
                'description' => 'تصنيع وطباعة 50 ستاند رول اب عالي الدقة بدون لمعان مع جدران العرض البوب اب (Pop-up) لتجهيز الصالة الرئيسية للمؤتمر والمعرض المصاحب.',
            ],
            [
                'title' => 'دروع تكريم كريستالية فاخرة بحفر ليزري ثلاثي الأبعاد',
                'client_name' => 'جائزة التميز الوطنية',
                'category_slug' => 'promotional-gifts',
                'image' => 'https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?auto=format&fit=crop&w=800&q=80',
                'description' => 'تصميم وتصنيع 80 درعاً كريستالياً نقياً بدرجة K9 مع حفر ليزري داخلي لشعار الجائزة وأسماء المكرمين مع تقديمها في علب قطيفة ملكية فاخرة.',
            ],
        ];

        foreach ($portfolios as $portfolioData) {
            $category = Category::where('slug', $portfolioData['category_slug'])->first();
            unset($portfolioData['category_slug']);

            $portfolioData['category_id'] = $category?->id;

            Portfolio::updateOrCreate(
                ['title' => $portfolioData['title']],
                $portfolioData
            );
        }
    }
}
