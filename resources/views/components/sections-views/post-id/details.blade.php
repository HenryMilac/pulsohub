@props(['post'])

<div class="flex flex-col gap-2">
    {{-- Section: Image & Name User & Date Post --}}
    <div class="flex justify-between items-center">
        <a href="{{ route('user.profile', $post->user->username) }}" class="inline-flex justify-between items-center gap-2">
            {{-- Image User --}}
            @if($post->user->image)
                <img
                    src="{{ asset('profileimages/' . $post->user->image) }}"
                    alt="{{ $post->user->name }}"
                    class="w-10 h-10 rounded-full object-cover"
                >
            @else
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 text-lg border">
                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                </div>
            @endif
            {{-- Name User--}}
            <p class="text-sm">{{$post->user->name}}</p>
        </a>
        {{-- Date post --}}
        <p class="text-xs text-gray-500">{{ $post->created_at->format('d/m/Y H:i') }}</p>
        {{-- <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p> --}}
    </div>

    {{-- Section: Description & Image Post --}}
    <span href="{{ route('posts.show', [
        'user' => $post->user,
        'post' => $post
        ]) }}"
        class="block space-y-2"
    >
        {{-- Description Post --}}
        <p class="text-sm">{{$post->description}}</p>
        {{-- Image Post --}}
        @if($post->image)
            <img
                src="{{ asset('uploads/' . $post->image) }}"
                alt="{{ $post->title }}"
                class="w-full object-cover rounded-xl cursor-pointer"
                onclick="openImageModal(this.src, this.alt)"
            >
        @endif
    </span>

    {{-- Section: Likes & Commments & Delete Post --}}
    <div class="flex justify-between items-center text-xs text-gray-500">
        <div class="flex gap-3">
            {{-- Likes --}}
            <livewire:like-post :post="$post"/>
            {{-- Comments --}}
            <p>{{ $post->comments_count }} @choice('Comentario|Comentarios', $post->comments_count)</p>
        </div>
        <div class="flex gap-3">
            {{-- Delete Post --}}
            @auth
            @if(auth()->id() === $post->user_id)
            <form action="{{route('posts.destroy', $post)}}" method="POST" onclick="return confirm('¿Estás seguro de eliminar este post?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 cursor-pointer flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    <p class="text-xs">Eliminar</p>
                </button>
            </form>
            @endif
            @endauth
        </div>
    </div>
</div>

{{-- Section: Modal zoom image --}}
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-7xl max-h-full">
        {{-- Botón cerrar --}}
        <button
            onclick="closeImageModal()"
            class="absolute -top-10 right-0 text-white cursor-pointer z-10"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        {{-- Imagen --}}
        <img
            id="modalImage"
            src=""
            alt=""
            class="max-w-full max-h-screen object-contain rounded-lg"
            onclick="event.stopPropagation()"
        >
    </div>
</div>

<script>
    function openImageModal(src, alt) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = src;
        modalImage.alt = alt;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    // Cerrar modal con tecla ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeImageModal();
        }
    });
</script>
