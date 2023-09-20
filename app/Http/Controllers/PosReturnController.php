<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use App\Models\PosReturn;
use Illuminate\Http\Request;
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
            'pos_retrun' => PosReturn::with('Pos_Product_Return')->get()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PosReturn  $posReturn
     * @return \Illuminate\Http\Response
     */
    public function show(PosReturn $posReturn)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PosReturn  $posReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(PosReturn $posReturn)
    {
        //
    }
}
