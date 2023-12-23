<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Log;
use Illuminate\View\View;
use App\Mail\MarkdownMail;
use Illuminate\Http\Request;
use App\Models\Shift\Transfer;
use Illuminate\Support\Carbon;
use App\Models\Inventory\Vendor;
use App\Models\Inventory\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase\Requistion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Shift\TransferProduct;
use Illuminate\Http\RedirectResponse;
use App\Models\Inventory\Manufacturer;
use Illuminate\Support\Facades\Storage;
use App\Models\Purchase\GoodReceiveNote;
use Illuminate\Support\Facades\Validator;
use App\Imports\Purchase\RequistionImport;
use App\Models\Purchase\RequistionProduct;
use App\Models\Purchase\GoodReceiveProduct;
use Illuminate\Support\Facades\Mail as Email;
use App\Http\Requests\Purchase\RequistionRequest;
use App\Imports\Purchase\RequistionDocumentImport;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RequistionController extends Controller
{
    public function index(): View
    {
        return view('purchase.requistion.index', [
            'requistions' => Requistion::with('vendor')->whereHas('requistionProducts', function ($query) {
                $query->where('is_approved', null);
            })->latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function importExcel(Request $request): RedirectResponse
    {
        $request->validate([
            'requistions_csv' => ['required', 'file', 'mimes:xlsx']
        ]);
        Excel::import(new RequistionImport, storage_path('app/public/' . request()->file('requistions_csv')->store('requistions-excel-files', 'public')));

        return back()->with('success', 'Imported successfully!');
    }

    public function importDocument(Request $request): JsonResponse
    {
        $request->validate([
            'document' => ['required', 'file', 'mimes:xlsx']
        ]);

        $data = Excel::toCollection(new RequistionDocumentImport, storage_path('app/public/' . request()->file('document')->store('requistion-document-excel-files', 'public')));

        foreach ($data as $key => $d) {
            try{
                $product = Product::where('product_name', $d[0]['product_name'])->firstOrFail(['id','product_name','total_quantity','cost_price']);
                $limit = $d[0]['limit'];
                $data->forget($key);
                $data[] = [
                    'product' => $product,
                    'limit' => $limit,
                    'price_per_unit' => $d[0]['price_per_unit'],
                    'total_piece' => $d[0]['total_piece'],
                    'total_packet' => $d[0]['total_packet'],
                ];
            } catch (ModelNotFoundException) {
                return response()->json([
                    'message' => 'Product '.$d[0]['product_name'].' not found'
                ], 404);
            }
        }

        return response()->json([
            'product' => $data,
        ]);
    }

    public function products(Request $request): JsonResponse
    {
        
        return response()->json([
            'data' => Product::where('manufacturer_id', Manufacturer::where('id', $request->manufacturer_id)->pluck('id')->first())->get(['id', 'product_name']),
        ]);
    }

    public function create(): View
    {
        return view('purchase.requistion.create', [
            'requistion_id' => Requistion::latest()->pluck('id')->first(),
            'vendors' => Vendor::orderBy('account_title')->get(['id', 'account_title']),
            'manufactuters' => Manufacturer::orderBy('company_name')->get(['id', 'company_name']),
            'products' => Product::orderBy('id')->with('generic')->get(),
        ]);
    }

    public function productDetails(Request $request): JsonResponse
    {
        return response()->json([
            'product' => Product::whereIn('id', $request->product_id)->get(),
        ]);
    }

    public function store(RequistionRequest $request): RedirectResponse
    {
        
        $requistion = Requistion::create([
            'vendor_id' => $request->vendor_id,
            'manufacturer_id' => $request->manufacturer_id,
            'remarks' => $request->remarks,
            'delivery_date' => now(),
            'discount_amount' => $request->discount_amount
        ]);

        $user = Auth::user();
        $requistionproductlogs = 'Requistion No. '.$requistion->id.' Products:{[produc_id, qty],';
        foreach ($request->products as $product) {
            RequistionProduct::create([
                'requistion_id' => $requistion->id,
                'product_id' => $product['id'],
                'limit' => $product['limit'],
                'price_per_unit' => $product['price_per_unit'],
                'total_piece' => $product['total_piece'],
                'discount_percentage' => $product['discount_percentage'],
                'total_amount' => $product['total_amount'],
            ]);
            $requistionproductlogs .= '['.$product['id'].','.$product['total_piece'].'],'; 
        }
        $requistionproductlogs .= '}';
        $logs = Log::create([
            'action' => 'Requistion Has Been Created Requistion No.'.$requistion->id ,
            'action_by_user_id' => $user->id,
        ]);
        $fileName = 'log/' . $logs->id . '.txt'; 
        $filePath = public_path($fileName); 
        $directory = dirname($filePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        file_put_contents($filePath, $requistionproductlogs);



        // EMAIL

        // $patient = Patient::where('id', $appointment->patient_id)->with('user')->first();
        // $doctor = Doctor::where('id',  $appointment->doctor_id)->with('user')->first();
        // $receptions = Receptionist::with('user')->get();

        // $patientEmail = $patient->user->email;
        // $doctorEmail = $doctor->user->email;
        // $recipient = [$patient->user->email, $doctor->user->email];
        $PharmacistAdmin = User::where('department_id', 13)->get();
        $Admins = User::where('department_id', 1)->get();

        $recipient = [];
        foreach ($PharmacistAdmin as $PharmacistAdmin) {
            $recipient[] = $PharmacistAdmin->email;
        }
        $subject = 'Requistion ' . $requistion->id . ' Created';


            $data = array(
                'message' => 'Requisition No. ' . $requistion->id . ' has been created and is awaiting your approval.',
            );


        $mail = array(
            'to' => $recipient,
            'subject' => $subject,
            'message' => 'Requisition No. ' . $requistion->id . ' has been created and is awaiting your approval.',
            'attachments' => null,
        );

        Email::to($recipient)
            ->send(new MarkdownMail(
                'emails.email',
                $mail['subject'],
                $mail
            ));

        foreach ($Admins as $admin) {
            $admin_mail = $admin->email;
            $admin_array = [];
            $admin_array[] = $admin_mail;


            $mail = array(
                'to' => $admin_array,
                'subject' => $subject,
                'message' => 'Requisition No. ' . $requistion->id . ' has been created and is awaiting your approval.',            
                'attachments' => null,
            );

            Email::to($admin_array)
                ->send(new MarkdownMail(
                    'emails.email',
                    $mail['subject'],
                    $mail
                ));
        }
        // EMAIL



        return to_route('purchase.requistions.index')->with('success', 'Requistion created!');
    }

    public function show(Requistion $requistion): View
    {
        return view('purchase.requistion.show', [
            'requistion' => $requistion->load('requistionProducts.product'),
        ]);
    }

    public function edit($requistion): View
    {
        return view('purchase.requistion.edit', [
            'requistion' => Requistion::where('id',$requistion)->with(['requistionProducts.product', 'vendor.manufacturer'])->first(),
            'requistion_id' => Requistion::latest()->pluck('id')->first(),
            'vendors' => Vendor::orderBy('account_title')->get(['id', 'account_title']),
            'manufactuters' => Manufacturer::orderBy('company_name')->get(['id', 'company_name']),
            'products' => Product::orderBy('id')->with('generic')->get(),
        ]);
    }

    public function update(RequistionRequest $request, Requistion $requistion): RedirectResponse
    {
        $requistion->update([
            'remarks' => $request->remarks,
            'delivery_date' => $request->delivery_date,
            'discount_amount' => $request->discount_amount
        ]);

        $requistion->requistionProducts()->delete();
        $user = Auth::user();
        $requistionproductlogs = 'Requistion No. '.$requistion->id.' Products:{[produc_id, qty],';
        foreach ($request->products as $product) {
            RequistionProduct::create([
                'requistion_id' => $requistion->id,
                'product_id' => $product['id'],
                'limit' => $product['limit'],
                'price_per_unit' => $product['price_per_unit'],
                'total_piece' => $product['total_piece'],
                'discount_percentage' => $product['discount_percentage'],
                'total_amount' => $product['total_amount'],
            ]);
            $requistionproductlogs .= '['.$product['id'].','.$product['total_piece'].'],'; 
        }
        $requistionproductlogs .= '}';
        $logs = Log::create([
            'action' => 'Requistion Has Been Updated Requistion No.'.$requistion->id ,
            'action_by_user_id' => $user->id,
        ]);
        $fileName = 'log/' . $logs->id . '.txt'; 
        $filePath = public_path($fileName); 
        $directory = dirname($filePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        file_put_contents($filePath, $requistionproductlogs);
        return to_route('purchase.requistions.index')->with('success', 'Requistion updated!');
    }

    public function destroy(Requistion $requistion): RedirectResponse
    {
        $user = Auth::user();
        Log::create([
            'action' => 'Requistion Has Been Deleted Requistion No.'.$requistion->id ,
            'action_by_user_id' => $user->id,
        ]);
        $requistion->delete();

        return back()->with('success', 'Requistion deleted!');
    }

    public function print(Requistion $requistion)
    {
        $requistionProduct = RequistionProduct::where('requistion_id', $requistion->id)->with('Product')->get();
        $productIds = $requistionProduct->pluck('product_id')->toArray();
        
        $currentMonth = now()->format('Y-m-d');
        
        
        
        foreach($requistionProduct as $prod){
            $date = Product::where('id',$prod->product_id)->first('created_at');;
            $consume = TransferProduct::where('product_id', $prod->product_id)->sum('total_piece');
            if($consume){
                $prod->averageMonthly = now()->diffInMonths($date->created_at->format('Y-m-d')) / $consume;
            }else {
                $prod->averageMonthly = '0';
            }
            
            $prod->consume = $consume;
        }
        
        $currentMonth = now()->month;
        $requistionProducts = RequistionProduct::where('requistion_id',$requistion->id)->get();

        foreach($requistionProducts as $requistionProduct){
            $currentMonth = now()->month;
            $openQuantity = GoodReceiveProduct::where('product_id', $requistionProduct->product_id)->whereMonth(DB::raw('DATE(created_at)'), $currentMonth)->first();
        }

        
        
        return view('purchase.requistion.print', [
            'requistion' => $requistion->load(['requistionProducts.product.manufacturer', 'vendor']),
            'last_purchase' => GoodReceiveNote::where('requistion_id',$requistion->id)->with('goodReceiveProducts.product')->latest()->first(),
            'requistionProducts' => $requistionProducts,
            'openQuantity' => $openQuantity,
        ]);
    }

    public function validateRequistion(Request $request){
        
        $customMessages = [
            'vendor_id.required' => 'Select at least one vendor',
            'products.required' => 'At least one product is required',
        ];
        
        $validatedData = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'remarks' => ['nullable', 'string', 'max:255'],
            'delivery_date' => ['nullable', 'date'],
            'products' => ['required'], // Check if the "products" array is required.
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.limit' => ['required', 'integer', 'min:0'],
            'products.*.price_per_unit' => ['required', 'numeric', 'min:0'],
            'products.*.total_piece' => ['required', 'numeric', 'min:1'],
            'products.*.total_amount' => ['required', 'numeric', 'min:0'],
        ], $customMessages);
        
            // Validation succeeded
            return response()->json(['valid' => true, 'message' => 'Validation succeeded.']);
        

    }
}