<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Inventory\Vendor;
use Illuminate\Http\JsonResponse;
use App\Models\Purchase\Requistion;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Purchase\GoodReceiveNote;

use App\Models\Purchase\RequistionProduct;
use App\Models\Purchase\GoodReceiveProduct;
use App\Http\Requests\Purchase\GoodReceiveNoteRequest;

class GoodReceiveNoteController extends Controller
{
    public function index(): View
    {
        return view('purchase.goodreceivenote.index', [
            'goodReceiveNotes' => GoodReceiveNote::with('requistion.vendor')->latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function create(): View
    {
        return view('purchase.goodreceivenote.create', [
            'id' => GoodReceiveNote::latest()->pluck('id')->first(),
            'vendors' => Vendor::orderBy('account_title')->get(['id', 'account_title']),
        ]);
    }

    public function getRequisitions($vendorId): JsonResponse
    {
        return response()->json([
            'requistions' => Requistion::where(['vendor_id' => $vendorId, 'is_approved' => 1])->get(),
        ]);
    }

    public function getRequisitionProducts($requistionId): JsonResponse
    {
        return response()->json([
            'requistionProducts' => RequistionProduct::where('requistion_id', $requistionId)->with('product')->get(),
        ]);
    }

    public function store(GoodReceiveNoteRequest $request): RedirectResponse
    {
        $goodReceiveNote = GoodReceiveNote::create([
            'invoice_number' => $request->invoice_number,
            'requistion_id' => $request->requistion_id,
            'remark' => $request->remark,
            'date' => $request->date,
            'bonus' => $request->bonus,
            'total_amount' => $request->total_amount,
            'total_discount_amount' => $request->total_discount_amount,
            'net_total_amount' => $request->net_total_amount,
            'advance_tax_percentage' => $request->advance_tax_percentage,
            'advance_tax_amount' => $request->advance_tax_amount,
            'sale_tax_percentage' => $request->sale_tax_percentage,
        ]);
        foreach ($request->products as $product) {
            GoodReceiveProduct::create([
                'good_receive_note_id' => $goodReceiveNote->id,
                'product_id' => $product['id'],
                'deliver_qty' => $product['deliver_qty'],
                'bonus' => $product['bonus'] ?? null,
                'expiry_date' => $product['expiry_date'],
                'item_amount' => $product['totalprice2'],
                'batch_number' => $product['batch_no'],
                'discount' => $product['discount'],
                'saletax_percentage' => $product['saletax_percentage'],
                'saletax_amount' => $product['saletax_amount'],
            ]);
        }

        return to_route('purchase.good_receive_note.index')->with('success', 'GRN created!');
    }

    public function show(GoodReceiveNote $goodReceiveNote): View
    {
        return view('purchase.goodreceivenote.show', [
            'goodReceiveNote' => $goodReceiveNote->load(['goodReceiveProducts.product','requistion.vendor']),
        ]);
    }

    public function edit($goodReceiveNote): View
    {
        return view('purchase.goodreceivenote.edit', [
            'goodReceiveNote' => GoodReceiveNote::where('id',$goodReceiveNote)->with(['goodReceiveProducts.product','goodReceiveProducts.requistionProduct'])->first(),
            'vendors' => Vendor::orderBy('contact_person')->get(),
        ]);
    }

    public function update(GoodReceiveNoteRequest $request, GoodReceiveNote $goodReceiveNote): RedirectResponse
    {

        $goodReceiveNote->update([
            'invoice_number' => $request->invoice_number,
            'remark' => $request->remark,
            'date' => $request->date,
            'bonus' => $request->bonus,
            'total_amount' => $request->total_amount,
            'total_discount_amount' => $request->total_discount_amount,
            'net_total_amount' => $request->net_total_amount,
            'advance_tax_percentage' => $request->advance_tax_percentage,
            'sale_tax_percentage' => $request->sale_tax_percentage,
            'advance_tax_amount' => $request->sale_tax_percentage,
        ]);

        foreach ($request->products as $product) {
            $product_id = $product['id'];
            GoodReceiveProduct::where(['product_id'=>$product_id],['good_receive_note_id'=>$goodReceiveNote->id])->update([
                'deliver_qty' => $product['deliver_qty'],
                'bonus' => $product['bonus'] ?? null,
                'expiry_date' => $product['expiry_date'],
                'item_amount' => $product['totalprice2'],
                'batch_number' => $product['batch_no'],
                'discount' => $product['discount'],
                'saletax_percentage' => $product['saletax_percentage'],
                'saletax_amount' => $product['saletax_amount'],
            ]);
        }

        return to_route('purchase.good_receive_note.index')->with('success', 'GRN updated!');
    }

    public function destroy(GoodReceiveNote $goodReceiveNote): RedirectResponse
    {
        $goodReceiveNote->delete();

        return back()->with('success', 'GRN deleted!');
    }

    public function print($goodReceiveNote): View
    {

        // $goodreceiveproduct = GoodReceiveProduct::where('good_receive_note_id', $goodReceiveNote->id)->with('product')->get();

        // $totalproductamount = 0;
        // foreach ($goodreceiveproduct as $product) {
        //     $totalproductamount += $product->item_amount;
        // }
        //requistion_id
        $grn = GoodReceiveNote::where('id',$goodReceiveNote)->with(['requistion.requistionProducts.product.manufacturer', 'requistion.vendor', 'goodReceiveProducts'])->first();
        $rec = Requistion::where('id', $grn->requistion_id)->first();
        $manuFacname = DB::table('manufacturers')->where('id', $rec->manufacturer_id )->first();
        return view('purchase.goodreceivenote.print', [
            'goodReceiveNote' => $grn,
            'grnManufactureName' => $manuFacname->company_name,
            // 'goodreceiveproduct' => $goodreceiveproduct,
            // 'totalproductamount' => $totalproductamount,
        ]);
    }

    public function validateGoodReceiveNote(Request $request)
    {
        $customMessages = [
            'requistion_id.required' => 'The Requisition is required.',
            'requistion_id.exists' => 'The Requisition does not exist in the database.',
            'date.required' => 'The date is required.',
            'total_amount.required' => 'The total amount is required.',
            'total_amount.numeric' => 'The total amount must be a number.',
            'total_amount.min' => 'The total amount must be at least :min.',
        ];

        $validatedData = $request->validate([
            'requistion_id' => ['required', 'exists:requistions,id'],
            'remark' => ['nullable', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'total_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'net_total_amount' => ['required', 'numeric', 'min:0'],
            'advance_tax_percentage' => ['nullable', 'numeric', 'min:0'],
            'advance_tax_amount' => ['nullable', 'numeric', 'min:0'],
            'sale_tax_percentage' => ['nullable', 'numeric', 'min:0'],
            'products.*' => ['required'],
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.deliver_qty' => ['required', 'integer', 'min:0'],
            'products.*.bonus' => ['nullable', 'integer', 'min:0'],
            'products.*.expiry_date' => ['required', 'date'],
            'products.*.batch_no' => ['required', 'min:0'],
            'products.*.totalprice2' => ['required', 'numeric', 'min:0'],
            'products.*.discount' => ['nullable', 'numeric', 'min:0'],
            'products.*.saletax_percentage' => ['nullable', 'numeric'],
            'products.*.saletax_amount' => ['nullable', 'numeric'],
        ], $customMessages);

        // Validation succeeded
        return response()->json(['valid' => true, 'message' => 'Validation succeeded.']);
    }

}
