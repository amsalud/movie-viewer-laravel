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
            'known_for' => $this->formatKnownFor($this->actor['combined_credits']['cast'])
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

    public function formatKnownFor($credits)
    {
        return collect($credits)->where('media_type', 'movie')->sortByDesc('popularity')->take(5)
            ->map(function ($movie) {
                return collect($movie)->merge([
                    'poster_path' => $movie['poster_path'] ? 'https://image.tmdb.org/t/p/w185' . $movie['poster_path'] : 'https://via.placeholder.com/185x278',
                    'title' => $movie['title'] ? $movie['title'] : 'Untitled'
                ])->only('title', 'poster_path', 'id');
            });
    }
}
