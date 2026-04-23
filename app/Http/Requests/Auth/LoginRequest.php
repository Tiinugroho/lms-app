<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Ubah dari 'email' menjadi 'login' (teks bebas)
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $login = $this->input('login');

        // Pencarian Cerdas: Cari berdasarkan Email, ATAU NIP Guru, ATAU NIP Staff, ATAU NISN Siswa
        $user = User::where('email', $login)
            ->orWhereIn('id', Teacher::select('user_id')->where('nip', $login))
            ->orWhereIn('id', Staff::select('user_id')->where('nip', $login))
            ->orWhereIn('id', Student::select('user_id')->where('nisn', $login))
            ->first();

        // Jika user tidak ditemukan, atau password salah
        if (! $user || ! Hash::check($this->input('password'), $user->password)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }

        Auth::login($user, $this->boolean('remember'));

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('login')).'|'.$this->ip());
    }
}