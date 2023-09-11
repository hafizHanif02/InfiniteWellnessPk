<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\ManufacturerRequest;
use App\Imports\Inventory\ManufacturerImport;
use App\Models\Inventory\Manufacturer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ManufacturerController extends Controller
{
    public function index(): View
    {
        return view('inventory.manufacturers.index', [
            'manufacturers' => Manufacturer::latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'manufacturer_csv' => ['required','file'],
        ]);

        Excel::import(new ManufacturerImport, storage_path('app/public/'.request()->file('manufacturer_csv')->store('manufacturer-excel-files', 'public')));

        return back()->with('success', 'Imported successfully!');
    }

    public function create(): View
    {
        return view('inventory.manufacturers.create', [
            'manucode' => Manufacturer::latest()->pluck('id')->first(),
        ]);
    }

    public function store(ManufacturerRequest $request): RedirectResponse
    {
        Manufacturer::create($request->validated());

        return to_route('inventory.manufacturers.index')->with('success', 'Manufacturer created!');
    }


    public function edit(Manufacturer $manufacturer): View
    {
        return view('inventory.manufacturers.edit', [
            'manufacturer' => $manufacturer,
        ]);
    }

    public function update(ManufacturerRequest $request, Manufacturer $manufacturer): RedirectResponse
    {
        $manufacturer->update($request->validated());

        return to_route('inventory.manufacturers.index')->with('success', 'Manufacturer updated!');
    }

    public function destroy(Manufacturer $manufacturer): RedirectResponse
    {
        $manufacturer->delete();

        return back()->with('success', 'Manufacturer deleted!');
    }
}
