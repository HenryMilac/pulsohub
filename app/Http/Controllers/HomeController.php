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
                         ->with('user')
                         ->withCount(['likes', 'comments'])
                         ->latest()
                         ->paginate(10);
        } else {
            // Mostrar todos los posts (General)
            $posts = Post::with('user')
                         ->withCount(['likes', 'comments'])
                         ->latest()
                         ->paginate(10);
        }

        // Si es una petición AJAX, devolver solo el HTML de los posts
        if ($request->ajax()) {
            $html = '';
            foreach ($posts as $post) {
                $html .= view('components.post-home', ['post' => $post])->render();
            }

            // Preservar el filtro en la URL de la siguiente página
            $nextPageUrl = $posts->nextPageUrl();
            if ($nextPageUrl && $filter !== 'general') {
                $nextPageUrl .= '&filter=' . $filter;
            }

            return response()->json([
                'html' => $html,
                'next_page' => $nextPageUrl,
                'has_more' => $posts->hasMorePages(),
            ]);
        }

        return view('home', compact('user', 'posts', 'filter'));
    }
}
