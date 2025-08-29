@extends('layouts.app')

@section('contenido')
    <div>
        <div class="flex gap-10 p-5">
            <div class="border rounded-full h-36 w-36">
            </div>
            <div>
                <h1 class="text-3xl font-bold mb-4">{{ $user->name }}</h1>
                <p>0 Seguidores</p>
                <p>0 Siguiendo</p>
                <p>0 Posts</p>
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
    </div>
@endsection