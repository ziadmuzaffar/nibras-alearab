<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Database\Seeders\SettingSeeder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the settings management view.
     */
    public function index(Request $request): View
    {
        $settings = Setting::getAll();
        $activeTab = $request->input('tab', 'general');

        // Available tabs
        $tabs = [
            'general' => [
                'name' => __('الهوية والمظهر'),
                'icon' => 'fa-palette',
                'description' => __('شعار المطبعة، الاسم، الشعار اللفظي، والوصف العام'),
            ],
            'contact' => [
                'name' => __('بيانات الاتصال'),
                'icon' => 'fa-address-book',
                'description' => __('أرقام الهاتف، الجوال، الواتساب، والبريد الإلكتروني ومواعيد العمل'),
            ],
            'social' => [
                'name' => __('التواصل الاجتماعي'),
                'icon' => 'fa-share-nodes',
                'description' => __('روابط الحسابات الرسمية على منصات التواصل'),
            ],
            'commercial' => [
                'name' => __('البيانات التجارية وعروض الأسعار'),
                'icon' => 'fa-file-invoice-dollar',
                'description' => __('الرقم الضريبي، السجل التجاري، العملة، وضبط عروض الأسعار'),
            ],
            'announcement' => [
                'name' => __('شريط الإعلانات والصيانة'),
                'icon' => 'fa-bullhorn',
                'description' => __('شريط التنبيه العلوي في الموقع ووضع الصيانة المؤقت'),
            ],
            'seo' => [
                'name' => __('محركات البحث والأكواد'),
                'icon' => 'fa-magnifying-glass-chart',
                'description' => __('الكلمات المفتاحية، جوجل أناليتكس، والأكواد المخصصة'),
            ],
        ];

        // System overview statistics
        $stats = [
            'total_settings' => count($settings),
            'has_logo' => !empty($settings['site_logo']),
            'has_tax_number' => !empty($settings['tax_number']),
            'is_maintenance' => ($settings['maintenance_mode'] ?? '0') === '1',
            'has_announcement' => ($settings['header_notice_active'] ?? '0') === '1' && !empty($settings['header_notice']),
        ];

        return view('pages.admin.settings.index', compact('settings', 'activeTab', 'tabs', 'stats'));
    }

    /**
     * Update system settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $activeTab = $request->input('_tab', 'general');

        // Validation rules
        $rules = [
            'site_name' => 'nullable|string|max:190',
            'site_name_en' => 'nullable|string|max:190',
            'site_tagline' => 'nullable|string|max:255',
            'site_tagline_en' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'site_description_en' => 'nullable|string|max:1000',
            'established_year' => 'nullable|string|max:10',
            'contact_email' => 'nullable|email|max:190',
            'support_email' => 'nullable|email|max:190',
            'sales_email' => 'nullable|email|max:190',
            'phone' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'whatsapp_default_message' => 'nullable|string|max:500',
            'whatsapp_default_message_en' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:300',
            'address_en' => 'nullable|string|max:300',
            'map_url' => 'nullable|string|max:500',
            'working_hours' => 'nullable|string|max:255',
            'working_hours_en' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'tiktok' => 'nullable|url|max:255',
            'snapchat' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'tax_number' => 'nullable|string|max:50',
            'commercial_registration' => 'nullable|string|max:50',
            'currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:15',
            'currency_symbol_en' => 'nullable|string|max:15',
            'vat_rate' => 'nullable|numeric|min:0|max:100',
            'quote_success_message' => 'nullable|string|max:500',
            'quote_success_message_en' => 'nullable|string|max:500',
            'header_notice' => 'nullable|string|max:500',
            'header_notice_en' => 'nullable|string|max:500',
            'header_notice_type' => 'nullable|string|in:promo,info,warning,danger',
            'maintenance_message' => 'nullable|string|max:500',
            'maintenance_message_en' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'meta_keywords_en' => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:500',
            'meta_description_en' => 'nullable|string|max:500',
            'google_analytics_id' => 'nullable|string|max:50',
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:4096',
            'site_logo_dark' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:4096',
            'site_favicon' => 'nullable|image|mimes:ico,png,svg,webp|max:1024',
        ];

        $validated = $request->validate($rules);

        // Uploads directory
        $destinationDir = public_path('uploads/settings');
        if (!File::isDirectory($destinationDir)) {
            File::makeDirectory($destinationDir, 0755, true, true);
        }

        // Handle File Uploads & Deletions
        $imageFields = ['site_logo', 'site_logo_dark', 'site_favicon'];
        foreach ($imageFields as $field) {
            // Check if removal was requested
            if ($request->boolean("remove_{$field}")) {
                $oldPath = Setting::get($field);
                if ($oldPath && File::exists(public_path($oldPath))) {
                    File::delete(public_path($oldPath));
                }
                Setting::set($field, null);
            }

            // Check if new file uploaded
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $oldPath = Setting::get($field);
                if ($oldPath && File::exists(public_path($oldPath))) {
                    File::delete(public_path($oldPath));
                }

                $filename = $field . '_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                $file->move($destinationDir, $filename);
                Setting::set($field, 'uploads/settings/' . $filename);
            }
        }

        // Handle Checkbox / Toggle Fields (they send nothing when unchecked)
        $checkboxFields = [
            'header_notice_active' => '0',
            'maintenance_mode' => '0',
            'enable_quotes' => '0',
        ];

        // Process all input fields except internal tokens and files
        $skipFields = ['_token', '_tab', 'site_logo', 'site_logo_dark', 'site_favicon', 'remove_site_logo', 'remove_site_logo_dark', 'remove_site_favicon'];
        
        $settingsToSave = [];

        foreach ($request->all() as $key => $value) {
            if (in_array($key, $skipFields, true)) {
                continue;
            }

            // Exclude keys starting with _
            if (str_starts_with($key, '_')) {
                continue;
            }

            $settingsToSave[$key] = is_string($value) ? trim($value) : $value;
        }

        // Check toggles relevant to the current tab or request
        if ($activeTab === 'announcement' || $request->has('header_notice_present')) {
            $settingsToSave['header_notice_active'] = $request->has('header_notice_active') ? '1' : '0';
            $settingsToSave['maintenance_mode'] = $request->has('maintenance_mode') ? '1' : '0';
        }

        if ($activeTab === 'commercial' || $request->has('enable_quotes_present')) {
            $settingsToSave['enable_quotes'] = $request->has('enable_quotes') ? '1' : '0';
        }

        // Save settings in database
        Setting::setMany($settingsToSave);

        return redirect()
            ->route('admin.settings.index', ['tab' => $activeTab])
            ->with('success', __('تم حفظ وتحديث إعدادات النظام بنجاح!'));
    }

    /**
     * Reset settings to default values.
     */
    public function resetDefaults(Request $request): RedirectResponse
    {
        $seeder = new SettingSeeder();
        $seeder->run();

        Setting::clearCache();

        return redirect()
            ->route('admin.settings.index')
            ->with('success', __('تمت استعادة الإعدادات الافتراضية للنظام بنجاح!'));
    }
}
