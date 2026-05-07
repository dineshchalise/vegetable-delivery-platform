<?php

namespace App\Livewire\Admin;

use App\Models\Hub;
use Livewire\Component;

class HubManager extends Component
{
    public function toggle(Hub $hub): void
    {
        $hub->update(['is_active' => ! $hub->is_active]);
    }

    public function render()
    {
        return view('livewire.admin.hub-manager', [
            'hubs' => Hub::latest()->get(),
        ])->layout('components.layouts.admin');
    }
}
