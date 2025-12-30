@extends('layouts.app')

@section('contenido')
        {{-- Toggle Posts Filter --}}
        @auth
            <div class="my-5">
                <x-toggles.posts-general-following :filter="$filter" />
            </div>
        @endauth

        {{-- Posts Container --}}
        <div id="posts-container" class="flex flex-col gap-5 mt-3">
            @foreach ($posts as $post)
                <x-post-home :post="$post" />
            @endforeach
            {{-- Loading Indicator --}}
            <div id="loading-indicator" class="hidden pt-5 text-center">
                <svg class="animate-spin h-5 w-5 mx-auto text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            {{-- Sentinel Element for Intersection Observer --}}
            <div id="scroll-sentinel"></div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('posts-container');
                const sentinel = document.getElementById('scroll-sentinel');
                const loading = document.getElementById('loading-indicator');

                @php
                    $nextPageUrl = $posts->nextPageUrl();
                    if ($nextPageUrl && $filter !== 'general') {
                        $nextPageUrl .= '&filter=' . $filter;
                    }
                @endphp
                let nextPage = {!! json_encode($nextPageUrl) !!};
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
@endsection
