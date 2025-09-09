@extends('layouts.app')

@section('contenido')
<div class="flex gap-5 my-10 relative">
    <a href="{{ route('home') }}" class="absolute top-0 left-0 bg-gray-700 text-white px-4 py-1 rounded-2xl">Atras</a>
    <div class="w-1/2">
        <img src="{{ asset('uploads/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
        <a href="{{ route('user.name', $post->user) }}" class="flex items-center mb-6 cursor-pointer">
            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                <span class="">{{ substr($post->user->name ?? 'Usuario', 0, 1) }}</span>
            </div>
            <p class="">{{ $post->user->name ?? 'Usuario' }}</p>
        </a>
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
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                <span class="text-sm">{{ substr($comment->user->name ?? 'Usuario', 0, 1) }}</span>
                            </div>
                            <span class="font-medium">{{ $comment->user->name ?? 'Usuario' }}</span>
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
