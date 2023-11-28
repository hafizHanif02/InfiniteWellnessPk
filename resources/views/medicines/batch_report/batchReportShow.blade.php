@extends('layouts.app')
@section('title')
    Batch Pos Report
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Batch Report </h3>
                <a href="{{ route('medicines.batch-pos-report') }}" class="btn btn-secondary mb-3">Back to Batch Pos
                    </a>
            </div>
            <div class="card-body">

                <table class="table table-bordered">
                    <thead class="table-dark text-dark">
                        <th>Batch Id</th>
                        <th>Unit Trade</th>
                        <th>Unit Retail</th>
                        <th>Quantity</th>
                        <th>Sold Qty</th>
                        <th>Remaining Qty</th>
                        <th>Expiry Date</th>
                    </thead>
                    <tbody class="table-light">
                        @foreach ($batches as $product)
                            <tr>
                                <td>{{ $product->batch_id }}</td>
                                <td>{{ $product->unit_trade }}</td>
                                <td>{{ ($product->unit_retail)?$product->unit_retail:0 }} </td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->sold_quantity }}</td>
                                <td>{{ $product->remaining_qty }}</td>
                                <td>{{ $product->expiry_date }}</td>
                            </tr>
                        @endforeach
                        @if (count($batches) == 0)
                            <tr class="text-center text-danger">
                                <td>No data found</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>

            </div>
        @endsection
