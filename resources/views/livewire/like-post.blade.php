<div class="flex items-center gap-3">
    <p class="font-medium">{{ $post->likes->count() }} 
        {{ $post->likes->count() === 1 ? 'like' : 'likes' }}
    </p>
    @auth
        @if($post->checkLike(auth()->user()))
            <button wire:click="like" class="cursor-pointer text-red-500 hover:text-red-600 transition-colors duration-200">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                </svg>
            </button>
        @else
            <button wire:click="like" class="cursor-pointer text-gray-400 hover:text-red-500 transition-colors duration-200">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </button>
        @endif
    @endauth
</div>
