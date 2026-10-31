<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(Request $request): View
    {
        $query = Category::withCount(['products', 'portfolios']);

        // Search by name or slug
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '' && $request->status !== 'all') {
            $isActive = $request->status === '1' || $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        // Sorting
        $sortBy = $request->input('sort', 'order_asc');
        switch ($sortBy) {
            case 'order_asc':
                $query->orderBy('order', 'asc')->orderBy('id', 'asc');
                break;
            case 'order_desc':
                $query->orderBy('order', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'products_desc':
                $query->orderBy('products_count', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('order', 'asc')->orderBy('id', 'asc');
                break;
        }

        $categories = $query->paginate(12)->withQueryString();

        // Calculate KPI Statistics
        $stats = [
            'total' => Category::count(),
            'active' => Category::where('is_active', true)->count(),
            'inactive' => Category::where('is_active', false)->count(),
            'with_products' => Category::has('products')->count(),
        ];

        return view('pages.admin.categories.index', compact('categories', 'stats'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        // Suggest next order number
        $nextOrder = (Category::max('order') ?? 0) + 1;

        return view('pages.admin.categories.create', compact('nextOrder'));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
            'icon' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => __('main.category_name_required'),
            'name.max' => __('main.category_name_max'),
            'slug.unique' => __('main.category_slug_unique'),
            'image.image' => __('main.category_image_invalid'),
            'image.mimes' => __('main.category_image_mimes'),
            'image.max' => __('main.category_image_max'),
            'order.integer' => __('main.category_order_integer'),
        ]);

        // Auto generate slug if empty
        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'], '-', null)
            : Str::slug($validated['name'], '-', null);

        // Ensure unique slug if generated slug already exists
        $originalSlug = $slug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'cat_' . time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/categories');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $image->move($destinationPath, $filename);
            $imagePath = 'uploads/categories/' . $filename;
        }

        $order = isset($validated['order']) && $validated['order'] !== '' 
            ? (int) $validated['order'] 
            : ((Category::max('order') ?? 0) + 1);

        $nameTranslations = [
            'ar' => $validated['name'],
            'en' => !empty($validated['name_en']) ? $validated['name_en'] : $validated['name'],
        ];

        $category = Category::create([
            'name' => $nameTranslations,
            'slug' => $slug,
            'icon' => $validated['icon'] ?? 'box',
            'image' => $imagePath,
            'order' => $order,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('main.category_created_success', ['name' => $category->name]));
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category): View
    {
        $category->loadCount([
            'products',
            'products as active_products_count' => fn($q) => $q->where('is_active', true),
            'products as inactive_products_count' => fn($q) => $q->where('is_active', false),
            'products as featured_products_count' => fn($q) => $q->where('is_featured', true),
            'portfolios',
        ]);

        $quotesCount = \App\Models\QuoteRequest::whereIn('product_id', $category->products()->select('id'))->count();

        $stats = [
            'products_total' => $category->products_count,
            'products_active' => $category->active_products_count ?? 0,
            'products_inactive' => $category->inactive_products_count ?? 0,
            'products_featured' => $category->featured_products_count ?? 0,
            'portfolios_total' => $category->portfolios_count,
            'quotes_total' => $quotesCount,
        ];

        $products = $category->products()->latest()->take(8)->get();

        return view('pages.admin.categories.show', compact('category', 'products', 'stats'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): View
    {
        return view('pages.admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($category->id),
            ],
            'icon' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
            'remove_image' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => __('main.category_name_required'),
            'name.max' => __('main.category_name_max'),
            'slug.unique' => __('main.category_slug_unique'),
            'image.image' => __('main.category_image_invalid'),
            'image.mimes' => __('main.category_image_mimes'),
            'image.max' => __('main.category_image_max'),
            'order.integer' => __('main.category_order_integer'),
        ]);

        // Process slug
        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'], '-', null)
            : Str::slug($validated['name'], '-', null);

        // Ensure unique slug except this category
        $originalSlug = $slug;
        $counter = 1;
        while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $imagePath = $category->image;

        // Handle image removal if requested
        if ($request->boolean('remove_image')) {
            if ($category->image && File::exists(public_path($category->image))) {
                File::delete(public_path($category->image));
            }
            $imagePath = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Remove previous image if exists
            if ($category->image && File::exists(public_path($category->image))) {
                File::delete(public_path($category->image));
            }

            $image = $request->file('image');
            $filename = 'cat_' . time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/categories');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $image->move($destinationPath, $filename);
            $imagePath = 'uploads/categories/' . $filename;
        }

        $order = isset($validated['order']) && $validated['order'] !== '' 
            ? (int) $validated['order'] 
            : $category->order;

        $existingEn = $category->getTranslation('name', 'en', false);
        $nameTranslations = [
            'ar' => $validated['name'],
            'en' => !empty($validated['name_en'])
                ? $validated['name_en']
                : ($existingEn ?: $validated['name']),
        ];

        $category->update([
            'name' => $nameTranslations,
            'slug' => $slug,
            'icon' => $validated['icon'] ?? $category->icon ?? 'box',
            'image' => $imagePath,
            'order' => $order,
            'is_active' => $request->boolean('is_active', false),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('main.category_updated_success', ['name' => $category->name]));
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $name = $category->name;
        $productsCount = $category->products()->count();

        // Safety check if category contains products
        if ($productsCount > 0) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', __('main.category_has_products_error', ['name' => $name, 'count' => $productsCount]));
        }

        // Delete image file if exists
        if ($category->image && File::exists(public_path($category->image))) {
            File::delete(public_path($category->image));
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('main.category_deleted_success', ['name' => $name]));
    }

    /**
     * Toggle active status of category.
     */
    public function toggleStatus(Category $category): RedirectResponse
    {
        $category->update([
            'is_active' => !$category->is_active,
        ]);

        $statusText = $category->is_active ? __('main.category_status_enabled') : __('main.category_status_disabled');

        return back()->with('success', __('main.category_status_toggled', ['status' => $statusText, 'name' => $category->name]));
    }
}
