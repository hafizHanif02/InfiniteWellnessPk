@extends('layouts.app')
@section('title')
    POS VIEW
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <div class="col-md-12 mb-5 text-end">
                <a href="{{ route('pos.index') }}"><button class="btn btn-secondary">Back</button></a>
                @if ($pos->is_paid == 1)
                    <a href="{{ route('pos.print', $pos->id) }}" target="_blank"><button
                            class="btn btn-primary">Print</button></a>
                @endif
            </div>
            @if ($pos->is_paid != 1)
                <div class="col-md-12 mb-5 text-end">
                    <a href="{{ route('pos.proceed-to-pay-page', $pos->id) }}"><button class="btn btn-primary">Proceed To
                            Pay</button></a>
                    @role('Admin|PharmacistAdmin')
                        <a href="{{ route('pos.edit', $pos->id) }}" target="_blank" class="btn btn-primary">
                            <i class="fa fa-edit"></i>
                        </a>
                    @endrole
                </div>
            @endif
            <form action="{{ route('pos.enter-paymethod', $pos) }}">
                @csrf
                <div class="title text-center mb-5">
                    <h1>POS VIEW </h1>
                </div>
                <div class="container">
                    <table class="table table-bodered">
                        <tbody>
                            <tr>
                                <th>Patient Name:</th>
                                <td>{{ $pos->patient_name }}</td>
                            </tr>
                            <tr>
                                <th>Doctor Name:</th>
                                <td>{{ $pos->doctor_name }}</td>
                            </tr>
                            <tr>
                                <th>POS Date:</th>
                                <td>{{ $pos->pos_date }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    @if ($pos->is_paid == 1)
                                        <span class="badge bg-success">Success</span>
                                    @else
                                        <span class="badge bg-danger">Unpaid</span>
                                    @endif
                                </td>
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

                    <table class="table table-border">
                        <tr colspan="2">
                            <th>Total Amount:</th>
                            <td>{{ $pos->total_amount }}</td>
                        </tr>
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
                        <tr>
                            <th>Given Amount</th>
                            <td>{{ $pos->enter_payment_amount }}</td>
                        </tr>
                        <tr>
                            <th>Change Amount</th>
                            <td>{{ $pos->change_amount }}</td>
                        </tr>
                    </table>
                </div>
            </form>
            <div class="row ms-5">
                <div class="col-md-12 p-5 ms-5">
                    <a href="{{ url('/pos/recalculate') }}/{{ $pos->id }}" style="color: white"><button
                            type="button" class="btn btn-success ms-5">Recalculate</button></a>
                </div>
            </div>
        </div>
    </div>
@endsection
