<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        $post->likes()->create([
            'user_id' => Auth::user()->id,
        ]);

        return back()->with('success', 'Like agregado correctamente');
    }
    public function destroy(Like $like)
    {
        // Verificar que el usuario sea el propietario del like
        if ($like->user_id !== Auth::user()->id) {
            return back()->with('error', 'No tienes permisos para eliminar este like');
        }

        $like->delete();
        return back()->with('success', 'Like eliminado correctamente');
    }
}
