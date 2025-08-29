@extends('layouts.app')

@section('contenido')
    <div>
        <p class="text-xl mb-5">Publicaciones de todos los usuarios</p>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
            @foreach ($posts as $post)
            <a href="{{ route('posts.show', [
                'user' => $post->user,
                'post' => $post
                ]) }}"
            >
                <img src="{{ asset('uploads/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-56 object-cover">
                <p>{{$post->user->name}}</p>
                <p>{{$post->title}}</p>
                <p>{{$post->description}}</p>
            </a>
            @endforeach
        </div>
        <div class="flex justify-center py-10">
            {{$posts->links('pagination::simple-tailwind')}}
        </div>
    </div>
@endsection