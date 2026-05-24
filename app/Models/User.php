<?php

namespace App\Models;

use App\Notifications\EmailOtpNotification;
use App\Notifications\WelcomeNotification;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'avatar',
    ];

    protected $hidden = [
        'password', 'remember_token', 'otp_code',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at'    => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Override default link-based verification → kirim OTP
    public function sendEmailVerificationNotification(): void
    {
        $this->generateAndSendOtp();
    }

    public function generateAndSendOtp(): void
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->otp_code       = $otp;
        $this->otp_expires_at = now()->addMinutes(10);
        $this->saveQuietly();
        $this->notify(new EmailOtpNotification($otp));
    }

    public function isOtpValid(string $code): bool
    {
        return $this->otp_code === $code
            && $this->otp_expires_at !== null
            && $this->otp_expires_at->isFuture();
    }

    public function markEmailAsVerifiedAndClearOtp(): void
    {
        $this->email_verified_at = now();
        $this->otp_code          = null;
        $this->otp_expires_at    = null;
        $this->saveQuietly();
        $this->notify(new WelcomeNotification());
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
