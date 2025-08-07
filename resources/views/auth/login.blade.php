@extends('layouts.app')

@section('contenido')
<div class="max-w-md mx-auto py-20">
    <p class="text-center text-2xl font-bold pb-10">Login</p>
    <form action="{{route('login')}}" method="POST" class="flex flex-col gap-4">
        @csrf
        <input type="email" name="email" placeholder="Email" class="border p-2 rounded-md @error('email') border-red-500 @enderror" value="{{old('email')}}">
        @error('email')<p class="text-red-500">{{$message}}</p>@enderror
        <input type="password" name="password" placeholder="Contraseña" class="border p-2 rounded-md @error('password') border-red-500 @enderror">
        @error('password')<p class="text-red-500">{{$message}}</p>@enderror
        <div class="flex items-center gap-2">
            <input type="checkbox" name="remember" id="remember" class="w-5 h-5">
            <label for="remember">Recordar sesión</label>
        </div>
        <button type="submit" class="bg-blue-700 text-white p-2 rounded-md">Iniciar sesión</button>
    </form>
</div>
@endsection