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
            'customer_name.required' => 'يرجى إدخال اسم العميل أو الجهة.',
            'customer_name.max' => 'اسم العميل لا يجب أن يتجاوز 255 حرفاً.',
            'phone.required' => 'رقم هاتف / جوال العميل مطلوب للتواصل.',
            'phone.max' => 'رقم الهاتف غير صالح أو طويل جداً.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
            'product_id.exists' => 'المنتج المختار غير موجود في النظام.',
            'quantity.integer' => 'يجب إدخال كمية صحيحة.',
            'quantity.min' => 'الحد الأدنى للكمية هو قطعة واحدة على الأقل.',
            'status.required' => 'يرجى تحديد حالة الطلب.',
            'status.in' => 'حالة الطلب المحددة غير صحيحة.',
            'notes.max' => 'الملاحظات وتفاصيل المواصفات طويلة جداً.',
        ]);

        $quoteRequest = QuoteRequest::create($validated);

        return redirect()
            ->route('admin.quote-requests.index')
            ->with('success', "تم إضافة طلب عرض السعر للعميل \"{$quoteRequest->customer_name}\" بنجاح!");
    }

    /**
     * Display the specified quote request.
     */
    public function show(QuoteRequest $quoteRequest): View
    {
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
            'customer_name.required' => 'يرجى إدخال اسم العميل أو الجهة.',
            'customer_name.max' => 'اسم العميل لا يجب أن يتجاوز 255 حرفاً.',
            'phone.required' => 'رقم هاتف / جوال العميل مطلوب للتواصل.',
            'phone.max' => 'رقم الهاتف غير صالح أو طويل جداً.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
            'product_id.exists' => 'المنتج المختار غير موجود في النظام.',
            'quantity.integer' => 'يجب إدخال كمية صحيحة.',
            'quantity.min' => 'الحد الأدنى للكمية هو قطعة واحدة على الأقل.',
            'status.required' => 'يرجى تحديد حالة الطلب.',
            'status.in' => 'حالة الطلب المحددة غير صحيحة.',
            'notes.max' => 'الملاحظات وتفاصيل المواصفات طويلة جداً.',
        ]);

        $quoteRequest->update($validated);

        return redirect()
            ->route('admin.quote-requests.index')
            ->with('success', "تم تحديث بيانات طلب عرض السعر رقم #{$quoteRequest->id} بنجاح!");
    }

    /**
     * Update only the status of the quote request.
     */
    public function updateStatus(Request $request, QuoteRequest $quoteRequest): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(QuoteRequest::STATUSES))],
        ]);

        $quoteRequest->update(['status' => $validated['status']]);

        return redirect()->back()
            ->with('success', "تم تحديث حالة الطلب #{$quoteRequest->id} إلى \"{$quoteRequest->status_label}\" بنجاح!");
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
            ->with('success', "تم حذف طلب عرض السعر #{$id} للعميل \"{$customerName}\" بنجاح.");
    }
}
