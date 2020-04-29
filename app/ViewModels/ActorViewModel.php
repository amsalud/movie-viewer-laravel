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
            'credits' => $this->formatCredits($this->actor['combined_credits']['cast'])
        ])->dump();
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
        return collect($credits)->where('media_type', 'movie')->sortByDesc('popularity')->take(5)
            ->map(function ($movie) {
                return collect($movie)->merge([
                    'poster_path' => $movie['poster_path'] ? 'https://image.tmdb.org/t/p/w185' . $movie['poster_path'] : 'https://via.placeholder.com/185x278',
                    'title' => $movie['title'] ? $movie['title'] : 'Untitled'
                ])->only('title', 'poster_path', 'id');
            });
    }

    private function formatCredits($credits)
    {
        return collect($credits)->map(function ($credit) {
                $title = $this->extractCreditTitle($credit);
                $releaseDate = $this->extractCreditReleaseDate($credit);

                return collect($credit)->merge([
                    'title'=> $title,
                    'release_date' => $releaseDate,
                    'release_year' => isset($releaseDate) ? Carbon::parse($releaseDate)->format('Y') : 'Future',
                    'character' => isset($credit['character']) ? $credit['character'] : ''
                ])->only('title', 'release_year', 'character');
            })->sortByDesc('release_date');
    }

    private function extractCreditTitle($credit){
        $title = '';
        if(isset($credit['title'])){
            return $credit['title'];
        }
        else if($credit['name']){
            return $credit['name'];
        }
        return $title;
    }

    private function extractCreditReleaseDate($credit){
        $releaseDate = '';
        if(isset($credit['release_date'])){
            return $releaseDate = $credit['release_date'];
        }
        else if(isset($credit['first_air_date'])){
            return $releaseDate = $credit['first_air_date'];
        }
        return $releaseDate;
    }
}
