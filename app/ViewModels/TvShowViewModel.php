<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class TvShowViewModel extends ViewModel
{
    public $tvShow;

    public function __construct($tvShow)
    {
        $this->tvShow = $tvShow;
    }

    public function tvShow(){
        return collect($this->tvShow)->merge([
            'name' => $this->tvShow['name'] . ' (' . Carbon::parse($this->tvShow['first_air_date'])->format('Y') . ')',
            'poster_path' => 'https://image.tmdb.org/t/p/w500' . $this->tvShow['poster_path'],
            'vote_average' => $this->tvShow['vote_average'] * 10 . '%',  
            'first_air_date' => Carbon::parse($this->tvShow['first_air_date'])->format('M d, Y'),
            'trailer' => count($this->tvShow['videos']['results']) > 0 ? 'https://www.youtube.com/embed/' . ($this->tvShow['videos']['results'][0]['id']) : null,
            'genres' => collect($this->tvShow['genres'])->pluck('name')->flatten()->implode(', '),
            'crews' => $this->formatCrews(),
            'casts' => $this->formatCasts(),
            'images' => $this->formatImages(),
            'creators' => collect($this->tvShow['created_by'])->pluck('name')->take(2)
        ])->only('name', 'poster_path', 'vote_average', 'first_air_date', 'trailer', 'genres', 'crews', 'casts', 'images', 'overview', 'creators');
    }

    private function formatCrews(){
        return collect($this->tvShow['credits']['crew'])->map(function($crew){
            return collect($crew)->only(['name', 'job']);
        })->take(2);
    }

    private function formatCasts(){
        return collect($this->tvShow['credits']['cast'])->map(function($cast){
            return collect($cast)->merge([
                'image' => isset($cast['profile_path']) ? 'https://image.tmdb.org/t/p/w300' . $cast['profile_path'] : 'https://api.adorable.io/avatars/285/abott@adorable.png'
            ])->only(['name', 'character', 'image', 'id']);
        })->take(5);
    }

    private function formatImages(){
        return collect($this->tvShow['images']['backdrops'])->map(function($image){
            return 'https://image.tmdb.org/t/p/original' . $image['file_path'];
        })->take(9); 
    }
}
