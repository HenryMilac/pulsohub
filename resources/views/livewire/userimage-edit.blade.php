<div class="relative mx-auto md:mx-0 self-start">
    {{-- Hidden file input --}}
    <input
        type="file"
        wire:model="image"
        id="userImageInput"
        accept="image/*"
        class="hidden"
    >

    {{-- Image Display --}}
    <div class="w-40 h-40 flex-shrink-0 relative overflow-hidden" wire:loading.class="opacity-50" wire:target="image">
        @if($currentImage)
            <img
                src="{{ asset('profileimages/' . $currentImage) }}"
                alt="Imagen de perfil"
                class="w-full h-full rounded-full object-cover"
            >
        @else
            <div class="w-full h-full rounded-full flex items-center justify-center text-gray-300 text-5xl border border-gray-300">
                {{ $userInitial }}
            </div>
        @endif

        {{-- Loading Spinner --}}
        <div wire:loading wire:target="image" class="absolute inset-0 flex items-center justify-center">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div>
        </div>
    </div>

    {{-- Edit Button --}}
    <button
        type="button"
        onclick="document.getElementById('userImageInput').click()"
        class="bg-black text-white p-2 rounded-full cursor-pointer absolute bottom-2 right-0 hover:bg-gray-800 transition-colors"
        wire:loading.attr="disabled"
        wire:target="image"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
        </svg>
    </button>

    {{-- Delete Button --}}
    @if($currentImage)
        <button
            type="button"
            wire:click="deleteImage"
            wire:confirm="¿Estás seguro de que quieres eliminar la imagen de perfil?"
            class="bg-red-500 text-white p-2 rounded-full cursor-pointer absolute bottom-2 left-0 hover:bg-red-600 transition-colors"
            wire:loading.attr="disabled"
            wire:target="deleteImage"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
    @endif

    {{-- Error Message --}}
    @error('image')
        <p class="text-red-500 text-xs mt-2 absolute -bottom-6 left-0 right-0 text-center">{{ $message }}</p>
    @enderror
</div>
