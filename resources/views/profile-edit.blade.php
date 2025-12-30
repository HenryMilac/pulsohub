@extends('layouts.app')

@section('contenido')
    <div class="">
        <div class="flex justify-between pt-5 pb-10">
            <h1 class="text-xl font-bold my-2">Editar Perfil</h1>
            <livewire:theme-toggle />
        </div>

        <div class="flex flex-col md:flex-row gap-5">
            <livewire:user-image-edit />

            {{-- Section: Form --}}
            <div class="w-full">
                <form action="{{route('profile.update')}}" method="POST" class="">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col w-full gap-3">
                        {{-- ----- Name --}}
                        <div class="flex flex-col">
                            <label for="name" class="text-sm text-gray-400">Nombres y Apellidos</label>
                            <input type="text" name="name" id="name" placeholder="Nombre" value="{{ old('name', auth()->user()->name) }}" required  class="border border-gray-400 rounded-xl p-2">
                            @error('name')<p class="text-red-500">{{$message}}</p>@enderror
                        </div>
                    </div>

                    {{-- ----- Buttons --}}
                    <div class="flex gap-3 justify-end mt-5">
                        <x-buttons.button type="submit">Guardar Cambios</x-buttons.button>
                        <x-buttons.button type="button" onclick="window.location.href='{{ route('user.name', ['user' => auth()->user()->name]) }}'">Cancelar</x-buttons.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
