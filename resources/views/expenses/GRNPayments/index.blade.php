@extends('layouts.app')
@section('title')
    GRN Payments
@endsection
@section('content')
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

    <div class="container-fluid mt-5">
        <div class="d-flex flex-column">
            @include('flash::message')
            <div class="card">
                <div class="card-header">
                    <div class="col-md-12 mb-5 d-flex justify-content-between align-items-center px-3 py-0 mt-3">
                        <div>
                            <span class="h3">GRN Payments</span>
                        </div>
                        <div>
                            <a href="{{ route('expenses.index') }}"><button class="btn btn-secondary me-2">Back</button></a>
                            <a href="{{ route('grn-payments-create') }}"><button class="btn btn-primary">Create <i
                                        class="fa fa-plus"></i></button></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered text-center table-hover" id="tbl_exporttable_to_xls">
                        <thead class="table-dark">
                            <tr>
                                <td>#</td>
                                <td>GRN #</td>
                                <td>Invoice No.</td>
                                <td>Distributor</td>
                                <td>Net Total Amount</td>
                                <td>Paid Amount</td>
                                <td>Paid Date</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grnPayments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>{{ $payment->grn_id }}</td>
                                    <td>{{ $payment->grn->invoice_number }}</td>
                                    <td>{{ $payment->grn->requistion->vendor->account_title }}</td>
                                    <td>{{ $payment->grn->net_total_amount }}</td>
                                    <td>{{ $payment->paid_amount }}</td>
                                    <td>{{ $payment->paid_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
