@extends('layouts.app')
@section('title')
    POS RETURN VIEW
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
                <div class="col-md-12 mb-5 text-end">
                    <a href="{{ route('pos.index') }}"><button class="btn btn-secondary">Back</button></a>
                    <a href="{{ route('pos-return.print',$PosReturn->id) }}"><button class="btn btn-primary">Print</button></a>
                </div>
               
                {{-- {{dd($PosReturn) }} --}}
            <div class="title text-center mb-5">
                <h1>POS Return View </h1>
            </div>
            <div class="container">
                <table class="table table-bodered">
                    <tbody>
                        <tr>
                            <th>Patient Name:</th>
                            <td>{{$PosReturn->pos->patient_name }}</td>
                        </tr>
                        <tr>
                            <th>POS No:</th>
                            <td>{{$PosReturn->pos->id}}</td>
                        </tr>
                        <tr>
                            <th>POS Date:</th>
                            <td>{{$PosReturn->pos->pos_date }}</td>
                        </tr>
                        
                    </tbody>
                </table>
                
                <table class="table table-bordered">
                    <thead>
                        <h2 class="m-5">Products</h2>
                        <tr>
                            <th class="text-center">Medicine</th>
                            <th class="text-center">Generic</th>
                            <th class="text-center">Return Quantity</th>
                            <th class="text-center">MRP Per Unit</th>
                            <th class="text-center">Total Cost</th>
                        </tr>
                        <tbody>
                            
                            @foreach ($Pos_return_product as $PosProduct)
                            <tr class="text-center">
                                <td>{{$PosProduct->medicine->name }}</td>
                                <td>{{$PosProduct->generic_formula }}</td>
                                <td>{{$PosProduct->product_quantity}}</td>
                                <td>{{$PosProduct->medicine->selling_price}}</td>
                                <td>{{$PosProduct->product_total_price }} Rs</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
