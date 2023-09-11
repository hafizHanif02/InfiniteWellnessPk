<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\GenericRequest;
use App\Imports\Inventory\GenericImport;
use App\Models\Inventory\Generic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class GenericController extends Controller
{
    public function index(): View
    {
        return view('inventory.generic.index', [
            'generics' => Generic::latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'generic_csv' => ['required','file'],
        ]);

        Excel::import(new GenericImport, storage_path('app/public/'.request()->file('generic_csv')->store('generics-excel-files', 'public')));

        return back()->with('success', 'Imported successfully!');
    }

    public function create(): View
    {
        return view('inventory.generic.create', [
            'code' => Generic::latest()->pluck('id')->first(),
        ]);
    }

    public function store(GenericRequest $request): RedirectResponse
    {
        Generic::create($request->validated());

        return to_route('inventory.generics.index')->with('success', 'Generic created!');
    }

    public function edit(Generic $generic): View
    {
        return view('inventory.generic.edit', [
            'generic' => $generic,
        ]);
    }

    public function update(GenericRequest $request, Generic $generic): RedirectResponse
    {
        $generic->update($request->validated());

        return to_route('inventory.generics.index')->with('success', 'Generic updated!');
    }

    public function destroy(Generic $generic): RedirectResponse
    {
        $generic->delete();

        return back()->with('success', 'Generic deleted!');
    }
}
