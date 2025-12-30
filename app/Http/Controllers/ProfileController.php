<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index(){
        return view('profile-edit');
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:20|unique:users,username,' . Auth::id(),
            'date_of_birth' => 'nullable|date|before:today',
            'genre' => 'nullable|string|in:male,female,other',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',

            'username.required' => 'El usuario es obligatorio.',
            'username.max' => 'El usuario no puede tener más de 20 caracteres.',
            'username.unique' => 'Este usuario ya está en uso.',

            'date_of_birth.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'date_of_birth.before' => 'La fecha de nacimiento debe ser anterior a hoy.',

            'genre.in' => 'El género seleccionado no es válido.',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->date_of_birth = $request->date_of_birth;
        $user->genre = $request->genre;
        $user->save();

        return redirect()->route('user.profile', ['user' => $user->username])
            ->with('success', 'Perfil actualizado correctamente');
    }
}
