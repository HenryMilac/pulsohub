<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|string|email|max:20|unique:users',
            'password' => 'required|string|min:4|confirmed',
        ]);
        dd($request->all());
    }
}
