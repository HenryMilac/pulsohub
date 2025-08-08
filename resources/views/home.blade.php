@extends('layouts.app')

@section('contenido')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-4">Perfil de {{ $user->name }}</h1>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p>0 Seguidores</p>
        <p>0 Siguiendo</p>
        <p>0 Posts</p>
        
        <div class="bg-gray-500 p-2 text-gray-100">
            @auth
                @if(auth()->user()->id === $user->id)
                    <p>Este es tu perfil</p>
                @else
                    <p>Tu usuario: {{ auth()->user()->name }}</p>
                @endif
            @else
                <p>Estás viendo el perfil de {{ $user->name }} como invitado</p>
            @endauth
        </div>
    </div>
@endsection