<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(User $user, Request $request)
    {
        $posts = Post::where('user_id', $user->id)->withCount(['likes', 'comments'])->latest()->paginate(10);

        // Check if the authenticated user is following this user
        $isFollowing = false;
        if (Auth::check()) {
            /** @var User $authUser */
            $authUser = Auth::user();
            $isFollowing = $authUser->following()->where('user_id', $user->id)->exists();
        }

        // Si es una petición AJAX, devolver solo el HTML de los posts
        if ($request->ajax()) {
            $html = '';
            foreach ($posts as $post) {
                $html .= view('components.post-profile', ['post' => $post])->render();
            }
            return response()->json([
                'html' => $html,
                'next_page' => $posts->nextPageUrl(),
                'has_more' => $posts->hasMorePages(),
            ]);
        }

        return view('profile', [
            'user' => $user,
            'posts' => $posts,
            'isFollowing' => $isFollowing,
        ]);
    }
}
