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
            'poster_path' => 'https://image.tmdb.org/t/p/w500' . $this->movie['poster_path'],
            'vote_average' => $this->movie['vote_average'] * 10 . '%',  
            'release_date' => Carbon::parse($this->movie['release_date'])->format('M d, Y'),
            'trailer' => count($this->movie['videos']['results']) > 0 ? 'https://www.youtube.com/embed/' . ($this->movie['videos']['results'][0]['id']) : null,
            'genres' => $this->formatGenres(),
            'crews' => $this->formatCrews(),
            'casts' => $this->formatCasts(),
            'images' => $this->formatImages()
        ])->only('title', 'poster_path', 'vote_average', 'release_date', 'trailer', 'genres', 'crews', 'casts', 'images', 'overview');
    }

    private function formatGenres(){
        return collect($this->movie['genres'])->map(function($genre){
            return $genre['name'];
        })->implode(', ');
    }

    private function formatCrews(){
        return collect($this->movie['credits']['crew'])->map(function($crew){
            return collect($crew)->only(['name', 'job']);
        })->slice(0, 2);
    }

    private function formatCasts(){
        return collect($this->movie['credits']['cast'])->map(function($cast){
            return collect($cast)->merge([
                'image' => isset($cast['profile_path']) ? 'https://image.tmdb.org/t/p/w300' . $cast['profile_path'] : 'https://api.adorable.io/avatars/285/abott@adorable.png'
            ])->only(['name', 'character', 'image']);
        })->slice(0, 5);
    }

    private function formatImages(){
        return collect($this->movie['images']['backdrops'])->map(function($image){
            return 'https://image.tmdb.org/t/p/w300' . $image['file_path'];
        })->slice(0, 6); 
    }

}
