@extends('layouts.dashboard.app')

@section('title', 'تفاصيل المستخدم: ' . $user->name)

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                    <span>تفاصيل المستخدم</span>
                </h1>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1.5">عرض كافة البيانات الشخصية وتفاصيل الحساب</p>
        </div>

        <!-- Header Actions -->
        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 hover:text-slate-900 shadow-2xs transition-all duration-200 active:scale-[0.98]">
                <i class="fa-solid fa-arrow-right text-xs"></i>
                <span>العودة للقائمة</span>
            </a>
        </div>
    </div>

    <!-- KPI Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Account Status -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">حالة الحساب</p>
                <p class="text-xl sm:text-2xl font-black {{ $user->is_active ? 'text-emerald-600' : 'text-amber-600' }} mt-1">
                    {{ $user->is_active ? 'نشط ومفعّل' : 'معطل' }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl {{ $user->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }} flex items-center justify-center">
                <i class="fa-solid {{ $user->is_active ? 'fa-circle-check' : 'fa-circle-pause' }} text-xl"></i>
            </div>
        </div>

        <!-- Verification Status -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">البريد الإلكتروني</p>
                <p class="text-xl sm:text-2xl font-black {{ $user->email_verified_at ? 'text-purple-600' : 'text-slate-500' }} mt-1">
                    {{ $user->email_verified_at ? 'تم التحقق' : 'غير موثق' }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <i class="fa-solid fa-circle-check text-xl"></i>
            </div>
        </div>

        <!-- Phone Status -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">رقم الهاتف</p>
                <p class="text-base sm:text-lg font-black text-slate-800 mt-1 font-mono truncate max-w-[170px]" dir="ltr">
                    {{ $user->phone ?: 'غير مسجل' }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                <i class="fa-solid fa-phone text-xl"></i>
            </div>
        </div>

        <!-- Membership Date -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">تاريخ التسجيل</p>
                <p class="text-base sm:text-lg font-black text-indigo-600 mt-1 font-mono">
                    {{ $user->created_at ? $user->created_at->format('Y-m-d') : '—' }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <i class="fa-solid fa-calendar-days text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Main Content Layout (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Right Side: Details (8 Columns) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- User Detailed Information Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                            <i class="fa-solid fa-circle-info text-sm"></i>
                        </div>
                        <span>المعلومات الشخصية وبيانات الحساب</span>
                    </h3>
                </div>

                <div class="divide-y divide-slate-100 text-xs sm:text-sm">
                    <!-- User Full Name -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-user text-slate-400 w-4"></i>
                            <span>الاسم الكامل</span>
                        </div>
                        <span class="font-bold text-slate-900 text-sm sm:text-base">{{ $user->name }}</span>
                    </div>

                    <!-- Email -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-envelope text-slate-400 w-4"></i>
                            <span>البريد الإلكتروني</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span dir="ltr" class="font-mono font-bold text-blue-700 bg-blue-50 border border-blue-100 px-3 py-1 rounded-lg text-xs">
                                {{ $user->email }}
                            </span>
                            <button type="button"
                                onclick="copyText('{{ $user->email }}')"
                                class="text-slate-400 hover:text-blue-600 transition-colors p-1"
                                title="نسخ البريد">
                                <i class="fa-regular fa-copy text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-phone text-slate-400 w-4"></i>
                            <span>رقم الهاتف</span>
                        </div>
                        @if($user->phone)
                        <div class="flex items-center gap-2">
                            <a href="tel:{{ $user->phone }}" dir="ltr" class="font-mono font-bold text-slate-800 bg-slate-50 border border-slate-200 px-3 py-1 rounded-lg text-xs hover:text-blue-600">
                                {{ $user->phone }}
                            </a>
                            <button type="button"
                                onclick="copyText('{{ $user->phone }}')"
                                class="text-slate-400 hover:text-blue-600 transition-colors p-1"
                                title="نسخ الهاتف">
                                <i class="fa-regular fa-copy text-xs"></i>
                            </button>
                        </div>
                        @else
                        <span class="text-slate-400">غير محدد</span>
                        @endif
                    </div>

                    <!-- Email Verified Timestamp -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-circle-check text-slate-400 w-4"></i>
                            <span>تاريخ توثيق البريد</span>
                        </div>
                        <span class="font-mono text-slate-700">
                            {{ $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i:s') : 'غير موثق' }}
                        </span>
                    </div>

                    <!-- Created At -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-calendar-plus text-slate-400 w-4"></i>
                            <span>تاريخ إنشاء الحساب</span>
                        </div>
                        <span class="font-mono text-slate-700">
                            {{ $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '—' }}
                        </span>
                    </div>

                    <!-- Updated At -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-clock-rotate-left text-slate-400 w-4"></i>
                            <span>آخر تحديث للبيانات</span>
                        </div>
                        <span class="font-mono text-slate-700">
                            {{ $user->updated_at ? $user->updated_at->diffForHumans() : '—' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Security & Password Info Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 space-y-4">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5 pb-4 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                    <span>أمان الحساب ومعلومات الدخول</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                        <p class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-key text-blue-600"></i>
                            <span>تشفير كلمة المرور</span>
                        </p>
                        <p class="text-[11px] text-slate-400">
                            كلمة المرور مشفرة بأعلى معايير الحماية (Bcrypt Hashed).
                        </p>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                        <p class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                            <span>حالة الحساب</span>
                        </p>
                        <p class="text-[11px] text-slate-400">
                            {{ $user->is_active ? 'الحساب مفعّل ويحق له الدخول واستخدام النظام بشكل طبيعي.' : 'الحساب معطل وممنوع من تسجيل الدخول.' }}
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Left Side: Profile Card (4 Columns) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Profile Summary Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <!-- Cover Banner -->
                <div class="h-28 bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 relative">
                    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:14px_14px]"></div>
                </div>

                <!-- Avatar and Info -->
                <div class="px-6 pb-6 text-center relative">
                    <div class="w-24 h-24 mx-auto rounded-2xl bg-white p-1.5 shadow-xl -mt-12 mb-3 relative z-10 border-2 border-white">
                        <img src="{{ $user->avatar_url }}"
                            alt="{{ $user->name }}"
                            class="w-full h-full object-cover rounded-xl"
                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=1d4ed8&background=eff6ff';">
                    </div>

                    <h2 class="text-lg font-black text-slate-900">{{ $user->name }}</h2>
                    <p class="text-xs font-mono text-slate-400 mt-0.5" dir="ltr">{{ $user->email }}</p>

                    <div class="flex items-center justify-center gap-2 mt-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $user->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                            <span>{{ $user->is_active ? 'حساب نشط' : 'حساب معطل' }}</span>
                        </span>
                    </div>

                    <!-- Quick Action Buttons -->
                    <div class="grid grid-cols-2 gap-3 mt-6 pt-5 border-t border-slate-100">
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="py-2.5 px-4 rounded-xl text-xs font-bold text-white bg-blue-700 hover:bg-blue-800 transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-pen-to-square"></i>
                            <span>تعديل الحساب</span>
                        </a>

                        <button type="button"
                            onclick="openDeleteModal('{{ $user->id }}', '{{ addslashes($user->name) }}')"
                            class="py-2.5 px-4 rounded-xl text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 transition-colors flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-trash-can"></i>
                            <span>حذف المستخدم</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 text-right space-y-4">

        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>

        <div>
            <h3 class="text-lg font-bold text-slate-900">تأكيد حذف المستخدم</h3>
            <p class="text-sm text-slate-500 mt-1">
                هل أنت متأكد من رغبتك في حذف حساب المستخدم: <strong id="modal-user-name" class="text-slate-800"></strong>؟
            </p>
        </div>

        <form id="delete-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button"
                    onclick="closeDeleteModal()"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition-colors">
                    إلغاء
                </button>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-bold shadow-md shadow-red-900/20 transition-all">
                    تأكيد الحذف
                </button>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
    function copyText(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('تم نسخ النص إلى الحافظة: ' + text);
        });
    }

    function openDeleteModal(userId, userName) {
        const modal = document.getElementById('delete-modal');
        const form = document.getElementById('delete-form');
        const nameEl = document.getElementById('modal-user-name');

        form.action = `/admin/users/${userId}`;
        nameEl.textContent = userName;

        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100', 'pointer-events-auto');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100', 'pointer-events-auto');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
</script>
@endpush
@endsection