@extends('layouts.app')
@section('title')
    Add Medicines Adjustment
@endsection
@section('content')
<div class="container-fluid mt-5">
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-column">
                @include('flash::message')
            </div>
            <div class="d-flex justify-content-between mb-5">
                <h3>Adjustment Products</h3>
                <a href="{{ route('medicines.adjustment.create') }}" class="btn btn-primary">Add
                    Adjustment</a>
            </div>
            <table class="table table-bordered text-center table-hover">
                <thead class="table-dark">
                    <tr>
                        <td scope="col">Adjustment #</td>
                        <td scope="col">Medicine Name</td>
                        <td scope="col">Batch_POS ID</td>
                        <td scope="col">Current Quantity</td>
                        <td scope="col">Adjustment Quantity</td>
                        <td scope="col">Difference Quantity</td>
                        <td scope="col">Adjustment Date</td>
                    </tr>
                </thead>
                <tbody>
                    {{-- {{ dd($adjustment) }} --}}
                    @foreach ($adjustment as $medicine)
                        <tr>
                            <td scope="row">{{ $medicine->id }}</td>
                            <td>{{ $medicine->medicine_name }}</td>
                            <td>{{ $medicine->batchPOS ? $medicine->batchPOS->id : 'N/A' }}</td>
                            <td>{{ $medicine->current_qty }}</td>
                            <td>{{ $medicine->adjustment_qty }}</td>
                            <td>{{ $medicine->different_qty }}</td>
                            <td>{{ $medicine->created_at }}</td>
                        </tr>
                    @endforeach
                    @if (count($adjustment) == 0)
                        <tr class="text-center">
                            <td colspan="5" class="text-danger">No Medicine found!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{ $adjustment->links() }}
            <div>
            </div>
        </div>
    </div>
</div>
@endsection
    
