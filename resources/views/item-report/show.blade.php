@extends('layouts.app')
@section('title')
    Item Report Show
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Item Report</h3>
                <div>
                    <a href="{{ route('itemReport.index') }}" class="btn btn-secondary">Back</a>
                    <a href="{{ route('itemReport.print', $product->medicine_id) }}" target="_blank"><button
                            class="btn btn-primary ms-5">Print</button></a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered text-start">
                    <tr>
                        <th>Product Name :</th>
                        <td>{{ $product->product_name }}</td>
                    </tr>
                    <tr>
                        <th>Product QTY :</th>
                        <td>{{ $totalQuantity }}</td>
                    </tr>
                    <tr>
                        <th>Return QTY :</th>
                        <td>{{ $totalReturnQuantity }}</td>
                    </tr>
                    
                </table>

            </div>
        </div>
    </div>
@endsection
