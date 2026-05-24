<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailOtpController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('home'));
        }
        return view('auth.verify-otp');
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate(['otp' => 'required|string|size:6']);

        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('home'));
        }

        if (! $user->isOtpValid($request->otp)) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
        }

        $user->markEmailAsVerifiedAndClearOtp();

        return redirect()->route('home')->with('success', 'Email berhasil diverifikasi! Selamat datang di malangan.com.');
    }

    public function resend(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('home'));
        }

        // Throttle: 1 menit per resend
        if ($user->otp_expires_at && $user->otp_expires_at->diffInSeconds(now()) < 540) {
            return back()->withErrors(['otp' => 'Tunggu sebentar sebelum meminta kode baru.']);
        }

        $user->generateAndSendOtp();

        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}
