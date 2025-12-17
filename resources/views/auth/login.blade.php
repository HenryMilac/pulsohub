@extends('layouts.app')

@section('contenido')
<div class="h-screen flex justify-center items-center">
    <div class="max-w-sm w-full">
        <p class="text-center text-2xl font-bold pb-5">Iniciar sesión</p>
        <form action="{{route('login')}}" method="POST" class="flex flex-col gap-4">
            @csrf
            <div>
                <input type="email" name="email" placeholder="Email" class="border border-gray-400 rounded-xl p-2 w-full @error('email') border-red-500 @enderror" value="{{old('email')}}">
                @error('email')<p class="text-red-500 text-sm">{{$message}}</p>@enderror
            </div>
            <div>
                <input type="password" name="password" placeholder="Contraseña" class="border border-gray-400 rounded-xl p-2 w-full @error('password') border-red-500 @enderror">
                @error('password')<p class="text-red-500 text-sm">{{$message}}</p>@enderror
            </div>
            <div class="flex items-center gap-1 -mt-2">
                <input type="checkbox" name="remember" id="remember" class="w-3 h-3">
                <label for="remember" class="text-sm text-gray-400 cursor-pointer">Recordar sesión</label>
            </div>
            <x-button-general type="submit">Iniciar Sesión</x-button-general>
        </form>
        <div class="flex gap-2 justify-center py-5">
            <p>¿No tienes una cuenta?</p>
            <a href="{{route('register')}}" class="text-blue-500 font-bold">Regístrate</a>
        </div>
    </div>
</div>
@endsection