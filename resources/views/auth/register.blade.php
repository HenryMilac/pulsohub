@extends('layouts.app')

@section('contenido')
<div class="max-w-md mx-auto py-20">
    <p class="text-center text-2xl font-bold pb-10">Registrar</p>
    <form action="{{route('register')}}" method="POST" class="flex flex-col gap-4">
        @csrf
        <input type="text" name="name" placeholder="Nombre" class="border p-2 rounded-md @error('name') border-red-500 @enderror" value="{{old('name')}}">
        @error('name')<p class="text-red-500">{{$message}}</p>@enderror
        <input type="email" name="email" placeholder="Email" class="border p-2 rounded-md @error('email') border-red-500 @enderror" value="{{old('email')}}">
        @error('email')<p class="text-red-500">{{$message}}</p>@enderror
        <input type="password" name="password" placeholder="Contraseña" class="border p-2 rounded-md @error('password') border-red-500 @enderror">
        @error('password')<p class="text-red-500">{{$message}}</p>@enderror
        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" class="border p-2 rounded-md">
        @error('password_confirmation')<p class="text-red-500">{{$message}}</p>@enderror
        <button type="submit" class="bg-blue-700 text-white p-2 rounded-md cursor-pointer">Registrar</button>
    </form>
</div>
@endsection