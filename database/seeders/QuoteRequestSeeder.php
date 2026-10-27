<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\QuoteRequest;
use Illuminate\Database\Seeder;

class QuoteRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requests = [
            [
                'product_slug' => 'luxury-magnetic-gift-boxes',
                'customer_name' => 'عبدالله السعيد',
                'phone' => '+966501234567',
                'email' => 'a.saeed@company.com',
                'quantity' => 1000,
                'notes' => 'نحتاج إلى علب فاخرة مع طباعة الشعار باللون الذهبي البارز، يرجى تزويدنا بالنماذج وعرض السعر مع موعد التسليم المتوقع إلى مدينة الرياض.',
                'status' => 'pending',
                'created_at' => now()->subDays(1),
            ],
            [
                'product_slug' => 'eco-friendly-kraft-paper-bags',
                'customer_name' => 'نورة القحطاني',
                'phone' => '+966559876543',
                'email' => 'noura@boutique.sa',
                'quantity' => 500,
                'notes' => 'أكياس تسوق لمتجر ملابس مع ورق كرافت ومقابض شريط حريري، مقاس وسط ومقاس كبير.',
                'status' => 'contacted',
                'created_at' => now()->subDays(3),
            ],
            [
                'product_slug' => 'cotton-letterpress-edge-foil-cards',
                'customer_name' => 'م. خالد الشمري',
                'phone' => '+966541122334',
                'email' => 'khalid@eng-office.com',
                'quantity' => 250,
                'notes' => 'طلب كروت شخصية ورق قطني مع لتربرس وحواف مذهبة باللون البرونزي لطاقم الإدارة التنفيذية.',
                'status' => 'completed',
                'created_at' => now()->subDays(5),
            ],
            [
                'product_slug' => 'custom-printed-shipping-boxes',
                'customer_name' => 'سلطان الدوسري',
                'phone' => '+966567788990',
                'email' => 'sultan@logistics.sa',
                'quantity' => 2500,
                'notes' => 'كراتين شحن مضلعة مقاس 30x20x15 سم مطبوع عليها الهوية من الجهتين ومقاومة للصدمات.',
                'status' => 'pending',
                'created_at' => now()->subHours(6),
            ],
            [
                'product_slug' => 'luxury-gold-foil-business-cards',
                'customer_name' => 'ريم العتيبي',
                'phone' => '+966533445566',
                'email' => 'reem@perfumes.com',
                'quantity' => 1000,
                'notes' => 'كروت شخصية فاخرة بالفويل الذهبي والسبوت يو في لخمسة موظفين (200 كرت لكل موظف).',
                'status' => 'contacted',
                'created_at' => now()->subDays(2),
            ],
            [
                'product_slug' => 'premium-advertising-rollup-stand',
                'customer_name' => 'فراس الزهراني',
                'phone' => '+966581239874',
                'email' => 'firas@agency.sa',
                'quantity' => 12,
                'notes' => 'ستاندات رول اب لمعرض التسويق والاتصال الأسبوع القادم في مركز المعارض بجدة مع سرعة التوريد.',
                'status' => 'completed',
                'created_at' => now()->subDays(7),
            ],
            [
                'product_slug' => 'waterproof-vinyl-die-cut-stickers',
                'customer_name' => 'د. هيفاء النجار',
                'phone' => '+966504561230',
                'email' => 'dr.haifa@medical-center.sa',
                'quantity' => 5000,
                'notes' => 'ستيكرات لاصقة مقاومة للماء والتعقيم لاستخدام عبوات المعامل الطبية والمختبرات.',
                'status' => 'pending',
                'created_at' => now()->subHours(12),
            ],
            [
                'product_slug' => 'corporate-company-profile-catalogues',
                'customer_name' => 'عمر الحربي',
                'phone' => '+966598765123',
                'email' => 'omar@startup.com',
                'quantity' => 150,
                'notes' => 'طلب بروفايل شركة ملون كوشيه مع غراء حراري وتجليد كرتوني بعدد 36 صفحة.',
                'status' => 'cancelled',
                'created_at' => now()->subDays(10),
            ],
        ];

        foreach ($requests as $requestData) {
            $product = Product::where('slug', $requestData['product_slug'])->first();
            unset($requestData['product_slug']);

            $requestData['product_id'] = $product?->id;

            QuoteRequest::create($requestData);
        }
    }
}
