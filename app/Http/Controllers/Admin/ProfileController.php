<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the profile edit page for the authenticated admin.
     */
    public function edit(): View
    {
        $user = Auth::user();

        return view('pages.admin.profile.edit', compact('user'));
    }

    /**
     * Update the authenticated admin's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

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
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
            'remove_avatar' => ['nullable', 'boolean'],
        ], [
            'name.required' => __('يرجى إدخال اسمك الكامل.'),
            'name.max' => __('الاسم طويل جداً (الحد الأقصى 255 حرفاً).'),
            'email.required' => __('يرجى إدخال البريد الإلكتروني.'),
            'email.email' => __('صيغة البريد الإلكتروني غير صحيحة.'),
            'email.unique' => __('البريد الإلكتروني مسجل بالفعل لمستخدم آخر.'),
            'avatar.image' => __('الصورة الشخصية يجب أن تكون ملف صورة صالح.'),
            'avatar.mimes' => __('صيغ الصور المسموح بها: jpeg, png, jpg, webp, svg.'),
            'avatar.max' => __('حجم الصورة لا يجب أن يتجاوز 3 ميغابايت.'),
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

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'avatar' => $avatarPath,
        ]);

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', __('تم تحديث بيانات الملف الشخصي بنجاح!'));
    }

    /**
     * Update the authenticated admin's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => __('يرجى إدخال كلمة المرور الحالية.'),
            'password.required' => __('يرجى إدخال كلمة المرور الجديدة.'),
            'password.min' => __('كلمة المرور الجديدة يجب ألا تقل عن 8 أحرف.'),
            'password.confirmed' => __('تأكيد كلمة المرور الجديدة غير متطابق.'),
        ]);

        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => __('كلمة المرور الحالية غير صحيحة.'),
            ]);
        }

        $user->update([
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', __('تم تغيير كلمة المرور بنجاح!'));
    }
}
