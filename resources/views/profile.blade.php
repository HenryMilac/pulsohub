@extends('layouts.app')

@section('contenido')
    <div class="flex gap-5 py-5">
        {{-- Image User --}}
        <div class="rounded-full h-36 w-36 flex-shrink-0 relative overflow-hidden">
            @if($user->image)
                <img src="{{ asset('profileimages/' . $user->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-500 text-5xl">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
        </div>
        <div class="space-y-2 w-full">
            <div class="flex flex-col">
                <div class="flex justify-between">
                    <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                    {{-- Dropdown Menu --}}
                    @auth
                    @if(auth()->id() === $user->id)
                    <div class="relative inline-block mt-2" x-data="{ open: false }">
                        {{-- Icon 3 pints --}}
                        <button @click="open = !open" class="pl-2 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                            </svg>
                        </button>
                        {{-- Buttons --}}
                        <div x-show="open" @click.away="open = false" class="absolute right-0 bg-gray-100 dark:bg-gray-950 rounded-lg shadow-xl border border-gray-300 z-10 py-3 px-4 space-y-2 w-auto min-w-fit" style="width: auto; min-width: max-content;">
                            <a href="{{ route('profile.index') }}" class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                Editar Perfil
                            </a>
                            <form action="{{route('logout')}}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-1 text-red-600 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                    </svg>
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                    @endauth
                </div>
                <div class="flex gap-5">
                    <p class="text-sm text-gray-500">{{ $user->followers()->count() }} @choice('Seguidor|Seguidores', $user->followers()->count())</p>
                    <p class="text-sm text-gray-500">{{ $user->following()->count() }} Siguiendo</p>
                </div>
            </div>
            @auth
            @if(auth()->id() !== $user->id)
                @if($isFollowing)
                    <form action="{{ route('users.unfollow', $user) }}" method="POST" class="">
                        @csrf
                        @method('DELETE')
                        <x-buttons.button type="submit">Dejar de seguir</x-buttons.button>
                    </form>
                    @else
                    <form action="{{ route('users.follow', $user) }}" method="POST" class="">
                        @csrf
                        <x-buttons.button type="submit">Seguir</x-buttons.button>
                    </form>
                @endif
            @endif
            @endauth
        </div>
    </div>

    <div>
        <p class="text-xl font-bold mb-2">{{ $posts->count() }} Publicaciones</p>
        @auth
        @if(auth()->id() === $user->id)
            <div class="mb-5">
                <x-create-post />
            </div>
        @endif
        @endauth
        
        {{-- ---------- Posts --}}
        @if ($posts->count() > 0)
            <div class="grid grid-cols-1 gap-5">
                @foreach ($posts as $post)
                <x-post-profile :post="$post" />
                @endforeach
            </div>
            {{-- ---------- Page Next --}}
            {{-- <div class="flex justify-center py-10">
                {{$posts->links('pagination::simple-tailwind')}}
            </div> --}}
        @else
            <p class="text-center">No tienes publicaciones aún</p>
        @endif
    </div>
@endsection