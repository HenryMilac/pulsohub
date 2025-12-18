@extends('layouts.app')

@section('contenido')
    <div class="">
        <div class="flex justify-between pt-5 pb-10">
            <h1 class="text-xl font-bold my-2">Editar Perfil</h1>
            <livewire:theme-toggle />
        </div>

        <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data" class="">
            @csrf
            @method('PUT')
            <input type="hidden" name="delete_image" id="delete_image" value="0">
            
            <div class="flex flex-col md:flex-row gap-5">
                {{-- Section: Image --}}
                <div class="relative mx-auto md:mx-0">
                    <input type="file" name="image" id="image" accept="image/*" class="hidden">

                    {{-- Imagen --}}
                    <div class="rounded-full h-40 w-40 overflow-hidden">
                        @if(auth()->user()->image)
                            <img src="{{ asset('profileimages/' . auth()->user()->image) }}" alt="Imagen actual" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-500 text-7xl">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    {{-- Botón de editar --}}
                    <button type="button" onclick="document.getElementById('image').click()" class="bg-black text-white p-2 rounded-full cursor-pointer absolute bottom-2 right-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>

                    {{-- Botón de eliminar --}}
                    @if(auth()->user()->image)
                        <button type="button" onclick="deleteImage()" class="bg-red-500 text-white p-2 rounded-full cursor-pointer absolute bottom-2 left-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    @endif
                </div>

                {{-- Section: Form --}}
                <div class="w-full">
                    <div class="flex flex-col w-full gap-3">
                        {{-- ----- Name --}}
                        <div class="flex flex-col">
                            <label for="image" class="text-sm text-gray-400">Nombres y Apellidos</label>
                            <input type="text" name="name" id="name" placeholder="Nombre" value="{{ old('name', auth()->user()->name) }}" required  class="border border-gray-400 rounded-xl p-2">
                            @error('name')<p class="text-red-500">{{$message}}</p>@enderror
                        </div>
                    </div>
                    {{-- ----- Buttons --}}
                    <div class="flex gap-3 justify-end mt-5">
                        <x-buttons.button type="submit">Guardar Cambios</x-buttons.button>
                        <x-buttons.button type="button" onclick="window.location.href='{{ route('user.name', ['user' => auth()->user()->name]) }}'">Cancelar</x-buttons.button>
                    </div>
                </div>
            </div>




        </form>
    </div>

    <script>
        function deleteImage() {
            if (confirm('¿Estás seguro de que quieres eliminar la imagen de perfil?')) {
                // Marcar para eliminar en el servidor
                document.getElementById('delete_image').value = '1';
                
                // Limpiar el input de archivo
                document.getElementById('image').value = '';
                
                // Cambiar inmediatamente la imagen mostrada por la inicial del nombre
                const imageContainer = document.querySelector('.rounded-full.h-40.w-40');
                const userName = document.getElementById('name').value;
                const initial = userName.charAt(0).toUpperCase();
                imageContainer.innerHTML = `<div class="w-full h-full flex items-center justify-center text-gray-500 text-7xl">${initial}</div>`;                
                // Ocultar el botón "Quitar Imagen"
                const deleteButton = document.querySelector('button[onclick="deleteImage()"]');
                if (deleteButton) {
                    deleteButton.style.display = 'none';
                }
            }
        }

        // Mostrar preview de nueva imagen cuando se selecciona
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Resetear el flag de eliminar imagen
                document.getElementById('delete_image').value = '0';
                
                // Crear URL temporal para mostrar la imagen
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageContainer = document.querySelector('.rounded-full.h-40.w-40');
                    imageContainer.innerHTML = `<img src="${e.target.result}" alt="Nueva imagen" class="w-full h-full object-cover">`;
                };
                reader.readAsDataURL(file);
                
                // Mostrar el botón "Quitar Imagen" si estaba oculto
                const deleteButton = document.querySelector('button[onclick="deleteImage()"]');
                if (deleteButton) {
                    deleteButton.style.display = 'inline-block';
                }
            }
        });
    </script>
@endsection