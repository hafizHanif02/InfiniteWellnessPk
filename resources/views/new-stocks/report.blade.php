@extends('layouts.app')
@section('title')
Transfer Report
@endsection
@section('content')
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Transfer Report</h3>
                    @if ($reportStocks->count() > 0)
                        <a href="{{ route('transfer-report.export') }}" class="btn btn-primary float-end mr-5 mb-3">Export To Excel</a>
                    @endif
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Tranfer ID</th>
                            {{-- <th>Total Price Amount</th>
                            <th>Total Supply Quantity</th> --}}
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reportStocks as $reportStock)

                            <tr class="data">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $reportStock->supply_date }}</td>
                                <td>{{ $reportStock->id }}</td>
                                {{-- <td>{{ $reportStock->total_price_amount }}</td>
                                <td>{{ $reportStock->total_supply_quantity }}</td> --}}
                                <td>{{ $reportStock->status === null ? 'Pending' : ($reportStock->status == 1 ? 'Approved' : 'Rejected') }}</td>
                                <td>
                                    <a href="{{ route('new-stocks.report.show',$reportStock->id) }}"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="6" class="text-danger">No Stock In found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $reportStocks->links() }}
                </div>
            </div>
        </div>
    </div>
    @endsection
