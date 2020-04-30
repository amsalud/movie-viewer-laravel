<div class="casts border-b border-gray-800" x-data="{ isOpen: false, image: ''}">
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-4xl font-seminold">Cast</h2>
        <div class="grid grid-cols-1 sm:grid-cols2 md:grid-cols-3 lg:grid-cols-5 gap-8">
            @foreach($casts as $cast)
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