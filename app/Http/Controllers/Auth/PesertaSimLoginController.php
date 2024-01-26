<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PesertaSim;
use Hash;

class PesertaSimLoginController extends Controller
{
    // use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:peserta-sim')->except('logout');
    }

    public function showLoginForm()
    {
        return view('simulasi.login');
    }

    public function showRegisterForm()
    {
        return view('simulasi.register');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string',
            'email' => 'required|string|email|unique:peserta_sim',
            'username' => 'required|string|unique:peserta_sim|min:6',
            'password' => 'required|string|min:8|confirmed',
        ],[
            'nama.required' => 'nama harus diisi',
            'email.required' => 'email harus diisi',
            'email.email' => 'format email harus benar',
            'username.required' => 'username harus diisi',
            'username.min' => 'username minimal 6 karakter',
            'password.required' => 'password harus diisi',
            'password.min' => 'password minimal 8 karakter'
        ]);
    
        PesertaSim::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        return redirect('simulasi/login')->with(['success' => 'register berhasil, silahkan login untuk memulai tes']);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string|min:8',
        ],[
            'username.required' => 'username / email harus diisi',
            'password.required' => 'password harus diisi',
            'password.min' => 'password minimal 8 karakter'
        ]);

        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
        $login = [
            $loginType => $request->username,
            'password' => $request->password
        ];

        if (auth()->guard('peserta-sim')->attempt($login)) {
            $request->session()->regenerate();
            // $this->clearLoginAttempts($request);       
            return redirect()->route('ujian-sim');
        } else {
            return redirect('/simulasi/login')->with(['error' => 'e-mail/username atau password salah!']);
        }
    }

    public function logout()
    {
        auth()->guard('peserta-sim')->logout();
        session()->flush();
        return redirect('/simulasi/login');
    }
}
