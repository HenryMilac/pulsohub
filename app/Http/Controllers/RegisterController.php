<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:25',
            'username' => 'required|string|max:20|unique:users',
            'email' => 'required|string|email|max:60|unique:users',
            'password' => 'required|string|min:4|confirmed',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 25 caracteres.',

            'username.required' => 'El usuario es obligatorio.',
            'username.unique' => 'Este usuario ya está en uso.',
            'username.max' => 'El usuario no puede tener más de 20 caracteres.',

            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección válida.',
            'email.unique' => 'Este email ya está registrado.',
            'email.max' => 'El email no puede tener más de 60 caracteres.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 4 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        Auth::attempt($request->only('email', 'password'));
        return redirect()->route('user.profile', Auth::user()->username);
    }
}
