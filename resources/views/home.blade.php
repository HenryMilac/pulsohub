@extends('layouts.app')

@section('contenido')
    <div>
        <div class="flex justify-around py-5">
            <a href="{{ route('home', ['filter' => 'general']) }}" 
               class="cursor-pointer px-4 py-2 {{ $filter === 'general' ? 'border-b-2' : '' }}">
                General
            </a>
            @auth
            <a href="{{ route('home', ['filter' => 'following']) }}" 
               class="cursor-pointer px-4 py-2 {{ $filter === 'following' ? 'border-b-2' : '' }}">
                Following
            </a>
            @endauth
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach ($posts as $post)
            <div>
                <a href="{{ route('posts.show', [
                    'user' => $post->user,
                    'post' => $post
                    ]) }}"
                >
                    <img src="{{ asset('uploads/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-56 object-cover">
                    <div>
                        <p>{{$post->title}}</p>
                        <p>{{$post->description}}</p>
                    </div>
                </a>
                <a href="{{ route('user.name', $post->user) }}" class="flex items-center gap-2">
                    @if($post->user->image)
                        <img src="{{ asset('profileimages/' . $post->user->image) }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 text-lg border">
                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                        </div>
                    @endif
                    <p>{{$post->user->name}}</p>
                </a>
            </div>
            @endforeach
        </div>
        <div class="flex justify-center py-10">
            {{$posts->links('pagination::simple-tailwind')}}
        </div>
    </div>
@endsection