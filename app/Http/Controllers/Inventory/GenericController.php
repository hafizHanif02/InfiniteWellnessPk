<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Log;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Inventory\Generic;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Imports\Inventory\GenericImport;
use App\Http\Requests\Inventory\GenericRequest;

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
        $generic = Generic::create($request->validated());
        $user = Auth::user();
        Log::create([
        'action' => 'Generic Formula Has Been Created Generic Formula: '.$generic->formula,
        'action_by_user_id' => $user->id,
        ]);

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
        $user = Auth::user();
        Log::create([
        'action' => 'Generic Formula Has Been Updated Generic Formula: '.$generic->formula.' Code ('.$generic->id .')',
        'action_by_user_id' => $user->id,
        ]);

        return to_route('inventory.generics.index')->with('success', 'Generic updated!');
    }

    public function destroy(Generic $generic): RedirectResponse
    {
        $user = Auth::user();
        Log::create([
        'action' => 'Generic Formula Has Been Deleted Generic Formula: '.$generic->formula. ' Code ('.$generic->id .')',
        'action_by_user_id' => $user->id,
        ]);
        $generic->delete();

        return back()->with('success', 'Generic deleted!');
    }
}
