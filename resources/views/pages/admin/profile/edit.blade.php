@extends('layouts.dashboard.app')

@section('title', 'الملف الشخصي')

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-sm shadow-xs">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
                <span>الملف الشخصي</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">إدارة معلوماتك الشخصية، بيانات الاتصال، وتحديث كلمة المرور الخاصة بحسابك</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 hover:text-slate-900 shadow-xs transition-all duration-200 active:scale-[0.98]">
                <svg class="w-4 h-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>العودة للوحة التحكم</span>
            </a>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left / Profile Summary Sidebar (4 cols) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Profile Summary Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <!-- Cover Banner -->
                <div class="h-28 bg-gradient-to-l from-blue-900 via-blue-800 to-red-700 relative p-4 flex items-end justify-end">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-white/20 backdrop-blur-md text-white border border-white/20 shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>مدير النظام العام</span>
                    </span>
                </div>

                <!-- Avatar and Info -->
                <div class="px-6 pb-6 pt-0 relative text-center">
                    <div class="relative -mt-14 inline-block mb-3">
                        <div class="w-28 h-28 rounded-2xl bg-gradient-to-tr from-blue-700 via-blue-600 to-red-600 p-1 shadow-xl shadow-blue-950/20 mx-auto">
                            <img id="sidebar-avatar-img"
                                src="{{ $user->avatar_url }}"
                                alt="{{ $user->name }}"
                                class="w-full h-full object-cover rounded-[14px] bg-slate-900 border-2 border-white"
                                onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=1d4ed8&background=eff6ff&size=128&font-size=0.4';">
                        </div>
                        <span class="absolute bottom-1.5 left-1.5 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white shadow-xs" title="حساب نشط"></span>
                    </div>

                    <h2 class="text-lg font-black text-slate-900 tracking-tight">{{ $user->name }}</h2>
                    <p class="text-xs text-slate-500 font-mono mt-0.5" dir="ltr">{{ $user->email }}</p>

                    @if($user->phone)
                    <div class="inline-flex items-center gap-1.5 mt-2 px-3 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-mono font-medium" dir="ltr">
                        <i class="fa-solid fa-phone text-slate-400 text-[10px]"></i>
                        <span>{{ $user->phone }}</span>
                    </div>
                    @endif

                    <div class="mt-6 pt-6 border-t border-slate-100 space-y-3 text-right">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400 font-medium">حالة الحساب</span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full font-bold text-[11px] bg-emerald-100 text-emerald-700">
                                <i class="fa-solid fa-circle-check text-[10px]"></i>
                                <span>نشط وفعّال</span>
                            </span>
                        </div>

                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400 font-medium">البريد الإلكتروني</span>
                            @if($user->email_verified_at)
                            <span class="inline-flex items-center gap-1 font-bold text-emerald-600">
                                <i class="fa-solid fa-check text-[10px]"></i>
                                <span>تم التحقق</span>
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 font-bold text-amber-600">
                                <i class="fa-solid fa-clock text-[10px]"></i>
                                <span>قيد التحقق</span>
                            </span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400 font-medium">تاريخ الانضمام</span>
                            <span class="text-slate-700 font-semibold font-mono">{{ $user->created_at->format('Y-m-d') }}</span>
                        </div>

                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400 font-medium">آخر تحديث</span>
                            <span class="text-slate-700 font-semibold font-mono">{{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Quick Advice Card -->
            <div class="bg-gradient-to-br from-blue-50/80 to-indigo-50/50 p-5 rounded-2xl border border-blue-100/80 shadow-xs space-y-3">
                <div class="flex items-center gap-2.5 text-blue-900 font-bold text-xs sm:text-sm">
                    <i class="fa-solid fa-shield-halved text-blue-600 text-base"></i>
                    <span>نصائح أمان الحساب</span>
                </div>
                <ul class="text-xs text-slate-600 space-y-2 leading-relaxed">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check-circle text-blue-500 text-[11px] mt-1 shrink-0"></i>
                        <span>اختر كلمة مرور قوية تحتوي على أحرف كبيرة وصغيرة وأرقام ورموز.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check-circle text-blue-500 text-[11px] mt-1 shrink-0"></i>
                        <span>لا تشارك بيانات تسجيل الدخول الخاصة بك مع أي شخص آخر.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check-circle text-blue-500 text-[11px] mt-1 shrink-0"></i>
                        <span>قم بتسجيل الخروج عند استخدام أجهزة مشتركة أو غير موثوقة.</span>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Right / Form Details (8 cols) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Card 1: Personal Details & Avatar -->
            <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                <div class="border-b border-slate-100 pb-4 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                            <span>البيانات الشخصية والصورة</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">تحديث اسمك الكامل، البريد الإلكتروني، رقم الهاتف والصورة الشخصية</p>
                    </div>
                </div>

                <form action="{{ route('admin.profile.update') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Avatar Uploader Section -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            الصورة الشخصية (Avatar)
                        </label>
                        <div class="flex flex-col sm:flex-row items-center gap-5 p-4 rounded-xl border border-slate-200/80 bg-slate-50/60">
                            <div class="relative group cursor-pointer" onclick="document.getElementById('avatar-input').click()">
                                <img id="avatar-preview-box"
                                    src="{{ $user->avatar_url }}"
                                    alt="{{ $user->name }}"
                                    class="w-20 h-20 rounded-2xl object-cover shadow-sm border-2 border-white ring-2 ring-slate-200 group-hover:ring-blue-400 transition-all"
                                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=1d4ed8&background=eff6ff';">
                                <div class="absolute inset-0 bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 flex items-center justify-center text-white transition-opacity">
                                    <i class="fa-solid fa-camera text-sm"></i>
                                </div>
                            </div>

                            <div class="flex-1 text-center sm:text-right space-y-2">
                                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5">
                                    <button type="button"
                                        onclick="document.getElementById('avatar-input').click()"
                                        class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-700 hover:bg-blue-800 transition-colors shadow-xs flex items-center gap-1.5">
                                        <i class="fa-solid fa-cloud-arrow-up text-xs"></i>
                                        <span>اختيار صورة جديدة</span>
                                    </button>

                                    @if($user->avatar)
                                    <label class="px-3 py-2 rounded-xl text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 transition-colors cursor-pointer flex items-center gap-1.5 border border-red-200/60">
                                        <input type="checkbox" name="remove_avatar" value="1" class="w-3.5 h-3.5 text-red-600 rounded border-red-300">
                                        <span>حذف الصورة الحالية</span>
                                    </label>
                                    @endif
                                </div>
                                <p class="text-[11px] text-slate-400">الصيغ المقبولة: JPG, PNG, WebP, SVG حتى 3 ميغابايت كحد أقصى.</p>
                            </div>

                            <input type="file"
                                id="avatar-input"
                                name="avatar"
                                accept="image/*"
                                class="hidden"
                                onchange="previewAvatar(event)">
                        </div>
                        @error('avatar')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            الاسم الكامل <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                placeholder="أدخل اسمك بالكامل"
                                class="w-full pr-10 pl-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-regular fa-user text-sm"></i>
                            </span>
                        </div>
                        @error('name')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email & Phone Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                البريد الإلكتروني <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    dir="ltr"
                                    required
                                    placeholder="admin@example.com"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm font-mono text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-regular fa-envelope text-sm"></i>
                                </span>
                            </div>
                            @error('email')
                            <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                رقم الهاتف أو الجوال
                                <span class="text-[11px] font-normal text-slate-400 mr-1">(اختياري)</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    dir="ltr"
                                    placeholder="0501234567"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $errors->has('phone') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm font-mono text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-phone text-sm"></i>
                                </span>
                            </div>
                            @error('phone')
                            <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2 flex items-center justify-end">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-800 hover:to-red-700 shadow-md shadow-blue-900/20 hover:shadow-lg transition-all duration-200 active:scale-[0.98]">
                            <i class="fa-solid fa-check"></i>
                            <span>حفظ التعديلات الشخصية</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Card 2: Password & Security Update -->
            <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                <div class="border-b border-slate-100 pb-4 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                            <span>تغيير كلمة المرور والأمان</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">تحديث كلمة مرور الدخول للوحة التحكم لحماية حسابك</p>
                    </div>
                </div>

                <form action="{{ route('admin.profile.password.update') }}"
                    method="POST"
                    class="space-y-5">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            كلمة المرور الحالية <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password"
                                id="current_password"
                                name="current_password"
                                required
                                placeholder="أدخل كلمة المرور الحالية لتأكيد هويتك"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $errors->has('current_password') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            <button type="button" onclick="togglePasswordVisibility('current_password')" class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <i class="fa-regular fa-eye text-sm" id="current_password-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password & Confirmation Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                كلمة المرور الجديدة <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password"
                                    id="password"
                                    name="password"
                                    required
                                    minlength="8"
                                    placeholder="8 أحرف على الأقل"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $errors->has('password') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                                <button type="button" onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                    <i class="fa-regular fa-eye text-sm" id="password-eye"></i>
                                </button>
                            </div>
                            @error('password')
                            <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmation -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                تأكيد كلمة المرور الجديدة <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    minlength="8"
                                    placeholder="أعد إدخال كلمة المرور الجديدة"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                                <button type="button" onclick="togglePasswordVisibility('password_confirmation')" class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                    <i class="fa-regular fa-eye text-sm" id="password_confirmation-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2 flex items-center justify-end">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors shadow-sm active:scale-[0.98]">
                            <i class="fa-solid fa-key"></i>
                            <span>تحديث كلمة المرور</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</div>

@push('scripts')
<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview1 = document.getElementById('avatar-preview-box');
                const preview2 = document.getElementById('sidebar-avatar-img');
                if (preview1) preview1.src = e.target.result;
                if (preview2) preview2.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-eye');
        if (!field || !icon) return;

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