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

    /** @test */
    public function the_movie_page_show_the_correct_info(){
        Http::fake([
            'https://api.themoviedb.org/3/movie/' => $this->fakeMovie()
        ]);

        $response = $this->get(route('movies.show', 1234));
        $response->assertSee('Fake Movie');
        $response->assertSee('John Smith');
        $response->assertSee('Fake Casting Director');
        $response->assertSee('Jane Doe');
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

    private function fakeMovie(){
        return Http::response(
            [
                "adult" => false,
                  "backdrop_path" => "/fake.jpg",
                  "belongs_to_collection" => null,
                  "budget" => 0,
                  "genres" => null,
                  "homepage" => "https://fake.com",
                  "id" => 1234,
                  "imdb_id" => "tt1234",
                  "original_language" => "en",
                  "original_title" => "Fake Movie",
                  "overview" => "Lorem Ipsum...",
                  "popularity" => 224.468,
                  "poster_path" => "/fake.jpg",
                  "production_companies" => null,
                  "production_countries" => [],
                  "release_date" => "2020-02-12",
                  "revenue" => 0,
                  "runtime" => 99,
                  "spoken_languages" => [],
                  "status" => "Released",
                  "tagline" => "fake",
                  "title" => "Fake Movie",
                  "video" => false,
                  "vote_average" => 0,
                  "vote_count" => 0,
                  "credits" => [
                      "crew" =>[
                        "credit_id" => "3232",
                        "department" => "None",
                        "gender" => 0,
                        "id" => 1,
                        "job" => "Fake Casting Director",
                        "name" => "John Smith",
                        "profile_path" => null
                      ],
                      "cast" => [
                        "cast_id" => 123,
                        "character" => "none",
                        "credit_id" => "1234",
                        "gender" => 2,
                        "id" => 1234,
                        "name" => "Jane Doe",
                        "order" => 0,
                        "profile_path" => "/fake.jpg"
                      ]
                      ],
                  "videos" => null,
                  "images" => null
                ], 200);
    }
}
