<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if ($this->attemptLogin($user, $request->input('password'))) {
            return $this->handleUserStatus($request, $user);
        }

        return $this->handleFailedLogin($request, 'Email atau password salah.');
    }

    private function attemptLogin(?User $user, string $password): bool
    {
        return $user && Hash::check($password, $user->password);
    }

    private function handleFailedLogin(Request $request, string $message)
    {
        return redirect()->back()->withInput()->with('notif_loginn', $message);
    }

    private function handleUserStatus(Request $request, User $user)
    {
        if ($user->status === 'pending') {
            return $this->handleFailedLogin($request, 'Akun Anda sedang dalam proses persetujuan.');
        }

        if ($user->status === 'rejected') {
            return $this->handleFailedLogin($request, 'Akun Anda telah ditolak.');
        }

        Auth::login($user);

        // Arahkan berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->intended('/dashboard');
        } elseif ($user->role === 'alumni') {
            return redirect()->intended('/');
        }

        // Default redirect jika role tidak dikenal
        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}
