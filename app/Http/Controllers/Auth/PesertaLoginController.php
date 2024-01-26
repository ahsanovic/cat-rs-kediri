<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Peserta;
use DB;

class PesertaLoginController extends Controller
{
    // use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:peserta')->except('logout');
    }

    public function showLoginForm()
    {
        return view('tes.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'nik' => 'required|string',
            'password' => 'required|string|min:6',
        ],[
            'nik.required' => 'username harus diisi',
            'password.required' => 'password harus diisi',
            'password.min' => 'password minimal 6 karakter'
        ]);

        //$loginType = (is_numeric($request->nik)) ? 'nik' : 'nip';
        $login = [
            //$loginType => $request->nik,
            'nik'=> $request->nik,
            'password' => $request->password,
            'blokir' => 'N'
        ];

        if (auth()->guard('peserta')->attempt($login)) {
            $request->session()->regenerate();
            DB::table('peserta')
                ->where('id', auth()->guard('peserta')->user()->id)
                ->update([
                    'last_login' => date('Y-m-d H:i:s'),
                    'ip_address' => request()->ip(),
		    //'blokir' => 'Y'
                ]);
            // $this->clearLoginAttempts($request);
            return redirect()->route('ujian');
        } else {
            return redirect('/login')->with(['error' => 'username / password salah atau account anda diblokir!']);
        }
    }

    public function logout()
    {
        auth()->guard('peserta')->logout();
        session()->flush();
        return redirect('/');
    }
}
