<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string|max:100',
            'image' => 'required|string',
        ]);
        
        try {
            $request->user()->posts()->create([
                "title" => $request->title,
                "description" => $request->description,
                "image" => $request->image,
                "user_id" => Auth::id(),
            ]);
            
            return redirect()->route('user.name', Auth::user())->with('success', 'Post creado exitosamente');
            
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al crear el post: ' . $e->getMessage()]);
        }
    }
}
