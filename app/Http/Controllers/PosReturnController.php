<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use App\Models\Medicine;
use App\Models\PosReturn;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Models\PosProductReturn;
use App\Http\Controllers\Controller;
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
        return view('pos-return.create',[
            'poses' => Pos::with('PosProduct.medicine')->get()
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
        foreach($request->products as $product){
            PosProductReturn::create([
                'pos_return_id' => $posReturn->id,
                "pos_id" => $request->pos_id,
                "medicine_id" => $product['medicine_id'],
                "product_id" => $product['product_id'],
                "product_name" => $product['product_name'],
                "generic_formula" => $product['generic_formula'],
                "product_quantity" => $product['return_quantity'],
                "product_total_price" => $product['product_total_price'],
            ]);
            Medicine::where('id', $product['medicine_id'])->increment('total_quantity', $product['return_quantity']);

        }
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
        Flash::message('POS Returned Deleted!');

        return to_route('pos-return.index');

    }
}
