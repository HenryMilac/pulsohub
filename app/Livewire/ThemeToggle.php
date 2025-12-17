<?php

namespace App\Livewire;

use Livewire\Component;

class ThemeToggle extends Component
{
    public $theme;

    public function mount()
    {
        $this->theme = auth()->user()->theme ?? 'light';
    }

    public function toggleTheme()
    {
        $this->theme = $this->theme === 'light' ? 'dark' : 'light';

        auth()->user()->update([
            'theme' => $this->theme
        ]);

        $this->dispatch('theme-changed', theme: $this->theme);
    }

    public function render()
    {
        return view('livewire.theme-toggle');
    }
}
