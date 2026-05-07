<?php

namespace App\Livewire\Admin;

use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class StaffManager extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'staff';

    public function add(): void
    {
        abort_unless(Auth::guard('staff')->user()?->role === 'admin', 403);

        $data = $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'unique:staff,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,staff'],
        ]);

        $data['password'] = Hash::make($data['password']);
        Staff::create($data);
        $this->reset('name', 'email', 'password');
    }

    public function render()
    {
        return view('livewire.admin.staff-manager', [
            'staff' => Staff::latest()->get(),
        ])->layout('components.layouts.admin');
    }
}
