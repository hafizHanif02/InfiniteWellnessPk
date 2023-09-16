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
            <form action="{{ route('pos.updatetocheckout',$pos) }}" method="post">
                @csrf
            <div class="title text-center mb-5">
                <h1>POS CHECKOUT </h1>
            </div>
            <div class="container">
                <table class="table table-bodered">
                    <tbody>
                        <tr>
                            <th>Patient Name:</th>
                            <td>{{$pos->patient_name }}</td>
                        </tr>
                        <tr>
                            <th>Doctor Name:</th>
                            <td>{{$pos->doctor_name }}</td>
                        </tr>
                        <tr>
                            <th>POS Date:</th>
                            <td>{{$pos->pos_date }}</td>
                        </tr>
                    </tbody>
                </table>
                
                <table class="table table-bordered">
                    <thead>
                        <h2 class="m-5">Products</h2>
                        <tr>
                            <th>Medicine</th>
                            <th>Quantity</th>
                            <th>Total Cost</th>
                        </tr>
                        <tbody>
                            @foreach ($pos->PosProduct as $PosProduct)
                            <tr>
                                <td>{{$PosProduct->medicine->name }}</td>
                                <td>{{$PosProduct->product_quantity}}</td>
                                <td>{{$PosProduct->product_total_price }} Rs</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </thead>
                </table>
                <div class="bg-dark w-100" style="padding: 0.01rem;"></div>
                <table class="table table-border">
                    <tr colspan="2">
                        <th>Total Amount:</th>
                        <td>{{$pos->total_amount }}</td>
                    </tr>
                </table>
                <div class="row mt-10 mb-10">
                    <div class="col-md-4">
                        <label for="enter_payment_amount">Enter Payment Amount</label>
                        <input type="number" onkeyup="enterpayment()" value="0" class="form-control" name="enter_payment_amount" id="enter_payment_amount" >
                    </div>
                    <div class="col-md-8">
                        <label for="change_amount">Change Amount</label>
                        <input type="text" class="form-control"  name="change_amount" readonly class="change_amount" id="change_amount" value="{{$pos->total_amount }}" >
                    </div>
                    <input type="hidden" id="pos_total_amount" value="{{$pos->total_amount }}">
                </div>
                <div class="mb-5">
                    <button type="submit" class="btn btn-primary">Proceede To Checkout</button>
                </div>
            </div>
        </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function enterpayment() {
            var EnterAmount = parseFloat($('#enter_payment_amount').val());
            var pos_total_amount = parseFloat($('#pos_total_amount').val());
    
            if (isNaN(EnterAmount) || isNaN(pos_total_amount)) {
                $('#change_amount').val('Not A Valid Value, Enter Bill Amount = '+pos_total_amount);
            } else if (EnterAmount >= pos_total_amount) {
                $('#change_amount').val(EnterAmount - pos_total_amount);
            } else {
                $('#change_amount').val('Insufficient Amount');
            }
        }
    </script>
    
@endsection
