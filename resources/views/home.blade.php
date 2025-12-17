@extends('layouts.app')
@section('contenido')

        {{-- ---------- Buttons: General | Siguiendo --}}
        <div class="flex justify-around p-1 bg-gray-200 dark:bg-gray-800 rounded-4xl gap-5 my-5">
            <a href="{{ route('home', ['filter' => 'general']) }}" class="w-full rounded-4xl text-center py-2 font-bold {{ $filter === 'general' ? 'bg-white dark:bg-gray-950 shadow-2xl' : '' }}">General</a>
            @auth
            <a href="{{ route('home', ['filter' => 'following']) }}" class="w-full rounded-4xl text-center py-2 font-bold {{ $filter === 'following' ? 'bg-white dark:bg-gray-950 shadow-2xl' : '' }}">Siguiendo</a>
            @endauth
        </div>

        {{-- ---------- Posts --}}
        <div class="space-y-5">
            @foreach ($posts as $post)
                <x-post-home :post="$post" />
            @endforeach
        </div>

        {{-- ---------- Pagination Posts --}}
        {{-- <div class="flex justify-center py-10">
            {{$posts->links('pagination::simple-tailwind')}}
        </div> --}}
@endsection