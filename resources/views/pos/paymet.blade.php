@extends('layouts.app')
@section('title')
    Payment Page
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <div class="container m-10">
               
                <form action="{{ route('pos.paid',$pos) }}" method="POST" >
                    @csrf
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
                    <button class="btn btn-primary">Enter payment</button>
                </form>
            </div>
        </div>
    </div>
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
