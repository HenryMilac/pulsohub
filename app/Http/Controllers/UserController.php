<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(User $user)
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(10);
        return view('profile', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }
}
