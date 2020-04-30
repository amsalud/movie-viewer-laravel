<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class ActorViewModel extends ViewModel
{
    public $actor;

    public function __construct($actor)
    {
        $this->actor = $actor;
    }

    public function actor()
    {
        return collect($this->actor)->merge([
            'profile_path' => isset($this->actor['profile_path']) ?  'https://image.tmdb.org/t/p/w300' . $this->actor['profile_path'] : 'https://via.placeholder.com/300x450',
            'birthday' =>  Carbon::parse($this->actor['birthday'])->format('M d, Y'),
            'age' => Carbon::parse($this->actor['birthday'])->age,
            'social_media_links' => $this->formatSocialMediaLinks($this->actor['external_ids']),
            'known_for' => $this->formatKnownFor($this->actor['combined_credits']['cast']),
            'credits' => $this->formatCredits($this->actor['combined_credits']['cast']),
        ])->only('profile_path', 'birthday', 'age', 'biography', 'social_media_links', 'known_for', 'credits', 'homepage', 'name', 'place_of_birth');
    }

    private function formatSocialMediaLinks($links)
    {
        return collect($links)->merge([
            'facebook' => isset($links['facebook_id']) ? 'https://www.facebook.com/' . $links['facebook_id'] : null,
            'instagram' => isset($links['instagram_id']) ? 'https://www.instagram.com/' . $links['instagram_id'] : null,
            'twitter' => isset($links['twitter_id']) ? 'https://twitter.com/' . $links['twitter_id'] : null,
        ])->only('facebook', 'instagram', 'twitter');
    }

    private function formatKnownFor($credits)
    {
        return collect($credits)->sortByDesc('popularity')->take(5)
            ->map(function ($credit) {
                $title = $this->extractTitle($credit);
                return collect($credit)->merge([
                    'poster_path' => $credit['poster_path'] ? 'https://image.tmdb.org/t/p/w185' . $credit['poster_path'] : 'https://via.placeholder.com/185x278',
                    'title' => $title,
                    'route_name' => $this->getRouteName($credit)
                ])->only('title', 'poster_path', 'id', 'route_name');
            });
    }

    private function formatCredits($credits)
    {
        return collect($credits)->map(function ($credit) {
                $title = $this->extractTitle($credit);
                $releaseDate = $this->extractReleaseDate($credit);

                return collect($credit)->merge([
                    'title'=> $title,
                    'release_year' => isset($releaseDate) && !empty($releaseDate) ? Carbon::parse($releaseDate)->format('Y') : 'Future',
                    'character' => isset($credit['character']) ? $credit['character'] : '',
                    'release_date' => $releaseDate
                ])->only('title', 'release_year', 'character', 'release_date', 'media_type');
            })->sortByDesc('release_date');
    }

    private function extractTitle($credit){
        $title = 'Untitled';
        if(isset($credit['title'])){
            return $credit['title'];
        }
        else if($credit['name']){
            return $credit['name'];
        }
        return $title;
    }

    private function extractReleaseDate($credit){
        $releaseDate = '';
        if(isset($credit['release_date'])){
            return $credit['release_date'];
        }
        else if(isset($credit['first_air_date'])){
            return $credit['first_air_date'];
        }
        return $releaseDate;
    }

    private function getRouteName($credit){
        if($credit['media_type'] == 'movie'){
            return 'movies.show';
        }
        else if($credit['media_type'] == 'tv'){
            return 'tv.show';
        }
    }
}
