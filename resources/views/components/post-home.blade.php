@props(['post'])

<div class="border-b border-gray-400 pb-2 space-y-2">
    {{-- ---------- User information: Image, Name, Date --}}
    <a href="{{ route('user.name', $post->user) }}" class="flex justify-between w-full items-center gap-2">
        <div class="flex items-center gap-2">
            {{-- Image user --}}
            @if($post->user->image)
                <img src="{{ asset('profileimages/' . $post->user->image) }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full object-cover">
            @else
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-gray-300 text-lg  border border-gray-300">
                {{ strtoupper(substr($post->user->name, 0, 1)) }}
            </div>
            @endif
            {{-- Name user --}}
            <p class="text-sm">{{$post->user->name}}</p>
        </div>
        {{-- Date post --}}
        <p class="text-xs text-gray-500 ">{{ $post->created_at->diffForHumans() }}</p>
    </a>

    {{-- ---------- Post information: Description --}}
    <a href="{{ route('posts.show', [
        'user' => $post->user,
        'post' => $post
        ]) }}"
        class="block space-y-2"
    >
        {{-- Description --}}
        <p class="text-sm">{{$post->description}}</p>
        {{-- Image --}}
        @if($post->image)
            <img 
                src="{{ asset('uploads/' . $post->image) }}" 
                alt="{{ $post->title }}" 
                class="w-full object-cover rounded-xl"
            >
        @endif
    </a>
    {{-- ---------- Likes & Commments --}}
    <div class="flex gap-3 items-center text-xs text-gray-500">
        <livewire:like-post :post="$post"/>
        {{-- <p>{{ $post->likes_count }} @choice('Like|Likes', $post->likes_count)</p> --}}
        <p>{{ $post->comments_count }} @choice('Comentario|Comentarios', $post->comments_count)</p>
    </div>
</div>
