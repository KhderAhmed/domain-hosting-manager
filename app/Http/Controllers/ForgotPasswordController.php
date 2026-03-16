<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

use function Termwind\render;

class ForgotPasswordController extends Controller
{
    /**
     * عرض صفحة طلب إعادة تعيين كلمة المرور
     */
    public function create()
    {
        // ترجع صفحة الـ Inertia أو Blade
        return Inertia::render('Auth/ForgotPassword'); // لو تستخدم Inertia + Vue
        // return view('auth.forgot-password'); // لو تستخدم Blade
    }

    /**
     * معالجة طلب إعادة تعيين كلمة المرور
     */
    public function store(Request $request)
    {
        // التحقق من البريد الإلكتروني
        $request->validate([
            'email' => ['required', 'email']
        ]);

        // إرسال رابط إعادة تعيين كلمة المرور
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // تحقق من النتيجة وأرجع رسالة مناسبة
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    }
}
