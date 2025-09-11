@extends('layouts.app')

@section('contenido')
    <div class="max-w-md mx-auto mt-8 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Editar Perfil</h1>

        <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="delete_image" id="delete_image" value="0">
            
            {{-- ----- Name --}}
            <div class="flex flex-col gap-2">
                <label for="image" class="text-gray-500 text-sm">Nombre</label>
                <input type="text" name="name" id="name" placeholder="Nombre" value="{{ old('name', auth()->user()->name) }}" required  class="border p-2">
                @error('name')<p class="text-red-500">{{$message}}</p>@enderror
            </div>

            {{-- ----- Image --}}
            <div class="flex flex-col gap-2">
                <label for="image" class="text-gray-500 text-sm">Imagen de perfil</label>
                <input type="file" name="image" id="image" accept="image/*"  class="border cursor-pointer px-2 py-1">
                @if(auth()->user()->image)
                    <button type="button" onclick="deleteImage()" class="border px-2 py-1 cursor-pointer">Quitar Imagen</button>
                @endif
                <div class="rounded-full h-40 w-40 overflow-hidden border">
                    @if(auth()->user()->image)
                        <img src="{{ asset('profileimages/' . auth()->user()->image) }}" alt="Imagen actual" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-500 text-5xl">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- ----- Buttons --}}
            <div class="flex gap-5 mt-20">
                <button type="submit" class="border px-2 py-1 cursor-pointer">Guardar cambios</button>
                <a href="{{ route('user.name', ['user' => auth()->user()->name]) }}" class="border px-2 py-1 cursor-pointer">Cancelar</a>
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
                
                // Cambiar inmediatamente la imagen mostrada por "Sin imagen"
                const imageContainer = document.querySelector('.rounded-full.h-40.w-40');
                imageContainer.innerHTML = '<div class="w-full h-full flex items-center justify-center text-gray-500">Sin imagen</div>';
                
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