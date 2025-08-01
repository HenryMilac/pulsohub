@extends('layouts.app')

@section('contenido')
<div class="max-w-md mx-auto py-20">
    <p class="text-center text-2xl font-bold pb-10">Registrar</p>
    <form action="{{route('register')}}" method="POST" class="flex flex-col gap-4">
        @csrf
        <input type="text" name="name" placeholder="Nombre" class="border p-2 rounded-md">
        <input type="email" name="email" placeholder="Email" class="border p-2 rounded-md">
        <input type="password" name="password" placeholder="Contraseña" class="border p-2 rounded-md">
        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" class="border p-2 rounded-md">
        <button type="submit" class="bg-blue-700 text-white p-2 rounded-md">Registrar</button>
    </form>
</div>
@endsection