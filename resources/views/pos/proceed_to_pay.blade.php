@extends('layouts.app')
@section('title')
    Payment Page
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <div class="col-md-12 mb-5 text-end">
                <a href="{{ route('pos.index') }}"><button class="btn btn-secondary">Back</button></a>
            </div>
            <form action="{{ route('pos.enter-paymethod', $pos) }}">
                @csrf
                <div class="title text-center mb-5">
                    <h1>POS CHECKOUT </h1>
                </div>
                <div class="container">
                    <table class="table table-bodered">
                        <tbody>
                            <tr>
                                <th>Patient Name:</th>
                                <td>{{ $pos->patient_name }}</td>
                            </tr>
                            @if ($pos->doctor_name != null)
                                <tr>
                                    <th>Doctor Name:</th>
                                    <td>{{ $pos->doctor_name }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>POS Date:</th>
                                <td>{{ $pos->pos_date }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <thead>
                            <h2 class="m-5">Products</h2>
                            <tr>
                                <th>Medicine</th>
                                <th>Generic</th>
                                <th>Quantity</th>
                                <th>MRP Per Unit</th>
                                <th>GST %</th>
                                <th>GST Amount</th>
                                <th>Discount %</th>
                                <th>Discount Amount</th>
                                <th>Total Cost</th>
                            </tr>
                        <tbody>
                            @foreach ($pos->PosProduct as $PosProduct)
                                <tr class="text-center">
                                    <td>{{ $PosProduct->medicine->name }}</td>
                                    <td>{{ $PosProduct->generic_formula }}</td>
                                    <td>{{ $PosProduct->product_quantity }}</td>
                                    <td>{{ $PosProduct->mrp_perunit }}</td>
                                    <td>{{ $PosProduct->gst_percentage }}</td>
                                    <td>{{ $PosProduct->gst_amount }}</td>
                                    <td>{{ $PosProduct->discount_percentage }}</td>
                                    <td>{{ $PosProduct->discount_amount }}</td>
                                    <td>{{ $PosProduct->product_total_price }} Rs</td>
                                </tr>
                            @endforeach
                        </tbody>
                        </thead>
                    </table>
                    <div class="bg-dark w-100" style="padding: 0.01rem;"></div>
                    <table class="table table-border">
                        <tr colspan="2">
                            <th>Pos Fees:</th>
                            <td>{{ $pos->pos_fees }}</td>
                        </tr>
                        <tr colspan="2">
                            <th>Total Discount:</th>
                            <td>{{ $pos->total_discount }}</td>
                        </tr>
                        <tr colspan="2">
                            <th>Total Sales Tax:</th>
                            <td>{{ $pos->total_saletax }}</td>
                        </tr>
                        <tr colspan="2">
                            <th>Total Amount Exlusive Sale Tax:</th>
                            <td>{{ $pos->total_amount_ex_saletax }}</td>
                        </tr>
                        <tr colspan="2">
                            <th>Total Amount Inclusive Sale Tax:</th>
                            <td>{{ $pos->total_amount_inc_saletax }}</td>
                        </tr>
                        <tr colspan="2">
                            <th>Grand Total Amount:</th>
                            <td>{{ $pos->total_amount }}</td>
                        </tr>
                    </table>
                    <div class="row text-center">
                        <div class="mb-5">
                            <button type="submit" class="btn btn-primary">Proceed To Checkout</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row text-start">
                <div class="mb-5 ms-5">
                    <a href="{{ url('/pos/recalculate') }}/{{ $pos->id }}" style="color: white"><button
                            type="button" class="btn btn-success">Recalculate</button></a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function enterpayment() {
            var EnterAmount = parseFloat($('#enter_payment_amount').val());
            var pos_total_amount = parseFloat($('#pos_total_amount').val());

            if (isNaN(EnterAmount) || isNaN(pos_total_amount)) {
                $('#change_amount').val('Not A Valid Value, Enter Bill Amount = ' + pos_total_amount);
            } else if (EnterAmount >= pos_total_amount) {
                $('#change_amount').val(EnterAmount - pos_total_amount);
            } else {
                $('#change_amount').val('Insufficient Amount');
            }
        }
    </script>
@endsection
