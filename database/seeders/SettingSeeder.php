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
            // Branding & General (Arabic & English)
            'site_name' => 'نبراس العرب للطباعة والتغليف',
            'site_name_en' => 'Nibras Al-Arab Printing & Packaging',
            'site_tagline' => 'ريادة في عالم الطباعة الفاخرة والتغليف المبتكر',
            'site_tagline_en' => 'Pioneers in Luxury Printing & Innovative Packaging',
            'site_description' => 'نبراس العرب هي وجهتكم الموثوقة لخدمات الطباعة الرقمية والأوفست، تصنيع علب التغليف الفاخرة، والهدايا الترويجية بالمملكة العربية السعودية وفق أرقى المعايير العالمية.',
            'site_description_en' => 'Nibras Al-Arab is your trusted destination in Saudi Arabia for digital & offset printing, luxury packaging boxes manufacturing, and corporate promotional gifts crafted to world-class standards.',
            'site_logo' => null,
            'site_logo_dark' => null,
            'site_favicon' => null,
            'established_year' => '2015',

            // Contact & Location
            'contact_email' => 'info@nibras-alarab.com',
            'support_email' => 'support@nibras-alarab.com',
            'sales_email' => 'sales@nibras-alarab.com',
            'phone' => '+966 11 456 7890',
            'mobile' => '+966 50 123 4567',
            'whatsapp' => '+966501234567',
            'whatsapp_default_message' => 'مرحباً، أود الاستفسار عن خدمات الطباعة والتغليف لدى مطبعة نبراس العرب.',
            'whatsapp_default_message_en' => 'Hello, I would like to inquire about printing and packaging services at Nibras Al-Arab Press.',
            'address' => 'المملكة العربية السعودية، الرياض، شارع صلاح الدين الأيوبي، حي الملز',
            'address_en' => 'Salahuddin Al-Ayyubi Rd, Al-Malaz District, Riyadh, Kingdom of Saudi Arabia',
            'map_url' => 'https://maps.google.com/?q=24.6748,46.7303',
            'working_hours' => 'السبت - الخميس: 8:30 صباحاً إلى 10:00 مساءً | الجمعة: مغلق',
            'working_hours_en' => 'Sat - Thu: 8:30 AM to 10:00 PM | Friday: Closed',

            // Social Media
            'facebook' => 'https://facebook.com/nibrasalarab',
            'twitter' => 'https://twitter.com/nibrasalarab',
            'instagram' => 'https://instagram.com/nibrasalarab',
            'linkedin' => 'https://linkedin.com/company/nibrasalarab',
            'tiktok' => 'https://tiktok.com/@nibrasalarab',
            'snapchat' => 'https://snapchat.com/add/nibrasalarab',
            'youtube' => 'https://youtube.com/@nibrasalarab',

            // Commercial & Quotation
            'tax_number' => '310234567800003',
            'commercial_registration' => '1010789456',
            'currency' => 'SAR',
            'currency_symbol' => 'ر.س',
            'currency_symbol_en' => 'SAR',
            'vat_rate' => '15',
            'enable_quotes' => '1',
            'quote_success_message' => 'تم استلام طلبك بنجاح! سيقوم فريق المبيعات والتسعير بدراسة المواصفات والتواصل معك خلال ساعات العمل الرسمية.',
            'quote_success_message_en' => 'Your quote request has been received! Our sales and estimation team will review your specifications and contact you during business hours.',

            // Announcement Banner & Maintenance
            'header_notice' => 'خصم خاص 15% على جميع طلبات التغليف والعلب الفاخرة للكميات الكبيرة بمناسبة تدشين موقعنا الجديد!',
            'header_notice_en' => 'Special 15% discount on all bulk luxury packaging & box orders celebrating our new website launch!',
            'header_notice_active' => '1',
            'header_notice_type' => 'promo',
            'maintenance_mode' => '0',
            'maintenance_message' => 'الموقع يخضع حالياً لبعض أعمال الصيانة والتحسينات، وسنعود للعمل في أقرب وقت.',
            'maintenance_message_en' => 'Our website is currently undergoing scheduled maintenance and upgrades. We will be back shortly.',

            // SEO & Tracking
            'meta_keywords' => 'مطبعة الرياض, طباعة علب كرتون, تغليف فاخر, كروت شخصية, بروشورات, نبراس العرب, طباعة أوفست, هدايا دعائية',
            'meta_keywords_en' => 'Riyadh printing press, luxury packaging boxes, business cards, brochures, Nibras Al-Arab, offset printing, promotional gifts',
            'meta_description' => 'نبراس العرب للطباعة والتغليف بالرياض - خدمات متكاملة في الطباعة والتغليف الفاخر والهدايا الدعائية بأحدث التقنيات وأعلى جودة.',
            'meta_description_en' => 'Nibras Al-Arab Printing & Packaging in Riyadh - Integrated solutions in luxury packaging, offset & digital printing, and corporate gifts.',
            'google_analytics_id' => '',
            'custom_header_scripts' => '',
            'custom_footer_scripts' => '',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
