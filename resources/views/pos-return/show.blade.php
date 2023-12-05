@extends('layouts.app')
@section('title')
    POS RETURN VIEW
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <div class="col-md-12 mb-5 text-end">
                <a href="{{ route('pos-return.index') }}"><button class="btn btn-secondary">Back</button></a>
                <a href="{{ route('pos-return.print', $PosReturn->id) }}" target="_blank"><button
                        class="btn btn-primary">Print</button></a>
            </div>


            <div class="title text-center mb-5">
                <h1>POS Return View </h1>
            </div>
            <div class="container">
                <table class="table table-bodered">
                    <tbody>
                        <tr>

                            <th>Patient Name:</th>
                            <td>{{ $PosReturn->pos->patient_name }}</td>
                        </tr>
                        <tr>
                            <th>POS No:</th>
                            <td>{{ $PosReturn->pos->id }}</td>
                        </tr>
                        <tr>
                            <th>POS Date:</th>
                            <td>{{ $PosReturn->pos->pos_date }}</td>
                        </tr>
                        <tr>
                            <th>RETURN ID</th>
                            <td>{{ $PosReturn->id }}</td>
                        </tr>
                        <tr>
                            <th>RETURN DATE/TIME</th>
                            <td>{{ $PosReturn->created_at }}</td>
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
                        {{-- {{dd($PosReturn->Pos_Product_Return) }} --}}
                        @foreach ($PosReturn->Pos_Product_Return as $PosProduct)
                            <tr class="text-center">
                                <td>{{ $PosProduct->medicine->name }}</td>
                                <td>{{ $PosProduct->generic_formula }}</td>
                                <td>{{ $PosProduct->product_quantity }}</td>
                                {{-- <td>{{ $PosProduct->medicine->selling_price }}</td> --}}
                                <td>{{ $PosProduct->mrp_perunit }}</td>
                                <td>{{ $PosProduct->product_total_price }} Rs</td>
                            </tr>
                        @endforeach
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
