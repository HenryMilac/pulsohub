@extends('layouts.app')

@section('contenido')
    <div>
        <div class="fixed top-0 left-0 w-full pt-5 flex justify-center">
            <a href="{{ route('home') }}" class="font-extrabold text-4xl">PulsoHub</a>
        </div>
        <div class="flex flex-col items-center justify-center h-screen max-w-sm w-full mx-auto">
            <p class="text-center text-2xl font-bold pb-5">Iniciar sesión</p>
            <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-4 w-full">
                @csrf
                <div>
                    <input type="email" name="email" placeholder="Email"
                        class="border border-gray-400 rounded-xl p-2 w-full @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <input type="password" name="password" placeholder="Contraseña"
                        class="border border-gray-400 rounded-xl p-2 w-full @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center gap-1 -mt-2">
                    <input type="checkbox" name="remember" id="remember" class="w-3 h-3">
                    <label for="remember" class="text-sm text-gray-400 cursor-pointer">Recordar sesión</label>
                </div>
                <x-buttons.button type="submit">Iniciar Sesión</x-buttons.button>
            </form>
            <div class="flex gap-2 justify-center py-5 text-sm">
                <p class="text-gray-400">¿No tienes una cuenta?</p>
                <a href="{{ route('register') }}" class="text-blue-500 font-bold">Regístrate</a>
            </div>
        </div>
    </div>
@endsection
