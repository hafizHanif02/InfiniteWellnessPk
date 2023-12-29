@extends('layouts.app')
@section('title')
    GRN Payments Create
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
            </div>
            @include('flash::message')
            <div class="col-md-12 mb-5 text-end">
                <a href="{{ route('grn-payments') }}"><button class="btn btn-secondary">Back</button></a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>GRN Payments Create</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('grn-payments-store') }}" method="post">
                        @csrf
                        <div class="row mb-5 mt-5">
                            <div class="col-md-6">
                                <label for="grn_id">Select GRN</label>
                                <select class="form-control" name="grn_id" id="grn_id">
                                    <option value="" selected disabled>Select GRN</option>
                                    @foreach ($grn as $grn)
                                        <option value="{{ $grn->id }}">
                                            {{ $grn->id }} ({{ $grn->invoice_number }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-10">
                            <div class="row mb-5 ">
                                <div class="col-md-8">
                                    <h4>GRN</h4>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bodered table-medicine" id="able-medicine">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th>GRN Id</th>
                                            <th>Invoice Number</th>
                                            <th>Net Total Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Remaining Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="" id="grn-table">

                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <label class="form-label" for="paid_amount">Enter Amount</label>
                                    <input type="number" step="any" class="form-control" name="paid_amount"
                                        id="paid_amount">
                                    <span id="paid_amount_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="paid_date">Enter Date</label>
                                    <input type="date" class="form-control" name="paid_date" id="paid_date">
                                    <span id="paid_date_error"></span>
                                </div>
                                <div class="col-md-12 mt-5">
                                    <label class="form-label" for="paid_date">Enter Date</label>
                                    <textarea class="form-control" name="comments" id="comments" cols="30" rows="10"></textarea>
                                    <span id="comments_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mb-5 mt-5">
                            <button class="btn btn-primary" id="submitBtn">Submit</button>
                        </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#grn_id').select2();

            $("#submitBtn").attr("disabled", true);

            $("#grn_id").change(function() {

                $("#paid_amount").val("");
                $("#paid_date").val("");
                $("#comments").val("");

                if ($("#paid_amount").val() !== '' && $("#paid_date").val() !== '' && $("#comments")
                    .val() !== '') {
                    $("#submitBtn").attr("disabled", false);
                } else {
                    $("#submitBtn").attr("disabled", true);
                }

                var id = $(this).val();

                $.ajax({
                    type: "POST",
                    url: "/get-grn/",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(response) {
                        console.log(response.grn);
                        $("#paid_amount").attr("disabled", false);
                        var paid_amount = 0;
                        var RemainingAmount = 0;
                        if (response.grn.grn_payments.length != 0) {
                            for (var i = 0; i < response.grn.grn_payments.length; i++) {
                                paid_amount += response.grn.grn_payments[i].paid_amount;
                            }
                        }

                        RemainingAmount = response.grn.net_total_amount - paid_amount;
                        RemainingAmount = RemainingAmount.toFixed(2);
                        console.log(RemainingAmount);

                        if (RemainingAmount == 0) {
                            $("#paid_amount").attr("disabled", true);
                        }

                        $('#grn-table').empty();
                        $('#grn-table').append(`
                            <tr>
                                <td>${response.grn.id}</td>
                                <td>${response.grn.invoice_number}</td>
                                <td>${response.grn.net_total_amount}</td>
                                <td>${paid_amount}</td>
                                <td>${RemainingAmount}</td>
                            </tr>
                        `);
                    }
                })


                $("#paid_amount").on("keyup", function() {
                    if ($("#paid_amount").val() !== '' && $("#paid_date").val() !== '' && $(
                            "#comments")
                        .val() !== '') {
                        $("#submitBtn").attr("disabled", false);
                    } else {
                        $("#submitBtn").attr("disabled", true);
                    }
                });

                $("#paid_date").on("change", function() {
                    if ($("#paid_amount").val() !== '' && $("#paid_date").val() !== '' && $(
                            "#comments")
                        .val() !== '') {
                        $("#submitBtn").attr("disabled", false);
                    } else {
                        $("#submitBtn").attr("disabled", true);
                    }
                });

                $("#comments").on("keyup", function() {
                    if ($("#paid_amount").val() !== '' && $("#paid_date").val() !== '' && $(
                            "#comments")
                        .val() !== '') {
                        $("#submitBtn").attr("disabled", false);
                    } else {
                        $("#submitBtn").attr("disabled", true);
                    }
                });

            });

        });
    </script>
@endsection
