@extends('layouts.app')

@section('contenido')
        {{-- Toggle Posts Filter --}}
        @auth
            <div class="my-5">
                <x-toggles.posts-general-following :filter="$filter" />
            </div>
        @endauth

        {{-- Posts --}}
        <div class="space-y-5">
            @foreach ($posts as $post)
                <x-post-home :post="$post" />
            @endforeach
        </div>

        {{-- Pagination Posts --}}
        {{-- <div class="flex justify-center py-10">
            {{$posts->links('pagination::simple-tailwind')}}
        </div> --}}
@endsection