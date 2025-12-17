<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index(){
        return view('profile-edit');
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . Auth::id(),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $user = Auth::user();
        $user->name = $request->name;

        // Handle image deletion
        if ($request->delete_image == '1') {
            // Delete old image if exists (same as PostController approach)
            if ($user->image) {
                $imagePath = public_path('profileimages/' . $user->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $user->image = null;
        }
        // Handle image upload
        elseif ($request->hasFile('image')) {
            // Delete old image if exists (same as PostController approach)
            if ($user->image) {
                $imagePath = public_path('profile_images/' . $user->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Store new image in public/profileimages (same as PostController approach)
            $image = $request->file('image');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profileimages'), $imageName);
            $user->image = $imageName;
        }

        $user->save();

        return redirect()->route('user.name', ['user' => $user->name])
            ->with('success', 'Perfil actualizado correctamente');
    }
}
