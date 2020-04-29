@extends('layouts.main')

@section('content')
<div class="movie-info border-b border-gray-800">
    <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
        <img src="/img/actor1.jpg" alt="profile image" class="w-64 md:w-96">
        <div class="md:ml-24">
            <h2 class="text-4xl font-semibold">Will Smith</h2>
            <div class="flex flex-wrap items-center text-gray-400 text-sm">
                <svg class="fill-current text-orange-500 w-4" viewBox="0 0 24 24">
                    <g data-name="Layer 2">
                        <path d="M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z" data-name="star" />
                    </g>
                </svg>
                <span class="ml-1">Info</span>
                <span class="mx-2">|</span>
                <span>Info</span>
            </div>

            <p class="text-gray-300 mt-8">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nulla fugiat neque aliquid minima. Aliquam odio corrupti incidunt dolore reprehenderit, in nemo ut velit error, sint modi. Illo aut autem natus!
            </p>
        </div>
    </div>
</div>
<div class="credits border-b border-gray-800" x-data="{ isOpen: false, image: ''}">
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-4xl font-seminold">Credits</h2>
    </div>
</div>
@endsection