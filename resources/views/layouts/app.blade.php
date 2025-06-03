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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">


    <!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


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

            <a href="/manage" class="flex items-center gap-3 text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md hover:bg-blue-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Add New Rayon</span>
            </a>


            <!-- <a href="" class="flex items-center gap-3 text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md hover:bg-blue-100 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 
            4-1.79 4-4-1.79-4-4-4z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 
            01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09a1.65 1.65 
            0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 
            1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 
            2 0 012.83-2.83l.06.06a1.65 1.65 0 001.82.33h.09a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 
            0 001 1.51h.09a1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82v.09a1.65 
            1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
    </svg>
    <span>Manage Structure</span>
</a> -->


                <a href="/structure" class="flex items-center gap-3 text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md hover:bg-blue-100 transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <span>View Structure</span>
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
