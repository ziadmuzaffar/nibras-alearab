<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\QuoteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class QuoteRequestController extends Controller
{
    /**
     * Display a listing of quote requests.
     */
    public function index(Request $request): View
    {
        $query = QuoteRequest::with(['product.category']);

        // Search by customer name, phone, email, notes, or product name
        if ($search = trim((string) $request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($pq) use ($search) {
                        $pq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($status = $request->input('status')) {
            if ($status !== 'all' && array_key_exists($status, QuoteRequest::STATUSES)) {
                $query->where('status', $status);
            }
        }

        // Filter by product
        if ($productId = $request->input('product_id')) {
            if ($productId === 'custom') {
                $query->whereNull('product_id');
            } elseif ($productId !== 'all') {
                $query->where('product_id', $productId);
            }
        }

        // Sorting
        $sortBy = $request->input('sort', 'newest');
        switch ($sortBy) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'customer_asc':
                $query->orderBy('customer_name', 'asc');
                break;
            case 'customer_desc':
                $query->orderBy('customer_name', 'desc');
                break;
            case 'quantity_desc':
                $query->orderBy('quantity', 'desc');
                break;
            case 'quantity_asc':
                $query->orderBy('quantity', 'asc');
                break;
            case 'status':
                $query->orderBy('status', 'asc')->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $quoteRequests = $query->paginate(12)->withQueryString();

        // Calculate KPI Statistics
        $stats = [
            'total' => QuoteRequest::count(),
            'pending' => QuoteRequest::where('status', 'pending')->count(),
            'in_progress' => QuoteRequest::whereIn('status', ['contacted', 'in_progress'])->count(),
            'completed' => QuoteRequest::where('status', 'completed')->count(),
        ];

        // Products list for filter dropdown
        $products = Product::orderBy('name')->get(['id', 'name']);

        return view('pages.admin.quote-requests.index', compact('quoteRequests', 'stats', 'products'));
    }

    /**
     * Show the form for creating a new quote request.
     */
    public function create(): View
    {
        $products = Product::orderBy('name')->get(['id', 'name']);
        $statuses = QuoteRequest::STATUSES;

        return view('pages.admin.quote-requests.create', compact('products', 'statuses'));
    }

    /**
     * Store a newly created quote request in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'product_id' => ['nullable', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', Rule::in(array_keys(QuoteRequest::STATUSES))],
            'notes' => ['nullable', 'string', 'max:3000'],
        ], [
            'customer_name.required' => __('يرجى إدخال اسم العميل أو الجهة.'),
            'customer_name.max' => __('اسم العميل لا يجب أن يتجاوز 255 حرفاً.'),
            'phone.required' => __('رقم هاتف / جوال العميل مطلوب للتواصل.'),
            'phone.max' => __('رقم الهاتف غير صالح أو طويل جداً.'),
            'email.email' => __('يرجى إدخال بريد إلكتروني صالح.'),
            'product_id.exists' => __('المنتج المختار غير موجود في النظام.'),
            'quantity.integer' => __('يجب إدخال كمية صحيحة.'),
            'quantity.min' => __('الحد الأدنى للكمية هو قطعة واحدة على الأقل.'),
            'status.required' => __('يرجى تحديد حالة الطلب.'),
            'status.in' => __('حالة الطلب المحددة غير صحيحة.'),
            'notes.max' => __('الملاحظات وتفاصيل المواصفات طويلة جداً.'),
        ]);

        $quoteRequest = QuoteRequest::create($validated);

        return redirect()
            ->route('admin.quote-requests.index')
            ->with('success', __('تم إضافة طلب عرض السعر للعميل ":name" بنجاح!', ['name' => $quoteRequest->customer_name]));
    }

    /**
     * Display the specified quote request.
     */
    public function show(QuoteRequest $quoteRequest): View
    {
        if (is_null($quoteRequest->read_at)) {
            $quoteRequest->update(['read_at' => now()]);
        }

        $quoteRequest->load(['product.category']);

        // Related requests (same customer by phone/email or same product)
        $relatedRequests = QuoteRequest::with(['product'])
            ->where('id', '!=', $quoteRequest->id)
            ->where(function ($q) use ($quoteRequest) {
                if ($quoteRequest->phone) {
                    $q->orWhere('phone', $quoteRequest->phone);
                }
                if ($quoteRequest->email) {
                    $q->orWhere('email', $quoteRequest->email);
                }
                if ($quoteRequest->product_id) {
                    $q->orWhere('product_id', $quoteRequest->product_id);
                }
            })
            ->latest()
            ->take(4)
            ->get();

        $statuses = QuoteRequest::STATUSES;

        return view('pages.admin.quote-requests.show', compact('quoteRequest', 'relatedRequests', 'statuses'));
    }

    /**
     * Show the form for editing the specified quote request.
     */
    public function edit(QuoteRequest $quoteRequest): View
    {
        if (is_null($quoteRequest->read_at)) {
            $quoteRequest->update(['read_at' => now()]);
        }

        $products = Product::orderBy('name')->get(['id', 'name']);
        $statuses = QuoteRequest::STATUSES;

        return view('pages.admin.quote-requests.edit', compact('quoteRequest', 'products', 'statuses'));
    }

    /**
     * Update the specified quote request in storage.
     */
    public function update(Request $request, QuoteRequest $quoteRequest): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'product_id' => ['nullable', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', Rule::in(array_keys(QuoteRequest::STATUSES))],
            'notes' => ['nullable', 'string', 'max:3000'],
        ], [
            'customer_name.required' => __('يرجى إدخال اسم العميل أو الجهة.'),
            'customer_name.max' => __('اسم العميل لا يجب أن يتجاوز 255 حرفاً.'),
            'phone.required' => __('رقم هاتف / جوال العميل مطلوب للتواصل.'),
            'phone.max' => __('رقم الهاتف غير صالح أو طويل جداً.'),
            'email.email' => __('يرجى إدخال بريد إلكتروني صالح.'),
            'product_id.exists' => __('المنتج المختار غير موجود في النظام.'),
            'quantity.integer' => __('يجب إدخال كمية صحيحة.'),
            'quantity.min' => __('الحد الأدنى للكمية هو قطعة واحدة على الأقل.'),
            'status.required' => __('يرجى تحديد حالة الطلب.'),
            'status.in' => __('حالة الطلب المحددة غير صحيحة.'),
            'notes.max' => __('الملاحظات وتفاصيل المواصفات طويلة جداً.'),
        ]);

        $quoteRequest->update($validated);

        return redirect()
            ->route('admin.quote-requests.index')
            ->with('success', __('تم تحديث بيانات طلب عرض السعر رقم #:id بنجاح!', ['id' => $quoteRequest->id]));
    }

    /**
     * Update only the status of the quote request.
     */
    public function updateStatus(Request $request, QuoteRequest $quoteRequest): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(QuoteRequest::STATUSES))],
        ]);

        $quoteRequest->update([
            'status' => $validated['status'],
            'read_at' => $quoteRequest->read_at ?? now(),
        ]);

        return redirect()->back()
            ->with('success', __('تم تحديث حالة الطلب #:id إلى ":status" بنجاح!', ['id' => $quoteRequest->id, 'status' => $quoteRequest->status_label]));
    }

    /**
     * Mark a single quote request notification as read.
     */
    public function markAsRead(Request $request, QuoteRequest $quoteRequest)
    {
        if (is_null($quoteRequest->read_at)) {
            $quoteRequest->update(['read_at' => now()]);
        }

        $unreadCount = QuoteRequest::unread()->count();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'unread_count' => $unreadCount,
            ]);
        }

        return redirect()->back();
    }

    /**
     * Mark all unread quote request notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        QuoteRequest::unread()->update(['read_at' => now()]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'unread_count' => 0,
            ]);
        }

        return redirect()->back()->with('success', __('تم تحديد جميع الإشعارات كمقروءة.'));
    }

    /**
     * Remove the specified quote request from storage.
     */
    public function destroy(QuoteRequest $quoteRequest): RedirectResponse
    {
        $id = $quoteRequest->id;
        $customerName = $quoteRequest->customer_name;

        $quoteRequest->delete();

        return redirect()
            ->route('admin.quote-requests.index')
            ->with('success', __('تم حذف طلب عرض السعر #:id للعميل ":name" بنجاح.', ['id' => $id, 'name' => $customerName]));
    }
}
