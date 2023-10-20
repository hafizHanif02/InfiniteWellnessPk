@extends('layouts.app')
@section('title')
    Payment Page
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <div class="container m-10">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="fas fa-dollar-sign fa-lg"></i>Cash Payment
                        </button>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
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
                                    <input type="hidden" value="1" name="is_cash">
                                    <input type="hidden" value="" name="card_number">
                                    <input type="hidden" id="pos_total_amount" value="{{$pos->total_amount }}">
                                </div>
                                <button class="btn btn-primary">Enter payment</button>
                            </form>
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="fa fa-credit-card fa-lg mr-5"></i>Card Payment
                        </button>
                      </h2>
                      <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form action="{{ route('pos.paid',$pos) }}" method="POST" >
                                @csrf
                                <div class="row mt-10 mb-10">
                                    <div class="col-md-4">
                                        <label for="enter_payment_amount">Enter Payment Amount</label>
                                        <input type="number" onkeyup="enterpaymentcard()" value="0" class="form-control" name="enter_payment_amount" id="enter_payment_amount_card" >
                                    </div>
                                    <div class="col-md-8">
                                        <label for="change_amount">Change Amount</label>
                                        <input type="text" class="form-control"  name="change_amount" readonly class="change_amount" id="change_amount_card" value="{{$pos->total_amount }}" >
                                    </div>
                                    <input type="hidden" value="0" name="is_cash">
                                    <input type="hidden" id="pos_total_amount_card" value="{{$pos->total_amount }}">
                                </div>
                                <button class="btn btn-primary">Enter payment</button>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
                {{-- <form action="{{ route('pos.paid',$pos) }}" method="POST" >
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
                </form> --}}
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
                $('#change_amount').val((EnterAmount - pos_total_amount).toFixed(2));
            } else {
                $('#change_amount').val('Insufficient Amount (Actual Bill Amount = '+pos_total_amount+')');
            }
        }
        function enterpaymentcard(){
            var EnterAmount = parseFloat($('#enter_payment_amount_card').val());
            var pos_total_amount = parseFloat($('#pos_total_amount_card').val());
    
            if (isNaN(EnterAmount) || isNaN(pos_total_amount)) {
                $('#change_amount_card').val('Not A Valid Value, Enter Bill Amount = '+pos_total_amount);
            } else if (EnterAmount >= pos_total_amount) {
                $('#change_amount_card').val((EnterAmount - pos_total_amount).toFixed(2));
            } else {
                $('#change_amount_card').val('Insufficient Amount (Actual Bill Amount = '+pos_total_amount+')');
            }
        }
    </script>
@endsection   
