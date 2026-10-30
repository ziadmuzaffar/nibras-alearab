@extends('layouts.dashboard.app')

@section('title', __('إضافة مستخدم جديد'))

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>{{ __('إضافة مستخدم جديد') }}</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">{{ __('أدخل بيانات المستخدم وكلمة المرور في نظام نبراس العرب') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 hover:text-slate-900 shadow-sm transition-all duration-200 active:scale-[0.98]">
                <svg class="w-4 h-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>{{ __('العودة للمستخدمين') }}</span>
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <form action="{{ route('admin.users.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Main Information (8 cols) -->
            <div class="lg:col-span-8 space-y-6">

                <!-- Basic Fields Card -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        <span>{{ __('البيانات الشخصية والأساسية') }}</span>
                    </h3>

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('الاسم الكامل') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="{{ __('مثال: أحمد عبد الله، سارة المنصور...') }}"
                            required
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                        @error('name')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email & Phone Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                {{ __('البريد الإلكتروني') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="name@example.com"
                                dir="ltr"
                                required
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm font-mono text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            @error('email')
                            <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Field -->
                        <div>
                            <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                {{ __('رقم الهاتف أو الجوال') }}
                                <span class="text-[11px] font-normal text-slate-400 mr-1">{{ __('(اختياري)') }}</span>
                            </label>
                            <input type="text"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="0501234567"
                                dir="ltr"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('phone') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm font-mono text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            @error('phone')
                            <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password & Security Card -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-red-600"></span>
                        <span>{{ __('أمان الحساب وكلمة المرور') }}</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                {{ __('كلمة المرور') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password"
                                    id="password"
                                    name="password"
                                    required
                                    minlength="8"
                                    placeholder="{{ __('8 أحرف على الأقل') }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $errors->has('password') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                                <button type="button" onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 hover:text-slate-600">
                                    <i class="fa-regular fa-eye text-sm" id="password-eye"></i>
                                </button>
                            </div>
                            @error('password')
                            <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                {{ __('تأكيد كلمة المرور') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    minlength="8"
                                    placeholder="{{ __('أعد إدخال كلمة المرور') }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                                <button type="button" onclick="togglePasswordVisibility('password_confirmation')" class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 hover:text-slate-600">
                                    <i class="fa-regular fa-eye text-sm" id="password_confirmation-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Sidebar Controls (4 cols) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- Avatar Upload Card -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-camera text-blue-600"></i>
                        <span>{{ __('الصورة الشخصية (Avatar)') }}</span>
                    </h3>

                    <div>
                        <!-- Preview Box -->
                        <div class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-dashed border-slate-200 bg-slate-50/60 hover:bg-slate-50 transition-colors cursor-pointer relative"
                            onclick="document.getElementById('avatar').click()">
                            <img id="avatar-preview"
                                src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'><circle cx='50' cy='50' r='50' fill='%23f1f5f9'/><circle cx='50' cy='38' r='18' fill='%2394a3b8'/><path d='M20,85 C20,68 35,65 50,65 C65,65 80,68 80,85 Z' fill='%2394a3b8'/></svg>"
                                alt="{{ __('معاينة الصورة') }}"
                                class="w-24 h-24 rounded-full object-cover shadow-sm border-2 border-white mb-2">
                            <span class="text-xs font-bold text-blue-700">{{ __('انقر لرفع صورة') }}</span>
                            <span class="text-[11px] text-slate-400 mt-0.5">{{ __('PNG, JPG, WebP حتى 3MB') }}</span>

                            <input type="file"
                                id="avatar"
                                name="avatar"
                                accept="image/*"
                                class="hidden"
                                onchange="previewAvatar(event)">
                        </div>
                        @error('avatar')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Account Status & Verification Card -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-sliders text-blue-600"></i>
                        <span>{{ __('حالة وتفعيل الحساب') }}</span>
                    </h3>

                    <!-- Is Active Switch -->
                    <label class="flex items-center justify-between p-3 rounded-xl bg-slate-50/70 border border-slate-100 cursor-pointer hover:bg-slate-100/50 transition-colors">
                        <div>
                            <span class="text-xs font-bold text-slate-800 block">{{ __('حساب نشط') }}</span>
                            <span class="text-[11px] text-slate-400">{{ __('السماح بتسجيل الدخول والوصول للنظام') }}</span>
                        </div>
                        <input type="checkbox"
                            name="is_active"
                            value="1"
                            {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 border-slate-300">
                    </label>

                    <!-- Email Verified Switch -->
                    <label class="flex items-center justify-between p-3 rounded-xl bg-slate-50/70 border border-slate-100 cursor-pointer hover:bg-slate-100/50 transition-colors">
                        <div>
                            <span class="text-xs font-bold text-slate-800 block">{{ __('تأكيد البريد الإلكتروني فوراً') }}</span>
                            <span class="text-[11px] text-slate-400">{{ __('اعتبار البريد مفعّلاً دون انتظار رابط تحقق') }}</span>
                        </div>
                        <input type="checkbox"
                            name="email_verified"
                            value="1"
                            {{ old('email_verified', '1') == '1' ? 'checked' : '' }}
                            class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500 border-slate-300">
                    </label>
                </div>

                <!-- Submit Action Card -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
                    <button type="submit"
                        class="w-full py-3 px-5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-800 hover:to-red-700 shadow-md shadow-blue-900/20 hover:shadow-lg transition-all duration-200 active:scale-[0.98] flex items-center justify-center gap-2">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>{{ __('حفظ وإضافة المستخدم') }}</span>
                    </button>

                    <a href="{{ route('admin.users.index') }}"
                        class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors text-center block">
                        {{ __('إلغاء والعودة') }}
                    </a>
                </div>

            </div>

        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-eye');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush
@endsection
