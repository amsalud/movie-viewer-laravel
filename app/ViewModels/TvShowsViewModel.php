<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class TvShowsViewModel extends ViewModel
{
    public $popularTvShows;
    public $topRatedTvShows;
    public $genres;

    public function __construct($popularTvShows, $topRatedTvShows, $genres)
    {
        $this->popularTvShows = $popularTvShows;
        $this->topRatedTvShows = $topRatedTvShows;
        $this->genres = $genres;
    }

    public function popularTvShows(){
        return $this->formatTvShowsData($this->popularTvShows);
    }

    public function topRatedTvShows(){
        return $this->formatTvShowsData($this->topRatedTvShows);
    }
    private function formatTvShowsData($tvShows){
        return collect($tvShows)->map(function($tvShow){
            return collect($tvShow)->merge([
                'poster_path' => 'https://image.tmdb.org/t/p/w500' . $tvShow['poster_path'],
                'vote_average' => $tvShow['vote_average'] * 10 . '%',  
                'first_air_date' => Carbon::parse($tvShow['first_air_date'])->format('M d, Y'),
                'genres' => $this->formatGenres($tvShow)
            ])->only(['poster_path', 'id', 'name', 'vote_average', 'overview', 'first_air_date', 'genres']);
        });
    }

    private function formatGenres($tvShow){
        return collect($tvShow['genre_ids'])->mapWithKeys(function($value){
            return [$value => $this->genres()->get($value)];
        })->implode(', ');
    }

    public function genres(){
        return collect($this->genres)->mapWithKeys(function($genre){
            return [ $genre['id'] => $genre['name']];
        });
    }
}
