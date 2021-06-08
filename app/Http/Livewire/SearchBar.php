<?php

namespace App\Http\Livewire;

use App\Models\School;
use Livewire\Component;

class SearchBar extends Component
{
    public $search;

    protected $rules = [
        'search' => ['required', 'string', 'max:255']
    ];

    public function lookup()
    {
        $this->validate();

        $schools = School::where('name', 'LIKE', "%{$this->search}%")->get();

        dd([
            'results'   => $schools->count(),
            'retrieved' => $schools->pluck('name')->toArray(),
        ]);
    }

    public function render()
    {
        return view('livewire.search-bar');
    }
}
