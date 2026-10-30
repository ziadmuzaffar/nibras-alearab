@extends('layouts.dashboard.app')

@section('title', __('تعديل طلب عرض السعر') . ' #' . $quoteRequest->id)

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>{{ __('تعديل طلب عرض السعر') }}</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">{{ __('تحديث بيانات العميل وتفاصيل المواصفات وحالة الطلب في سجلات نبراس العرب') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.quote-requests.index') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 hover:text-slate-900 shadow-sm transition-all duration-200 active:scale-[0.98]">
                <svg class="w-4 h-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>{{ __('العودة للقائمة') }}</span>
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <form action="{{ route('admin.quote-requests.update', $quoteRequest) }}"
        method="POST"
        class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Main Information (8 cols) -->
            <div class="lg:col-span-8 space-y-6">

                <!-- Customer Details Card -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        <span>{{ __('بيانات العميل والتواصل') }}</span>
                    </h3>

                    <!-- Customer Name -->
                    <div>
                        <label for="customer_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('اسم العميل / الجهة الطالبة') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            id="customer_name"
                            name="customer_name"
                            value="{{ old('customer_name', $quoteRequest->customer_name) }}"
                            placeholder="{{ __('مثال: عبدالله السعيد، شركة آفاق الدعاية...') }}"
                            required
                            class="w-full h-12 px-4 rounded-xl border {{ $errors->has('customer_name') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                        @error('customer_name')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone & Email Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                {{ __('رقم الهاتف / الجوال') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                id="phone"
                                name="phone"
                                value="{{ old('phone', $quoteRequest->phone) }}"
                                placeholder="{{ __('مثال: 0501234567') }}"
                                required
                                dir="ltr"
                                class="w-full h-12 px-4 text-start rounded-xl border {{ $errors->has('phone') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            @error('phone')
                            <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                {{ __('البريد الإلكتروني') }}
                                <span class="text-[11px] font-normal text-slate-400 mr-1">{{ __('(اختياري)') }}</span>
                            </label>
                            <input type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $quoteRequest->email) }}"
                                placeholder="name@company.com"
                                dir="ltr"
                                class="w-full h-12 px-4 text-start rounded-xl border {{ $errors->has('email') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            @error('email')
                            <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>

                <!-- Order Details Card -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        <span>{{ __('تفاصيل ومواصفات المنتج المطلوب') }}</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Product Selection -->
                        <div>
                            <label for="product_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                {{ __('المنتج المطلوب') }}
                                <span class="text-[11px] font-normal text-slate-400 mr-1">{{ __('(اختياري)') }}</span>
                            </label>
                            <select id="product_id"
                                name="product_id"
                                class="w-full h-12 px-4 rounded-xl border {{ $errors->has('product_id') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                                <option value="">{{ __('-- طلب مخصص عام (بدون منتج محدد) --') }}</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id', $quoteRequest->product_id) == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('product_id')
                            <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label for="quantity" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                {{ __('الكمية التقريبية المطلوبة') }}
                                <span class="text-[11px] font-normal text-slate-400 mr-1">{{ __('(اختياري)') }}</span>
                            </label>
                            <input type="number"
                                id="quantity"
                                name="quantity"
                                min="1"
                                step="1"
                                value="{{ old('quantity', $quoteRequest->quantity) }}"
                                placeholder="{{ __('مثال: 500, 1000...') }}"
                                class="w-full h-12 px-4 rounded-xl border {{ $errors->has('quantity') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            @error('quantity')
                            <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Notes / Specifications -->
                    <div>
                        <label for="notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('تفاصيل ومواصفات الطلب والملاحظات') }}
                            <span class="text-[11px] font-normal text-slate-400 mr-1">{{ __('(اختياري)') }}</span>
                        </label>
                        <textarea id="notes"
                            name="notes"
                            rows="5"
                            placeholder="{{ __('اكتب مواصفات المقاسات، نوع الورق أو الخامات، ألوان الطباعة، التشطيب (سلوفان، بصمة ذهبية، يو في بارز)، وموعد التسليم المستهدف...') }}"
                            class="w-full p-4 rounded-xl border {{ $errors->has('notes') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all leading-relaxed">{{ old('notes', $quoteRequest->notes) }}</textarea>
                        @error('notes')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

            </div>

            <!-- Side Organization & Actions (4 cols) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- Status Card -->
                <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <span>{{ __('حالة الطلب ومساره') }}</span>
                        </div>
                        <span class="text-xs text-red-500 font-bold">* {{ __('مطلوبة') }}</span>
                    </h3>

                    <div>
                        <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('الحالة الحالية') }}
                        </label>
                        <select id="status"
                            name="status"
                            required
                            class="w-full h-12 px-4 rounded-xl border {{ $errors->has('status') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm font-semibold focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            @foreach($statuses as $statusKey => $statusLabel)
                            <option value="{{ $statusKey }}" {{ old('status', $quoteRequest->status) == $statusKey ? 'selected' : '' }}>
                                {{ __($statusLabel) }}
                            </option>
                            @endforeach
                        </select>
                        @error('status')
                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Record Metadata Card -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 shadow-2xs space-y-3">
                    <h4 class="text-xs font-bold text-slate-700 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-blue-600 text-sm"></i>
                        <span>{{ __('بيانات التسجيل في النظام') }}</span>
                    </h4>
                    <div class="text-xs text-slate-600 space-y-2">
                        <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                            <span class="text-slate-400">{{ __('رقم الطلب:') }}</span>
                            <span class="font-mono font-bold text-slate-800">#{{ $quoteRequest->id }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                            <span class="text-slate-400">{{ __('تاريخ الاستلام:') }}</span>
                            <span class="font-mono text-slate-700">{{ $quoteRequest->created_at ? $quoteRequest->created_at->format('Y-m-d H:i') : '—' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1">
                            <span class="text-slate-400">{{ __('آخر تحديث:') }}</span>
                            <span class="font-mono text-slate-700">{{ $quoteRequest->updated_at ? $quoteRequest->updated_at->diffForHumans() : '—' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
                    <button type="submit"
                        class="w-full py-3 px-5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-800 hover:to-red-700 shadow-md shadow-blue-900/20 hover:shadow-lg transition-all duration-200 active:scale-[0.98] flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>{{ __('تحديث وحفظ التعديلات') }}</span>
                    </button>

                    <a href="{{ route('admin.quote-requests.show', $quoteRequest) }}"
                        class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-800 hover:bg-slate-100 transition-colors flex items-center justify-center gap-1.5">
                        <span>{{ __('إلغاء والعودة للمعاينة') }}</span>
                    </a>
                </div>

            </div>

        </div>

    </form>

</div>
@endsection