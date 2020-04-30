<div class="tvShow-images" x-data="{ isOpen: false, image: ''}">
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-4xl font-semibold">Images</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @foreach ($images as $image)
            <div class="mt-8">
                <a @click.prevent="
                                    isOpen = true
                                    image='{{ $image }}'
                                " href="#">
                    <img src="{{ $image }}" alt="image1" class="hover:opacity-75 transition ease-in-out duration-150">
                </a>
            </div>
            @endforeach
        </div>
        <x-modal>
            <img :src="image" alt="poster">
        </x-modal>
    </div>
</div>