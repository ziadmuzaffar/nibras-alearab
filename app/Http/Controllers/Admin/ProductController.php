<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request): View
    {
        $query = Product::with(['category'])->withCount(['images', 'quoteRequests']);

        // Search by name, slug or description
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($categoryId = $request->input('category_id')) {
            if ($categoryId !== 'all') {
                $query->where('category_id', $categoryId);
            }
        }

        // Filter by active status
        if ($request->has('status') && $request->status !== '' && $request->status !== 'all') {
            $isActive = $request->status === '1' || $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        // Filter by featured status
        if ($request->has('featured') && $request->featured !== '' && $request->featured !== 'all') {
            $isFeatured = $request->featured === '1' || $request->featured === 'featured';
            $query->where('is_featured', $isFeatured);
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
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'category':
                $query->join('categories', 'products.category_id', '=', 'categories.id')
                      ->orderBy('categories.name', 'asc')
                      ->select('products.*');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        // Calculate KPI Statistics
        $stats = [
            'total' => Product::count(),
            'active' => Product::where('is_active', true)->count(),
            'inactive' => Product::where('is_active', false)->count(),
            'featured' => Product::where('is_featured', true)->count(),
        ];

        // Categories for filter dropdown
        $categories = Category::orderBy('name')->get(['id', 'name']);

        return view('pages.admin.products.index', compact('products', 'stats', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $categories = Category::orderBy('order', 'asc')->orderBy('name', 'asc')->get();

        return view('pages.admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'short_description_en' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'spec_keys' => ['nullable', 'array'],
            'spec_values' => ['nullable', 'array'],
            'spec_keys_en' => ['nullable', 'array'],
            'spec_values_en' => ['nullable', 'array'],
        ], [
            'category_id.required' => __('يرجى اختيار قسم أو تصنيف للمنتج.'),
            'category_id.exists' => __('التصنيف المحدد غير موجود.'),
            'name.required' => __('يرجى إدخال اسم المنتج.'),
            'name.max' => __('اسم المنتج طويل جداً (الحد الأقصى 255 حرفاً).'),
            'slug.unique' => __('الرابط المخصص (Slug) مستخدم بالفعل لمنتج آخر.'),
            'featured_image.image' => __('صورة المنتج الرئيسية يجب أن تكون ملف صورة صالح.'),
            'featured_image.mimes' => __('صيغ الصور المسموح بها هي: jpeg, png, jpg, webp, svg.'),
            'featured_image.max' => __('حجم الصورة لا يجب أن يتجاوز 3 ميغابايت.'),
            'gallery_images.*.image' => __('يجب أن تكون جميع ملفات المعرض صوراً صالحة.'),
            'gallery_images.*.mimes' => __('صيغ صور المعرض المسموح بها هي: jpeg, png, jpg, webp, svg.'),
            'gallery_images.*.max' => __('حجم كل صورة في المعرض لا يتجاوز 3 ميغابايت.'),
        ]);

        // Auto generate slug if empty
        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'], '-', null)
            : Str::slug($validated['name'], '-', null);

        // Ensure unique slug
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        // Process specifications key/value pairs (Arabic & English)
        $specificationsAr = [];
        if (!empty($request->spec_keys) && is_array($request->spec_keys)) {
            foreach ($request->spec_keys as $index => $key) {
                $trimmedKey = trim((string) $key);
                $value = isset($request->spec_values[$index]) ? trim((string) $request->spec_values[$index]) : '';
                if ($trimmedKey !== '' && $value !== '') {
                    $specificationsAr[$trimmedKey] = $value;
                }
            }
        }

        $specificationsEn = [];
        if (!empty($request->spec_keys_en) && is_array($request->spec_keys_en)) {
            foreach ($request->spec_keys_en as $index => $key) {
                $trimmedKey = trim((string) $key);
                $value = isset($request->spec_values_en[$index]) ? trim((string) $request->spec_values_en[$index]) : '';
                if ($trimmedKey !== '' && $value !== '') {
                    $specificationsEn[$trimmedKey] = $value;
                }
            }
        }

        $specifications = null;
        if (!empty($specificationsAr) || !empty($specificationsEn)) {
            if (!empty($specificationsEn)) {
                $specifications = [
                    'ar' => $specificationsAr ?: $specificationsEn,
                    'en' => $specificationsEn,
                ];
            } else {
                $specifications = $specificationsAr;
            }
        }

        // Handle featured image upload
        $featuredImagePath = null;
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = 'prod_' . time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/products');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $image->move($destinationPath, $filename);
            $featuredImagePath = 'uploads/products/' . $filename;
        }

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => [
                'ar' => $validated['name'],
                'en' => !empty($validated['name_en']) ? $validated['name_en'] : $validated['name'],
            ],
            'slug' => $slug,
            'short_description' => ($validated['short_description'] ?? null) || ($validated['short_description_en'] ?? null) ? [
                'ar' => $validated['short_description'] ?? $validated['short_description_en'] ?? '',
                'en' => !empty($validated['short_description_en']) ? $validated['short_description_en'] : ($validated['short_description'] ?? ''),
            ] : null,
            'description' => ($validated['description'] ?? null) || ($validated['description_en'] ?? null) ? [
                'ar' => $validated['description'] ?? $validated['description_en'] ?? '',
                'en' => !empty($validated['description_en']) ? $validated['description_en'] : ($validated['description'] ?? ''),
            ] : null,
            'specifications' => $specifications,
            'featured_image' => $featuredImagePath,
            'is_featured' => $request->boolean('is_featured', false),
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Handle additional gallery images
        if ($request->hasFile('gallery_images')) {
            $galleryPath = public_path('uploads/products/gallery');
            if (!File::isDirectory($galleryPath)) {
                File::makeDirectory($galleryPath, 0755, true, true);
            }

            $order = 0;
            foreach ($request->file('gallery_images') as $galleryFile) {
                if ($galleryFile->isValid()) {
                    $gFilename = 'prod_' . $product->id . '_' . time() . '_' . Str::random(6) . '.' . $galleryFile->getClientOriginalExtension();
                    $galleryFile->move($galleryPath, $gFilename);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'uploads/products/gallery/' . $gFilename,
                        'sort_order' => $order++,
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', __('تم إضافة المنتج ":name" بنجاح!', ['name' => $product->name]));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): View
    {
        $product->load(['category', 'images', 'quoteRequests']);

        $stats = [
            'images_count' => $product->images->count(),
            'quotes_count' => $product->quoteRequests->count(),
        ];

        return view('pages.admin.products.show', compact('product', 'stats'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        $product->load(['images']);
        $categories = Category::orderBy('order', 'asc')->orderBy('name', 'asc')->get();

        return view('pages.admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product->id),
            ],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'short_description_en' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
            'remove_featured_image' => ['nullable', 'boolean'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
            'delete_images' => ['nullable', 'array'],
            'delete_images.*' => ['integer'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'spec_keys' => ['nullable', 'array'],
            'spec_values' => ['nullable', 'array'],
            'spec_keys_en' => ['nullable', 'array'],
            'spec_values_en' => ['nullable', 'array'],
        ], [
            'category_id.required' => __('يرجى اختيار قسم أو تصنيف للمنتج.'),
            'category_id.exists' => __('التصنيف المحدد غير موجود.'),
            'name.required' => __('يرجى إدخال اسم المنتج.'),
            'name.max' => __('اسم المنتج طويل جداً (الحد الأقصى 255 حرفاً).'),
            'slug.unique' => __('الرابط المخصص (Slug) مستخدم بالفعل في منتج آخر.'),
            'featured_image.image' => __('صورة المنتج الرئيسية يجب أن تكون ملف صورة صالح.'),
            'featured_image.mimes' => __('صيغ الصور المسموح بها هي: jpeg, png, jpg, webp, svg.'),
            'featured_image.max' => __('حجم الصورة لا يجب أن يتجاوز 3 ميغابايت.'),
            'gallery_images.*.image' => __('يجب أن تكون جميع ملفات المعرض صوراً صالحة.'),
            'gallery_images.*.mimes' => __('صيغ صور المعرض المسموح بها هي: jpeg, png, jpg, webp, svg.'),
            'gallery_images.*.max' => __('حجم كل صورة في المعرض لا يتجاوز 3 ميغابايت.'),
        ]);

        // Process slug
        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'], '-', null)
            : Str::slug($validated['name'], '-', null);

        // Ensure unique slug except this product
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        // Process specifications key/value pairs (Arabic & English)
        $specificationsAr = [];
        if (!empty($request->spec_keys) && is_array($request->spec_keys)) {
            foreach ($request->spec_keys as $index => $key) {
                $trimmedKey = trim((string) $key);
                $value = isset($request->spec_values[$index]) ? trim((string) $request->spec_values[$index]) : '';
                if ($trimmedKey !== '' && $value !== '') {
                    $specificationsAr[$trimmedKey] = $value;
                }
            }
        }

        $specificationsEn = [];
        if (!empty($request->spec_keys_en) && is_array($request->spec_keys_en)) {
            foreach ($request->spec_keys_en as $index => $key) {
                $trimmedKey = trim((string) $key);
                $value = isset($request->spec_values_en[$index]) ? trim((string) $request->spec_values_en[$index]) : '';
                if ($trimmedKey !== '' && $value !== '') {
                    $specificationsEn[$trimmedKey] = $value;
                }
            }
        }

        $specifications = null;
        if (!empty($specificationsAr) || !empty($specificationsEn)) {
            if (!empty($specificationsEn)) {
                $specifications = [
                    'ar' => $specificationsAr ?: $specificationsEn,
                    'en' => $specificationsEn,
                ];
            } else {
                $specifications = $specificationsAr;
            }
        }

        $featuredImagePath = $product->featured_image;

        // Handle featured image removal
        if ($request->boolean('remove_featured_image')) {
            if ($product->featured_image && File::exists(public_path($product->featured_image))) {
                File::delete(public_path($product->featured_image));
            }
            $featuredImagePath = null;
        }

        // Handle new featured image upload
        if ($request->hasFile('featured_image')) {
            if ($product->featured_image && File::exists(public_path($product->featured_image))) {
                File::delete(public_path($product->featured_image));
            }

            $image = $request->file('featured_image');
            $filename = 'prod_' . time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/products');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $image->move($destinationPath, $filename);
            $featuredImagePath = 'uploads/products/' . $filename;
        }

        // Handle deletion of selected gallery images
        if (!empty($request->delete_images) && is_array($request->delete_images)) {
            $imagesToDelete = ProductImage::where('product_id', $product->id)
                ->whereIn('id', $request->delete_images)
                ->get();

            foreach ($imagesToDelete as $delImg) {
                if (File::exists(public_path($delImg->image_path))) {
                    File::delete(public_path($delImg->image_path));
                }
                $delImg->delete();
            }
        }

        // Handle new gallery images upload
        if ($request->hasFile('gallery_images')) {
            $galleryPath = public_path('uploads/products/gallery');
            if (!File::isDirectory($galleryPath)) {
                File::makeDirectory($galleryPath, 0755, true, true);
            }

            $lastOrder = ProductImage::where('product_id', $product->id)->max('sort_order') ?? 0;
            foreach ($request->file('gallery_images') as $galleryFile) {
                if ($galleryFile->isValid()) {
                    $gFilename = 'prod_' . $product->id . '_' . time() . '_' . Str::random(6) . '.' . $galleryFile->getClientOriginalExtension();
                    $galleryFile->move($galleryPath, $gFilename);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'uploads/products/gallery/' . $gFilename,
                        'sort_order' => ++$lastOrder,
                    ]);
                }
            }
        }

        $existingNameEn = $product->getTranslation('name', 'en', false);
        $existingShortEn = $product->getTranslation('short_description', 'en', false);
        $existingDescEn = $product->getTranslation('description', 'en', false);

        $product->update([
            'category_id' => $validated['category_id'],
            'name' => [
                'ar' => $validated['name'],
                'en' => !empty($validated['name_en']) ? $validated['name_en'] : ($existingNameEn ?: $validated['name']),
            ],
            'slug' => $slug,
            'short_description' => ($validated['short_description'] ?? null) || ($validated['short_description_en'] ?? null) ? [
                'ar' => $validated['short_description'] ?? $validated['short_description_en'] ?? '',
                'en' => !empty($validated['short_description_en']) ? $validated['short_description_en'] : ($existingShortEn ?: ($validated['short_description'] ?? '')),
            ] : null,
            'description' => ($validated['description'] ?? null) || ($validated['description_en'] ?? null) ? [
                'ar' => $validated['description'] ?? $validated['description_en'] ?? '',
                'en' => !empty($validated['description_en']) ? $validated['description_en'] : ($existingDescEn ?: ($validated['description'] ?? '')),
            ] : null,
            'specifications' => $specifications,
            'featured_image' => $featuredImagePath,
            'is_featured' => $request->boolean('is_featured', false),
            'is_active' => $request->boolean('is_active', false),
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', __('تم تحديث بيانات المنتج ":name" بنجاح!', ['name' => $product->name]));
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $name = $product->name;

        // Delete featured image file if exists
        if ($product->featured_image && File::exists(public_path($product->featured_image))) {
            File::delete(public_path($product->featured_image));
        }

        // Delete all gallery image files
        foreach ($product->images as $galleryImg) {
            if ($galleryImg->image_path && File::exists(public_path($galleryImg->image_path))) {
                File::delete(public_path($galleryImg->image_path));
            }
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', __('تم حذف المنتج ":name" بنجاح.', ['name' => $name]));
    }

    /**
     * Toggle active status of product.
     */
    public function toggleStatus(Product $product): RedirectResponse
    {
        $product->update([
            'is_active' => !$product->is_active,
        ]);

        $statusText = $product->is_active ? __('تفعيل') : __('تعطيل');

        return back()->with('success', __('تم :status المنتج ":name" بنجاح.', ['status' => $statusText, 'name' => $product->name]));
    }

    /**
     * Toggle featured status of product.
     */
    public function toggleFeatured(Product $product): RedirectResponse
    {
        $product->update([
            'is_featured' => !$product->is_featured,
        ]);

        $statusText = $product->is_featured ? __('تمييز') : __('إلغاء تمييز');

        return back()->with('success', __('تم :status المنتج ":name" بنجاح.', ['status' => $statusText, 'name' => $product->name]));
    }

    /**
     * Delete a single gallery image.
     */
    public function destroyImage(ProductImage $image): RedirectResponse
    {
        if (File::exists(public_path($image->image_path))) {
            File::delete(public_path($image->image_path));
        }

        $image->delete();

        return back()->with('success', __('تم حذف الصورة من المعرض بنجاح.'));
    }
}
