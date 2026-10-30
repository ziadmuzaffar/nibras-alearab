@extends('layouts.dashboard.app')

@section('title', __('تعديل المنتج') . ': ' . $product->name)

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>{{ __('تعديل المنتج') }}</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">{{ __('تحديث بيانات ومواصفات المنتج وصوره في الكتالوج') }}</p>
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
    <form action="{{ route('admin.products.update', $product) }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6">
        @csrf
        @method('PUT')

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
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                            value="{{ old('name', $product->name) }}"
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
                            <span class="text-[11px] font-normal text-slate-400 mr-2">{{ __('(يُستخدم في روابط التصفح)') }}</span>
                        </label>
                        <input type="text"
                            id="slug"
                            name="slug"
                            value="{{ old('slug', $product->slug) }}"
                            dir="ltr"
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('slug') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm font-mono text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                        @error('slug')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Short Description -->
                    <div>
                        <label for="short_description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('الوصف المختصر (يظهر في بطاقات الكتالوج)') }}
                        </label>
                        <textarea id="short_description"
                            name="short_description"
                            rows="2"
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('short_description') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">{{ old('short_description', $product->short_description) }}</textarea>
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
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('description') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">{{ old('description', $product->description) }}</textarea>
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
                        $currentSpecs = old('spec_keys')
                        ? array_combine(old('spec_keys'), old('spec_values', []))
                        : ($product->specifications ?? []);
                        @endphp

                        @if(!empty($currentSpecs) && is_array($currentSpecs))
                        @foreach($currentSpecs as $key => $val)
                        <div class="spec-row flex items-center gap-2 sm:gap-3 bg-slate-50/80 p-3 rounded-xl border border-slate-200/80">
                            <div class="w-1/3">
                                <input type="text"
                                    name="spec_keys[]"
                                    value="{{ $key }}"
                                    placeholder="{{ __('اسم الخاصية') }}"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-800 text-xs sm:text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-blue-600">
                            </div>
                            <div class="flex-1">
                                <input type="text"
                                    name="spec_values[]"
                                    value="{{ $val }}"
                                    placeholder="{{ __('القيمة أو التفاصيل') }}"
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
                        @else
                        <div class="spec-row flex items-center gap-2 sm:gap-3 bg-slate-50/80 p-3 rounded-xl border border-slate-200/80">
                            <div class="w-1/3">
                                <input type="text"
                                    name="spec_keys[]"
                                    value="{{ __('المقاسات') }}"
                                    placeholder="{{ __('اسم الخاصية') }}"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-800 text-xs sm:text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-blue-600">
                            </div>
                            <div class="flex-1">
                                <input type="text"
                                    name="spec_values[]"
                                    value="{{ __('مخصص حسب رغبة العميل') }}"
                                    placeholder="{{ __('القيمة أو التفاصيل') }}"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                            </div>
                            <button type="button"
                                onclick="removeSpecificationRow(this)"
                                class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                title="{{ __('حذف الخاصية') }}">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-2 pt-2 text-[11px] text-slate-500">
                        <span class="font-bold text-slate-600">{{ __('اقتراحات سريعة للإضافة:') }}</span>
                        <button type="button" onclick="addSuggestedSpec('{{ __('نوع الورق') }}', '{{ __('كوشيه 350 جرام') }}')" class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">{{ __('+ نوع الورق') }}</button>
                        <button type="button" onclick="addSuggestedSpec('{{ __('نوع الطباعة') }}', '{{ __('ألوان كاملة CMYK عالية الدقة') }}')" class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">{{ __('+ نوع الطباعة') }}</button>
                        <button type="button" onclick="addSuggestedSpec('{{ __('خيارات التشطيب') }}', '{{ __('سلوفان حراري مطفي / لامع') }}')" class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">{{ __('+ خيارات التشطيب') }}</button>
                        <button type="button" onclick="addSuggestedSpec('{{ __('أقل كمية مقترحة') }}', '{{ __('100 حبة') }}')" class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">{{ __('+ أقل كمية') }}</button>
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

                    <!-- Image Display / Replacement -->
                    <div class="space-y-3">
                        @if($product->featured_image)
                        <div id="current-image-container" class="relative w-full h-44 rounded-xl border border-slate-200 overflow-hidden bg-slate-100 group">
                            <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center p-4">
                                <a href="{{ asset($product->featured_image) }}" target="_blank" class="px-3 py-1.5 bg-white/90 text-slate-800 text-xs font-bold rounded-lg shadow-sm hover:bg-white transition-all flex items-center gap-1.5">
                                    <i class="fa-solid fa-up-right-from-square text-[11px]"></i>
                                    <span>{{ __('عرض الصورة الأصلية') }}</span>
                                </a>
                            </div>
                            <span class="absolute top-2 right-2 px-2 py-0.5 rounded-md bg-black/60 text-white text-[10px] font-bold backdrop-blur-xs">
                                {{ __('الصورة الحالية') }}
                            </span>
                        </div>

                        <!-- Checkbox to remove current image -->
                        <div id="remove-image-wrapper">
                            <label class="flex items-center gap-2 text-xs text-red-600 font-semibold cursor-pointer select-none">
                                <input type="checkbox"
                                    name="remove_featured_image"
                                    value="1"
                                    id="remove_featured_image"
                                    onchange="toggleRemoveImageState(this.checked)"
                                    class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                                <span>{{ __('حذف الصورة الرئيسية الحالية') }}</span>
                            </label>
                        </div>
                        @endif

                        <!-- Preview for new upload -->
                        <div id="image-preview-wrapper" class="hidden relative w-full h-44 rounded-xl border border-slate-200 overflow-hidden bg-slate-100 group">
                            <img id="image-preview" src="#" alt="{{ __('معاينة الصورة الجديدة') }}" class="w-full h-full object-cover">
                            <button type="button"
                                onclick="clearNewImageSelection()"
                                class="absolute top-2 left-2 p-1.5 rounded-lg bg-red-600/90 text-white hover:bg-red-700 shadow-md transition-colors"
                                title="{{ __('إلغاء الصورة الجديدة') }}">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Upload Box -->
                        <label id="upload-box" class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-slate-300 hover:border-blue-500 rounded-xl cursor-pointer bg-slate-50/50 hover:bg-blue-50/20 transition-all p-4 text-center">
                            <div class="w-9 h-9 rounded-full bg-blue-100/70 text-blue-700 flex items-center justify-center mb-1.5">
                                <i class="fa-solid fa-cloud-arrow-up text-sm"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700">{{ $product->featured_image ? __('تغيير / استبدال الصورة الرئيسية') : __('اضغط لرفع الصورة الرئيسية') }}</span>
                            <span class="text-[10px] text-slate-400 mt-0.5">{{ __('PNG, JPG, WEBP حتى 3MB') }}</span>
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

                <!-- Gallery Images Card -->
                <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-purple-600"></span>
                            <span>{{ __('معرض الصور الإضافية') }}</span>
                        </h3>
                        <span class="text-xs font-mono font-bold text-purple-700 bg-purple-50 px-2 py-0.5 rounded-md">
                            {{ $product->images->count() }} {{ __('صور') }}
                        </span>
                    </div>

                    <!-- Existing Gallery Images -->
                    @if($product->images->isNotEmpty())
                    <div class="space-y-2">
                        <p class="text-[11px] font-bold text-slate-600">{{ __('الصور الحالية (حدد ما ترغب بحذفه):') }}</p>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach($product->images as $img)
                            <div class="relative w-full h-20 rounded-xl border border-slate-200 overflow-hidden bg-slate-100 group shadow-2xs">
                                <img src="{{ asset($img->image_path) }}" class="w-full h-full object-cover">
                                <label class="absolute inset-0 bg-slate-950/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center cursor-pointer p-1 text-center">
                                    <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="rounded text-red-600 focus:ring-red-500 mb-1">
                                    <span class="text-[9px] text-white font-bold leading-tight">{{ __('تحديد للحذف') }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Upload New Gallery Images -->
                    <div>
                        <label class="flex flex-col items-center justify-center w-full py-3.5 border-2 border-dashed border-slate-300 hover:border-purple-500 rounded-xl cursor-pointer bg-slate-50/50 hover:bg-purple-50/20 transition-all text-center">
                            <i class="fa-solid fa-plus text-purple-600 text-sm mb-1"></i>
                            <span class="text-xs font-bold text-slate-700">{{ __('إضافة صور جديدة للمعرض') }}</span>
                            <span class="text-[10px] text-slate-400">{{ __('يمكنك اختيار ملفات متعددة') }}</span>
                            <input type="file"
                                id="gallery-input"
                                name="gallery_images[]"
                                accept="image/*"
                                multiple
                                class="hidden"
                                onchange="previewGalleryImages(this)">
                        </label>
                        <div id="gallery-preview-container" class="grid grid-cols-3 gap-2 mt-2 empty:hidden"></div>
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
                                    {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
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
                                    {{ old('is_active', $product->is_active) ? 'checked' : '' }}
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
                        <span>{{ __('تحديث وحفظ التعديلات') }}</span>
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
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function clearNewImageSelection() {
        const input = document.getElementById('image-input');
        input.value = '';
        document.getElementById('image-preview-wrapper').classList.add('hidden');
    }

    function toggleRemoveImageState(isRemoving) {
        const currentContainer = document.getElementById('current-image-container');
        if (currentContainer) {
            currentContainer.style.opacity = isRemoving ? '0.3' : '1';
        }
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