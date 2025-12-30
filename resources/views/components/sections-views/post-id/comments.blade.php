@props(['post'])

<div class="flex flex-col gap-3">
    {{-- Title --}}
    <p class="text-xl font-bold">Comentarios</p>

    {{-- Section: Comment User --}}
    <div class="flex flex-col gap-3">
        @forelse ($post->comments as $comment)
            <div class="border-b border-gray-400 pb-2">
                <a href="{{ route('user.name', $comment->user) }}" class="inline-flex items-center gap-1 cursor-pointer">
                    {{-- Image User --}}
                    @if($comment->user && $comment->user->image)
                        <img 
                            src="{{ asset('profileimages/' . $comment->user->image) }}" 
                            alt="{{ $comment->user->name }}" 
                            class="w-7 h-7 rounded-full object-cover"
                        >
                    @else
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-gray-300 text-sm border border-gray-300">
                            {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                    {{-- Name User --}}
                    <p class="text-sm">{{ $comment->user->name ?? 'Usuario' }}</p>
                </a>
                {{-- Comment User --}}
                <p class="text-sm">{{ $comment->comment }}</p>
                <div class="flex justify-between items-center">
                    {{-- Date comment --}}
                    <span class="text-gray-500 text-xs">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                    {{-- Delete Comment --}}
                    @auth
                        @if(auth()->id() === $comment->user_id)
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="">
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
        @empty
            <p class="text-gray-500 text-sm text-center">No hay comentarios aún.</p>
        @endforelse
    </div>

    {{-- Section: Form Add Comment --}}
    @auth
        <form action="{{route('comments.store')}}" method="POST" class="flex flex-col gap-3">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <textarea type="text" name="comment" placeholder="Agregar comentario" class="w-full border border-gray-400 rounded-xl p-2 focus:outline-none">{{old('comment')}}</textarea>
            <x-buttons.button type="submit">Agregar comentario</x-buttons.button>
        </form>
    @endauth
</div>
