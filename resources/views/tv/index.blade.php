@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 pt-16">
    <div class="popular-tvshows">
        <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">Popular TV Shows</h2>
        <div class="grid grid-cols-1 sm:grid-cols2 md:grid-cols-3 lg:grid-cols-5 gap-8">
            @foreach($popularTvShows as $tvShow)
            <x-tv-item :tvShow="$tvShow" />
            @endforeach
        </div>
    </div>
</div>
@endsection