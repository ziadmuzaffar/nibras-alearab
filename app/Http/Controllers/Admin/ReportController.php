<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\QuoteRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display a comprehensive reports & statistics analytics dashboard.
     */
    public function index(Request $request)
    {
        $period = $request->input('period', 'all');
        $statusFilter = $request->input('status', 'all');
        $categoryId = $request->input('category_id', 'all');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Base query for quote requests
        $query = QuoteRequest::with(['product.category']);

        // Apply period/date filters
        [$startDate, $endDate] = $this->resolveDateRange($period, $fromDate, $toDate);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Apply status filter
        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        // Apply category filter
        if ($categoryId && $categoryId !== 'all') {
            $query->whereHas('product', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        // Clone query for KPI metrics calculations
        $totalQuotes = (clone $query)->count();
        $pendingQuotes = (clone $query)->where('status', 'pending')->count();
        $contactedQuotes = (clone $query)->where('status', 'contacted')->count();
        $inProgressQuotes = (clone $query)->where('status', 'in_progress')->count();
        $completedQuotes = (clone $query)->where('status', 'completed')->count();
        $cancelledQuotes = (clone $query)->where('status', 'cancelled')->count();
        $totalQuantity = (clone $query)->sum('quantity');
        $avgQuantity = $totalQuotes > 0 ? (int) round($totalQuantity / $totalQuotes) : 0;
        $conversionRate = $totalQuotes > 0 ? round(($completedQuotes / $totalQuotes) * 100, 1) : 0;

        // General system counters
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $totalCategories = Category::count();
        $totalPortfolios = Portfolio::count();

        // 1. Chart: Quote Requests Trend over time
        $trendData = $this->getTrendData(clone $query, $startDate, $endDate);

        // 2. Chart: Status breakdown
        $statusBreakdown = [
            'labels' => ['قيد الانتظار', 'تم التواصل', 'قيد التسعير والدراسة', 'مكتمل / تم تقديم العرض', 'ملغي'],
            'counts' => [$pendingQuotes, $contactedQuotes, $inProgressQuotes, $completedQuotes, $cancelledQuotes],
            'colors' => ['#f59e0b', '#3b82f6', '#8b5cf6', '#10b981', '#64748b'],
        ];

        // 3. Chart: Top 6 requested products
        $topProductsData = $this->getTopProductsData(clone $query);

        // 4. Chart: Demand by printing category
        $categoryDemandData = $this->getCategoryDemandData(clone $query);

        // 5. Chart: Quantity brackets distribution
        $quantityBrackets = $this->getQuantityBrackets(clone $query);

        // Top products detailed list with metrics
        $topProductsList = $this->getTopProductsDetailed(clone $query, $totalQuotes);

        // Detailed recent quotes list within the active filter
        $detailedQuotes = (clone $query)->latest()->paginate(15)->appends($request->query());

        // Categories list for filter dropdown
        $categories = Category::orderBy('name')->get(['id', 'name']);

        return view('pages.admin.reports.index', compact(
            'period',
            'statusFilter',
            'categoryId',
            'fromDate',
            'toDate',
            'startDate',
            'endDate',
            'totalQuotes',
            'pendingQuotes',
            'contactedQuotes',
            'inProgressQuotes',
            'completedQuotes',
            'cancelledQuotes',
            'totalQuantity',
            'avgQuantity',
            'conversionRate',
            'totalProducts',
            'activeProducts',
            'totalCategories',
            'totalPortfolios',
            'trendData',
            'statusBreakdown',
            'topProductsData',
            'categoryDemandData',
            'quantityBrackets',
            'topProductsList',
            'detailedQuotes',
            'categories'
        ));
    }

    /**
     * Export the filtered reports to a clean Excel-compatible CSV file with UTF-8 BOM.
     */
    public function export(Request $request): StreamedResponse
    {
        $period = $request->input('period', 'all');
        $statusFilter = $request->input('status', 'all');
        $categoryId = $request->input('category_id', 'all');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $query = QuoteRequest::with(['product.category']);

        [$startDate, $endDate] = $this->resolveDateRange($period, $fromDate, $toDate);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        if ($categoryId && $categoryId !== 'all') {
            $query->whereHas('product', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        $records = $query->latest()->get();

        $filename = 'تقرير-طلبات-التسعير-مطبعة-نبراس-العرب-' . now()->format('Y-m-d_H-i') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($records) {
            $output = fopen('php://output', 'w');

            // Write UTF-8 BOM for Microsoft Excel Arabic character compatibility
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Write Header
            fputcsv($output, [
                'رقم الطلب',
                'تاريخ الطلب',
                'اسم العميل',
                'رقم الهاتف',
                'البريد الإلكتروني',
                'اسم المنتج المطلوب',
                'تصنيف المنتج',
                'الكمية المطلوبة',
                'حالة الطلب',
                'ملاحظات ومواصفات العميل',
            ]);

            foreach ($records as $item) {
                fputcsv($output, [
                    $item->id,
                    $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-',
                    $item->customer_name,
                    $item->phone,
                    $item->email ?: '-',
                    $item->product ? $item->product->name : 'منتج غير محدد',
                    $item->product && $item->product->category ? $item->product->category->name : '-',
                    $item->quantity,
                    $item->status_label,
                    $item->notes ?: '-',
                ]);
            }

            fclose($output);
        }, 200, $headers);
    }

    /**
     * Resolve date range bounds based on selected period preset or custom dates.
     */
    private function resolveDateRange(string $period, ?string $fromDate, ?string $toDate): array
    {
        return match ($period) {
            'today' => [
                Carbon::today()->startOfDay(),
                Carbon::today()->endOfDay(),
            ],
            'yesterday' => [
                Carbon::yesterday()->startOfDay(),
                Carbon::yesterday()->endOfDay(),
            ],
            'last_7_days' => [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay(),
            ],
            'this_month' => [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ],
            'last_30_days' => [
                Carbon::now()->subDays(29)->startOfDay(),
                Carbon::now()->endOfDay(),
            ],
            'this_year' => [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ],
            'custom' => [
                $fromDate ? Carbon::parse($fromDate)->startOfDay() : null,
                $toDate ? Carbon::parse($toDate)->endOfDay() : ($fromDate ? Carbon::parse($fromDate)->endOfDay() : null),
            ],
            default => [null, null], // 'all'
        };
    }

    /**
     * Prepare Timeline Trend Data for Chart.js.
     */
    private function getTrendData($query, ?Carbon $startDate, ?Carbon $endDate): array
    {
        // Fetch all matching quote created dates
        $quotes = $query->orderBy('created_at', 'asc')->get(['id', 'quantity', 'created_at']);

        if ($quotes->isEmpty()) {
            return [
                'labels' => ['لا توجد بيانات'],
                'counts' => [0],
                'quantities' => [0],
            ];
        }

        // Group by day or month depending on range span
        $minDate = $startDate ?: $quotes->first()->created_at;
        $maxDate = $endDate ?: $quotes->last()->created_at;
        $diffInDays = $minDate->diffInDays($maxDate);

        $labels = [];
        $counts = [];
        $quantities = [];

        if ($diffInDays <= 31) {
            // Group by Day
            $grouped = $quotes->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            });

            // Fill all days between min and max date (or at least the recorded days)
            $cursor = (clone $minDate)->startOfDay();
            $endLimit = (clone $maxDate)->endOfDay();

            while ($cursor <= $endLimit) {
                $dayKey = $cursor->format('Y-m-d');
                $labels[] = $cursor->translatedFormat('d M');
                $dayQuotes = $grouped->get($dayKey, collect());
                $counts[] = $dayQuotes->count();
                $quantities[] = $dayQuotes->sum('quantity');
                $cursor->addDay();
            }
        } else {
            // Group by Month
            $grouped = $quotes->groupBy(function ($item) {
                return $item->created_at->format('Y-m');
            });

            foreach ($grouped as $monthKey => $monthQuotes) {
                $monthCarbon = Carbon::createFromFormat('Y-m', $monthKey);
                $labels[] = $monthCarbon->translatedFormat('F Y');
                $counts[] = $monthQuotes->count();
                $quantities[] = $monthQuotes->sum('quantity');
            }
        }

        return [
            'labels' => $labels,
            'counts' => $counts,
            'quantities' => $quantities,
        ];
    }

    /**
     * Top Products data for Chart.js.
     */
    private function getTopProductsData($query): array
    {
        $top = (clone $query)
            ->whereNotNull('product_id')
            ->select('product_id', DB::raw('count(*) as total_requests'), DB::raw('sum(quantity) as total_units'))
            ->groupBy('product_id')
            ->orderByDesc('total_requests')
            ->take(6)
            ->with('product:id,name')
            ->get();

        $labels = [];
        $requests = [];
        $units = [];

        foreach ($top as $item) {
            $name = $item->product ? $item->product->name : 'منتج #' . $item->product_id;
            // Truncate long Arabic names nicely for charts
            $labels[] = mb_strlen($name) > 22 ? mb_substr($name, 0, 22) . '...' : $name;
            $requests[] = (int) $item->total_requests;
            $units[] = (int) $item->total_units;
        }

        return [
            'labels' => $labels,
            'requests' => $requests,
            'units' => $units,
        ];
    }

    /**
     * Demand by printing category for Chart.js.
     */
    private function getCategoryDemandData($query): array
    {
        $categories = Category::withCount(['products as requests_count' => function ($productQuery) use ($query) {
            $productQuery->whereHas('quoteRequests', function ($q) use ($query) {
                // If query has date filters, reflect them
            });
        }])->get();

        // More accurate approach: group requests by product.category_id
        $categoryCounts = [];
        $categoryNames = [];

        $allCategories = Category::all()->keyBy('id');

        $requests = (clone $query)->with('product:id,category_id')->get(['id', 'product_id']);

        foreach ($requests as $req) {
            if ($req->product && $req->product->category_id) {
                $catId = $req->product->category_id;
                $catName = $allCategories->get($catId)?->name ?? 'قسم آخر';
                $categoryCounts[$catName] = ($categoryCounts[$catName] ?? 0) + 1;
            } else {
                $categoryCounts['بدون تصنيف'] = ($categoryCounts['بدون تصنيف'] ?? 0) + 1;
            }
        }

        arsort($categoryCounts);

        return [
            'labels' => array_keys($categoryCounts),
            'counts' => array_values($categoryCounts),
        ];
    }

    /**
     * Quantity brackets distribution.
     */
    private function getQuantityBrackets($query): array
    {
        $under500 = (clone $query)->where('quantity', '<', 500)->count();
        $from500To1k = (clone $query)->whereBetween('quantity', [500, 1000])->count();
        $from1kTo5k = (clone $query)->whereBetween('quantity', [1001, 5000])->count();
        $above5k = (clone $query)->where('quantity', '>', 5000)->count();

        return [
            'labels' => ['أقل من 500 قطعة', '500 - 1,000 قطعة', '1,001 - 5,000 قطعة', 'أكثر من 5,000 قطعة'],
            'counts' => [$under500, $from500To1k, $from1kTo5k, $above5k],
        ];
    }

    /**
     * Detailed list of top products with share and status breakdowns.
     */
    private function getTopProductsDetailed($query, int $totalQuotes): array
    {
        $records = (clone $query)
            ->whereNotNull('product_id')
            ->select('product_id', DB::raw('count(*) as total_requests'), DB::raw('sum(quantity) as total_units'))
            ->groupBy('product_id')
            ->orderByDesc('total_requests')
            ->take(8)
            ->with(['product.category'])
            ->get();

        $list = [];

        foreach ($records as $item) {
            $percentage = $totalQuotes > 0 ? round(($item->total_requests / $totalQuotes) * 100, 1) : 0;
            $completedCount = (clone $query)->where('product_id', $item->product_id)->where('status', 'completed')->count();

            $list[] = [
                'product' => $item->product,
                'total_requests' => $item->total_requests,
                'total_units' => $item->total_units,
                'completed_count' => $completedCount,
                'percentage' => $percentage,
            ];
        }

        return $list;
    }
}
