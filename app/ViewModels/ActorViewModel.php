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
            'profile_path' => isset($this->actor['profile_path']) ?  'https://image.tmdb.org/t/p/w300'. $this->actor['profile_path'] : 'https://via.placeholder.com/300x450',
            'birthday' =>  Carbon::parse($this->actor['birthday'])->format('M d, Y'),
            'age' => Carbon::parse($this->actor['birthday'])->age

        ])->dump();
    }
}
