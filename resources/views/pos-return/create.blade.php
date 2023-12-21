@extends('layouts.app')
@section('title')
    Pos Return
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
                <a href="{{ route('pos.index') }}"><button class="btn btn-secondary">Back</button></a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Point Of Sales</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('pos-return.store') }}" method="post">
                        @csrf
                        <div class="row mb-5 mt-5">
                            <div class="col-md-6">
                                <label for="pos_id">Select POS</label>
                                <select class="form-control" name="pos_id" id="pos_id">
                                    <option value="" selected disabled>Select Pos fro Return</option>
                                    @foreach ($poses as $pos)
                                        <option value="{{ $pos->id }}" data-pos_date="{{ $pos->pos_date }}"
                                            data-patient="{{ $pos->patient_name }}" data-product="{{ $pos->PosProduct }}">
                                            {{ $pos->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="patient_name">Patient Name<sup class="text-danger">*</sup></label>
                                <input type="text" readonly name="patient_name" id="patient_name" class="form-control"
                                    placeholder="Select POS">
                                @error('patient_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="pos_date" class="form-label">POS Date <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" placeholder="Select POS First" readonly
                                    name="pos_date" id="pos_date">
                                @error('pos_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="mt-10">
                            <div class="row mb-5 ">
                                <div class="col-md-8">
                                    <h4>Pos Items</h4>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bodered table-medicine" id="able-medicine">
                                    <thead class="bg-dark">
                                        <th class="col">Product</th>
                                        <th class="col">Batch</th>
                                        <th class="col">Generic Formula</th>
                                        <th class="col">Qty</th>
                                        <th class="col">MRP Per Unit</th>
                                        <th class="col">Return Quantity</th>
                                        <th class="col">Discount</th>
                                        <th class="col">Return Cost</th>
                                        <th></th>
                                    </thead>
                                    <tbody class="" id="medicine-table-body">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row md-5 mt-5">
                            <div class="col-md-6">  
                                <label for="pos_fee">POS Fees</label>
                                <input type="number" class="form-control" value="1" id="pos_fee" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="total-amount">Total Return Amount</label>
                                <input type="number" class="form-control" readonly id="total_amount" name="total_amount">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mb-5 mt-5">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#pos_id').select2();
            $("#pos_id").change(function() {
                var selectedOption = $(this).find(":selected");
                var selectedPosProductAttr = selectedOption.data("product");
                console.log(selectedPosProductAttr);
                var selectedPatientAttr = selectedOption.data("patient");
                var selectedPosDateAttr = selectedOption.data("pos_date");
                $('#patient_name').val(selectedPatientAttr);
                $('#pos_date').val(selectedPosDateAttr);

                $("#medicine-table-body").empty();
                selectedPosProductAttr.forEach(function(medicine, items) {
                    var row = `
                <tr scope="row" id="medicine-row${items}">
                    <input type="hidden" value="${medicine.medicine.id}" name="products[${items}][medicine_id]">
                    <input type="hidden" value="${medicine.id}" name="products[${items}][product_id]">
                    <td><input type="text" class="form-control" value="${medicine.medicine.name}" name="products[${items}][product_name]" readonly ></td>
                    <td>
                        <input type="hidden" class="form-control" value="${(medicine.batchpos)?medicine.batchpos.id:''}"  placeholder="" name="products[${items}][batch_id]" readonly >
                        <input type="text" class="form-control" value="${(medicine.batchpos)?medicine.batchpos.batch.batch_no:''}" readonly >
                        </td>
                    <td><input type="text" class="form-control" value="${medicine.medicine.generic_formula}" name="products[${items}][generic_formula]" readonly ></td>
                    <td><input type="number" class="form-control" value="${medicine.product_quantity}" readonly ></td>
                    <td><input type="number"  class="form-control" name="products[${items}][mrp_perunit]" value="${medicine.mrp_perunit}" id="mrp_perunit${items}" readonly ></td>
                    <td><input type="number"  class="form-control" id="return_quantity${items}" value="0" max=${medicine.product_quantity} oninput="chnagequantity(${items})" name="products[${items}][return_quantity]" ></td>
                    <td><input type="number"  class="form-control" id="discount_percentage${items}" value="${medicine.discount_percentage}" name="products[${items}][discount_percentage]" readonly ></td>
                    <td><input type="number"  class="form-control" value="0"  id="product_total_price${items}" name="products[${items}][product_total_price]" readonly >
                        <input type="hidden"  class="form-control" value="0"  id="product_total_price2${items}" name="products[${items}][product_total_price2]" readonly >
                        <input type="hidden"  class="form-control" value="${medicine.product_total_price}"  id="total_cost${items}" name="products[${items}][total_cost]" readonly >

                       </td>
                </tr>`;
                    $("#medicine-table-body").append(row);


                });

                $('#total_amount').val(0);


            });
        });

        // function chnagequantity(id){
        //     var return_quantity = $('#return_quantity'+id).val();
        //     var price_per_unit = $('#mrp_perunit'+id).val();
        //     var total_cost = $('#total_cost'+id).val();
        //     var ReturnAmount = return_quantity * total_cost;
        //     // var ReturnAmount = return_quantity * price_per_unit;
        //     $('#product_total_price'+id).val(ReturnAmount);
        //     $('#product_total_price2'+id).val(ReturnAmount);
        //     totalAmount();
        //   }
        function chnagequantity(id) {
            var return_quantity = $('#return_quantity' + id).val();
            var discount_percentage = $('#discount_percentage' + id).val();
            var price_per_unit = $('#mrp_perunit' + id).val();
            var ReturnAmount = price_per_unit * return_quantity;
            var discountAmount = (ReturnAmount * discount_percentage) / 100;
            discountAmount = discountAmount.toFixed(2);
            var totalProductAmount = ReturnAmount - discountAmount;
            var totalProductAmount = totalProductAmount.toFixed(2);

            $('#product_total_price' + id).val(totalProductAmount);
            // $('#product_total_price2' + id).val(totalProductAmount);
            totalAmount(); 
        }


        function totalAmount() {
            var TotalAmount = 0;
            $("input[id^='product_total_price']").each(function() {
                if ($(this).val() != '') {
                    TotalAmount += parseFloat($(this).val());
                }
            });
            console.log(TotalAmount);
            pos_fee = parseFloat($('#pos_fee').val());
            TotalAmount = TotalAmount + pos_fee;
            $('#total_amount').val(TotalAmount.toFixed(2));

        }





        // const prescriptionSelect123 = document.getElementById('prescription_id');
        // const patientInput123 = document.getElementById('patient_name');
        // const doctorInput123 = document.getElementById('doctor_name');

        // prescriptionSelect123.addEventListener('change', function() {
        //     const selectedOption = prescriptionSelect123.options[prescriptionSelect123.selectedIndex];
        //     const patientName = selectedOption.getAttribute('data-patient');
        //     const doctorName = selectedOption.getAttribute('data-doctor');

        //     patientInput123.value = patientName;
        //     doctorInput123.value = doctorName;
        //     patientInput123.readonly = true;
        //     doctorInput123.readonly = true;

        // });
    </script>
    <script>
        // Use JavaScript to set the value to an empty string
        document.querySelector('input[name="products[${items}][batch_id]"]').value = '';
    </script>
@endsection
