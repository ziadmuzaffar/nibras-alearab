@extends('layouts.dashboard.app')

@php
    $isRtl = LaravelLocalization::getCurrentLocaleDirection() === 'rtl';
@endphp

@section('title', __('main.add_new_category'))

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>{{ __('main.add_new_category') }}</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">{{ __('main.add_category_desc') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.categories.index') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 hover:text-slate-900 shadow-sm transition-all duration-200 active:scale-[0.98]">
                <svg class="w-4 h-4 {{ $isRtl ? 'rotate-0' : 'rotate-180' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>{{ __('main.back_to_categories') }}</span>
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <form action="{{ route('admin.categories.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Main Information (Left on desktop RTL = 8 cols) -->
            <div class="lg:col-span-8 space-y-6">

                <!-- Basic Fields Card (Spatie Translatable Bilingual) -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        <span>{{ __('main.basic_info') }}</span>
                    </h3>

                    <!-- Bilingual Names Grid (Arabic & English) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name Field (Arabic) -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                {{ __('main.category_name_ar') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="{{ __('main.category_name_ar_placeholder') }}"
                                required
                                dir="rtl"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            @error('name')
                            <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name Field (English) -->
                        <div>
                            <label for="name_en" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                {{ __('main.category_name_en') }}
                            </label>
                            <input type="text"
                                id="name_en"
                                name="name_en"
                                value="{{ old('name_en') }}"
                                placeholder="{{ __('main.category_name_en_placeholder') }}"
                                dir="ltr"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name_en') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            @error('name_en')
                            <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Slug Field -->
                    <div>
                        <label for="slug" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('main.category_slug') }}
                            <span class="text-[11px] font-normal text-slate-400 mr-2">{{ __('main.category_slug_hint_auto') }}</span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                id="slug"
                                name="slug"
                                value="{{ old('slug') }}"
                                placeholder="packaging-boxes"
                                dir="ltr"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('slug') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm font-mono text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                        </div>
                        @error('slug')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icon Field (Clean Text Input with Live Preview) -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="icon-input" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                {{ __('main.category_icon') }} <span class="text-blue-600 font-semibold">(Font Awesome)</span>
                            </label>
                            <a href="https://fontawesome.com/icons?o=r&m=free" target="_blank" rel="noopener noreferrer" class="text-[11px] font-medium text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                                <span>{{ __('main.browse_icons') }}</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            </a>
                        </div>
                        @php
                        $selectedIcon = old('icon', 'box');
                        @endphp
                        <div class="flex items-center gap-3">
                            <!-- Icon Preview Box -->
                            <div id="icon-preview-box"
                                class="w-12 h-12 shrink-0 rounded-xl bg-blue-50/90 border border-blue-200 text-blue-700 flex items-center justify-center shadow-sm transition-all"
                                title="{{ __('main.icon_preview') }}">
                                <span id="icon-preview-icon" class="flex items-center justify-center">
                                    <x-category-icon :icon="$selectedIcon" class="w-6 h-6" />
                                </span>
                            </div>

                            <!-- Clean Text Input -->
                            <div class="flex-1">
                                <input type="text"
                                    id="icon-input"
                                    name="icon"
                                    value="{{ $selectedIcon }}"
                                    placeholder="{{ __('main.icon_placeholder') }}"
                                    dir="ltr"
                                    oninput="updateIconPreview(this.value)"
                                    class="w-full px-4 py-3 rounded-xl border {{ $errors->has('icon') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm font-mono text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            </div>
                        </div>

                        @error('icon')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

            <!-- Side Organization & Media (4 cols) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- Image Card -->
                <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        <span>{{ __('main.category_image') }}</span>
                    </h3>

                    <!-- Image Dropzone / Preview -->
                    <div class="space-y-3">
                        <div id="image-preview-wrapper" class="hidden relative w-full h-44 rounded-xl border border-slate-200 overflow-hidden bg-slate-100 group">
                            <img id="image-preview" src="#" alt="{{ __('main.image_preview') }}" class="w-full h-full object-cover">
                            <button type="button"
                                onclick="clearImageSelection()"
                                class="absolute top-2 left-2 p-1.5 rounded-lg bg-red-600/90 text-white hover:bg-red-700 shadow-md transition-colors"
                                title="{{ __('main.remove_image') }}">
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
                            <span class="text-xs font-bold text-slate-700">{{ __('main.upload_category_image') }}</span>
                            <span class="text-[10px] text-slate-400 mt-1">{{ __('main.image_specs_hint') }}</span>
                            <input type="file"
                                id="image-input"
                                name="image"
                                accept="image/*"
                                class="hidden"
                                onchange="previewUploadedImage(this)">
                        </label>
                        @error('image')
                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Settings Card (Order & Status) -->
                <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-slate-600"></span>
                        <span>{{ __('main.display_settings') }}</span>
                    </h3>

                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('main.display_order') }}
                        </label>
                        <input type="number"
                            id="order"
                            name="order"
                            value="{{ old('order', $nextOrder) }}"
                            min="0"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <p class="text-[11px] text-slate-400 mt-1">{{ __('main.display_order_hint') }}</p>
                    </div>

                    <!-- Active Toggle -->
                    <div class="pt-2">
                        <label class="flex items-center justify-between cursor-pointer p-3 rounded-xl bg-slate-50 border border-slate-200/80 hover:bg-slate-100/70 transition-colors">
                            <span class="flex flex-col">
                                <span class="text-xs font-bold text-slate-800">{{ __('main.activation_status') }}</span>
                                <span class="text-[11px] text-slate-500">{{ __('main.activation_status_desc') }}</span>
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
                        <span>{{ __('main.save_category') }}</span>
                    </button>
                    <a href="{{ route('admin.categories.index') }}"
                        class="block w-full py-2.5 text-center text-xs font-semibold text-slate-500 hover:text-slate-700 rounded-xl hover:bg-slate-50 transition-colors">
                        {{ __('main.cancel_return') }}
                    </a>
                </div>

            </div>

        </div>

    </form>

</div>

@push('scripts')
<script>
    // Live Font Awesome category icon preview resolver
    function resolveFaClass(val) {
        if (!val) return 'fa-solid fa-box-open';
        const v = val.trim();
        const map = {
            'box': 'fa-solid fa-box-open',
            'boxes': 'fa-solid fa-boxes-stacked',
            'packaging': 'fa-solid fa-box-open',
            'card': 'fa-solid fa-id-card',
            'cards': 'fa-solid fa-id-card',
            'bag': 'fa-solid fa-bag-shopping',
            'bags': 'fa-solid fa-bag-shopping',
            'book': 'fa-solid fa-book-open',
            'books': 'fa-solid fa-book-open',
            'tag': 'fa-solid fa-tags',
            'tags': 'fa-solid fa-tags',
            'sticker': 'fa-solid fa-tags',
            'stickers': 'fa-solid fa-tags',
            'printer': 'fa-solid fa-print',
            'print': 'fa-solid fa-print',
            'gift': 'fa-solid fa-gift',
            'gifts': 'fa-solid fa-gift',
            'flag': 'fa-solid fa-flag',
            'banner': 'fa-solid fa-flag',
            'folder': 'fa-solid fa-folder-open',
            'folders': 'fa-solid fa-folder-open',
            'stamp': 'fa-solid fa-stamp',
            'seal': 'fa-solid fa-stamp',
            'shirt': 'fa-solid fa-shirt',
            'clothes': 'fa-solid fa-shirt',
            'cup': 'fa-solid fa-mug-hot',
            'mug': 'fa-solid fa-mug-hot',
            'calendar': 'fa-solid fa-calendar-days',
            'pen': 'fa-solid fa-pen-nib',
            'palette': 'fa-solid fa-palette',
            'envelope': 'fa-solid fa-envelope-open-text',
            'certificate': 'fa-solid fa-certificate',
            'award': 'fa-solid fa-award',
            'ribbon': 'fa-solid fa-ribbon',
            'newspaper': 'fa-solid fa-newspaper',
            'barcode': 'fa-solid fa-barcode',
            'qrcode': 'fa-solid fa-qrcode',
            'shapes': 'fa-solid fa-shapes',
            'layer-group': 'fa-solid fa-layer-group',
            'truck': 'fa-solid fa-truck-fast',
            'image': 'fa-solid fa-image'
        };

        const lower = v.toLowerCase();
        if (map[lower]) return map[lower];

        if (lower.startsWith('fa-solid ') || lower.startsWith('fa-regular ') || lower.startsWith('fa-brands ') || lower.startsWith('fas ') || lower.startsWith('far ') || lower.startsWith('fab ')) {
            return v;
        }

        if (lower.startsWith('fa-')) {
            return 'fa-solid ' + v;
        }

        return 'fa-solid fa-' + v;
    }

    function updateIconPreview(key) {
        const container = document.getElementById('icon-preview-icon');
        if (container) {
            const fa = resolveFaClass(key);
            container.innerHTML = `<span class="w-6 h-6 inline-flex items-center justify-center text-xl text-blue-700 leading-none" aria-hidden="true"><i class="${fa}"></i></span>`;
        }
    }

    // Image preview
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
</script>
@endpush
@endsection
