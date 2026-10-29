@extends('layouts.website.app')

@section('title', 'معرض أعمالنا ومشاريعنا المنفذة')

@section('content')

<!-- Page Hero Header -->
<section class="relative bg-slate-950 text-white py-12 sm:py-16 overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-40 pointer-events-none"></div>
    <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-blue-600/20 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-80 h-80 rounded-full bg-red-600/15 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-4">
            <a href="{{ route('website.home') }}" class="hover:text-white transition-colors">الرئيسية</a>
            <i class="fa-solid fa-chevron-left text-[10px] text-slate-600"></i>
            <span class="text-blue-400">معرض الأعمال والمشاريع</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-2.5 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-amber-300 text-xs font-bold">
                    <i class="fa-solid fa-award"></i>
                    <span>سجل حافل بالإنجازات والجودة</span>
                </div>
                <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                    معرض أعمالنا ومشاريع الطباعة والتغليف المنفذة
                </h1>
                <p class="text-xs sm:text-base text-slate-300 leading-relaxed">
                    نماذج مختارة من المشاريع التي تشرفت مطبعة نبراس العرب بتصميمها وتنفيذها لكبرى الشركات، العلامات التجارية، والمتاجر في المملكة العربية السعودية.
                </p>
            </div>

            @if(setting('enable_quotes', '1') === '1')
            <button type="button"
                onclick="openQuoteModal()"
                class="self-start md:self-auto inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-blue-600 to-red-600 hover:from-blue-500 hover:to-red-500 text-white font-black text-xs sm:text-sm shadow-xl">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                <span>ابدأ مشروعك معنا</span>
            </button>
            @endif
        </div>
    </div>
</section>

<!-- Filter & Portfolio Grid -->
<section class="py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Category Pills & Search Bar -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-4 sm:p-5 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <!-- Category Pills -->
            <div class="w-full lg:w-auto max-w-full min-w-0 flex items-center gap-2 overflow-x-auto no-scrollbar pb-1 lg:pb-0">
                <a href="{{ route('website.portfolios.index') }}"
                    class="shrink-0 px-4 py-2 rounded-xl text-xs font-black whitespace-nowrap transition-all {{ !$selectedCategory ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                    جميع المشاريع
                </a>
                @foreach($portfolioCategories as $pCat)
                @php
                    $isActiveCat = $selectedCategory && $selectedCategory->id === $pCat->id;
                @endphp
                <a href="{{ route('website.portfolios.index', ['category' => $pCat->slug]) }}"
                    class="shrink-0 px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-1.5 {{ $isActiveCat ? 'bg-blue-600 text-white shadow-sm font-black' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                    <span>{{ $pCat->name }}</span>
                    <span class="text-[10px] font-mono opacity-75">({{ $pCat->portfolios_count }})</span>
                </a>
                @endforeach
            </div>

            <!-- Search Input -->
            <form action="{{ route('website.portfolios.index') }}" method="GET" class="relative w-full lg:w-72 shrink-0">
                @if($selectedCategory)
                <input type="hidden" name="category" value="{{ $selectedCategory->slug }}">
                @endif
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="ابحث باسم المشروع أو العميل..."
                    class="w-full pr-9 pl-3 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-blue-600">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </button>
            </form>
        </div>

        <!-- Portfolio Cards Grid -->
        @if($portfolios->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-7">
            @foreach($portfolios as $portfolio)
            <article onclick="openPortfolioModal({{ Js::from([
                    'title' => $portfolio->title,
                    'client' => $portfolio->client_name ?: 'عميل مميز',
                    'category' => $portfolio->category?->name ?: 'مطبوعات وتغليف',
                    'image' => $portfolio->image_url,
                    'description' => $portfolio->description,
                ]) }})"
                class="min-w-0 group cursor-pointer bg-white rounded-3xl border border-slate-200/85 hover:border-blue-400 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col">

                <div class="relative h-56 sm:h-64 bg-slate-900 overflow-hidden">
                    @if($portfolio->image_url)
                    <img src="{{ $portfolio->image_url }}"
                        alt="{{ $portfolio->title }}"
                        loading="lazy"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=800&q=80';">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/75 via-transparent to-transparent"></div>

                    <div class="absolute top-4 inset-x-4 flex items-center justify-between gap-2">
                        @if($portfolio->category)
                        <span class="px-3 py-1 rounded-full bg-white/95 backdrop-blur-md text-slate-900 text-[11px] font-extrabold shadow-md truncate max-w-[70%]">
                            {{ $portfolio->category->name }}
                        </span>
                        @else
                        <span></span>
                        @endif

                        <span class="w-9 h-9 rounded-xl bg-slate-900/75 group-hover:bg-blue-600 text-white flex items-center justify-center backdrop-blur-md transition-colors shrink-0">
                            <i class="fa-solid fa-expand text-xs"></i>
                        </span>
                    </div>

                    @if($portfolio->client_name)
                    <div class="absolute bottom-3.5 right-4 left-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-900/80 backdrop-blur-sm text-amber-300 text-xs font-bold max-w-full">
                            <i class="fa-regular fa-building text-[11px] shrink-0"></i>
                            <span class="truncate">{{ $portfolio->client_name }}</span>
                        </span>
                    </div>
                    @endif
                </div>

                <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <h3 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-blue-700 transition-colors leading-snug">
                            {{ $portfolio->title }}
                        </h3>
                        @if($portfolio->description)
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed line-clamp-3">
                            {{ $portfolio->description }}
                        </p>
                        @endif
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-blue-700 group-hover:text-red-600 transition-colors">
                        <span>عرض تفاصيل المشروع</span>
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        @if($portfolios->hasPages())
        <div class="pt-6">
            {{ $portfolios->links() }}
        </div>
        @endif
        @else
        <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center space-y-4">
            <i class="fa-solid fa-images text-4xl text-slate-300 block"></i>
            <h3 class="text-base font-black text-slate-800">لا توجد مشاريع مطابقة للبحث</h3>
            <a href="{{ route('website.portfolios.index') }}" class="inline-block px-5 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-bold">
                عرض كافة الأعمال
            </a>
        </div>
        @endif

    </div>
</section>

<!-- Portfolio Lightbox Modal -->
<div id="portfolio-lightbox-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="min-h-screen px-4 flex items-center justify-center py-6 sm:py-8">
        <div onclick="closePortfolioModal()" class="fixed inset-0 bg-slate-950/75 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-2xl bg-white rounded-3xl overflow-hidden shadow-2xl border border-slate-200">
            <div class="relative h-60 sm:h-80 md:h-96 bg-slate-900">
                <img id="pmodal-image" src="" alt="" class="w-full h-full object-cover">
                <button type="button" onclick="closePortfolioModal()" class="absolute top-4 left-4 w-10 h-10 rounded-xl bg-slate-900/75 hover:bg-red-600 text-white flex items-center justify-center backdrop-blur-md transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <span id="pmodal-category" class="absolute top-4 right-4 px-3.5 py-1 rounded-full bg-blue-600 text-white text-xs font-bold shadow-md"></span>
            </div>
            <div class="p-5 sm:p-7 space-y-3 text-right">
                <div class="flex items-center gap-2 text-xs font-bold text-blue-700">
                    <i class="fa-solid fa-building"></i>
                    <span>العميل: <strong id="pmodal-client"></strong></span>
                </div>
                <h3 id="pmodal-title" class="text-base sm:text-xl font-black text-slate-900"></h3>
                <p id="pmodal-description" class="text-xs sm:text-sm text-slate-600 leading-relaxed"></p>
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2.5 sm:gap-3">
                    <button type="button"
                        onclick="closePortfolioModal(); openQuoteModal();"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-700 to-red-600 text-white text-xs sm:text-sm font-black shadow-md">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span>اطلب تنفيذ مشروع مماثل</span>
                    </button>
                    <button type="button" onclick="closePortfolioModal()" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold text-center">
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openPortfolioModal(data) {
        const modal = document.getElementById('portfolio-lightbox-modal');
        if (!modal || !data) return;

        document.getElementById('pmodal-image').src = data.image || 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=800&q=80';
        document.getElementById('pmodal-image').alt = data.title || '';
        document.getElementById('pmodal-title').textContent = data.title || '';
        document.getElementById('pmodal-client').textContent = data.client || 'عميل مميز';
        document.getElementById('pmodal-category').textContent = data.category || 'مطبوعات وتغليف';
        document.getElementById('pmodal-description').textContent = data.description || '';

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closePortfolioModal() {
        const modal = document.getElementById('portfolio-lightbox-modal');
        if (!modal) return;
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endpush

@endsection

