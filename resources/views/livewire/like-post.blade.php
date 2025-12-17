<div>
    {{-- TODO: si un post tiene 3 likes, le doy un like, pero luego le quito mi like, se borra todos los likes de todos los usuarios, corrige eso --}}
    @auth
        @if($post->checkLike(auth()->user()))
            <button 
                wire:click="like" 
                class="flex items-center gap-1 text-red-500 cursor-pointer"
            >
                <svg fill="currentColor" viewBox="0 0 20 20" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                </svg>
                <p>{{ $post->likes->count() }} 
                    {{ $post->likes->count() === 1 ? 'Like' : 'Likes' }}
                </p>
            </button>
        @else
            <button 
                wire:click="like"
                class="flex items-center gap-1 cursor-pointer"
            >
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <p>{{ $post->likes->count() }} 
                    {{ $post->likes->count() === 1 ? 'Like' : 'Likes' }}
                </p>
            </button>
        @endif
    @endauth
</div>
