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
            'genres' => $this->formatGenres(),
            'crews' => $this->formatCrews()
        ])->dump();
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

}
