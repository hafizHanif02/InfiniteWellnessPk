<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Pos;
use App\Models\BatchPOS;
use App\Models\Medicine;
use App\Models\PosReturn;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Models\PosProductReturn;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PosReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pos-return.index',[
            'pos_retrun' => PosReturn::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pos = Pos::with(['PosProduct.medicine','PosProduct.batchpos.batch'])->where('is_paid',1)->get();

        return view('pos-return.create',[
            'poses' => Pos::with(['PosProduct.medicine','PosProduct.batchpos.batch'])->where('is_paid',1)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pos_id' => 'required',
            'total_amount' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('pos-return.create')->withErrors($validator)->withInput();
        }
       $posReturn = PosReturn::create([
            'pos_id' => $request->pos_id,
            'total_amount' => $request->total_amount
        ]);
        $user = Auth::user();
        $requistionproductlogs = 'Pos Return No. '.$posReturn->id.' Products:{[medicine_id, qty],';
        foreach($request->products as $product){
            PosProductReturn::create([
                'pos_return_id' => $posReturn->id,
                "pos_id" => $request->pos_id,
                "medicine_id" => $product['medicine_id'],
                "product_id" => $product['product_id'],
                "product_name" => $product['product_name'],
                'mrp_perunit' => $product['mrp_perunit'],
                "generic_formula" => $product['generic_formula'],
                "product_quantity" => $product['return_quantity'],
                "product_total_price" => $product['product_total_price'],
            ]);
            Medicine::where('id', $product['medicine_id'])->increment('total_quantity', $product['return_quantity']);
            if($product['batch_id']){
                BatchPOS::where('id', $product['batch_id'])->decrement('sold_quantity', $product['return_quantity']);
                BatchPOS::where('id', $product['batch_id'])->update([
                    'remaining_qty' => DB::raw('remaining_qty +' . $product['return_quantity'])
                ]);
                $requistionproductlogs .= '['.$product['medicine_id'].','.$product['return_quantity'].'],'; 
            }
        }
        $requistionproductlogs .= '}';
        $logs = Log::create([
            'action' => 'Pos Return Has Been Created Pos Return No.'.$posReturn->id.' POS No.'.$request->pos_id ,
            'action_by_user_id' => $user->id,
        ]);
        $fileName = 'log/' . $logs->id . '.txt'; 
        $filePath = public_path($fileName); 
        $directory = dirname($filePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        file_put_contents($filePath, $requistionproductlogs);
        Flash::message('POS Returned!');
        // dd($posReturn->id);
        return to_route('pos-return.print',$posReturn->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PosReturn  $posReturn
     * @return \Illuminate\Http\Response
     */
    public function show($posReturn)
    {
        $PosReturn = PosReturn::where('id',$posReturn)->with(['Pos_Product_Return','Pos'])->first();
       return view('pos-return.show',[
        'PosReturn' => $PosReturn,
       ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PosReturn  $posReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(PosReturn $posReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PosReturn  $posReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PosReturn $posReturn)
    {
        //
    }

    public function print($posreturn){
        $posReturn = PosReturn::where('id',$posreturn)->with(['pos','Pos_Product_Return.medicine'])->first();
        return view('pos-return.print',[
            'posReturn' => $posReturn,
        ]);
    }
  
    public function destroy(PosReturn $posReturn)
    {
        $posReturn->delete();
        $user = Auth::user();
        Log::create([
            'action' => 'Pos Return Has Been Deleted Pos Return No.'.$posReturn->id.' Pos No.'.$posReturn->pos_id ,
            'action_by_user_id' => $user->id,
        ]);
        Flash::message('POS Returned Deleted!');

        return to_route('pos-return.index');

    }
}
