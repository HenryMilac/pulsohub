@extends('layouts.app')

@section('contenido')
    <div class="flex flex-col gap-5 my-5 relative">
        {{-- Section: Details --}}
        <x-sections-views.post-id.details :post="$post" />
        
        {{-- Section: Comments --}}
        <x-sections-views.post-id.comments :post="$post" />

        {{-- <a href="{{ route('home') }}" class="absolute top-0 left-0 bg-gray-700 text-white px-4 py-1 rounded-2xl">Atrás</a> --}}
    </div>
@endsection
