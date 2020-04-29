@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 pt-16">
    <div class="popular-actors">
        <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">Popular Actors</h2>
        <div class="grid grid-cols-1 sm:grid-cols2 md:grid-cols-3 lg:grid-cols-5 gap-8">
            <div class="actor mt-8">
                <a href="#">
                    <img src="/img/actor1.jpg" alt="" alt="profile image" class="hover:opacity-75 transition ease-in-out duration-150"/>
                </a>
                <div class="mt-2">
                    <a href="" class="text-lg hover:text-gray-300">Robert Downey Jr.</a>
                    <div class="text-sm truncate text-gray-400">Iron Man, Avengers, Avengers: Infinity War</div>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection