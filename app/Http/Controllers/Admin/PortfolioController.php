<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the portfolio items.
     */
    public function index(Request $request): View
    {
        $query = Portfolio::with('category');

        // Search by title, client name, or description
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($categoryId = $request->input('category_id')) {
            if ($categoryId === 'uncategorized') {
                $query->whereNull('category_id');
            } elseif ($categoryId !== 'all') {
                $query->where('category_id', $categoryId);
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
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'client_asc':
                $query->orderBy('client_name', 'asc');
                break;
            case 'client_desc':
                $query->orderBy('client_name', 'desc');
                break;
            case 'category':
                $query->leftJoin('categories', 'portfolios.category_id', '=', 'categories.id')
                      ->orderBy('categories.name', 'asc')
                      ->select('portfolios.*');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $portfolios = $query->paginate(12)->withQueryString();

        // Calculate KPI Statistics
        $stats = [
            'total' => Portfolio::count(),
            'categorized' => Portfolio::whereNotNull('category_id')->count(),
            'uncategorized' => Portfolio::whereNull('category_id')->count(),
            'clients' => Portfolio::whereNotNull('client_name')
                ->where('client_name', '!=', '')
                ->distinct('client_name')
                ->count('client_name'),
        ];

        // Categories for filter dropdown
        $categories = Category::orderBy('name')->get(['id', 'name']);

        return view('pages.admin.portfolios.index', compact('portfolios', 'stats', 'categories'));
    }

    /**
     * Show the form for creating a new portfolio item.
     */
    public function create(): View
    {
        $categories = Category::orderBy('order', 'asc')->orderBy('name', 'asc')->get();

        return view('pages.admin.portfolios.create', compact('categories'));
    }

    /**
     * Store a newly created portfolio item in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
        ], [
            'title.required' => 'يرجى إدخال عنوان المشروع أو العمل.',
            'title.max' => 'عنوان العمل طويل جداً (الحد الأقصى 255 حرفاً).',
            'client_name.max' => 'اسم العميل طويل جداً (الحد الأقصى 255 حرفاً).',
            'category_id.exists' => 'التصنيف المختار غير موجود في النظام.',
            'image.required' => 'صورة العمل أو المشروع مطلوبة.',
            'image.image' => 'يجب رفع ملف صورة صالح.',
            'image.mimes' => 'صيغ الصور المعتمدة هي: jpeg, png, jpg, webp, svg.',
            'image.max' => 'حجم الصورة لا يجب أن يتجاوز 5 ميغابايت.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'port_' . time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/portfolios');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $image->move($destinationPath, $filename);
            $imagePath = 'uploads/portfolios/' . $filename;
        }

        $portfolio = Portfolio::create([
            'title' => $validated['title'],
            'client_name' => $validated['client_name'] ?? null,
            'category_id' => $validated['category_id'] ?? null,
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', "تم إضافة عمل المشروع \"{$portfolio->title}\" بنجاح!");
    }

    /**
     * Display the specified portfolio item.
     */
    public function show(Portfolio $portfolio): View
    {
        $portfolio->load('category');

        // Fetch related portfolio projects
        $relatedPortfolios = Portfolio::with('category')
            ->where('id', '!=', $portfolio->id)
            ->when($portfolio->category_id, function ($q) use ($portfolio) {
                $q->where('category_id', $portfolio->category_id);
            })
            ->latest()
            ->take(3)
            ->get();

        return view('pages.admin.portfolios.show', compact('portfolio', 'relatedPortfolios'));
    }

    /**
     * Show the form for editing the specified portfolio item.
     */
    public function edit(Portfolio $portfolio): View
    {
        $categories = Category::orderBy('order', 'asc')->orderBy('name', 'asc')->get();

        return view('pages.admin.portfolios.edit', compact('portfolio', 'categories'));
    }

    /**
     * Update the specified portfolio item in storage.
     */
    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
        ], [
            'title.required' => 'يرجى إدخال عنوان المشروع أو العمل.',
            'title.max' => 'عنوان العمل طويل جداً (الحد الأقصى 255 حرفاً).',
            'client_name.max' => 'اسم العميل طويل جداً (الحد الأقصى 255 حرفاً).',
            'category_id.exists' => 'التصنيف المختار غير موجود في النظام.',
            'image.image' => 'يجب رفع ملف صورة صالح.',
            'image.mimes' => 'صيغ الصور المعتمدة هي: jpeg, png, jpg, webp, svg.',
            'image.max' => 'حجم الصورة لا يجب أن يتجاوز 5 ميغابايت.',
        ]);

        $imagePath = $portfolio->image;

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old file if it was a local upload
            if ($portfolio->image && !str_starts_with($portfolio->image, 'http') && File::exists(public_path($portfolio->image))) {
                File::delete(public_path($portfolio->image));
            }

            $image = $request->file('image');
            $filename = 'port_' . time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/portfolios');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $image->move($destinationPath, $filename);
            $imagePath = 'uploads/portfolios/' . $filename;
        }

        $portfolio->update([
            'title' => $validated['title'],
            'client_name' => $validated['client_name'] ?? null,
            'category_id' => $validated['category_id'] ?? null,
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', "تم تحديث بيانات العمل \"{$portfolio->title}\" بنجاح!");
    }

    /**
     * Remove the specified portfolio item from storage.
     */
    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $title = $portfolio->title;

        // Delete image file if stored locally
        if ($portfolio->image && !str_starts_with($portfolio->image, 'http') && File::exists(public_path($portfolio->image))) {
            File::delete(public_path($portfolio->image));
        }

        $portfolio->delete();

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', "تم حذف العمل \"{$title}\" بنجاح.");
    }
}
