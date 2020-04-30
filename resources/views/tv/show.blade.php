@extends('layouts.main')

@section('content')
<div class="tvshow-info border-b border-gray-800">
    <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
        <img src="{{ $tvShow['poster_path'] }}" alt="{{$tvShow['name']}}" class="w-64 md:w-96">
        <div class="md:ml-24">
            <h2 class="text-4xl font-semibold">{{ $tvShow['name']}}</h2>
            <div class="flex flex-wrap items-center text-gray-400 text-sm">
                <svg class="fill-current text-orange-500 w-4" viewBox="0 0 24 24">
                    <g data-name="Layer 2">
                        <path d="M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z" data-name="star" />
                    </g>
                </svg>
                <span class="ml-1">{{$tvShow['vote_average']}}</span>
                <span class="mx-2">|</span>
                <span>{{ $tvShow['first_air_date'] }}</span>
                <span class="mx-2">|</span>
                <span>{{$tvShow['genres']}}</span>
            </div>

            <p class="text-gray-300 mt-8">
                {{$tvShow['overview']}}
            </p>

            @if(count($tvShow['creators']) > 0)
            <div class="mt-12">
                <div class="flex mt-4">
                    @foreach($tvShow['creators'] as $creator)
                    <div class="mr-8">
                        <div>{{ $creator }}</div>
                        <div class="text-sm text-gray-400">Creator</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            <div x-data="{ isOpen: false}">
                @if(isset($tvShow['trailer']))
                <div class="mt-12">
                    <button @click="isOpen = true" class="flex inline-flex items-center bg-orange-500 text-gray-900 rounded font-semibold px-5 py-4 hover:bg-orange-600 transition ease-in-out duration-150">
                        <svg class="w-6 fill-current" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 16.5l6-4.5-6-4.5v9zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" /></svg>
                        <span class="ml-2">Play Trailer</span>
                    </button>
                </div>
                <x-modal>
                    <div class="responsive-container overflow-hidden relative" style="padding-top: 56.25%">
                        <iframe class="responsive-iframe absolute top-0 left-0 w-full h-full" src="{{ $tvShow['trailer']}}" style="border:0;" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                </x-modal>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="tvShow-cast border-b border-gray-800" x-data="{ isOpen: false, image: ''}">
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-4xl font-seminold">Cast</h2>
        <div class="grid grid-cols-1 sm:grid-cols2 md:grid-cols-3 lg:grid-cols-5 gap-8">
            @foreach($tvShow['casts'] as $cast)
            <div class="mt-8">
                <a href="{{ route('actors.show', $cast['id']) }}">
                    <img src="{{ $cast['image'] }}" alt="{{$cast['name']}}" class="hover:opacity-75 transition-ease-in-out duration-150">
                </a>
                <div class="mt-2">
                    <a href="{{ route('actors.show', $cast['id']) }}" class="text-lg mt-2 hover:text-gray:300">{{$cast['name']}}</a>
                    <div class="text-sm text-gray-400">{{$cast['character']}}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@if(count($tvShow['images']) > 0)
    <x-image-gallery :images="$tvShow['images']"></x-image-gallery>
@endif
@endsection