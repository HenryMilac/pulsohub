@props(['type' => 'button'])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'border px-4 py-2 bg-gray-900 text-gray-200 rounded-xl cursor-pointer']) }}
>
    {{ $slot }}
</button>
