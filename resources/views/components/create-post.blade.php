@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

<div class="">
    {{-- ----- Form to create a new post --}}
    <form action="{{route('posts.store')}}" method="POST" class="">
        @csrf

        {{-- Description Textarea --}}
        <div class="w-full" x-data="{ emojiOpen: false }">
            <textarea
                x-ref="textarea"
                name="description"
                placeholder="¿Qué estás pensando?"
                rows="4"
                class="w-full border border-gray-400 rounded-xl p-2 focus:outline-none @error('description') border-red-500 @enderror"
            >{{old('description')}}</textarea>
            @error('description')
                <p class="text-red-500 text-sm">{{$message}}</p>
            @enderror
        </div>


        <div class="flex justify-between">
            {{-- Icon Image Upload --}}
            <div>
                <button type="button" id="imageUploadBtn" class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </button>
                <input type="hidden" name="image" id="imageInput" value="{{old('image')}}">
            </div>
            {{-- Button Create a post --}}
            <x-buttons.button type="submit">Crear Post</x-buttons.button>
        </div>

        {{-- Image Error Message --}}
        @error('image')
            <p class="text-red-500 text-sm">{{$message}}</p>
        @enderror

        {{-- Hidden Dropzone (invisible) --}}
        <div id="imageDropzone" class="hidden"></div>
    </form>

    {{-- ---------- Image Preview Area --}}
    <div id="imagePreviewContainer" class="hidden">
        <div class="relative inline-block">
            {{-- Image upload preview --}}
            <img id="imagePreview" src="" alt="Preview" class="max-w-40 h-auto rounded-lg border border-gray-300">
            {{-- Button Delete Image --}}
            <button
                type="button"
                id="removeImageBtn"
                class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 cursor-pointer"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>
