<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    public function store(User $user)
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        
        // Prevent users from following themselves
        if ($authUser->id === $user->id) {
            return redirect()->back();
        }

        // Check if already following
        if (!$authUser->following()->where('user_id', $user->id)->exists()) {
            $authUser->following()->attach($user->id);
        }

        return redirect()->back();
    }
    
    public function destroy(User $user)
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        
        // Check if currently following
        if ($authUser->following()->where('user_id', $user->id)->exists()) {
            $authUser->following()->detach($user->id);
        }

        return redirect()->back();
    }
}
