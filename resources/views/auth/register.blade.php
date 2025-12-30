@extends('layouts.app')

@section('contenido')
    <div>
        <div class="fixed top-0 left-0 w-full pt-5 flex justify-center">
            <a href="{{ route('home') }}" class="font-extrabold text-4xl">PulsoHub</a>
        </div>
        <div class="flex flex-col items-center justify-center h-screen max-w-sm w-full mx-auto">
            <p class="text-center text-2xl font-bold pb-5">Crear cuenta</p>
            <form action="{{ route('register') }}" method="POST" class="flex flex-col gap-4 w-full">
                @csrf
                <div>
                    <input type="text" name="name" placeholder="Nombre"
                        class="border border-gray-400 rounded-xl p-2 w-full @error('name') border-red-500 @enderror"
                        value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <input type="text" name="username" placeholder="Usuario"
                        class="border border-gray-400 rounded-xl p-2 w-full @error('username') border-red-500 @enderror"
                        value="{{ old('username') }}">
                    @error('username')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
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
                <div>
                    <input type="password" name="password_confirmation" placeholder="Confirmar contraseña"
                        class="border border-gray-400 rounded-xl p-2 w-full">
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <x-buttons.button type="submit">Registrarse</x-buttons.button>
            </form>
            <div class="flex gap-2 justify-center py-5 text-sm">
                <p class="text-gray-400">¿Ya tienes una cuenta?</p>
                <a href="{{ route('login') }}" class="text-blue-500 font-bold">Inicia Sesión</a>
            </div>
        </div>
    </div>
@endsection
