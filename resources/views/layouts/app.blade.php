<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite & App Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />

    @livewireStyles
</head>
<body class="font-sans antialiased is-preload">
    <!-- Title Bar (for mobile toggle) -->
    <div id="titleBar">
        <a href="#sidebar" class="toggle"></a>
        <span class="title">{{ config('app.name', 'O!TH') }}</span>
    </div>
    <x-banner />

    <div class="min-h-screen bg-gray-100 flex flex-wrap">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white shadow-md">
            <div class="p-4 border-b">
                <h1 id="logo" class="text-2xl font-bold">
                    <a href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
                </h1>
            </div>

            <!-- Auth Links in Sidebar (moved above nav) -->
            <div class="p-4 border-b sidebar-auth">
                @auth
                    <p class="mb-2">Logged in as <strong>{{ Auth::user()->name }}</strong></p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sidebar-btn">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="sidebar-btn mb-2">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="sidebar-btn">Register</a>
                    @endif
                @endauth
            </div>

            <!-- Nav Links -->
            @include('partials.nav')
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            @auth
                @livewire('navigation-menu')
            @endauth

            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('modals')
    @livewireScripts

    <!-- Mobile sidebar toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggle = document.querySelector('#titleBar .toggle');
            var sidebar = document.getElementById('sidebar');
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                document.body.classList.toggle('sidebar-visible');
            });
        });
    </script>
</body>
</html>
