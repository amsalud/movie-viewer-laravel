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
                'route_name' => $this->getRouteName($searchResult)
            ]);
        })->take(10)->dump();
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
}
