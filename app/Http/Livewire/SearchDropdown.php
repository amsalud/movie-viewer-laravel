<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class SearchDropdown extends Component
{
    public $search = '';

    public function render()
    {
        $searchResults = [];

        if(strlen($this->search) > 2){
            $searchResults = Http::withToken(config('services.tmdb.token'))->get('https://api.themoviedb.org/3/search/multi?query='. $this->search)->json()['results'];
        }

        return view('livewire.search-dropdown', ['searchResults' => $this->formatSearchResults($searchResults)]);
    }

    private function formatSearchResults($searchResults){
        return collect($searchResults)->map(function($searchResult){
            return collect($searchResult)->merge([
                'title' => $this->getTitle($searchResult),
                'route_name' => $this->getRouteName($searchResult),
                'image' => $this->getImageLink($searchResult),
            ]);
        })->take(10)->dump();
    }

    private function getTitle($searchResult){
        if($searchResult['media_type'] === 'movie'){
            return isset($searchResult['title']) ? $searchResult['title'] : 'Untitled';
        }
        else if($searchResult['media_type'] === 'tv' || $searchResult['media_type'] === 'person'){
            return isset($searchResult['name']) ? $searchResult['name'] : 'Untitled';
        }
    }

    private function getRouteName($searchResult){
        if($searchResult['media_type'] === 'movie'){
            return 'movies.show';
        }
        else if($searchResult['media_type'] === 'tv'){
            return 'tv.show';
        }
        else if($searchResult['media_type'] === 'person'){
            return 'actors.show';
        }
    }

    private function getImageLink($searchResult){
        if($searchResult['media_type'] === 'movie' || $searchResult['media_type'] === 'tv'){
            return isset($searchResult['poster_path']) ? 'https://image.tmdb.org/t/p/w92' . $searchResult['poster_path'] : 'https://via.placeholder.com/50x75';
        }
        else if($searchResult['media_type'] === 'person'){
            return isset($searchResult['profile_path']) ? 'https://image.tmdb.org/t/p/w92' . $searchResult['profile_path'] : 'https://via.placeholder.com/50x75';
        }
    }
}
