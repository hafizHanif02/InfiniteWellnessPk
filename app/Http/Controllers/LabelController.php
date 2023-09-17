<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Http\Requests\LabelRequest;
use App\Http\Controllers\Controller;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LabelRequest $request)
{
    Label::create($request->validated());

}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        //
    }
    public function LabelShow($pos_id, $medicine_id)
    {
        $label = Label::where('pos_id',$pos_id)->where('medicine_id',$medicine_id)->first();
        return view('label.show',[
            'label' => $label,
        ]);
    }
    public function Labelprint($pos_id, $medicine_id){
        $label = Label::where('pos_id',$pos_id)->where('medicine_id',$medicine_id)->first();
        return view('label.print',[
            'label' => $label,
        ]);
    }
}
