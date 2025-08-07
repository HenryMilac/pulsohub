<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Verificar si el email existe en la base de datos
        if (!User::where('email', $request->email)->exists()) {
            return back()->withErrors([
                'email' => 'Este correo electrónico no está registrado.'
            ])->withInput($request->only('email'));
        }
        
        // Intentar autenticación
        if (!Auth::attempt($request->only('email', 'password'), $request->remember)) {
            return back()->withErrors([
                'password' => 'La contraseña es incorrecta.'
            ])->withInput($request->only('email'));
        }
        
        return redirect()->route('home');
    }
}
