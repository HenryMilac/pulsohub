<?php

namespace App\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    public $post;

    public function like()
    {
        if (!$this->post->checkLike(auth()->user())) {
            $this->post->likes()->create([
                'user_id' => auth()->user()->id,
            ]);
            $this->post->refresh();
        }
    }

    public function unlike()
    {
        if ($this->post->checkLike(auth()->user())) {
            $this->post->likes()->where('user_id', auth()->user()->id)->delete();
            $this->post->refresh();
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
