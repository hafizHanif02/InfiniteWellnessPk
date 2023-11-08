<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Log;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Inventory\Vendor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Models\Inventory\Manufacturer;
use App\Imports\Inventory\VendorImport;
use App\Http\Requests\Inventory\VendorRequest;

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
        $vendor = Vendor::create($request->validated());
        $user = Auth::user();
        Log::create([
            'action' => 'Vendor Has Been Created Vendor Account Title:'.$request->account_title. ' Code ('.$vendor->id.')' ,
            'action_by_user_id' => $user->id,
        ]);

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
        $user = Auth::user();
        Log::create([
            'action' => 'Vendor Has Been Updated Vendor Account Title:'.$vendor->account_title. ' Code ('.$vendor->id.')' ,
            'action_by_user_id' => $user->id,
        ]);

        return to_route('inventory.vendors.index')->with('success', 'Vendor updated!');
    }

    public function destroy(Vendor $vendor): RedirectResponse
    {
        $user = Auth::user();
        Log::create([
            'action' => 'Vendor Has Been Deleted Vendor Account Title:'.$vendor->account_title. ' Code ('.$vendor->id.')' ,
            'action_by_user_id' => $user->id,
        ]);
        $vendor->delete();

        return back()->with('success', 'Vendor deleted!');
    }
}
