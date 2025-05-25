<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <!-- Sidebar -->
<aside class="w-64 bg-white border-r shadow-md flex flex-col">
    <!-- Brand -->
    <div class="p-6 text-2xl font-bold text-blue-600 border-b">
        <a href="{{ route('dashboard') }}">{{ config('app.name', 'Manage Structure') }}</a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-4">
        <!-- Employee List -->
        <a href="/employee" class="flex items-center gap-3 text-gray-700 hover:text-blue-600 px-4 py-2 rounded-md hover:bg-blue-100 transition">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span>Employee List</span>
        </a>

        <!-- Structure Section -->
        <div>
            <p class="px-4 text-sm font-semibold text-gray-500 uppercase mb-2">Structure</p>

            <div class="space-y-2 pl-4">
                <a href="/structure" class="flex items-center gap-3 text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md hover:bg-blue-100 transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <span>View Structure</span>
                </a>

                <a href="/manage" class="flex items-center gap-3 text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md hover:bg-blue-100 transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Manage Structure</span>
                </a>
            </div>
        </div>

       
    </nav>
</aside>


        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
