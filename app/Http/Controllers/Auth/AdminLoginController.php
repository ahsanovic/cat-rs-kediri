<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;
    
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ],[
            'username.required' => 'username / email harus diisi',
            'password.required' => 'password harus diisi',
            'password.min' => 'password minimal 6 karakter'
        ]);

        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
        $login = [
            $loginType => $request->username,
            'password' => $request->password
        ];
    
        if (auth()->guard('admin')->attempt($login)) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            return redirect()->route('home');
        } else {
            return redirect('admin/login')->with(['error' => 'e-mail/username atau password salah!']);
        }

    }

    public function logout()
    {
        auth()->guard('admin')->logout();
        session()->flush();
        return redirect('/admin/login');
    }
}
