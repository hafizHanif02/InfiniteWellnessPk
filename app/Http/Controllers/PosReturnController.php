<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use App\Models\Medicine;
use App\Models\PosReturn;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Models\PosProductReturn;
use App\Http\Controllers\Controller;

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
        PosReturn::create([
            'pos_id' => $request->pos_id,
            'total_amount' => $request->total_amount
        ]);
        foreach($request->products as $product){
            PosProductReturn::create([
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

        return to_route('pos-return.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PosReturn  $posReturn
     * @return \Illuminate\Http\Response
     */
    public function show($posReturn)
    {
        $PosReturn = PosReturn::where('pos_id',$posReturn)->with(['Pos_Product_Return','Pos'])->first();
        $PosProductReturn = PosProductReturn::where('pos_id',$posReturn)->get();
       return view('pos-return.show',[
        'PosReturn' => $PosReturn,
        'Pos_return_product' => $PosProductReturn,
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
        $posReturn = PosReturn::where('id',$posreturn)->with('pos')->first();
        $posReturnProduct = PosProductReturn::where('pos_id',$posReturn->pos_id)->with('medicine.brand')->get();
        return view('pos-return.print',[
            'posReturn' => $posReturn,
            'posReturnProduct' => $posReturnProduct,
        ]);
    }
  
    public function destroy(PosReturn $posReturn)
    {
        $posReturn->delete();
        Flash::message('POS Returned Deleted!');

        return to_route('pos-return.index');

    }
}
