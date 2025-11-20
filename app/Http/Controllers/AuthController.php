<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 

class AuthController extends Controller
{


    public function showLogin()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->intended('dashboard'); 
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }


    public function showRegister()
    {
        return view('auth.register');
    }

    public function registerProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nim_nik' => 'required|string|unique:patients,nim_nik',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'tgl_lahir' => 'required|date',
        ]);

 
        DB::beginTransaction();

        try {
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'patient',
                'no_hp' => $request->no_hp,
            ]);

            Patient::create([
                'user_id' => $user->id,
                'nim_nik' => $request->nim_nik,
                'alamat' => $request->alamat,
                'tgl_lahir' => $request->tgl_lahir,
            ]);

            DB::commit();

   
            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Gagal mendaftar: ' . $e->getMessage()])->withInput();
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}