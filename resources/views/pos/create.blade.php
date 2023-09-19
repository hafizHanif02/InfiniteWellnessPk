@extends('layouts.app')
@section('title')
    {{ __('messages.bill.pos') }}
@endsection
@section('content')
    @if ($errors->any())
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
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="pos_id">INV #</label>
                                <input type="number" name="pos_id" id="pos_id" class="form-control"
                                value="{{ ($pos_id ? $pos_id : 1210) + 1 }}" required readonly title="Invoice Number">
                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="col-md-6">
                                    <label for="mr_number">MR No.</label>
                                    <select class="form-control" name="paitent_id" id="paitent_id">
                                        @foreach ($patients as $patient)
                                            <option value="" selected disabled>Select Patient MR#</option>
                                            <option value="{{ $patient->id }}">{{ $patient->id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="prescription_id">Prescription</label>
                                <select name="prescription_id" id="prescription_id" class="form-control">
                                    <option value="" selected disabled>Select MR# First</option>
                                </select>
                                @error('prescription_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="patient_name">Patient Name<sup class="text-danger">*</sup></label>
                                <input type="text" name="patient_name"  id="patient_name" class="form-control"
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
                                <label for="pos_date" class="form-label">POS Date <sup class="text-danger">*</sup></label>
                                <input type="date" readonly name="pos_date" id="pos_date" class="form-control"
                                    value="{{ old('pos_date', date('Y-m-d')) }}" title="Supply date">
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
                                    <button type="button" onclick="Addmore()" class="btn btn-primary">Add More</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bodered table-medicine" id="able-medicine">
                                    <thead class="bg-dark">
                                        <th class="col" style="min-width: 200px">Product</th>
                                        <th class="col" style="min-width: 200px">Generic Formula</th>
                                        <th class="col" style="min-width: 200px">Rmaining Quantity</th>
                                        <th class="col" style="min-width: 200px">MRP Per Unit</th>
                                        <th class="col" style="min-width: 200px">Dosage</th>
                                        <th class="col" style="min-width: 200px">Discount Percentage</th>
                                        <th class="col" style="min-width: 200px">GST %</th>
                                        <th class="col" style="min-width: 200px">Time</th>
                                        <th class="col" style="min-width: 200px">Comment</th>
                                        <th class="col" style="min-width: 200px">Price</th>
                                        <th class="col" style="min-width: 200px">Generate Label</th>
                                        <th class="col" style="min-width: 200px">View Label</th>
                                        <th></th>
                                        <th></th>
                                    </thead>
                                    <tbody class="" id="medicine-table-body">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mb-5 mt-5">
                            <div class="col-md-6">
                                <label for="total_saletax">Total Sale Tax</label>
                                <input type="number" class="form-control" id="total_saletax" name="total_saletax" readonly value="0">
                            </div>
                            <div class="col-md-6">
                                <label for="total_discount">Total Discount</label>
                                <input type="number" class="form-control" id="total_discount" name="total_discount" readonly
                                    value="0">
                            </div>
                        </div>
                        <div class="row mb-5 mt-5">
                            <div class="col-md-6">
                                <label for="total_amount_ex_aletax">Total Amount Exclusive Sale Tax</label>
                                <input type="number" class="form-control" id="total_amount_ex_aletax" name="total_amount_ex_aletax" readonly
                                    value="0">
                            </div>
                            <div class="col-md-6">
                                <label for="total_amount_inc_saletax">Total Amount Inclusive Sale Tax</label>
                                <input type="number" class="form-control" id="total_amount_inc_saletax" name="total_amount_inc_saletax" readonly
                                    value="0">
                            </div>
                        </div>

                        <div class="row mt-9 mb-9 row">
                            <div class="col-md-6">
                                <label for="pos_fees">FBR POS Fees</label>
                                <input type="number" class="form-control" id="pos_fees" name="pos_fees" readonly
                                     placeholder="Total Price" value="1">
                                <input type="hidden" id="pos_fees">
                            </div>
                            <div class="col-md-6">
                                <label for="total_amount">Grand Total Amount</label>
                                <input type="number" class="form-control" id="total_amount" name="total_amount" readonly
                                    value="0" placeholder="Total Price">
                                <input type="hidden" id="total_amount2">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-success">Proceed To Pay</button>
                        </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Generate Label</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('label.store') }}" method="POST">
                    @csrf
                <div class="modal-body">
                    <div class="row m-5">
                        <div class="mb-5">
                            <label>INV#</label>
                            <input type="text" id="pos_id_label" name="pos_id" readonly class="form-control">
                        </div>
                        <div class="mb-5">
                            <label>Patient Name</label>
                            <input type="text" id="patient_name_label" name="patient_name" readonly class="form-control">
                        </div>
                        <div class="mb-5">
                            <label>Medicine Name</label>
                            <input type="text" name="name" id="medicine_name_label" readonly class="form-control">
                            <input type="hidden" name="medicine_id" id="medicine_id_label" readonly class="form-control">
                        </div>
                        <div class="mb-5">
                            <label>Brand Name</label>
                            <input type="text" name="brand_name" id="brand_name_label" readonly class="form-control">
                            <input type="hidden" name="brand_id" id="brand_id_label" readonly class="form-control">
                        </div>
                        <div class="mb-5">
                            <label>Total Quantity</label>
                            <input type="text" name="quantity" id="quantity_label" readonly class="form-control">
                        </div>
                        <div class="mb-5">
                            <label>Date Of Selling</label>
                            <input type="text" name="date_of_selling" id="date_of_selling_label" readonly class="form-control">
                        </div>
                        <div class="mb-5">
                            <label>Dricetion Of Use </label>
                            <input type="text" name="direction_use" id="direction_use_label" class="form-control">
                        </div>
                        <div class="mb-5">
                            <label>Common Side Effect</label>
                            <input type="text" name="common_side_effect" id="common_side_effect_label" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="save_label" class="btn btn-primary" >Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#paitent_id').select2();
            $('.medicine-select').select2();

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
                // console.log(selectedMedicineData);
            });

            $("#prescription_id").change(function() {
                var selectedOption = $(this).find(":selected");
                var selectedMedicinesAttr = selectedOption.data("medicines");
                var selectedPatientAttr = selectedOption.data("patient");
                // console.log(selectedMedicinesAttr);
                $("#medicine-table-body").empty(); // Clear existing rows

                var total = 0;

                selectedMedicinesAttr.forEach(function(medicine, items) {
                    var row = `
                <tr scope="row" id="medicine-row${items}">
                    <input type="hidden" name="products[${items}][medicine_id]" value="${medicine.id}">
                    <td><input type="text" class="form-control" readonly value="${medicine.medicine.name}" name="products[${items}][product_name]" placeholder="item name" id="medicine${items}" data-medicine_id="${medicine.medicine.id}" data-medicine_name="${medicine.medicine.name}" data-brand_name="${medicine.medicine.brand.name}" data-brand_id="${medicine.medicine.brand.id}" data-sellingPrice="${medicine.medicine.selling_price}" data-Id="${medicine.medicine.id}" data-totalQuantity="${medicine.medicine.total_quantity}" data-totalPrice="${medicine.medicine.selling_price}"></td>
                    <td><input type="text" class="form-control" readonly value="${medicine.medicine.generic}" name="products[${items}][generic_formula]""></td>
                    <td><span>${medicine.medicine.total_quantity}</span></td>
                    <td><span>${medicine.medicine.selling_price}</span></td>
                    <td><input type="text" class="form-control" readonly id="dosage${items}" value="${medicine.dosage}" name="products[${items}][product_quantity]" placeholder="dosage"></td>
                    <td><input type="text" class="form-control" readonly id="mrp_perunit${items}" value="${medicine.selling_price}" name="products[${items}][mrp_perunit]" placeholder="mrp perunit"></td>
                    <td><input type="number" onkeyup="discountCalculation(${items})" id="discount_percentage${items}" value="0" class="form-control"  name="products[${items}][discount_percentage]" ></td>
                    <td><input type="number" onkeyup="gstCalculation(${items})" id="gst_percentage${items}" value="0" class="form-control"  name="products[${items}][gst_percentage]" ></td>
                    <td><input type="text" class="form-control" readonly value="${medicine.time == 0 ? 'Before Meal' : 'After Meal'}" placeholder="Before/After Meal"></td>
                    <td><input type="text" class="form-control" readonly value="${medicine.comment}" placeholder="Comment"></td>
                    <td><input type="text" class="form-control"  name="products[${items}][product_total_price]" id="product_total_price${items}" readonly value="${(medicine.medicine.selling_price) * medicine.dosage}" placeholder="selling_price"></td>
                    <input type="hidden" class="form-control"  name="products[${items}][product_total_price2]" id="product_total_price2${items}" readonly value="${(medicine.medicine.selling_price) * medicine.dosage}" placeholder="selling_price">
                    <td><button type="button" class="btn btn-primary" onclick="Addlabelforprescription(${items})" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Label</button></td>
                    <td><a href="{{route('label.show',1) }}"><i class="fa fa-eye"></i></a></td>
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
            $('#medicine' + a).select2();
            $('#medicine-table-body').append(`
   
    <tr id="medicine-row${a}">
                        <td>
                            <input type="hidden" id="medicineID${a}" name="products[${a}][medicine_id]">
                            <select name="products[${a}][product_name]" class="form-control medicine-select" id="medicine${a}" onchange="SelectMedicine(${a})" class="form-select prescriptionMedicineId">
                                <option value="" selected disabled>Select Medicine</option>
                                @foreach ($medicines as $medicine)
                                    <option value=" {{ $medicine->id }}" data-medicine_name="{{ $medicine->name }}" data-medicine_id="{{ $medicine->id }}" data-generic_formula="{{$medicine->generic_formula}}" data-brand_name="{{$medicine->brand->name}}" data-brand_id="{{$medicine->brand->id}}" data-sellingPrice="{{ $medicine->selling_price }}" data-Id="{{ $medicine->id }}" data-totalQuantity="{{ $medicine->total_quantity }}" data-totalPrice={{ $medicine->selling_price }}>
                                        {{ $medicine->name }}
                                    </option>
                                    @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" readonly  name="products[${a}][generic_formula]" id="generic_formula${a}" class="form-control">
                        </td>
                        <td>
                            <input type="number" readonly value="0"  id="total_quantity${a}" class="form-control">
                        </td>
                        <td>
                            <input type="number" readonly  name="products[${a}][mrp_perunit]" id="selling_price${a}" class="form-control">
                        </td>
                        <td>
                            <input type="number"  value="1" name="products[${a}][product_quantity]" id="dosage${a}" class="form-control" onkeyup="ChnageDosage(${a})">
                        </td>
                        <td>
                            <input type="number"  value="0" name="products[${a}][discount_percentage]" id="discount_percentage${a}" class="form-control" onkeyup="discountCalculation(${a})">
                            <input type="hidden" value="0" readonly  name="products[${a}][discount_amount]" id="discount_amount${a}" class="form-control">
                            <input type="hidden" value="0" readonly  name="products[${a}][discount_amount]" id="discount_amount2${a}" class="form-control">
                        </td>
                        <td>
                            <input type="number" value="0"  name="products[${a}][gst_percentage]" id="gst_percentage${a}" class="form-control" onkeyup="gstCalculation(${a})">
                            <input type="hidden" value="0" readonly  name="products[${a}][gst_amount]" id="gst_amount${a}" class="form-control">
                            <input type="hidden" value="0" readonly  name="products[${a}][gst_amount]" id="gst_amount2${a}" class="form-control">
                        </td>
                        <td>
                            {{ Form::select('time[]', \App\Models\Prescription::MEAL_ARR, null, ['class' => 'form-select prescriptionMedicineMealId']) }}
                        </td>
                        <td>
                            {{ Form::textarea('comment[]', null, ['class' => 'form-control', 'rows' => 1]) }}
                        </td>
                        <td>
                            <input type="number" value="0" name="products[${a}][product_total_price]" id="product_total_price${a}" readonly class="form-control">
                            <input type="hidden" value="0" id="product_total_price2${a}" readonly class="form-control">
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" onclick="Addlabel(${a})" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Add Label
                            </button>
                        </td>
                        <td><button type="button" id="labelprintbtn${a}" disabled class="btn btn-success" id="labelshow${a}"><a id="anchorlabel${a}" target="_blank"  style="text-decoration:none;color:white;""><i class="fa fa-eye"></i>View</button></a></td>
                        <td class="text-center">
                            <a href="javascript:void(0)" title=" {{ __('messages.common.delete') }}"
                            class="delete-prescription-medicine-item btn px-1 text-danger fs-3 pe-0">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                        <td>
                            
                        </td>
                        
                    </tr> 
    `);
        }

        function SelectMedicine(id) {
            const selectMedicine = document.getElementById('medicine' + id);
            const totalQuantitySpan = document.getElementById('total_quantity' + id);

            const sellingpriceTag = document.getElementById('selling_price' + id);
            var totalMedicineAmount = document.getElementById('product_total_price' + id);
            var totalMedicineAmount2 = document.getElementById('product_total_price2' + id);
            var medicineID = document.getElementById('medicineID' + id);
            var genericformulatag = document.getElementById('generic_formula' + id);

            const selectedOption = selectMedicine.options[selectMedicine.selectedIndex];
            const totalQuantity = selectedOption.getAttribute('data-totalQuantity');
            const totalPrice = selectedOption.getAttribute('data-totalPrice');
            const MedicineId = selectedOption.getAttribute('data-Id');
            const GenericFormula = selectedOption.getAttribute('data-generic_formula');
            const sellingPriceValue = selectedOption.getAttribute('data-sellingPrice');

            totalQuantitySpan.value = totalQuantity;
            totalMedicineAmount.value = totalPrice;
            totalMedicineAmount2.value = totalPrice;
            medicineID.value = MedicineId;
            sellingpriceTag.value = sellingPriceValue;
            genericformulatag.value = GenericFormula;

        }
        function ChnageDosage(id) {
                var Dosage = $('#dosage' + id).val();
                var PricePerUnit = $('#selling_price' + id).val();
                var TotalCost = parseFloat($('#total_amount').val());
                var TotalMedicineCost = (Dosage * PricePerUnit);
                $('#product_total_price'+id).val(TotalMedicineCost);
                $('#product_total_price2'+id).val(TotalMedicineCost)
                ChnageDosageTotal(id);
            }

            function ChnageDosageTotal() {
                var TotalAmount = 0;
                $("input[id^='product_total_price2']").each(function() {
                    if($(this).val() != ''){
                        TotalAmount += parseFloat($(this).val());
                        console.log('TotalAMount'+TotalAmount);
                    }
                });
                $('#total_amount').val(TotalAmount);
                $('#total_amount2').val(TotalAmount);
            }

     

          

            function discountCalculation(id) {
            var discount_percentage = $('#discount_percentage' + id).val();
            var totalMedicineCalculatedAmount = $('#product_total_price' + id).val();
            var totalMedicineAmount = $('#product_total_price2' + id).val();
            var discount_amount = ((discount_percentage * totalMedicineAmount )/ 100).toFixed(2);
            var totalMedicineAmountwithDisc = (parseFloat(totalMedicineAmount) - parseFloat(discount_amount) ).toFixed(2);
             $('#discount_amount'+id).val(discount_amount);
             $('#discount_amount2'+id).val(discount_amount);
             $('#product_total_price'+id).val(totalMedicineAmountwithDisc);
             $('#product_total_price2'+id).val(totalMedicineAmountwithDisc);
             discountCalculationTotal();
        }

        function discountCalculationTotal(){
            var discount_amount2 = 0;
            var amountwithouttax = 0;
                $("input[id^='discount_amount2']").each(function() {
                    if($(this).val() != ''){
                        discount_amount2 += parseFloat($(this).val());
                    }
                });
                $("input[id^='product_total_price2']").each(function() {
                    if($(this).val() != ''){
                        amountwithouttax += parseFloat($(this).val());
                    }
                });
                $('#total_amount_ex_aletax').val(amountwithouttax);
                $('#total_discount').val(discount_amount2);
        }



        function gstCalculation(id) {
            var gst_percentage = $('#gst_percentage' + id).val();
            var totalMedicineCalculatedAmount = $('#product_total_price' + id).val();
            var totalMedicineAmount = $('#product_total_price2' + id).val();
            var gst_amount = ((gst_percentage * totalMedicineCalculatedAmount )/ 100).toFixed(2);
            var totalMedicineAmountwithGst = (parseFloat(gst_amount) + parseFloat(totalMedicineAmount)).toFixed(2);
            console.log(totalMedicineAmountwithGst);
             $('#gst_amount'+id).val(gst_amount);
             $('#gst_amount2'+id).val(gst_amount);
             $('#product_total_price'+id).val(totalMedicineAmountwithGst);
             $('#product_total_price'+id).val(totalMedicineAmountwithGst);
            gstCalculationTotal();
        }

        function gstCalculationTotal(){
            var Totalgstamount = 0;
            var TotalWithTax = 0;
                $("input[id^='gst_amount2']").each(function() {
                    if($(this).val() != ''){
                        Totalgstamount += parseFloat($(this).val());
                    }
                });
                $("input[id^='product_total_price2']").each(function() {
                    if($(this).val() != ''){
                        TotalWithTax += parseFloat($(this).val());
                    }
                });
                $('#total_saletax').val(Totalgstamount);
                $('#total_amount_inc_saletax').val(TotalWithTax);
        }


        

        function Addlabel(id){
            $('#save_label').attr('onclick', 'AlertLabel(' + id + ')');
            var pos_id = $('#pos_id').val();
            $('#pos_id_label').val(pos_id);
            var paitentName = $('#patient_name').val();
            $('#patient_name_label').val(paitentName);

            const selectMedicine = document.getElementById('medicine'+id);
            const MedicineName = document.getElementById('medicine_name_label');
            const MedicineId = document.getElementById('medicine_id_label');

            
            const BrandName = document.getElementById('brand_name_label');
            const BrandIdTag = document.getElementById('brand_id_label');
            var medicineLabel_Id = document.getElementById('medicine_id_label');
            
            const selectedOption = selectMedicine.options[selectMedicine.selectedIndex];
            const medicineName = selectedOption.getAttribute('data-medicine_name');
            const medicineIDValue = selectedOption.getAttribute('data-medicine_id');
            const brandName = selectedOption.getAttribute('data-brand_name');
            const brandId = selectedOption.getAttribute('data-brand_id');
            
            console.log(medicineLabel_Id, medicineIDValue);
            var currentDate = new Date();
            var formattedDate = currentDate.toISOString().slice(0, 10);
            $('#date_of_selling_label').val(formattedDate);

            var dosage = $('#dosage'+id).val();
            $('#quantity_label').val(dosage);

            MedicineName.value = medicineName;
            MedicineId.value = medicineIDValue;
            BrandName.value = brandName;
            BrandIdTag.value = brandId;            
        }

        function Addlabelforprescription(id){
            var pos_id = $('#pos_id').val();
            $('#pos_id_label').val(pos_id);
            var paitentName = $('#patient_name').val();
            $('#patient_name_label').val(paitentName);
            const selectMedicine = document.getElementById('medicine'+id);
            const MedicineName = document.getElementById('medicine_name_label');
            const MedicineIdTag = document.getElementById('medicine_id_label');
            const BrandName = document.getElementById('brand_name_label');
            const BrandId = document.getElementById('brand_id_label');
            var medicineLabelId = document.getElementById('medicine_id_label');
            const medicineName = selectMedicine.getAttribute('data-medicine_name');
            const medicineId = selectMedicine.getAttribute('data-medicine_id');
            const brandName = selectMedicine.getAttribute('data-brand_name');
            const brandId = selectMedicine.getAttribute('data-brand_id');
            
            console.log(MedicineIdTag, medicineId);
            
            var currentDate = new Date();
            var formattedDate = currentDate.toISOString().slice(0, 10);
            $('#date_of_selling_label').val(formattedDate);

            var dosage = $('#dosage'+id).val();
            $('#quantity_label').val(dosage);

            MedicineName.value = medicineName;
            MedicineIdTag.value = medicineId;
            BrandName.value = brandName;
            BrandId.value = brandId;            
        }

        function AlertLabel(id){
            window.alert('Your Product Label Has been Generated');
            $('#labelprintbtn'+id).removeAttr('disabled');
            var pos_id = $('#pos_id').val();
            var medicine_id = $('#medicineID' + id).val();

            // Construct the URL with the values of pos_id and medicine_id
            var url = '/label/label-show/' + pos_id + '/' + medicine_id;

            $('#anchorlabel' + id).attr('href', url);
            
        }
        
        
        
    </script>
@endsection
