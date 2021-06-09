<?php

namespace App\Http\Livewire;

use App\Models\School;
use Livewire\Component;

class SearchContext extends Component
{
    public $search;
    public $schools;

    protected $rules = [
        'search' => ['required', 'string', 'max:255']
    ];

    public function lookup()
    {
        $this->validate();

        $this->results = app('schools')->search($this->search);
    }

    public function render()
    {
        return view('livewire.search-context');
    }
}
