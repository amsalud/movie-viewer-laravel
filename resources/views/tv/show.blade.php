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
            @if(isset($tvShow['trailer']))
                <x-trailer-link :trailer="$tvShow['trailer']"></x-trailer-link>
            @endif
        </div>
    </div>
</div>

@if(count($tvShow['casts']) > 0)
    <x-cast-info :casts="$tvShow['casts']"/>
@endif

@if(count($tvShow['images']) > 0)
    <x-image-gallery :images="$tvShow['images']"></x-image-gallery>
@endif
@endsection