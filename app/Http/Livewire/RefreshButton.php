<?php

namespace App\Http\Livewire;

use Artisan;
use App\Models\School;
use Livewire\Component;

class RefreshButton extends Component
{
    public function refresh()
    {
        Artisan::call('import:schools', [
            '--truncate' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.refresh-button', [
            'count' => School::count(),
        ]);
    }
}
