<?php

namespace App\Livewire\Admin;

use App\Models\Hub;
use Livewire\Component;

class HubManager extends Component
{
    public ?int $editingId = null;
    public string $name = '';
    public string $photo_url = '';
    public string $address = '';
    public string $contact_number = '';
    public string $pickup_timings = '';
    public bool $is_active = true;

    public function save(): void
    {
        $data = $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'photo_url' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'contact_number' => ['required', 'string', 'max:30'],
            'pickup_timings' => ['required', 'string', 'max:120'],
            'is_active' => ['boolean'],
        ]);

        Hub::updateOrCreate(['id' => $this->editingId], $data);
        $this->resetForm();
        session()->flash('status', 'Hub saved.');
    }

    public function edit(Hub $hub): void
    {
        $this->editingId = $hub->id;
        $this->name = $hub->name;
        $this->photo_url = (string) $hub->photo_url;
        $this->address = $hub->address;
        $this->contact_number = $hub->contact_number;
        $this->pickup_timings = $hub->pickup_timings;
        $this->is_active = $hub->is_active;
    }

    public function delete(Hub $hub): void
    {
        $hub->delete();
        session()->flash('status', 'Hub deleted.');
    }

    public function toggle(Hub $hub): void
    {
        $hub->update(['is_active' => ! $hub->is_active]);
    }

    public function resetForm(): void
    {
        $this->editingId = null;
        $this->name = '';
        $this->photo_url = '';
        $this->address = '';
        $this->contact_number = '';
        $this->pickup_timings = '';
        $this->is_active = true;
    }

    public function render()
    {
        return view('livewire.admin.hub-manager', [
            'hubs' => Hub::latest()->get(),
        ])->layout('components.layouts.admin');
    }
}
