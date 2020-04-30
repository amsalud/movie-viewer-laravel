<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class MovieViewModel extends ViewModel
{
    public $movie;

    public function __construct($movie)
    {
        $this->movie = $movie;
    }

    public function movie(){
        return collect($this->movie)->merge([
            'title' => $this->movie['title'] . ' (' . Carbon::parse($this->movie['release_date'])->format('Y') . ')',
            'poster_path' => isset($this->movie['poster_path']) ? 'https://image.tmdb.org/t/p/w500' . $this->movie['poster_path'] : 'https://via.placeholder.com/500x450',
            'vote_average' => $this->movie['vote_average'] * 10 . '%',  
            'release_date' => Carbon::parse($this->movie['release_date'])->format('M d, Y'),
            'trailer' => count($this->movie['videos']['results']) > 0 ? 'https://www.youtube.com/embed/' . ($this->movie['videos']['results'][0]['key']) : null,
            'genres' => collect($this->movie['genres'])->pluck('name')->flatten()->implode(', '),
            'crews' => $this->formatCrews(),
            'casts' => $this->formatCasts(),
            'images' => $this->formatImages()
        ])->only('title', 'poster_path', 'vote_average', 'release_date', 'trailer', 'genres', 'crews', 'casts', 'images', 'overview', 'videos');
    }

    private function formatCrews(){
        return collect($this->movie['credits']['crew'])->map(function($crew){
            return collect($crew)->only(['name', 'job']);
        })->take(2);
    }

    private function formatCasts(){
        return collect($this->movie['credits']['cast'])->map(function($cast){
            return collect($cast)->merge([
                'image' => isset($cast['profile_path']) ? 'https://image.tmdb.org/t/p/w300' . $cast['profile_path'] : 'https://api.adorable.io/avatars/285/abott@adorable.png'
            ])->only(['name', 'character', 'image', 'id']);
        })->take(5);
    }

    private function formatImages(){
        return collect($this->movie['images']['backdrops'])->map(function($image){
            return 'https://image.tmdb.org/t/p/original' . $image['file_path'];
        })->take(9); 
    }

}
