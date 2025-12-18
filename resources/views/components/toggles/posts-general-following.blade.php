@props(['filter' => 'general'])

<div class="flex justify-around p-1 bg-gray-200 dark:bg-gray-800 rounded-4xl gap-5">
    <a href="{{ route('home', ['filter' => 'general']) }}" class="w-full rounded-4xl text-center py-2 font-bold {{ $filter === 'general' ? 'bg-white dark:bg-gray-950 shadow-2xl' : '' }}">General</a>
    <a href="{{ route('home', ['filter' => 'following']) }}" class="w-full rounded-4xl text-center py-2 font-bold {{ $filter === 'following' ? 'bg-white dark:bg-gray-950 shadow-2xl' : '' }}">Siguiendo</a>
</div>
