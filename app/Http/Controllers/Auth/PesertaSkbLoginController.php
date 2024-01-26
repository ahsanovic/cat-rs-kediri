<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PesertaSkb;
use DB;

class PesertaSkbLoginController extends Controller
{
    // use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:peserta-skb')->except('logout');
    }

    public function showLoginForm()
    {
        return view('skb.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'nik' => 'required|string',
            'password' => 'required|string|min:8',
        ],[
            'nik.required' => 'username harus diisi',
            'password.required' => 'password harus diisi',
            'password.min' => 'password minimal 8 karakter'
        ]);

        $loginType = (is_numeric($request->nik)) ? 'nik' : 'nip';

        $login = [
         //   $loginType => $request->nik,
            'nik' => $request->nik,
	    'password' => $request->password,
            'blokir' => 'N',
        ];

        if (auth()->guard('peserta-skb')->attempt($login)) {
            $request->session()->regenerate();
            DB::table('peserta_skb')
                ->where('id', auth()->guard('peserta-skb')->user()->id)
                ->update([
                    'last_login' => date('Y-m-d H:i:s'),
                    'ip_address' => request()->ip(),
		    //'blokir' => 'Y'
                ]);
            // $this->clearLoginAttempts($request);
            return redirect()->route('ujian-skb');
        } else {
            return redirect('/skb')->with(['error' => 'NIK / password salah atau account anda diblokir!']);
        }
    }

    public function logout()
    {
        auth()->guard('peserta-skb')->logout();
        session()->flush();
        return redirect('/skb');
    }
}
