<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserImageEdit extends Component
{
    use WithFileUploads;

    public $image;
    public $currentImage;
    public $userInitial;

    public function mount()
    {
        $this->loadUserImage();
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $this->uploadImage();
    }

    public function deleteImage()
    {
        $user = Auth::user();

        if ($user->image) {
            $this->deleteImageFromDisk($user->image);
            $user->image = null;
            $user->save();

            $this->loadUserImage();
            $this->dispatch('image-deleted');
        }
    }

    private function uploadImage()
    {
        $user = Auth::user();

        // Delete old image if exists
        if ($user->image) {
            $this->deleteImageFromDisk($user->image);
        }

        // Store new image using Laravel Storage
        $imageName = Str::uuid() . '.' . $this->image->getClientOriginalExtension();
        $this->image->storeAs('profileimages', $imageName, 'public_root');

        $user->image = $imageName;
        $user->save();

        $this->loadUserImage();
        $this->image = null;
        $this->dispatch('image-updated');
    }

    private function deleteImageFromDisk($imageName)
    {
        $imagePath = public_path('profileimages/' . $imageName);

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    private function loadUserImage()
    {
        $user = Auth::user();
        $this->currentImage = $user->image;
        $this->userInitial = strtoupper(substr($user->name, 0, 1));
    }

    public function render()
    {
        return view('livewire.userimage-edit');
    }
}
