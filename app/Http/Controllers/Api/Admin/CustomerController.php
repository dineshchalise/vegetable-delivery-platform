<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query()
            ->when($request->query('search'), function ($query, $search) {
                $query->where('mobile', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            })
            ->when($request->has('is_blocked'), fn ($query) => $query->where('is_blocked', $request->boolean('is_blocked')));

        if ($request->query('export') === 'csv') {
            return response()->streamDownload(function () use ($query) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['name', 'mobile', 'address', 'is_blocked', 'created_at']);
                $query->orderBy('name')->each(function (Customer $customer) use ($handle) {
                    fputcsv($handle, [$customer->name, $customer->mobile, $customer->address, $customer->is_blocked ? 'yes' : 'no', $customer->created_at]);
                });
                fclose($handle);
            }, 'customers.csv');
        }

        return $query->latest()->paginate(25);
    }

    public function block(Request $request, Customer $customer)
    {
        $data = $request->validate(['is_blocked' => ['required', 'boolean']]);
        $customer->update($data);

        return $customer->refresh();
    }
}
