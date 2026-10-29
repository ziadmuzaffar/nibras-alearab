<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ setting('site_name', 'مطبعة نبراس العرب') }} | الموقع قيد التحديث</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/cairo/cairo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
    <script src="{{ asset('assets/vendor/tailwindcss/tailwind.min.js') }}"></script>
    <style>
        body { font-family: 'Cairo', system-ui, sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-white flex items-center justify-center p-4">
    <div class="max-w-lg w-full bg-slate-900 border border-slate-800 rounded-3xl p-8 sm:p-10 text-center space-y-6 shadow-2xl">
        <div class="w-16 h-16 rounded-2xl bg-amber-500/15 border border-amber-500/30 text-amber-400 flex items-center justify-center mx-auto">
            <i class="fa-solid fa-screwdriver-wrench text-2xl"></i>
        </div>
        <div class="space-y-2">
            <h1 class="text-xl sm:text-2xl font-black text-white">{{ setting('site_name', 'مطبعة نبراس العرب للطباعة والتغليف') }}</h1>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                {{ setting('maintenance_message', 'الموقع يخضع حالياً لبعض أعمال الصيانة والتحسينات، وسنعود للعمل في أقرب وقت.') }}
            </p>
        </div>
        <div class="pt-4 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-center gap-3">
            @if(setting('whatsapp') || setting('mobile'))
            <a href="{{ whatsapp_link() }}" target="_blank" rel="noopener"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs sm:text-sm transition-colors">
                <i class="fa-brands fa-whatsapp text-base"></i>
                <span>تواصل معنا عبر واتساب</span>
            </a>
            @endif
            @if(setting('mobile') || setting('phone'))
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('mobile', setting('phone'))) }}"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs sm:text-sm font-mono transition-colors" dir="ltr">
                <i class="fa-solid fa-phone text-xs"></i>
                <span>{{ setting('mobile', setting('phone')) }}</span>
            </a>
            @endif
        </div>
    </div>
</body>
</html>

