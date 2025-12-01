@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@section('contenido')
<div class="container mx-auto flex justify-between p-5 gap-5">
    {{-- ----- Image Dropzone --}}
    <form action="{{route('images.store')}}" method="POST" id="imageDropzone" enctype="multipart/form-data" class="dropzone text-gray-400" style="background-color: #000 !important; border: 1px dashed #fff; width: 100%; height: 100%;">@csrf</form>
    {{-- ----- Image Form: Title, Description --}}
    <form action="{{route('posts.store')}}" method="POST" class="flex flex-col gap-4 w-1/2">
        @csrf
        {{-- <input type="text" name="title" placeholder="Titulo" class="border p-2 rounded-md @error('title') border-red-500 @enderror" value="{{old('title')}}">
        @error('title')<p class="text-red-500">{{$message}}</p>@enderror --}}
        <textarea name="description" placeholder="Descripcion" class="border p-2 @error('description') border-red-500 @enderror">{{old('description')}}</textarea>
        @error('description')<p class="text-red-500">{{$message}}</p>@enderror
        <input type="hidden" name="image" id="imageInput" value="{{old('image')}}">
        @error('image')<p class="text-red-500">{{$message}}</p>@enderror
        <button type="submit" class="border p-2 rounded-md cursor-pointer">Crear Post</button>
    </form>
</div>
@endsection