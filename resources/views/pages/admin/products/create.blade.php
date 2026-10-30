@extends('layouts.dashboard.app')

@section('title', __('إضافة منتج جديد'))

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>{{ __('إضافة منتج جديد') }}</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">{{ __('أدخل بيانات المنتج والمواصفات الفنية وصور المعرض لكتالوج نبراس العرب') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 hover:text-slate-900 shadow-sm transition-all duration-200 active:scale-[0.98]">
                <svg class="w-4 h-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>{{ __('العودة للمنتجات') }}</span>
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <form action="{{ route('admin.products.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Main Information (Left on desktop RTL = 8 cols) -->
            <div class="lg:col-span-8 space-y-6">

                <!-- Basic Fields Card -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        <span>{{ __('البيانات الأساسية للمنتج') }}</span>
                    </h3>

                    <!-- Category Field -->
                    <div>
                        <label for="category_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('التصنيف أو القسم') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id"
                            name="category_id"
                            required
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('category_id') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            <option value="">{{ __('-- اختر التصنيف التابع له --') }}</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('اسم المنتج') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="{{ __('مثال: كروت شخصية فاخرة، علب برجر مخصصة، رول اب بنر إعلاني...') }}"
                            required
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                        @error('name')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug Field -->
                    <div>
                        <label for="slug" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('الرابط المخصص (Slug)') }}
                            <span class="text-[11px] font-normal text-slate-400 mr-2">{{ __('(يُترك فارغاً للتوليد التلقائي من الاسم)') }}</span>
                        </label>
                        <input type="text"
                            id="slug"
                            name="slug"
                            value="{{ old('slug') }}"
                            placeholder="luxury-business-cards"
                            dir="ltr"
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('slug') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm font-mono text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                        @error('slug')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Short Description -->
                    <div>
                        <label for="short_description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('الوصف المختصر (يظهر في بطاقات الكتالوج وقوائم المنتجات)') }}
                        </label>
                        <textarea id="short_description"
                            name="short_description"
                            rows="2"
                            placeholder="{{ __('نبذة سريعة ومختصرة تلخص نوع المطبوعة وميزاتها الأساسية...') }}"
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('short_description') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">{{ old('short_description') }}</textarea>
                        @error('short_description')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Detailed Description -->
                    <div>
                        <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('الوصف الشامل وتفاصيل التنفيذ') }}
                        </label>
                        <textarea id="description"
                            name="description"
                            rows="5"
                            placeholder="{{ __('شرح كامل عن استخدامات المنتج وخيارات الطباعة وإرشادات تسليم التصاميم...') }}"
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('description') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Specifications Card -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div>
                            <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                                <span>{{ __('المواصفات الفنية وخيارات التنفيذ') }}</span>
                            </h3>
                            <p class="text-xs text-slate-400 mt-1">{{ __('تحديد خامات الورق، المقاسات، والتشطيبات لعرضها في صفحة المنتج') }}</p>
                        </div>
                        <button type="button"
                            onclick="addSpecificationRow()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-blue-700 bg-blue-50 border border-blue-200/70 hover:bg-blue-100 transition-colors shadow-2xs">
                            <i class="fa-solid fa-plus text-[10px]"></i>
                            <span>{{ __('إضافة خاصية') }}</span>
                        </button>
                    </div>

                    <!-- Specifications Repeater Table / Container -->
                    <div id="specifications-container" class="space-y-3">
                        @php
                        $oldKeys = old('spec_keys', [__('نوع الورق / الخامة'), __('المقاسات المتاحة'), __('خيارات التشطيب')]);
                        $oldValues = old('spec_values', [__('كوشيه فاخر 350 جرام'), __('قياسي ومخصص حسب الطلب'), __('سلوفان حراري مطفي / لامع')]);
                        @endphp

                        @foreach($oldKeys as $index => $key)
                        <div class="spec-row flex items-center gap-2 sm:gap-3 bg-slate-50/80 p-3 rounded-xl border border-slate-200/80">
                            <div class="w-1/3">
                                <input type="text"
                                    name="spec_keys[]"
                                    value="{{ $key }}"
                                    placeholder="{{ __('اسم الخاصية (مثل: المقاس)') }}"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-800 text-xs sm:text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-blue-600">
                            </div>
                            <div class="flex-1">
                                <input type="text"
                                    name="spec_values[]"
                                    value="{{ $oldValues[$index] ?? '' }}"
                                    placeholder="{{ __('القيمة (مثل: A4 أو 9x5 سم)') }}"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                            </div>
                            <button type="button"
                                onclick="removeSpecificationRow(this)"
                                class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                title="{{ __('حذف الخاصية') }}">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>

                    <div class="flex flex-wrap items-center gap-2 pt-2 text-[11px] text-slate-500">
                        <span class="font-bold text-slate-600">{{ __('اقتراحات سريعة للإضافة:') }}</span>
                        <button type="button" onclick="addSuggestedSpec(@js(__('أقل كمية مقترحة')), @js(__('100 حبة')))" class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">+ {{ __('أقل كمية') }}</button>
                        <button type="button" onclick="addSuggestedSpec(@js(__('نوع الطباعة')), @js(__('ألوان كاملة CMYK عالية الدقة')))" class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">+ {{ __('نوع الطباعة') }}</button>
                        <button type="button" onclick="addSuggestedSpec(@js(__('مدة التنفيذ والتسليم')), @js(__('من 2 إلى 4 أيام عمل')))" class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">+ {{ __('مدة التنفيذ') }}</button>
                        <button type="button" onclick="addSuggestedSpec(@js(__('اللمسات الخاصة')), @js(__('بصمة ذهبية / فضية، سبوت يو في')))" class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">+ {{ __('اللمسات الخاصة') }}</button>
                    </div>
                </div>

            </div>

            <!-- Side Organization & Media (4 cols) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- Featured Image Card -->
                <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        <span>{{ __('صورة المنتج الرئيسية') }}</span>
                    </h3>

                    <!-- Image Dropzone / Preview -->
                    <div class="space-y-3">
                        <div id="image-preview-wrapper" class="hidden relative w-full h-44 rounded-xl border border-slate-200 overflow-hidden bg-slate-100 group">
                            <img id="image-preview" src="#" alt="{{ __('معاينة الصورة') }}" class="w-full h-full object-cover">
                            <button type="button"
                                onclick="clearImageSelection()"
                                class="absolute top-2 left-2 p-1.5 rounded-lg bg-red-600/90 text-white hover:bg-red-700 shadow-md transition-colors"
                                title="{{ __('إزالة الصورة') }}">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <label id="upload-box" class="flex flex-col items-center justify-center w-full h-44 border-2 border-dashed border-slate-300 hover:border-blue-500 rounded-xl cursor-pointer bg-slate-50/50 hover:bg-blue-50/20 transition-all p-4 text-center">
                            <div class="w-10 h-10 rounded-full bg-blue-100/70 text-blue-700 flex items-center justify-center mb-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-slate-700">{{ __('اضغط لرفع الصورة الرئيسية') }}</span>
                            <span class="text-[10px] text-slate-400 mt-1">{{ __('PNG, JPG, WEBP حتى 3MB') }}</span>
                            <input type="file"
                                id="image-input"
                                name="featured_image"
                                accept="image/*"
                                class="hidden"
                                onchange="previewUploadedImage(this)">
                        </label>
                        @error('featured_image')
                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Additional Gallery Images Card -->
                <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-purple-600"></span>
                        <span>{{ __('معرض الصور الإضافية للمنتج') }}</span>
                    </h3>

                    <div>
                        <label class="flex flex-col items-center justify-center w-full py-4 border-2 border-dashed border-slate-300 hover:border-purple-500 rounded-xl cursor-pointer bg-slate-50/50 hover:bg-purple-50/20 transition-all text-center">
                            <i class="fa-solid fa-images text-purple-600 text-xl mb-1.5"></i>
                            <span class="text-xs font-bold text-slate-700">{{ __('اختيار صور متعددة للمعرض') }}</span>
                            <span class="text-[10px] text-slate-400 mt-0.5">{{ __('يمكنك اختيار عدة صور معاً') }}</span>
                            <input type="file"
                                id="gallery-input"
                                name="gallery_images[]"
                                accept="image/*"
                                multiple
                                class="hidden"
                                onchange="previewGalleryImages(this)">
                        </label>

                        <!-- Selected Gallery Files Container -->
                        <div id="gallery-preview-container" class="grid grid-cols-3 gap-2 mt-3 empty:hidden"></div>

                        @error('gallery_images.*')
                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Settings Card (Featured & Active) -->
                <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-slate-600"></span>
                        <span>{{ __('خيارات العرض والتمييز') }}</span>
                    </h3>

                    <!-- Featured Toggle -->
                    <div>
                        <label class="flex items-center justify-between cursor-pointer p-3 rounded-xl bg-slate-50 border border-slate-200/80 hover:bg-slate-100/70 transition-colors">
                            <span class="flex flex-col">
                                <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                    <i class="fa-solid fa-star text-amber-500 text-xs"></i>
                                    <span>{{ __('منتج مميز (Featured)') }}</span>
                                </span>
                                <span class="text-[11px] text-slate-500">{{ __('يظهر في القسم المميز بالصفحة الرئيسية') }}</span>
                            </span>
                            <div class="relative inline-flex items-center">
                                <input type="checkbox"
                                    name="is_featured"
                                    value="1"
                                    {{ old('is_featured') ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                            </div>
                        </label>
                    </div>

                    <!-- Active Toggle -->
                    <div>
                        <label class="flex items-center justify-between cursor-pointer p-3 rounded-xl bg-slate-50 border border-slate-200/80 hover:bg-slate-100/70 transition-colors">
                            <span class="flex flex-col">
                                <span class="text-xs font-bold text-slate-800">{{ __('حالة التفعيل') }}</span>
                                <span class="text-[11px] text-slate-500">{{ __('عرض المنتج في الكتالوج للعملاء') }}</span>
                            </span>
                            <div class="relative inline-flex items-center">
                                <input type="checkbox"
                                    name="is_active"
                                    value="1"
                                    {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Submit Action Box -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
                    <button type="submit"
                        class="w-full py-3 px-6 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-800 hover:to-red-700 shadow-md shadow-blue-900/20 hover:shadow-lg transition-all duration-200 active:scale-[0.98] flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ __('حفظ وإضافة المنتج') }}</span>
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                        class="block w-full py-2.5 text-center text-xs font-semibold text-slate-500 hover:text-slate-700 rounded-xl hover:bg-slate-50 transition-colors">
                        {{ __('إلغاء والتراجع') }}
                    </a>
                </div>

            </div>

        </div>

    </form>

</div>

@push('scripts')
<script>
    // Featured Image Preview
    function previewUploadedImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview-wrapper').classList.remove('hidden');
                document.getElementById('upload-box').classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function clearImageSelection() {
        const input = document.getElementById('image-input');
        input.value = '';
        document.getElementById('image-preview-wrapper').classList.add('hidden');
        document.getElementById('upload-box').classList.remove('hidden');
    }

    // Gallery Images Preview
    function previewGalleryImages(input) {
        const container = document.getElementById('gallery-preview-container');
        container.innerHTML = '';

        if (input.files) {
            Array.from(input.files).forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative w-full h-16 rounded-lg border border-slate-200 overflow-hidden bg-slate-100 shadow-2xs';
                    div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    container.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    // Specifications Management
    function addSpecificationRow(key = '', val = '') {
        const container = document.getElementById('specifications-container');
        const row = document.createElement('div');
        row.className = 'spec-row flex items-center gap-2 sm:gap-3 bg-slate-50/80 p-3 rounded-xl border border-slate-200/80 animate-fade-in';
        row.innerHTML = `
            <div class="w-1/3">
                <input type="text"
                    name="spec_keys[]"
                    value="${key}"
                    placeholder="{{ __('اسم الخاصية') }}"
                    class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-800 text-xs sm:text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>
            <div class="flex-1">
                <input type="text"
                    name="spec_values[]"
                    value="${val}"
                    placeholder="{{ __('القيمة أو التفاصيل') }}"
                    class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>
            <button type="button"
                onclick="removeSpecificationRow(this)"
                class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                title="{{ __('حذف الخاصية') }}">
                <i class="fa-solid fa-trash-can text-sm"></i>
            </button>
        `;
        container.appendChild(row);
    }

    function removeSpecificationRow(btn) {
        const row = btn.closest('.spec-row');
        if (row) row.remove();
    }

    function addSuggestedSpec(key, val) {
        addSpecificationRow(key, val);
    }
</script>
@endpush
@endsection