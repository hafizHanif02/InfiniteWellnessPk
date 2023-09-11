<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Inventory\Dosage;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Imports\Inventory\DosageImport;
use App\Http\Requests\Inventory\DosageRequest;

class DosageController extends Controller
{
    public function index(): View
    {
        return view('inventory.dosages.index', [
            'dosages' => Dosage::latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'dosages_csv' => ['required','file'],
        ]);

        Excel::import(new DosageImport, storage_path('app/public/'.request()->file('dosages_csv')->store('dosages-excel-files', 'public')));

        return back()->with('success', 'Imported successfully!');
    }

    public function create(): View
    {
        return view('inventory.dosages.create', [
            'dosage_id' => Dosage::latest()->pluck('id')->first(),
        ]);
    }

    public function store(DosageRequest $request): RedirectResponse
    {
        Dosage::create($request->validated());

        return to_route('inventory.dosages.index')->with('success', 'Dosage created!');
    }

    public function edit(Dosage $dosage): View
    {
        return view('inventory.dosages.edit', [
            'dosage' => $dosage,
        ]);
    }

    public function update(DosageRequest $request, Dosage $dosage): RedirectResponse
    {
        $dosage->update($request->validated());

        return to_route('inventory.dosages.index')->with('success', 'Dosage updated!');
    }

    public function destroy(Dosage $dosage): RedirectResponse
    {
        $dosage->delete();

        return back()->with('success', 'Dosage deleted!');
    }
}
