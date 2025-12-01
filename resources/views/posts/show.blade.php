@extends('layouts.app')

@section('contenido')
<div class="flex gap-5 my-10 relative">
    <a href="{{ route('home') }}" class="absolute top-0 left-0 bg-gray-700 text-white px-4 py-1 rounded-2xl">Atras</a>

    {{-- Post Section --}}
    <div class="w-1/2">
        @if($post->image)
            <img src="{{ asset('uploads/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
        @endif
        <div class="flex justify-between items-center">
            <a href="{{ route('user.name', $post->user) }}" class="flex items-center mb-6 cursor-pointer gap-2">
                @if($post->user->image)
                    <img src="{{ asset('profileimages/' . $post->user->image) }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full object-cover">
                @else
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 text-lg border">
                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                    </div>
                @endif
                <p class="">{{ $post->user->name ?? 'Usuario' }}</p>
            </a>
            <livewire:like-post :post="$post"/>
        </div>
        <div class="flex justify-between">
            <h1 class="">{{ $post->title }}</h1>
            <p class="">{{ $post->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <p class="">{{ $post->description }}</p>
        @auth
        @if(auth()->id() === $post->user_id)
        <form action="{{route('posts.destroy', $post)}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="border p-2 cursor-pointer text-red-600">Eliminar Post</button>
        </form>
        @endif
        @endauth
    </div>

    {{-- Comments Section --}}
    <div class="w-1/2">
        @auth
        <div class="border p-5">
            <p>Agregar un comentario</p>
            <form action="{{route('comments.store')}}" method="POST" class="flex flex-col gap-5">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <textarea type="text" name="comment" placeholder="Comentario" class="border p-2">{{old('comment')}}</textarea>
                <input type="submit" value="Agregar comentario" class="border p-2 cursor-pointer">
            </form>
        </div>
            
        @endauth
        <div>
            <p>Comentarios:</p>
            <div class="flex flex-col gap-5">
                @forelse ($post->comments as $comment)
                    <a href="{{ route('user.name', $comment->user) }}" class="border p-2 cursor-pointer">
                        <div class="flex items-center">
                            <div class="flex items-center gap-2">
                                @if($comment->user && $comment->user->image)
                                    <img src="{{ asset('profileimages/' . $comment->user->image) }}" alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 text-lg border">
                                        {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                                <span class="font-medium">{{ $comment->user->name ?? 'Usuario' }}</span>
                            </div>
                            <span class="text-gray-500 text-sm ml-auto">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <p>{{ $comment->comment }}</p>
                            @auth
                            @if(auth()->id() === $comment->user_id)
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-2 text-red-600 hover:underline cursor-pointer">Eliminar</button>
                            </form>
                            @endif
                            @endauth
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500">No hay comentarios aún.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
