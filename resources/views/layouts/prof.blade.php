<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex">
        <div class="flex flex-col w-64 gap-2 border-r border-neutral-200">
            <div class="flex items-center px-6 h-16">
                <span class="text-xl font-bold">{{ config('app.name', 'Plagiat') }}</span>
            </div>
            <div class="flex flex-col gap-0 flex-1">
                @foreach ($nav as $item)
                    <a href="{{ $item['url'] }}"
                        class="flex items-center px-6 py-3 text-sm hover:bg-gray-100 transition-all text-neutral-600 capitalize">
                        <span class="text-gray-700">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
            <div class="flex flex-col">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit"
                        class="flex items-center px-6 py-3 text-sm hover:bg-gray-100 transition-all text-neutral-600 capitalize w-full text-left">
                        <span class="text-gray-700">Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="flex flex-col flex-1">
            <x-global-header />

            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>