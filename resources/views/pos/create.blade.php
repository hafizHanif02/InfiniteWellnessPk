@extends('layouts.app')
@section('title')
    {{ __('messages.bill.pos') }}
@endsection
@section('content')
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <div class="col-md-12 mb-5 text-end">
                <a href="{{ route('pos.index') }}"><button class="btn btn-secondary">Back</button></a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Point Of Sales</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('pos.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <div class="col-md-6">
                                <label for="mr_number">MR No.</label>
                                <select class="form-control" name="paitent_id" id="paitent_id">
                                    @foreach ($patients as $patient)
                                    <option value="" selected disabled>Select Patient MR#</option>
                                        <option value="{{$patient->id }}">{{$patient->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="prescription_id">Prescription</label>
                                <select name="prescription_id" id="prescription_id" class="form-control">
                                    <option value="" selected disabled>Select MR# Frist</option>
                                        </select>
                                @error('prescription_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="patient_name">Patient Name<sup class="text-danger">*</sup></label>
                                <input type="text" name="patient_name" id="patient_name" class="form-control"
                                    placeholder="Enter Patient Name">
                                @error('patient_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <table id="paitent-data">

                            </table>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="doctor_name">Doctor Name</label>
                                <input type="text" name="doctor_name" id="doctor_name" class="form-control"
                                    placeholder="Enter Doctor Name">
                                @error('doctor_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="pos_date" class="form-label">POS Date <sup
                                        class="text-danger">*</sup></label>
                                <input type="date" readonly name="pos_date" id="pos_date" class="form-control" value="{{ old('pos_date', date('Y-m-d')) }}" title="Supply date"> 
                                @error('pos_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-10">
                            <div class="row mb-5 ">
                                <div class="col-md-8">
                                    <h4>Prescription Items</h4>
                                </div>
                                <div class="col-md-4 text-end">
                                    <button type="button" onclick="Addmore()"  class="btn btn-primary">Add More</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bodered table-medicine" id="able-medicine">
                                    <thead class="bg-dark">
                                            <th class="col" style="min-width: 200px">Product</th>
                                            <th class="col" style="min-width: 200px">Rmaining Quantity</th>
                                            <th class="col" style="min-width: 200px">MRP Per Unit</th>
                                            <th class="col" style="min-width: 200px">Dosage</th>
                                            <th class="col" style="min-width: 200px">GST %</th>
                                            <th class="col" style="min-width: 200px">Discount Percentage</th>
                                            <th class="col" style="min-width: 200px">Time</th>
                                            <th class="col" style="min-width: 200px">Comment</th>
                                            <th class="col" style="min-width: 200px">Price</th>
                                            <th></th>
                                            <th></th>
                                    </thead>
                                    <tbody class="" id="medicine-table-body">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-9 mb-9 row">
                            {{-- <div class="col-md-4">
                                <label for="total_amount">Advance Cost</label>
                                <input type="number" step="any" class="form-control" onkeyup="updateTotalPrice()" id="advance_cost" placeholder="Any Other Charges">
                            </div> --}}
                            <div class="col-md-12">
                                <label for="total_amount">Total Amount</label>
                                <input type="number" class="form-control" id="total_amount" name="total_amount" readonly value="0" placeholder="Total Price">
                                <input type="hidden" id="total_amount2">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-success">Proceed To Pay</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

$(document).ready(function() {
    $('#paitent_id').select2();

    $('#paitent_id').change(function() {
        // Fetch prescription data via AJAX
        $.ajax({
            type: "get",
            url: "/pos/prescription/list",
            data: {
                paitent_id: $(this).val()
            },
            dataType: "json",
            success: function(response) {
                $("#prescription_id").empty();

                if (response.data.length !== 0) {
                    $.each(response.data, function(index, value) {
                        console.log(value);
                        $("#prescription_id").append(
                            `
                            <option>Select Prescription </option>
                            <option value="${value.id}" data-doctor="${value.doctor.user.full_name}"  data-patient="${value.patient.user.full_name}"  data-medicines='${JSON.stringify(value.get_medicine)}'>
                                ${value.doctor.user.full_name}" To "${value.patient.user.full_name}
                            </option>`
                        );
                    });
                } else {
                    $("#prescription_id").html(
                        `<option value="" class="text-danger" selected disabled>No Prescription found!</option>`
                    );
                }
            }
        });
    });

    // Handle medicine selection
    $('#medicine-table-body').on('change', '.medicine-select', function() {
        var selectedOption = $(this).find(":selected");
        var selectedMedicineData = selectedOption.data("medicine-data");

        // Handle medicine data here...
        console.log(selectedMedicineData);
    });

    $("#prescription_id").change(function() {
        var selectedOption = $(this).find(":selected");
        var selectedMedicinesAttr = selectedOption.data("medicines");
        var selectedPatientAttr = selectedOption.data("patient");
        console.log(selectedPatientAttr);
        $("#medicine-table-body").empty(); // Clear existing rows

        var total = 0;

        selectedMedicinesAttr.forEach(function(medicine, items) {
            var row = `
                <tr scope="row" id="medicine-row">
                    <input type="hidden" name="products[${items}][medicine_id]" value="${medicine.id}">
                    <td><input type="text" class="form-control" readonly value="${medicine.medicine.name}" name="products[${items}][product_name]" placeholder="item name"></td>
                    <td><span>${medicine.medicine.total_quantity}</span></td>
                    <td><span>${medicine.medicine.selling_price}</span></td>
                    <td><input type="text" class="form-control" readonly value="${medicine.dosage}" name="products[${items}][product_quantity]" placeholder="dosage"></td>
                    <td><input type="number" onkeyup="gstCalculation(${items})" id="gst_percentage${items}" class="form-control"  name="products[${items}][gst_percentage]" ></td>
                    <td><input type="number" onkeyup="discountCalculation(${items})" id="discount_percentage${items}" class="form-control"  name="products[${items}][discount_percentage]" ></td>
                    <td><input type="text" class="form-control" readonly value="${medicine.time == 0 ? 'Before Meal' : 'After Meal'}" placeholder="Before/After Meal"></td>
                    <td><input type="text" class="form-control" readonly value="${medicine.comment}" placeholder="Comment"></td>
                    <td><input type="text" class="form-control"  name="products[${items}][product_total_price]" id="total_medicine_amount${items}" readonly value="${(medicine.medicine.selling_price) * medicine.dosage}" placeholder="selling_price"></td>
                    <td><input type="hidden" class="form-control"  name="products[${items}][product_total_price2]" id="total_medicine_amount2${items}" readonly value="${(medicine.medicine.selling_price) * medicine.dosage}" placeholder="selling_price"></td>
                    <td></td>
                </tr>`;
            $("#medicine-table-body").append(row);

            total += ((medicine.medicine.selling_price) * medicine.dosage);
        });

        $("#total_amount").val(total.toFixed(2));
        $("#total_amount2").val(total.toFixed(2));
    });
});


        const prescriptionSelect = document.getElementById('prescription_id');
        const patientInput = document.getElementById('patient_name');
        const doctorInput = document.getElementById('doctor_name');

        prescriptionSelect.addEventListener('change', function() {
            const selectedOption = prescriptionSelect.options[prescriptionSelect.selectedIndex];
            const patientName = selectedOption.getAttribute('data-patient');
            const doctorName = selectedOption.getAttribute('data-doctor');

            patientInput.value = patientName;
            doctorInput.value = doctorName;
            patientInput.readonly = true;
            doctorInput.readonly = true;

        }); 
        function updateTotalPrice() {
        var total_amount = parseFloat($("#total_amount2").val()) || 0;
        var advance_cost = parseFloat($("#advance_cost").val()) || 0;

        var grandTotal = total_amount + advance_cost;

        $("#total_amount").val(grandTotal.toFixed(2));

    }
    function Addmore() {
        var tableRow = document.getElementById('medicine-table-body');
        var a = tableRow.rows.length;
    $('#medicine-table-body').append(`
   
    <tr id="medicine-row${a}">
                        <td>
                            <input type="hidden" id="medicineID${a}" name="products[${a}][medicine_id]">
                            <select name="products[${a}][product_name]" class="form-control" id="medicine${a}" onchange="SelectMedicine(${a})" class="form-select prescriptionMedicineId">
                                <option value="" selected disabled>Select Medicine</option>
                                @foreach ($medicines as $medicine)
                                    <option value=" {{ $medicine->id }}" data-sellingPrice="{{$medicine->selling_price }}" data-Id="{{$medicine->id}}" data-totalQuantity="{{ $medicine->total_quantity }}" data-totalPrice={{$medicine->selling_price }}>
                                        {{ $medicine->name }}
                                    </option>
                                    @endforeach
                            </select>
                        </td>
                        <td>
                            <span  id="total_quantity${a}"></span>
                        </td>
                        <td>
                            <span  id="selling_price${a}"></span>
                        </td>
                        <td>
                            <input type="number"  name="products[${a}][product_quantity]" id="dosage${a}" class="form-control" onkeyup="ChnageDosage(${a})">
                        </td>
                        <td>
                            <input type="number"  name="products[${a}][gst_percentage]" id="gst_percentage${a}" class="form-control" onkeyup="gstCalculation(${a})">
                        </td>
                        <td>
                            <input type="number"  name="products[${a}][discount_percentage]" id="discount_percentage${a}" class="form-control" onkeyup="discountCalculation(${a})">
                        </td>
                        <td>
                            {{ Form::select('time[]', \App\Models\Prescription::MEAL_ARR, null,['class' => 'form-select prescriptionMedicineMealId']) }}
                        </td>
                        <td>
                            {{ Form::textarea('comment[]', null, ['class' => 'form-control', 'rows'=>1]) }}
                        </td>
                        <td>
                            <input type="number" name="products[${a}][product_total_price]" id="total_medicine_amount${a}" readonly class="form-control">
                            <input type="hidden" id="total_medicine_amount2${a}" readonly class="form-control">
                        </td>
                        <td class="text-center">
                            <a href="javascript:void(0)" title=" {{__('messages.common.delete')}}"
                            class="delete-prescription-medicine-item btn px-1 text-danger fs-3 pe-0">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                        <td>
                            
                        </td>
                        
                    </tr> 
    `);
}

function SelectMedicine(id){
        const selectMedicine = document.getElementById('medicine'+id);
        const totalQuantitySpan = document.getElementById('total_quantity'+id);
        const sellingpriceTag = document.getElementById('selling_price'+id);
        var totalMedicineAmount = document.getElementById('total_medicine_amount'+id);
        var totalMedicineAmount2 = document.getElementById('total_medicine_amount2'+id);
        var medicineID = document.getElementById('medicineID'+id);
        const selectedOption = selectMedicine.options[selectMedicine.selectedIndex];
        const totalQuantity = selectedOption.getAttribute('data-totalQuantity');

        const totalPrice = selectedOption.getAttribute('data-totalPrice');
        const MedicineId = selectedOption.getAttribute('data-Id');
        const sellingPriceValue = selectedOption.getAttribute('data-sellingPrice');

        
        totalQuantitySpan.innerHTML = totalQuantity;
        totalMedicineAmount.value = totalPrice;
        totalMedicineAmount2.value = totalPrice;
        medicineID.value = MedicineId;
        sellingpriceTag.innerHTML = sellingPriceValue;

    }
function ChnageDosage(id){
    var totalMedicineAmount = $('#total_medicine_amount2'+id).val();
    var dosage = $('#dosage'+id).val();
    var additionalMedicineAmount = totalMedicineAmount*dosage;
    $('#total_medicine_amount'+id).val(additionalMedicineAmount);
    var total_amount = $('#total_amount2').val();
    if(total_amount != 0){
        $('#total_amount').val(parseFloat(additionalMedicineAmount)+parseFloat(total_amount));
    }
    else{
        $('#total_amount').val(parseFloat(additionalMedicineAmount));

    }
    console.log(totalMedicineAmount,dosage,additionalMedicineAmount );
}

function gstCalculation(id){
    var gst_percentage = $('#gst_percentage'+id).val();
    var totalMedicineCalculatedAmount = $('#total_medicine_amount2'+id).val();
    var totalMedicineAmount = $('#total_medicine_amount'+id).val();
    var gst_amount = (gst_percentage*totalMedicineCalculatedAmount/100).toFixed(2);
    console.log(gst_amount);
    $('#total_medicine_amount'+id).val((parseFloat(gst_amount)+parseFloat(totalMedicineAmount)).toFixed(2));
    var total_amount = $('#total_amount').val();
    console.log(total_amount+gst_amount);

    if(total_amount != 0){
        $('#total_amount').val((parseFloat(total_amount)+parseFloat(gst_amount)).toFixed(2));
    }
    else{
        $('#total_amount').val(parseFloat(total_amount));

    }
}
function discountCalculation(id){
    var discount_percentage = $('#discount_percentage'+id).val();
    var totalMedicineCalculatedAmount = $('#total_medicine_amount2'+id).val();
    var totalMedicineAmount = $('#total_medicine_amount'+id).val();
    var discount_amount = (discount_percentage*totalMedicineCalculatedAmount/100).toFixed(2);
    console.log(discount_amount);
    $('#total_medicine_amount'+id).val((parseFloat(discount_amount)-parseFloat(totalMedicineAmount)).toFixed(2));
    var total_amount = $('#total_amount').val();
    console.log(total_amount-discount_amount);

    if(total_amount != 0){
        $('#total_amount').val((parseFloat(total_amount)+parseFloat(discount_amount)).toFixed(2));
    }
    else{
        $('#total_amount').val(parseFloat(total_amount));

    }
}

    </script>
@endsection
