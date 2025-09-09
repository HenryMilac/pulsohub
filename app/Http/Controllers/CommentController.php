<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'post_id' => 'required|exists:posts,id',
        ]);

        Comment::create([
            'comment' => $request->comment,
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
        ]);

        return back()->with('success', 'Comentario agregado exitosamente');
    }
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('posts.show', ['user' => $comment->post->user, 'post' => $comment->post]);
    }
}
