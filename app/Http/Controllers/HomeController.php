<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
        
        // Determinar qué filtro aplicar
        $filter = $request->get('filter', 'general');
        
        if ($filter === 'following') {
            // Obtener IDs de usuarios que sigue el usuario actual
            $followingIds = Follower::where('follower_id', $user->id)->pluck('user_id');
            
            // Obtener posts solo de usuarios que sigue
            $posts = Post::whereIn('user_id', $followingIds)
                         ->latest()
                         ->paginate(20);
        } else {
            // Mostrar todos los posts (General)
            $posts = Post::latest()->paginate(20);
        }
        
        return view('home', compact('user', 'posts', 'filter'));
    }
}
