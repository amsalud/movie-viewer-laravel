<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class MoviesViewModel extends ViewModel
{
    private $popularMovies;
    private $nowPlayingMovies;
    private $genres;

    public function __construct($popularMovies, $nowPlayingMovies, $genres)
    {
        $this->popularMovies = $popularMovies;
        $this->nowPlayingMovies = $nowPlayingMovies;
        $this->genres = $genres;
    }

    public function getPopularMovies(){
        return $this->popularMovies;
    }

    public function getNowPlayingMovies(){
        return $this->nowPlayingMovies;
    }

    public function getGenres(){
        return $this->genres;
    }
}
