<nav class="flex justify-between items-center p-5 border-b border-gray-300 bg-gray-100 opacity-90">
    
    {{-- ---------- Logo --}}
    <a href="{{ route('home') }}" class="font-bold">PulsoHub</a>

    {{-- ---------- Name User | Login & Register --}}
    <div class="flex gap-3 font-bold">
        @auth
            <a href="{{ auth()->check() ? route('user.name', auth()->user()) : '/login' }}">Hola {{explode(' ', auth()->user()->name)[0]}}</a>
        @endauth
        @guest
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        @endguest
    </div>
</nav>