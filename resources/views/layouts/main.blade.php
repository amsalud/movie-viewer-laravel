<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Viewer</title>
    <link rel="stylesheet" href="/css/main.css">
    <livewire:styles>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body class="font-sans bg-gray-900 text-white">
    <nav class="border-b border-gray-800">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-4 py-6">
            <ul class="flex flex-col md:flex-row items-center">
                <li>
                    <a href="{{route('movies.index')}}" class="flex">
                        <img src="/img/logo.png" alt="logo" width="25">
                        <span class="ml-2">Movie Viewer</span>
                    </a>
                </li>
                <li class="md:ml-16 mt-3 md:mt-0">
                    <a href="{{route('movies.index')}}" class="hover:text-gray-300">Movies</a>
                </li>
                <li class="md:ml-6 mt-3 md:mt-0">
                    <a href="{{route('tv.index')}}" class="hover:text-gray-300">TV Shows</a>
                </li>
                <li class="md:ml-6 mt-3 md:mt-0">
                    <a href="{{route('actors.index')}}" class="hover:text-gray-300">Actors</a>
                </li>
            </ul>
            <div class="flex flex-col md:flex-row items-center">
                <livewire:search-dropdown />
                <!-- <div class="mt-3 md:ml-4 md:mt-0">
                    <a href="#">
                        <img src="/img/avatar.jpg" alt="avatar" class="rounded-full w-8 h-8">
                    </a>
                </div> -->
            </div>
        </div>
    </nav>
    @yield('content')
    <livewire:scripts>
    @yield('scripts')
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
</body>
</html>