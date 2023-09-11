<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\VendorRequest;
use App\Imports\Inventory\VendorImport;
use App\Models\Inventory\Manufacturer;
use App\Models\Inventory\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class VendorController extends Controller
{
    public function index(): View
    {
        return view('inventory.vendor.index', [
            'vendors' => Vendor::latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function importExcel(Request $request): RedirectResponse
    {
        $request->validate([
            'vendor_csv' => ['required','file'],
        ]);
        
        Excel::import(new VendorImport, storage_path('app/public/'.request()->file('vendor_csv')->store('vendors-excel-files', 'public')));

        return back()->with('success', 'Imported successfully!');
    }

    public function create(): View
    {
        return view('inventory.vendor.create', [
            'code' => Vendor::latest()->pluck('id')->first(),
            'manufacturers' => Manufacturer::orderBy('company_name')->get(['id', 'company_name']),
        ]);
    }

    public function store(VendorRequest $request): RedirectResponse
    {
        Vendor::create($request->validated());

        return to_route('inventory.vendors.index')->with('success', 'Vendor created!');
    }

    public function show(Vendor $vendor): View
    {
        return view('inventory.vendor.show', [
            'vendor' => $vendor->load('manufacturer'),
        ]);
    }

    public function edit(Vendor $vendor): View
    {
        return view('inventory.vendor.edit', [
            'vendor' => $vendor,
            'manufacturers' => Manufacturer::orderBy('company_name')->get(),
        ]);
    }

    public function update(VendorRequest $request, Vendor $vendor): RedirectResponse
    {
        $vendor->update($request->validated());

        return to_route('inventory.vendors.index')->with('success', 'Vendor updated!');
    }

    public function destroy(Vendor $vendor): RedirectResponse
    {
        $vendor->delete();

        return back()->with('success', 'Vendor deleted!');
    }
}
