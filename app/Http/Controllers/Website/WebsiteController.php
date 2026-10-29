<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\QuoteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WebsiteController extends Controller
{
    /**
     * Check if maintenance mode is active for non-admin visitors.
     */
    protected function checkMaintenanceMode(): ?View
    {
        if (setting('maintenance_mode', '0') === '1' && !auth()->check()) {
            return view('pages.website.maintenance');
        }

        return null;
    }

    /**
     * Get shared navigation categories and active products for modals/menus.
     */
    protected function getSharedWebsiteData(): array
    {
        $navCategories = Category::active()
            ->ordered()
            ->withCount(['products' => fn ($q) => $q->active()])
            ->get();

        $quoteProducts = Product::active()
            ->with('category:id,name,slug')
            ->orderBy('is_featured', 'desc')
            ->orderBy('name', 'asc')
            ->get(['id', 'category_id', 'name', 'slug', 'featured_image']);

        return compact('navCategories', 'quoteProducts');
    }

    /**
     * Display the website landing page (Home).
     */
    public function home(Request $request): View
    {
        if ($maintenanceView = $this->checkMaintenanceMode()) {
            return $maintenanceView;
        }

        $shared = $this->getSharedWebsiteData();

        $categories = Category::active()
            ->ordered()
            ->withCount([
                'products' => fn ($q) => $q->active(),
                'portfolios',
            ])
            ->get();

        // Featured & active products for home catalog showcase
        $featuredProducts = Product::active()
            ->with(['category', 'images'])
            ->orderByDesc('is_featured')
            ->latest()
            ->take(9)
            ->get();

        // Portfolios showcase
        $portfolios = Portfolio::with('category')
            ->latest()
            ->take(8)
            ->get();

        // Portfolio categories that actually have portfolio items
        $portfolioCategories = Category::active()
            ->ordered()
            ->whereHas('portfolios')
            ->get(['id', 'name', 'slug', 'icon']);

        $establishedYear = (int) setting('established_year', 2015);
        $yearsExperience = max(1, (int) date('Y') - $establishedYear);

        $stats = [
            'years_experience' => $yearsExperience,
            'established_year' => $establishedYear,
            'categories_count' => $categories->count(),
            'products_count' => Product::active()->count(),
            'portfolios_count' => Portfolio::count(),
        ];

        return view('pages.website.home', array_merge($shared, compact(
            'categories',
            'featuredProducts',
            'portfolios',
            'portfolioCategories',
            'stats'
        )));
    }

    /**
     * Display the full products catalog with search, category filter, and sorting.
     */
    public function products(Request $request): View
    {
        if ($maintenanceView = $this->checkMaintenanceMode()) {
            return $maintenanceView;
        }

        $shared = $this->getSharedWebsiteData();

        $query = Product::active()->with(['category', 'images']);

        // Search filter
        if ($search = trim((string) $request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter (by slug or ID)
        $selectedCategory = null;
        if ($categoryParam = $request->input('category')) {
            if ($categoryParam !== 'all') {
                $selectedCategory = Category::active()
                    ->where('slug', $categoryParam)
                    ->orWhere('id', $categoryParam)
                    ->first();

                if ($selectedCategory) {
                    $query->where('category_id', $selectedCategory->id);
                }
            }
        }

        // Featured filter
        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        // Sorting
        $sort = $request->input('sort', 'featured');
        switch ($sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'featured':
            default:
                $query->orderByDesc('is_featured')->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(9)->withQueryString();
        $totalActiveProducts = Product::active()->count();

        return view('pages.website.products.index', array_merge($shared, compact(
            'products',
            'selectedCategory',
            'totalActiveProducts',
            'sort'
        )));
    }

    /**
     * Display products filtered by a specific category slug.
     */
    public function category(Request $request, Category $category): View
    {
        if ($maintenanceView = $this->checkMaintenanceMode()) {
            return $maintenanceView;
        }

        if (!$category->is_active && !auth()->check()) {
            abort(404);
        }

        $request->merge(['category' => $category->slug]);

        return $this->products($request);
    }

    /**
     * Display a single product's full details, gallery, specifications, and quote form.
     */
    public function productShow(Product $product): View
    {
        if ($maintenanceView = $this->checkMaintenanceMode()) {
            return $maintenanceView;
        }

        if (!$product->is_active && !auth()->check()) {
            abort(404);
        }

        $shared = $this->getSharedWebsiteData();

        $product->load(['category', 'images']);

        // Related products from same category
        $relatedProducts = Product::active()
            ->with(['category', 'images'])
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->orderByDesc('is_featured')
            ->latest()
            ->take(4)
            ->get();

        if ($relatedProducts->count() < 4) {
            $moreProducts = Product::active()
                ->with(['category', 'images'])
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->orderByDesc('is_featured')
                ->latest()
                ->take(4 - $relatedProducts->count())
                ->get();

            $relatedProducts = $relatedProducts->concat($moreProducts);
        }

        return view('pages.website.products.show', array_merge($shared, compact(
            'product',
            'relatedProducts'
        )));
    }

    /**
     * Display the portfolio / executed projects page.
     */
    public function portfolios(Request $request): View
    {
        if ($maintenanceView = $this->checkMaintenanceMode()) {
            return $maintenanceView;
        }

        $shared = $this->getSharedWebsiteData();

        $query = Portfolio::with('category');

        if ($search = trim((string) $request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $selectedCategory = null;
        if ($categoryParam = $request->input('category')) {
            if ($categoryParam !== 'all') {
                $selectedCategory = Category::where('slug', $categoryParam)
                    ->orWhere('id', $categoryParam)
                    ->first();

                if ($selectedCategory) {
                    $query->where('category_id', $selectedCategory->id);
                }
            }
        }

        $portfolios = $query->latest()->paginate(9)->withQueryString();

        $portfolioCategories = Category::active()
            ->ordered()
            ->whereHas('portfolios')
            ->withCount('portfolios')
            ->get();

        return view('pages.website.portfolios.index', array_merge($shared, compact(
            'portfolios',
            'portfolioCategories',
            'selectedCategory'
        )));
    }

    /**
     * Display the About Us page.
     */
    public function about(): View
    {
        if ($maintenanceView = $this->checkMaintenanceMode()) {
            return $maintenanceView;
        }

        $shared = $this->getSharedWebsiteData();

        $establishedYear = (int) setting('established_year', 2015);
        $yearsExperience = max(1, (int) date('Y') - $establishedYear);

        $stats = [
            'years_experience' => $yearsExperience,
            'established_year' => $establishedYear,
            'categories_count' => Category::active()->count(),
            'products_count' => Product::active()->count(),
            'portfolios_count' => Portfolio::count(),
        ];

        $latestPortfolios = Portfolio::with('category')->latest()->take(4)->get();

        return view('pages.website.about', array_merge($shared, compact('stats', 'latestPortfolios')));
    }

    /**
     * Display the Contact & Custom Quote Request page.
     */
    public function contact(Request $request): View
    {
        if ($maintenanceView = $this->checkMaintenanceMode()) {
            return $maintenanceView;
        }

        $shared = $this->getSharedWebsiteData();

        $preselectedProduct = null;
        if ($prodParam = $request->input('product')) {
            $preselectedProduct = Product::active()
                ->where('slug', $prodParam)
                ->orWhere('id', $prodParam)
                ->first();
        }

        return view('pages.website.contact', array_merge($shared, compact('preselectedProduct')));
    }

    /**
     * Store a new customer quote request from the public website.
     */
    public function storeQuote(Request $request): JsonResponse|RedirectResponse
    {
        if (setting('enable_quotes', '1') === '0') {
            $errorMsg = 'عذراً، استقبال طلبات التسعير عبر الموقع متوقف مؤقتاً. يرجى التواصل معنا مباشرة عبر الواتساب أو الهاتف.';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $errorMsg], 403);
            }
            return redirect()->back()->with('error', $errorMsg);
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'product_id' => ['nullable', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:10000000'],
            'notes' => ['nullable', 'string', 'max:3000'],
        ], [
            'customer_name.required' => 'يرجى إدخال الاسم الكامل أو اسم الشركة / الجهة.',
            'customer_name.max' => 'الاسم المدخل طويل جداً.',
            'phone.required' => 'يرجى إدخال رقم الجوال أو الهاتف للتواصل معكم.',
            'phone.max' => 'رقم الهاتف غير صالح.',
            'email.email' => 'يرجى إدخال عنوان بريد إلكتروني صحيح.',
            'product_id.exists' => 'المنتج المحدد غير متوفر حالياً.',
            'quantity.integer' => 'يرجى إدخال كمية تقريبية صحيحة بالأرقام.',
            'quantity.min' => 'الحد الأدنى للكمية هو 1.',
            'notes.max' => 'تفاصيل الطلب والملاحظات لا يجب أن تتجاوز 3000 حرف.',
        ]);

        $quoteRequest = QuoteRequest::create([
            'product_id' => $validated['product_id'] ?? null,
            'customer_name' => $validated['customer_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'quantity' => $validated['quantity'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
            'read_at' => null,
        ]);

        $successMessage = setting(
            'quote_success_message',
            'تم استلام طلبك بنجاح! سيقوم فريق المبيعات والتسعير بدراسة المواصفات والتواصل معك خلال ساعات العمل الرسمية.'
        );

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage,
                'reference_id' => $quoteRequest->id,
                'customer_name' => $quoteRequest->customer_name,
            ]);
        }

        return redirect()->back()
            ->with('quote_success', $successMessage)
            ->with('quote_reference', $quoteRequest->id);
    }
}

