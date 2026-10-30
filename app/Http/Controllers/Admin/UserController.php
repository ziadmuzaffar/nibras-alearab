<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Search by name, email, or phone
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by active status
        if ($request->has('status') && $request->status !== '' && $request->status !== 'all') {
            $isActive = $request->status === '1' || $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        // Filter by email verification status
        if ($request->has('verified') && $request->verified !== '' && $request->verified !== 'all') {
            if ($request->verified === '1' || $request->verified === 'verified') {
                $query->whereNotNull('email_verified_at');
            } else {
                $query->whereNull('email_verified_at');
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
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $users = $query->paginate(12)->withQueryString();

        // Calculate KPI Statistics
        $stats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
        ];

        return view('pages.admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('pages.admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
            'is_active' => ['nullable', 'boolean'],
            'email_verified' => ['nullable', 'boolean'],
        ], [
            'name.required' => __('يرجى إدخال اسم المستخدم بالكامل.'),
            'name.max' => __('اسم المستخدم طويل جداً (الحد الأقصى 255 حرفاً).'),
            'email.required' => __('يرجى إدخال البريد الإلكتروني للمستخدم.'),
            'email.email' => __('صيغة البريد الإلكتروني غير صحيحة.'),
            'email.unique' => __('البريد الإلكتروني مسجل بالفعل لمستخدم آخر.'),
            'password.required' => __('يرجى إدخال كلمة المرور.'),
            'password.min' => __('كلمة المرور يجب ألا تقل عن 8 أحرف.'),
            'password.confirmed' => __('تأكيد كلمة المرور غير متطابق.'),
            'avatar.image' => __('الصورة الشخصية يجب أن تكون ملف صورة صالح.'),
            'avatar.mimes' => __('صيغ الصور المسموح بها هي: jpeg, png, jpg, webp, svg.'),
            'avatar.max' => __('حجم الصورة الشخصية لا يتجاوز 3 ميغابايت.'),
        ]);

        // Handle avatar upload
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $filename = 'usr_' . time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/users');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $image->move($destinationPath, $filename);
            $avatarPath = 'uploads/users/' . $filename;
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => $validated['password'],
            'avatar' => $avatarPath,
            'is_active' => $request->boolean('is_active', true),
            'email_verified_at' => $request->boolean('email_verified', true) ? now() : null,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('تم إضافة المستخدم ":name" بنجاح!', ['name' => $user->name]));
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        return view('pages.admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('pages.admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
            'remove_avatar' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'email_verified' => ['nullable', 'boolean'],
        ], [
            'name.required' => __('يرجى إدخال اسم المستخدم بالكامل.'),
            'name.max' => __('اسم المستخدم طويل جداً (الحد الأقصى 255 حرفاً).'),
            'email.required' => __('يرجى إدخال البريد الإلكتروني للمستخدم.'),
            'email.email' => __('صيغة البريد الإلكتروني غير صحيحة.'),
            'email.unique' => __('البريد الإلكتروني مسجل بالفعل لمستخدم آخر.'),
            'password.min' => __('كلمة المرور يجب ألا تقل عن 8 أحرف.'),
            'password.confirmed' => __('تأكيد كلمة المرور غير متطابق.'),
            'avatar.image' => __('الصورة الشخصية يجب أن تكون ملف صورة صالح.'),
            'avatar.mimes' => __('صيغ الصور المسموح بها هي: jpeg, png, jpg, webp, svg.'),
            'avatar.max' => __('حجم الصورة الشخصية لا يتجاوز 3 ميغابايت.'),
        ]);

        $avatarPath = $user->avatar;

        // Handle avatar removal
        if ($request->boolean('remove_avatar')) {
            if ($user->avatar && File::exists(public_path($user->avatar))) {
                File::delete(public_path($user->avatar));
            }
            $avatarPath = null;
        }

        // Handle new avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar && File::exists(public_path($user->avatar))) {
                File::delete(public_path($user->avatar));
            }

            $image = $request->file('avatar');
            $filename = 'usr_' . time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/users');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $image->move($destinationPath, $filename);
            $avatarPath = 'uploads/users/' . $filename;
        }

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'avatar' => $avatarPath,
            'is_active' => $request->boolean('is_active', false),
        ];

        // Update password if provided
        if (!empty($validated['password'])) {
            $userData['password'] = $validated['password'];
        }

        // Handle email verification toggle
        if ($request->boolean('email_verified')) {
            if (is_null($user->email_verified_at)) {
                $userData['email_verified_at'] = now();
            }
        } else {
            $userData['email_verified_at'] = null;
        }

        $user->update($userData);

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('تم تحديث بيانات المستخدم ":name" بنجاح!', ['name' => $user->name]));
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $name = $user->name;

        // Delete avatar file if exists
        if ($user->avatar && File::exists(public_path($user->avatar))) {
            File::delete(public_path($user->avatar));
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('تم حذف المستخدم ":name" بنجاح.', ['name' => $name]));
    }

    /**
     * Toggle active status of user.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $statusText = $user->is_active ? __('تفعيل') : __('تعطيل');

        return back()->with('success', __('تم :status حساب المستخدم ":name" بنجاح.', ['status' => $statusText, 'name' => $user->name]));
    }
}
