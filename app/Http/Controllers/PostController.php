<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        return view('posts.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:200',
            'image' => 'nullable|string',
        ]);

        try {
            $request->user()->posts()->create([
                "title" => null,
                "description" => $request->description,
                "image" => $request->image ?? null,
                "user_id" => Auth::id(),
            ]);

            return redirect()->route('user.name', Auth::user())->with('success', 'Post creado exitosamente');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al crear el post: ' . $e->getMessage()]);
        }
    }

    public function show(User $user, Post $post)
    {
        // Cargar las relaciones necesarias
        $post->load(['likes', 'comments.user'])
             ->loadCount('comments');

        return view('post-id', [
            'user' => $user,
            'post' => $post,
        ]);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        // Delete image
        $imagePath = public_path('uploads/' . $post->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        return redirect()->route('user.name', Auth::user())->with('success', 'Post eliminado exitosamente');
    }
}
