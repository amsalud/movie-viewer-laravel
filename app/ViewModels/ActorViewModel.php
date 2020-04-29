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

    public function actor(){
        return collect($this->actor)->merge([
            'profile_path' => 'https://image.tmdb.org/t/p/w150_and_h225_bestv2'. $this->actor['profile_path'],
            'birthday' =>  Carbon::parse($this->actor['birthday'])->format('M d, Y'),
            'age' => Carbon::parse($this->actor['birthday'])->age

        ])->dump();
    }
}
