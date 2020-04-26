<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ViewMoviesTest extends TestCase
{

    /** @test */    
    public function the_main_page_shows_correct_info()
    {
        Http::fake([
            'https://api.themoviedb.org/3/movie/popular' => $this->fakePopularMovies(),
            'https://api.themoviedb.org/3/movie/now_playing' => $this->fakeNowPlayingMovies(),
            'https://api.themoviedb.org/3/genre/movie/list' => $this->fakeGenres()
        ]);

        $response = $this->get(route('movies.index'));

        $response->assertSuccessful();
        $response->assertSee('Popular Movies');
        $response->assertSee('Fake Popular Movie');

        $response->assertSee('Now Playing');
        $response->assertSee('Fake Now Playing Movie');

        $response->assertSee('Fake, Fake2');
    }

    private function fakePopularMovies(){
        return Http::response([
            'results' => [
                [
                    "popularity" => 0,
                    "vote_count" => 0,
                    "video" => false,
                    "poster_path" => "/fake.jpg",
                    "id" => 1,
                    "adult" => false,
                    "backdrop_path" => "/fake.jpg",
                    "original_language" => "en",
                    "original_title" => "Fake",
                    "genre_ids" => [1,2],
                    "title" => "Fake Popular Movie",
                    "vote_average" => 1,
                    "overview" => "Lorem Ipsum...",
                    "release_date" => "2019-09-17"
                  ]
                ]
         ], 200);
    }

    private function fakeNowPlayingMovies(){
        return Http::response([
            'results' => [
                [
                    "popularity" => 0,
                    "vote_count" => 0,
                    "video" => false,
                    "poster_path" => "/fake.jpg",
                    "id" => 1,
                    "adult" => false,
                    "backdrop_path" => "/fake.jpg",
                    "original_language" => "en",
                    "original_title" => "Fake",
                    "genre_ids" => [1,2],
                    "title" => "Fake Now Playing Movie",
                    "vote_average" => 1,
                    "overview" => "Lorem Ipsum...",
                    "release_date" => "2019-09-17"
                  ]
                ]
         ], 200);
    }

    private function fakeGenres(){
        return Http::response([
            'genres' => [
                [
                    "id" => 1,
                    "name" => 'Fake'
                ],
                [
                    "id" => 2,
                    "name" => 'Fake2'
                ]
            ]
        ], 200);
    }
}
