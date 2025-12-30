<nav class="flex justify-between items-center p-5 border-b border-gray-300 bg-gray-100 dark:bg-gray-950 opacity-90">
    
    {{-- ---------- Logo --}}
    <a href="{{ route('home') }}" class="font-extrabold text-xl">PulsoHub</a>

    {{-- ---------- Name User | Login & Register --}}
    <div class="flex gap-3">
        @auth
            <a href="{{ auth()->check() ? route('user.profile', auth()->user()->username) : '/login' }}">Hola {{explode(' ', auth()->user()->name)[0]}}</a>
        @endauth
        @guest
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        @endguest
    </div>
</nav>