<?php

namespace App\Livewire\Traits;

use Livewire\Attributes\Url;

trait WithSorting
{
    //#[Url]
    //public $sortBy = 'id';
    
    //#[Url]
    //public $sortDirection = 'asc';
 
    protected function queryStringWithSorting()
    {
        return [
            'sortBy' => ['as' => 'sort'],
            'sortDirection' => ['as' => 'direction'],
        ];
    }
}
