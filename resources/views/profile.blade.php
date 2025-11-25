@extends('layouts.app')

@section('contenido')
    <div class="flex gap-10 p-5">
        <div class="rounded-full h-36 w-36 relative overflow-hidden border">
            @if($user->image)
                <img src="{{ asset('profileimages/' . $user->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-500 text-5xl">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
        </div>
        <div>
            <div class="flex items-center gap-5">
                <h1 class="text-3xl font-bold mb-4">{{ $user->name }}</h1>
                @auth
                @if(auth()->id() === $user->id)
                <a href="{{ route('profile.index') }}" class="border px-2 py-1 cursor-pointer">Editar</a>
                @endif
                @endauth
            </div>
            @auth
            @if(auth()->id() !== $user->id)
                @if($isFollowing)
                    <form action="{{ route('users.unfollow', $user) }}" method="POST" class="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="border px-2 py-1 cursor-pointer">Dejar de seguir</button>
                    </form>
                @else
                    <form action="{{ route('users.follow', $user) }}" method="POST" class="">
                        @csrf
                        <button type="submit" class="border px-2 py-1 cursor-pointer">Seguir</button>
                    </form>
                @endif
            @endif
            @endauth
            <p>{{ $user->followers()->count() }} @choice('Seguidor|Seguidores', $user->followers()->count())</p>
            <p>{{ $user->following()->count() }} Siguiendo</p>
            <p>{{ $posts->count() }} Posts</p>
        </div>
    </div>
    <div>
        <p class="text-xl mb-5">Publicaciones</p>
        @if ($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach ($posts as $post)
                <a href="{{ route('posts.show', [
                    'user' => $post->user,
                    'post' => $post
                    ]) }}"
                >
                    <img src="{{ asset('uploads/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    <p>{{$post->title}}</p>
                    <p>{{$post->description}}</p>
                </a>
                @endforeach
            </div>
            <div class="flex justify-center py-10">
                {{$posts->links('pagination::simple-tailwind')}}
            </div>
        @else
            <p class="text-center">No tienes publicaciones aún</p>
        @endif
    </div>
@endsection