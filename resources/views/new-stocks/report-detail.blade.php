@extends('layouts.app')
@section('title')
    Transfer Report Detail
@endsection
@section('content')
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Transfer Report Detail</h3>
                    <div>
                        @if ($stockReport->count() > 0)
                            <a href="{{ route('new-stocks.report') }}" class="btn btn-primary me-5">Print</a>
                        @endif
                        <a href="{{ route('new-stocks.report') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Code</th>
                            <td>{{ $stockReport->id }}</td>
                        </tr>
                        <tr>
                            <th>Total Supply Quantity</th>
                            <td>{{ $stockReport->total_supply_quantity }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center h1">Products</td>
                        </tr>
                        @forelse ($stockReport->transferProducts as $transferProduct)
                            <tr>
                                <th>Code:</th>
                                <td>{{ $transferProduct->product->id }}</td>
                            </tr>
                            <tr>
                                <th>QTY transfered:</th>
                                <td>{{ $transferProduct->total_piece }}</td>
                            </tr>
                            <tr>
                                <th>Name:</th>
                                <td>{{ $transferProduct->product->product_name }}</td>
                            </tr>
                            <br><br>
                        @empty
                            <td></td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
