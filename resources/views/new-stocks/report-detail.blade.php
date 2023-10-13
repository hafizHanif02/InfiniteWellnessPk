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
                            <a href="{{ url('new-stocks-report-print') }}/{{ $stockReport->id }}" target="_blank"
                                class="btn btn-primary me-5">Print</a>
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
                            <td>{{ $stockReport->total_supply_quantity }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <h3 class="m-5">Products</h3>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">QTY transfered</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stockReport->transferProducts as $transferProduct)
                            <tr>
                                <td>{{ $transferProduct->product->id }}</td>
                                <td>{{ $transferProduct->product->product_name }}</td>
                                <td>{{ $transferProduct->total_piece }}</td>
                            </tr>
                        @empty
                            <td>No products Found!</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
