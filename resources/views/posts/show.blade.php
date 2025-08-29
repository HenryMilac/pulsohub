@extends('layouts.app')

@section('contenido')
<div class="flex gap-5 my-10 relative">
    <a href="{{ route('home') }}" class="absolute top-0 left-0 bg-gray-700 text-white px-4 py-1 rounded-2xl">Atras</a>
    <div class="w-1/2">
        <img src="{{ asset('uploads/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
        <div class="">
            <h1 class="">{{ $post->title }}</h1>
            
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                    <span class="">{{ substr($post->user->name ?? 'Usuario', 0, 1) }}</span>
                </div>
                <div>
                    <p class="">{{ $post->user->name ?? 'Usuario' }}</p>
                    <p class="">{{ $post->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <p class="">{{ $post->description }}</p>
        </div>
    </div>
    <div class="w-1/2">
        <p>Comentarios etc</p>
    </div>
</div>
@endsection
