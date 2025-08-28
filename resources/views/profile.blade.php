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
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="border p-5">
                    <p>Image</p>
                    <p>Title</p>
                    <p>Description</p>
                    <p>Date</p>
                </div>
            </div>
        </div>
    </div>
@endsection