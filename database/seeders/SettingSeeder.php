<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'site_name' => 'نبراس العرب للطباعة والتغليف',
            'site_tagline' => 'ريادة في عالم الطباعة الفاخرة والتغليف المبتكر',
            'site_description' => 'نبراس العرب هي وجهتكم الموثوقة لخدمات الطباعة الرقمية والأوفست، تصنيع علب التغليف الفاخرة، والهدايا الترويجية بالمملكة العربية السعودية وفق أرقى المعايير العالمية.',
            'contact_email' => 'info@nibras-alarab.com',
            'support_email' => 'support@nibras-alarab.com',
            'sales_email' => 'sales@nibras-alarab.com',
            'phone' => '+966 11 456 7890',
            'mobile' => '+966 50 123 4567',
            'whatsapp' => '+966501234567',
            'address' => 'المملكة العربية السعودية، الرياض، شارع صلاح الدين الأيوبي، حي الملز',
            'map_url' => 'https://maps.google.com/?q=24.6748,46.7303',
            'working_hours' => 'السبت - الخميس: 8:30 صباحاً إلى 10:00 مساءً | الجمعة: مغلق',
            'facebook' => 'https://facebook.com/nibrasalarab',
            'twitter' => 'https://twitter.com/nibrasalarab',
            'instagram' => 'https://instagram.com/nibrasalarab',
            'linkedin' => 'https://linkedin.com/company/nibrasalarab',
            'tiktok' => 'https://tiktok.com/@nibrasalarab',
            'tax_number' => '310234567800003',
            'commercial_registration' => '1010789456',
            'currency' => 'SAR',
            'currency_symbol' => 'ر.س',
            'header_notice' => 'خصم خاص 15% على جميع طلبات التغليف والعلب الفاخرة للكميات الكبيرة بمناسبة تدشين موقعنا الجديد!',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
