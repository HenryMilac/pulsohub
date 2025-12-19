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
            'name' => 'required|string|max:255|unique:users,name,' . Auth::id()
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        return redirect()->route('user.name', ['user' => $user->name])
            ->with('success', 'Perfil actualizado correctamente');
    }
}
