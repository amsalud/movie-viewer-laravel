@extends('layouts.main')

@section('content')
<div class="movie-info border-b border-gray-800">
    <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
        <img src="{{ $movie['poster_path'] }}" alt="{{$movie['title']}}" class="w-64 md:w-96">
        <div class="md:ml-24">
            <h2 class="text-4xl font-semibold">{{ $movie['title']}}</h2>
            <div class="flex flex-wrap items-center text-gray-400 text-sm">
                <svg class="fill-current text-orange-500 w-4" viewBox="0 0 24 24">
                    <g data-name="Layer 2">
                        <path d="M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z" data-name="star" />
                    </g>
                </svg>
                <span class="ml-1">{{$movie['vote_average']}}</span>
                <span class="mx-2">|</span>
                <span>{{ $movie['release_date'] }}</span>
                <span class="mx-2">|</span>
                <span>{{$movie['genres']}}</span>
            </div>
            <p class="text-gray-300 mt-8">
                {{$movie['overview']}}
            </p>
            <div class="mt-12">
                <h4 class="text-white font-semibold">Featured Crew</h4>
                <div class="flex mt-4">
                    @foreach($movie['crews'] as $crew)
                    <div class="mr-8">
                        <div>{{ $crew['name'] }}</div>
                        <div class="text-sm text-gray-400">{{$crew['job']}}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @if(isset($movie['trailer']) && !empty($movie['trailer']))
                <x-trailer-link :trailer="$movie['trailer']"></x-trailer-link>
            @endif
        </div>
    </div>
</div>
@if(count($movie['casts']) > 0)
    <x-cast-info :casts="$movie['casts']"/>
@endif
@if(count($movie['images']) > 0)
    <x-image-gallery :images="$movie['images']" />
@endif
@endsection