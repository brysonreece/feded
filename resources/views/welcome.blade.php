<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @livewireStyles
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class="w-full min-w-sm max-w-3xl mx-auto p-8 sm:p-16 lg:p-32">
                <div class="h-full flex flex-col space-y-16 lg:space-y-32 items-center justify-start">
                    <header class="flex-shrink-0 flex w-full">
                        <x-nav />
                    </header>

                    <main class="w-full flex-1">
                        @livewire('search-bar')
                    </main>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        @livewireScripts
    </body>
</html>
