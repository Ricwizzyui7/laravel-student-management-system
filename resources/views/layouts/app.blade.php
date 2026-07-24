<!DOCTYPE html>
@php $userTheme = Auth::check() ? Auth::user()->theme : 'system'; @endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ $userTheme }}">
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

        <script>
            (function() {
                var theme = document.documentElement.getAttribute('data-theme');
                if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                }
                window.__userTheme = theme;
            })();
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow dark:bg-gray-800">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
             @if(session('success') || session('error'))
                 <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6" x-data="{ show: true }" x-show="show">
                     @if(session('success'))
                         <div class="flex items-start gap-3 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
                             <svg class="h-5 w-5 shrink-0 text-emerald-500 dark:text-emerald-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 5.29a1 1 0 010 1.42l-7.5 7.5a1 1 0 01-1.42 0l-3.5-3.5a1 1 0 011.42-1.42l2.79 2.79 6.79-6.79a1 1 0 011.42 0z" clip-rule="evenodd"/></svg>
                             <span class="flex-1 font-medium">{{ session('success') }}</span>
                             <button type="button" @click="show = false" class="text-emerald-400 hover:text-emerald-600 dark:text-emerald-500 dark:hover:text-emerald-300">&times;</button>
                         </div>
                     @endif
                     @if(session('error'))
                         <div class="flex items-start gap-3 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-950 dark:text-red-200">
                             <svg class="h-5 w-5 shrink-0 text-red-500 dark:text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                             <span class="flex-1 font-medium">{{ session('error') }}</span>
                             <button type="button" @click="show = false" class="text-red-400 hover:text-red-600 dark:text-red-500 dark:hover:text-red-300">&times;</button>
                         </div>
                     @endif
                 </div>
             @endif
             {{ $slot }}
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
