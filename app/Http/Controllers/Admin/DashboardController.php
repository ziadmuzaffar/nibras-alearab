<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\QuoteRequest;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the main admin dashboard with live vital metrics.
     */
    public function index()
    {
        // Vital KPIs
        $totalQuotes = QuoteRequest::count();
        $pendingQuotes = QuoteRequest::where('status', 'pending')->count();
        $contactedQuotes = QuoteRequest::where('status', 'contacted')->count();
        $inProgressQuotes = QuoteRequest::where('status', 'in_progress')->count();
        $completedQuotes = QuoteRequest::where('status', 'completed')->count();
        $cancelledQuotes = QuoteRequest::where('status', 'cancelled')->count();

        // Time-based stats
        $todayQuotes = QuoteRequest::whereDate('created_at', Carbon::today())->count();
        $thisWeekQuotes = QuoteRequest::where('created_at', '>=', Carbon::now()->startOfWeek())->count();
        $thisMonthQuotes = QuoteRequest::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        $unreadQuotes = QuoteRequest::unread()->count();

        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $featuredProducts = Product::where('is_featured', true)->count();

        $totalCategories = Category::count();
        $activeCategories = Category::where('is_active', true)->count();
        $totalPortfolios = Portfolio::count();
        $totalQuantityRequested = QuoteRequest::sum('quantity') ?: 0;

        // Conversion rate
        $conversionRate = $totalQuotes > 0 ? round(($completedQuotes / $totalQuotes) * 100, 1) : 0;

        // Recent Quote Requests (Latest 6)
        $recentQuotes = QuoteRequest::with('product')
            ->latest()
            ->take(6)
            ->get();

        // 7-day mini trend for dashboard chart
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $dayKey = $day->format('Y-m-d');
            $count = QuoteRequest::whereDate('created_at', $dayKey)->count();
            $last7Days->push([
                'label' => $day->translatedFormat('D j M'),
                'count' => $count,
                'date' => $dayKey,
            ]);
        }

        // Status breakdown
        $statusBreakdown = [
            'pending' => $pendingQuotes,
            'contacted' => $contactedQuotes,
            'in_progress' => $inProgressQuotes,
            'completed' => $completedQuotes,
            'cancelled' => $cancelledQuotes,
        ];

        // Top 5 categories with product counts
        $popularCategories = Category::withCount('products')
            ->orderByDesc('products_count')
            ->take(5)
            ->get();

        // Recent Products
        $recentProducts = Product::with('category')->latest()->take(5)->get();

        return view('pages.admin.dashboard', compact(
            'totalQuotes',
            'pendingQuotes',
            'contactedQuotes',
            'inProgressQuotes',
            'completedQuotes',
            'cancelledQuotes',
            'todayQuotes',
            'thisWeekQuotes',
            'thisMonthQuotes',
            'unreadQuotes',
            'totalProducts',
            'activeProducts',
            'featuredProducts',
            'totalCategories',
            'activeCategories',
            'totalPortfolios',
            'totalQuantityRequested',
            'conversionRate',
            'recentQuotes',
            'last7Days',
            'statusBreakdown',
            'popularCategories',
            'recentProducts'
        ));
    }
}
