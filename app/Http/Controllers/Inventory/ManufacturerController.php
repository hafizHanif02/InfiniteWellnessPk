<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Log;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Models\Inventory\Manufacturer;
use App\Imports\Inventory\ManufacturerImport;
use App\Http\Requests\Inventory\ManufacturerRequest;

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
        $manufacturer = Manufacturer::create($request->validated());

        $user = Auth::user();
        Log::create([
            'action' => 'Manufacturer Has Been Created Company Name: '.$request->company_name.' Code ('.$manufacturer->id.')',
            'action_by_user_id' => $user->id,
        ]);

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
        $user = Auth::user();
        Log::create([
            'action' => 'Manufacturer Has Been Edited Company Name: '.$manufacturer->company_name.' Code ('.$manufacturer->id.')',
            'action_by_user_id' => $user->id,
        ]);

        return to_route('inventory.manufacturers.index')->with('success', 'Manufacturer updated!');
    }

    public function destroy(Manufacturer $manufacturer): RedirectResponse
    {
        $user = Auth::user();
        Log::create([
            'action' => 'Manufacturer Has Been Deleted Company Name: '.$manufacturer->company_name.' Code ('.$manufacturer->id.')',
            'action_by_user_id' => $user->id,
        ]);
        $manufacturer->delete();

        return back()->with('success', 'Manufacturer deleted!');
    }
}
