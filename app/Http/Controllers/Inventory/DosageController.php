<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Log;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Inventory\Dosage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        
        $dosage = Dosage::create($request->validated());
        $user = Auth::user();
        Log::create([
        'action' => 'Dosage Form Has Been Created Dosage Form Name:'.$request->name.' Code ('.$request->code .')',
        'action_by_user_id' => $user->id,
    ]);


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
        $user = Auth::user();
        Log::create([
        'action' => 'Dosage Form Has Been Updated Dosage Form Name:'.$dosage->name.' Code ('.$dosage->id .')',
        'action_by_user_id' => $user->id,
        ]);

        return to_route('inventory.dosages.index')->with('success', 'Dosage updated!');
    }

    public function destroy(Dosage $dosage): RedirectResponse
    {
        $user = Auth::user();
        Log::create([
        'action' => 'Dosage Form Has Been Deleted Dosage Form Name:'.$dosage->name.' Code ('.$dosage->id .')',
        'action_by_user_id' => $user->id,
        ]);
        $dosage->delete();

        return back()->with('success', 'Dosage deleted!');
    }
}
