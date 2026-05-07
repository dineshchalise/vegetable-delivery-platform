<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class SettingsForm extends Component
{
    public array $settings = [];

    public function mount(): void
    {
        $this->settings = Setting::pluck('value', 'key')->all();
    }

    public function save(): void
    {
        foreach ($this->settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        session()->flash('status', 'Settings saved.');
    }

    public function render()
    {
        return view('livewire.admin.settings-form')->layout('components.layouts.admin');
    }
}
