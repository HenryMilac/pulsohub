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
                            <input type="text" name="name" id="name" placeholder="Nombre" value="{{ old('name', auth()->user()->name) }}" required class="border border-gray-400 rounded-xl p-2 @error('name') border-red-500 @enderror">
                            @error('name')<p class="text-red-500 text-sm">{{$message}}</p>@enderror
                        </div>

                        {{-- ----- Username --}}
                        <div class="flex flex-col">
                            <label for="username" class="text-sm text-gray-400">Usuario</label>
                            <input type="text" name="username" id="username" placeholder="Usuario" value="{{ old('username', auth()->user()->username) }}" required class="border border-gray-400 rounded-xl p-2 @error('username') border-red-500 @enderror">
                            @error('username')<p class="text-red-500 text-sm">{{$message}}</p>@enderror
                        </div>

                        <div class="flex gap-5">
                            {{-- ----- Genre --}}
                            <div class="flex flex-col w-1/2">
                                <label for="genre" class="text-sm text-gray-400">Género</label>
                                <select name="genre" id="genre" class="border border-gray-400 rounded-xl p-2 cursor-pointer @error('genre') border-red-500 @enderror">
                                    <option value="">Seleccionar género</option>
                                    <option value="male" {{ old('genre', auth()->user()->genre) == 'male' ? 'selected' : '' }}>Masculino</option>
                                    <option value="female" {{ old('genre', auth()->user()->genre) == 'female' ? 'selected' : '' }}>Femenino</option>
                                    <option value="other" {{ old('genre', auth()->user()->genre) == 'other' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('genre')<p class="text-red-500 text-sm">{{$message}}</p>@enderror
                            </div>

                            {{-- ----- Date of Birth --}}
                            <div class="flex flex-col w-1/2">
                                <label for="date_of_birth" class="text-sm text-gray-400">Fecha de Nacimiento</label>
                                <input 
                                    type="date" 
                                    name="date_of_birth" 
                                    id="date_of_birth" 
                                    value="{{ old('date_of_birth', auth()->user()->date_of_birth?->format('Y-m-d')) }}" 
                                    class="border border-gray-400 rounded-xl p-2 cursor-pointer @error('date_of_birth') border-red-500 @enderror"
                                >
                                @error('date_of_birth')<p class="text-red-500 text-sm">{{$message}}</p>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- ----- Buttons --}}
                    <div class="flex gap-3 justify-end mt-5">
                        <x-buttons.button type="submit">Guardar Cambios</x-buttons.button>
                        <x-buttons.button type="button" onclick="window.location.href='{{ route('user.profile', ['user' => auth()->user()->username]) }}'">Cancelar</x-buttons.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
