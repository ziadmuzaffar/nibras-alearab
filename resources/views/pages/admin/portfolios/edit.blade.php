@extends('layouts.dashboard.app')

@section('title', __('تعديل العمل') . ': ' . $portfolio->title)

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>{{ __('تعديل العمل / المشروع') }}</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">{{ __('تحديث بيانات المشروع والجهة المستفيدة وصورة النموذج في سابقة الأعمال') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.portfolios.show', $portfolio) }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 hover:text-slate-900 shadow-sm transition-all duration-200 active:scale-[0.98]">
                <i class="fa-solid fa-eye text-xs"></i>
                <span>{{ __('معاينة العمل') }}</span>
            </a>
            <a href="{{ route('admin.portfolios.index') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 hover:text-slate-900 shadow-sm transition-all duration-200 active:scale-[0.98]">
                <svg class="w-4 h-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>{{ __('العودة للقائمة') }}</span>
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <form action="{{ route('admin.portfolios.update', $portfolio) }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Main Information (8 cols) -->
            <div class="lg:col-span-8 space-y-6">

                <!-- Basic Fields Card -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        <span>{{ __('بيانات ومعلومات العمل أو المشروع') }}</span>
                    </h3>

                    <!-- Title Field -->
                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('عنوان العمل / المشروع') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            id="title"
                            name="title"
                            value="{{ old('title', $portfolio->title) }}"
                            placeholder="{{ __('مثال: تصميم وتنفيذ علب فاخرة لمجموعة عطور ملكية...') }}"
                            required
                            class="w-full h-12 px-4 rounded-xl border {{ $errors->has('title') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                        @error('title')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Field -->
                    <div>
                        <label for="category_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('التصنيف أو القسم التابع له') }}
                            <span class="text-[11px] font-normal text-slate-400 mr-1">{{ __('(اختياري)') }}</span>
                        </label>
                        <select id="category_id"
                            name="category_id"
                            class="w-full h-12 px-4 rounded-xl border {{ $errors->has('category_id') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            <option value="">{{ __('-- بدون تصنيف (عمل عام) --') }}</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $portfolio->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Client Name Field -->
                    <div>
                        <label for="client_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('اسم العميل / الجهة المستفيدة') }}
                            <span class="text-[11px] font-normal text-slate-400 mr-1">{{ __('(اختياري)') }}</span>
                        </label>
                        <input type="text"
                            id="client_name"
                            name="client_name"
                            value="{{ old('client_name', $portfolio->client_name) }}"
                            placeholder="{{ __('مثال: شركة ألفا للاستثمار، مطعم وكافيه جمر...') }}"
                            class="w-full h-12 px-4 rounded-xl border {{ $errors->has('client_name') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                        @error('client_name')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description Field -->
                    <div>
                        <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('تفاصيل وشرح العمل المنفذ') }}
                            <span class="text-[11px] font-normal text-slate-400 mr-1">{{ __('(اختياري)') }}</span>
                        </label>
                        <textarea id="description"
                            name="description"
                            rows="5"
                            placeholder="{{ __('اكتب شرحاً وافياً عن مواصفات المشروع، خامات الورق المستخدمة، تقنيات الطباعة، التشطيب، والكميات المنفذة...') }}"
                            class="w-full p-4 rounded-xl border {{ $errors->has('description') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all leading-relaxed">{{ old('description', $portfolio->description) }}</textarea>
                        @error('description')
                        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

            </div>

            <!-- Side Organization & Media (4 cols) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- Featured Image Card -->
                <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                            <span>{{ __('صورة العمل الحالية') }}</span>
                        </div>
                        <span class="text-xs text-slate-400 font-normal">{{ __('اختياري للتغيير') }}</span>
                    </h3>

                    <!-- Image Dropzone / Preview -->
                    <div class="space-y-3">
                        <div id="image-preview-wrapper" class="relative w-full h-52 rounded-xl border border-slate-200 overflow-hidden bg-slate-900 group">
                            <img id="image-preview" src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center p-4">
                                <label for="image-input" class="cursor-pointer px-3.5 py-2 rounded-xl bg-white text-slate-900 text-xs font-bold shadow-lg hover:bg-slate-100 transition-colors flex items-center gap-1.5">
                                    <i class="fa-solid fa-camera"></i>
                                    <span>{{ __('تغيير الصورة') }}</span>
                                </label>
                            </div>
                        </div>

                        <label id="upload-box" class="hidden flex flex-col items-center justify-center w-full h-52 border-2 border-dashed {{ $errors->has('image') ? 'border-red-400 bg-red-50/20' : 'border-slate-300 hover:border-blue-500 bg-slate-50/50 hover:bg-blue-50/20' }} rounded-xl cursor-pointer transition-all p-4 text-center">
                            <div class="w-12 h-12 rounded-full bg-blue-100/70 text-blue-700 flex items-center justify-center mb-2">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-slate-700">{{ __('اضغط لرفع صورة بديلة') }}</span>
                            <span class="text-[11px] text-slate-400 mt-1">{{ __('PNG, JPG, WEBP حتى 5MB') }}</span>
                        </label>

                        <input type="file"
                            id="image-input"
                            name="image"
                            accept="image/*"
                            class="hidden"
                            onchange="previewUploadedImage(this)">

                        <div class="flex items-center justify-between text-[11px] text-slate-400 px-1">
                            <span>{{ __('اترك حقل الصورة فارغاً للإبقاء على الصورة الحالية') }}</span>
                        </div>

                        @error('image')
                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Meta Info Card -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
                    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider pb-2 border-b border-slate-100">
                        {{ __('معلومات السجل') }}
                    </h4>
                    <div class="space-y-2 text-xs">
                        <div class="flex items-center justify-between text-slate-500">
                            <span>{{ __('رقم المعرف:') }}</span>
                            <span class="font-mono font-bold text-slate-800">#{{ $portfolio->id }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-500">
                            <span>{{ __('تاريخ الإنشاء:') }}</span>
                            <span class="font-mono text-slate-700">{{ $portfolio->created_at ? $portfolio->created_at->format('Y-m-d H:i') : '—' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-500">
                            <span>{{ __('آخر تحديث:') }}</span>
                            <span class="font-mono text-slate-700">{{ $portfolio->updated_at ? $portfolio->updated_at->format('Y-m-d H:i') : '—' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
                    <button type="submit"
                        class="w-full py-3 px-5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-800 hover:to-red-700 shadow-md shadow-blue-900/20 hover:shadow-lg transition-all duration-200 active:scale-[0.98] flex items-center justify-center gap-2">
                        <i class="fa-solid fa-check-double"></i>
                        <span>{{ __('تحديث وحفظ التعديلات') }}</span>
                    </button>

                    <a href="{{ route('admin.portfolios.index') }}"
                        class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-800 hover:bg-slate-100 transition-colors flex items-center justify-center gap-1.5">
                        <span>{{ __('إلغاء والعودة') }}</span>
                    </a>
                </div>

            </div>

        </div>

    </form>

</div>

@push('scripts')
<script>
    function previewUploadedImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('image-preview');
                const previewWrapper = document.getElementById('image-preview-wrapper');
                const uploadBox = document.getElementById('upload-box');

                previewImg.src = e.target.result;
                previewWrapper.classList.remove('hidden');
                uploadBox.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection