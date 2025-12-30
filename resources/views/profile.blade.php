@extends('layouts.app')

@section('contenido')
    <div class="flex gap-5 py-5">
        {{-- Image User --}}
        <div class="flex-shrink-0 relative overflow-hidden">
            @if($user->image)
                <img 
                    src="{{ asset('profileimages/' . $user->image) }}" 
                    alt="{{ $user->name }}" 
                    class="w-36 h-36 rounded-full object-cover"
                >
            @else
                <div class="w-36 h-36 rounded-full flex items-center justify-center text-gray-300 text-5xl border border-gray-300">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
        </div>
        {{-- Name User & Follows & Icon points --}}
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
        {{-- Create a new post --}}
        <p class="text-xl font-bold mb-2">{{ $posts->total() }} @choice('Publicación|Publicaciones', $posts->total())</p>
        @auth
        @if(auth()->id() === $user->id)
            <div class="mb-5">
                <x-create-post />
            </div>
        @endif
        @endauth

        {{-- Posts --}}
        @if ($posts->count() > 0)
            <div id="posts-container" class="flex flex-col gap-5 mt-5">
                @foreach ($posts as $post)
                <x-post-profile :post="$post" />
                @endforeach
            </div>

            {{-- Loading Indicator --}}
            <div id="loading-indicator" class="hidden pt-5 text-center">
                <svg class="animate-spin h-5 w-5 mx-auto text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            {{-- Sentinel Element for Intersection Observer --}}
            <div id="scroll-sentinel"></div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const container = document.getElementById('posts-container');
                    const sentinel = document.getElementById('scroll-sentinel');
                    const loading = document.getElementById('loading-indicator');

                    let nextPage = {!! json_encode($posts->nextPageUrl()) !!};
                    let isLoading = false;
                    let hasMore = {{ $posts->hasMorePages() ? 'true' : 'false' }};

                    function stopLoading() {
                        observer.disconnect();
                        sentinel.classList.add('hidden');
                        loading.classList.add('hidden');
                        hasMore = false;
                        nextPage = null;
                    }

                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting && hasMore && nextPage && !isLoading) {
                                loadMorePosts();
                            }
                        });
                    }, {
                        rootMargin: '100px'
                    });

                    if (hasMore && nextPage) {
                        observer.observe(sentinel);
                    } else {
                        stopLoading();
                    }

                    function loadMorePosts() {
                        if (!nextPage || !hasMore || isLoading) return;

                        isLoading = true;
                        loading.classList.remove('hidden');

                        fetch(nextPage, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            isLoading = false;
                            loading.classList.add('hidden');

                            if (data.html && data.html.trim() !== '') {
                                container.insertAdjacentHTML('beforeend', data.html);

                                // Reinicializar Livewire para los nuevos componentes
                                if (window.Livewire) {
                                    window.Livewire.rescan();
                                }
                            }

                            // Actualizar estado
                            nextPage = data.next_page || null;
                            hasMore = data.has_more === true;

                            // Detener si no hay más páginas
                            if (!hasMore || !nextPage) {
                                stopLoading();
                            }
                        })
                        .catch(error => {
                            console.error('Error loading posts:', error);
                            isLoading = false;
                            loading.classList.add('hidden');
                            // En caso de error, detener el scroll infinito
                            stopLoading();
                        });
                    }
                });
            </script>
        @else
            <p class="text-center">No tienes publicaciones aún</p>
        @endif
    </div>
@endsection