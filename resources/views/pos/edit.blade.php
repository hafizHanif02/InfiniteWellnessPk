@extends('layouts.app')
@section('title')
    Pos Edit
@endsection
@section('content')

    <div class="container-fluid">
        <div class="row">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
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
                    <form action="{{ route('pos.update', $pos->id) }}" id="possubmitform" onsubmit="return false;"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="pos_id">INV #</label>
                                <input type="number" step="any"name="pos_id" id="pos_id" class="form-control"
                                    value="{{ $pos->id }}" required readonly title="Invoice Number">
                            </div>
                            <div class="col-md-6">
                                <label for="cashier_name">Cashier Name</label>
                                <input type="text" id="cashier_name" name="cashier_name" value="{{ $pos->cashier_name }}"
                                    placeholder="Enter Cashier Name" class="form-control">
                                @error('cashier_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 mt-3">
                            <div class="col-md-6">
                                <label for="patient_mr_number">MR No.</label>
                                <input type="text" id="patient_mr_number" name="patient_mr_number" readonly
                                    value="{{ $pos->patient_mr_number }}" class="form-control">
                                @error('patient_mr_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="prescription_id">Prescription</label>
                                <input type="text" id="prescription_id" name="prescription_id" readonly
                                    value="{{ $pos->prescription_id }}" class="form-control">
                                {{-- <select name="prescription_id" id="prescription_id" class="form-control">
                                    <option value="{{ $pos->prescription_id }}" selected disabled>{{ $pos->prescription }}</option>
                                </select> --}}
                                @error('prescription_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="patient_name">Patient Name<sup class="text-danger">*</sup></label>
                                <input type="text" name="patient_name" readonly value="{{ $pos->patient_name }}"
                                    id="patient_name" class="form-control" placeholder="Enter Patient Name">
                                @error('patient_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="patient_name">Contact Number<sup class="text-danger">*</sup></label>
                                <input type="text" name="patient_number" readonly value="{{ $pos->patient_number }}"
                                    id="patient_number" class="form-control" placeholder="Enter Patient Number">
                                @error('patient_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <table id="paitent-data">

                            </table>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="doctor_name" class="form-label">Doctor Name</label>
                                <input type="text" name="doctor_name" value="{{ $pos->doctor_name }}" id="doctor_name"
                                    class="form-control" placeholder="Enter Doctor Name">
                                @error('doctor_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="pos_date" class="form-label">POS Date <sup class="text-danger">*</sup></label>
                                <input type="date" readonly name="pos_date" id="pos_date" class="form-control"
                                    value="{{ $pos->pos_date }}" title="Supply date">
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
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#advancesearch" onclick="disablemainbutton()">Advance
                                        Search</button>
                                </div>
                            </div>

                            {{-- Model --}}
                            <div id="advancesearch" class="modal fade" role="dialog" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="groupModalLabel">Advance Search</h3>
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#advancesearch"
                                                class="btn-close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input id="myInput" class="form-control" type="text"
                                                placeholder="Search..">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td>Product</td>
                                                        <td>Generic Fromula</td>
                                                        <td>Barcode</td>
                                                        <td>Action</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="myTable">

                                                    @foreach ($medicines as $medicine)
                                                        <tr>
                                                            <td>{{ $medicine->name }}</td>
                                                            <td>{{ $medicine->generic_formula }}</td>
                                                            <td>{{ $medicine->barcode }}</td>
                                                            <td><button class="btn btn-success" type="button"
                                                                    onclick="addMedicine({{ $medicine->id }})"><i
                                                                        class="fa fa-plus"></i></button>
                                                                <input type="hidden"
                                                                    id="search_addbtn{{ $medicine->id }}"
                                                                    data-product_id="{{ $medicine->id }}"
                                                                    data-product_name="{{ $medicine->name }}"
                                                                    data-generic_formula="{{ $medicine->generic_formula }}"
                                                                    data-total_quantity="{{ $medicine->total_quantity }}"
                                                                    data-selling_price="{{ $medicine->product->unit_retail }}"
                                                                    data-brand_name="{{ $medicine->brand->name }}"
                                                                    data-brand_id="{{ $medicine->brand->id }}"
                                                                    data-gst="{{ $medicine->product->sale_tax_percentage }}"
                                                                    data-batch_pos="{{ json_encode($medicine->batchpos) }}"
                                                                    data-fixed_discount="{{ $medicine->product->fixed_discount }}"
                                                                    data-dricetion_of_use="{{ $medicine->product->dricetion_of_use }}"
                                                                    data-common_side_effect="{{ $medicine->product->common_side_effect }}">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End Model --}}

                            <div class="table-responsive">
                                <table class="table table-bodered table-medicine" id="able-medicine">
                                    <thead class="bg-dark">
                                        <th class="col" style="min-width: 200px">Product</th>
                                        <th class="col" style="min-width: 200px">Batch</th>
                                        <th class="col" style="min-width: 130px">Qty OH</th>
                                        <th class="col" style="min-width: 130px">MRP Per Unit</th>
                                        <th class="col" style="min-width: 130px">Qty</th>
                                        <th class="col" style="min-width: 130px">DST %</th>
                                        <th class="col" style="min-width: 130px">GST %</th>
                                        <th class="col" style="min-width: 130px">Amount</th>
                                        <th class="col" style="min-width: 130px">Generate Label</th>
                                        <th></th>
                                        <th></th>
                                    <tbody class="" id="medicine-table-body">
                                        @foreach ($pos->PosProduct as $posProduct)
                                            <tr id="{{ $posProduct->id }}">
                                                <td>
                                                    <input type="hidden" id="medicineID{{ $loop->iteration }}"
                                                        value="{{ $posProduct->medicine_id }}"
                                                        name="products[{{ $loop->iteration }}][medicine_id]">
                                                    <select name="products[{{ $loop->iteration }}][product_name]"
                                                        class="form-control  medicine-select medicine_name{{ $loop->iteration }}"
                                                        id="medicine{{ $loop->iteration }}"
                                                        onchange="SelectMedicine({{ $loop->iteration }})"
                                                        class="form-select prescriptionMedicineId">
                                                        <option value="{{ $posProduct->medicine->name }}" selected
                                                            data-medicine_name="{{ $medicine->name }}"
                                                            data-medicine_id="{{ $medicine->id }}"
                                                            data-gst="{{ $medicine->product != null ? $medicine->product->sale_tax_percentage : '' }}"
                                                            data-fixed_discount="{{ $medicine->product != null ? $medicine->product->fixed_discount : '' }}"
                                                            data-generic_formula="{{ $medicine->generic_formula }}"
                                                            data-brand_name="{{ $medicine->brand->name }}"
                                                            data-brand_id="{{ $medicine->brand->id }}"
                                                            data-sellingPrice="{{ $medicine->selling_price }}"
                                                            data-Id="{{ $medicine->id }}"
                                                            data-totalQuantity="{{ $medicine->total_quantity }}"
                                                            data-totalPrice={{ $medicine->selling_price }}>
                                                            {{ $posProduct->medicine->name }}</option>
                                                        @foreach ($medicines as $medicine)
                                                            <option value="{{ $medicine->name }}"
                                                                data-medicine_name="{{ $medicine->name }}"
                                                                data-medicine_id="{{ $medicine->id }}"
                                                                data-gst="{{ $medicine->product != null ? $medicine->product->sale_tax_percentage : '' }}"
                                                                data-fixed_discount="{{ $medicine->product != null ? $medicine->product->fixed_discount : '' }}"
                                                                data-generic_formula="{{ $medicine->generic_formula }}"
                                                                data-brand_name="{{ $medicine->brand->name }}"
                                                                data-brand_id="{{ $medicine->brand->id }}"
                                                                data-sellingPrice="{{ $medicine->selling_price }}"
                                                                data-Id="{{ $medicine->id }}"
                                                                data-totalQuantity="{{ $medicine->total_quantity }}"
                                                                data-totalPrice="{{ $medicine->selling_price }}"
                                                                data-batch_pos ="{{ $medicine->batchpos }}"
                                                                {{-- data-dricetion_of_use="{{ $posProduct->medicine->product->dricetion_of_use }}"
                                                                data-common_side_effect="{{ $posProduct->medicine->product->common_side_effect }}" --}}
                                                                data-dricetion_of_use="{{ $medicine->product->dricetion_of_use }}"
                                                                data-common_side_effect="{{ $medicine->product->common_side_effect }}">
                                                                <div class="select2_generic">
                                                                    ({{ $medicine->generic_formula }})
                                                                </div>
                                                                {{ $medicine->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control"
                                                        name="products[{{ $loop->iteration }}][batch_id]"
                                                        id="batch_pos{{ $loop->iteration }}"
                                                        onchange="ChangeBatch({{ $loop->iteration }})">
                                                        @foreach ($posProduct->medicine->batchpos as $batch)
                                                            <option value="{{ $batch->id }}"
                                                                data-batch-id="{{ $batch->id }}"
                                                                data-quantity_oh="{{ $batch->quantity }}"
                                                                data-expiry-date="{{ $batch->expiry_date }}"
                                                                data-unit_retail="{{ $batch->unit_retail }}"
                                                                data-price="{{ $batch->unit_trade }}"
                                                                {{ $batch->id == $posProduct->batch_id ? 'selected' : '' }}>
                                                                {{ $batch->batch->batch_no }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                {{-- <td>
                                                <input type="text" readonly  name="products[{{ $loop->iteration }}][generic_formula]" id="generic_formula{{ $loop->iteration }}" value="{{ $posProduct->medicine->generic_formula }}" class="form-control">
                                            </td> --}}
                                                <td>
                                                    <input type="number" step="any"readonly
                                                        id="total_quantity{{ $loop->iteration }}"
                                                        name="products[{{ $loop->iteration }}][total_stock]"
                                                        value="{{ $posProduct->batchpos ? $posProduct->batchpos->quantity : $posProduct->medicine->total_quantity }}"
                                                        class="form-control">
                                                </td>
                                                <td>
                                                    <input type="number" step="any"readonly
                                                        name="products[{{ $loop->iteration }}][mrp_perunit]"
                                                        id="selling_price{{ $loop->iteration }}"
                                                        {{-- value="{{ $posProduct->batchpos ? $posProduct->batchpos->unit_retail : $posProduct->medicine->selling_price }}" --}}
                                                        value="{{ $posProduct->mrp_perunit }}"
                                                        class="form-control">
                                                </td>
                                                <td>
                                                    <input type="number" step="any"
                                                        value="{{ $posProduct->product_quantity }}"
                                                        name="products[{{ $loop->iteration }}][product_quantity]"
                                                        id="dosage{{ $loop->iteration }}" class="form-control"
                                                        oninput="ChnageDosage({{ $loop->iteration }})">
                                                </td>
                                                <td>
                                                    <input type="number" step="any"
                                                        value="{{ $posProduct->discount_percentage }}"
                                                        name="products[{{ $loop->iteration }}][discount_percentage]"
                                                        readonly id="discount_percentage{{ $loop->iteration }}"
                                                        class="form-control"
                                                        oninput="discountCalculation({{ $loop->iteration }})">
                                                    <input type="hidden" value="{{ $posProduct->discount_amount }}"
                                                        readonly name="products[{{ $loop->iteration }}][discount_amount]"
                                                        id="discount_amount{{ $loop->iteration }}" class="form-control">
                                                    <input type="hidden" value="{{ $posProduct->discount_amount }}"
                                                        readonly name="products[{{ $loop->iteration }}][discount_amount]"
                                                        id="discount_amounts2{{ $loop->iteration }}"
                                                        class="form-control">
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        step="any"value="{{ $posProduct->gst_percentage }}"
                                                        name="products[{{ $loop->iteration }}][gst_percentage]" readonly
                                                        id="gst_percentage{{ $loop->iteration }}" class="form-control">
                                                    <input type="hidden" value="{{ $posProduct->gst_amount }}" readonly
                                                        name="products[{{ $loop->iteration }}][gst_amount]"
                                                        id="gst_amount{{ $loop->iteration }}" class="form-control">
                                                    <input type="hidden" value="{{ $posProduct->gst_amount }}" readonly
                                                        name="products[{{ $loop->iteration }}][gst_amount]"
                                                        id="gst_amounts2{{ $loop->iteration }}" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        step="any"value="{{ $posProduct->product_total_price }}"
                                                        name="products[{{ $loop->iteration }}][product_total_price]"
                                                        id="product_total_price{{ $loop->iteration }}" readonly
                                                        class="form-control">
                                                    <input type="hidden" value="{{ $posProduct->product_total_price }}"
                                                        id="product_total_prices2{{ $loop->iteration }}" readonly
                                                        class="form-control">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="Addlabel({{ $loop->iteration }})"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </td>
                                                <td><a id="printlabel{{ $loop->iteration }}"><button type="button"
                                                            class="btn btn-success text-center" id="" disabled><i
                                                                class="fa-solid fa-print"></i></button></a></td>
                                                <td class="text-center">
                                                    <a
                                                        title=" {{ __('messages.common.delete') }}"  onclick="deletevalues({{ $loop->iteration }})"
                                                        class="delete-prescription-medicine-item btn px-1 text-danger fs-3 pe-0">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                                <input type="hidden"
                                                    value="{{ $posProduct->medicine->product->dricetion_of_use }}"
                                                    id="dricetion_of_use{{ $loop->iteration }}">
                                                <input type="hidden"
                                                    value="{{ $posProduct->medicine->product->common_side_effect }}"
                                                    id="common_side_effect{{ $loop->iteration }}">
                                                <td>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mb-5 mt-5">
                            <div class="col-md-6">
                                <label for="total_saletax">Total Sale Tax</label>
                                <input type="number" step="any"class="form-control" id="total_saletax"
                                    name="total_saletax" readonly value="">
                            </div>
                            <div class="col-md-6">
                                <label for="total_discount">Total Discount</label>
                                <input type="number" step="any"class="form-control" id="total_discount"
                                    name="total_discount" readonly value="">
                            </div>
                        </div>
                        <div class="row mb-5 mt-5">
                            <div class="col-md-6">
                                <label for="total_amount_ex_saletax">Total Amount Exclusive Sale Tax</label>
                                <input type="number" step="any"class="form-control" id="total_amount_ex_saletax"
                                    name="total_amount_ex_saletax" readonly value="">
                            </div>
                            <div class="col-md-6">
                                <label for="total_amount_inc_saletax">Total Amount Inclusive Sale Tax</label>
                                <input type="number" step="any"class="form-control" id="total_amount_inc_saletax"
                                    name="total_amount_inc_saletax" readonly value="">
                            </div>
                        </div>

                        <div class="row mt-9 mb-9 row">
                            <div class="col-md-6">
                                <label for="pos_fees">FBR POS Fees</label>
                                <input type="number" step="any"class="form-control" id="pos_fees" name="pos_fees"
                                    readonly placeholder="Total Price" value="1">
                                <input type="hidden" id="pos_fees">
                            </div>
                            <div class="col-md-6">
                                <label for="total_amount">Grand Total Amount</label>
                                <input type="number" step="any"class="form-control" id="total_amount"
                                    name="total_amount" readonly value="" placeholder="Total Price">
                                <input type="hidden" id="total_amounts2">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-success" type="submit" id="proceede_to_pay">Update</button>
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
                <form action="{{ route('label.store') }}" id="labelsubmitform" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row m-5">
                            <div class="mb-5">
                                <label>INV#</label>
                                <input type="text" id="pos_id_label" name="pos_id" readonly class="form-control">
                            </div>
                            <div class="mb-5">
                                <label>Patient Name</label>
                                <input type="text" id="patient_name_label" name="patient_name" readonly
                                    class="form-control">
                            </div>
                            <div class="mb-5">
                                <label>Medicine Name</label>
                                <input type="text" name="name" id="medicine_name_label" readonly
                                    class="form-control">
                                <input type="hidden" name="medicine_id" id="medicine_id_label" readonly
                                    class="form-control">
                            </div>
                            {{-- <div class="mb-5">
                                <label>Generic Formula</label>
                                <input type="text" name="brand_name" id="generic_formula_label" readonly
                                    class="form-control">
                                <input type="hidden" name="brand_id" id="brand_id_label" readonly class="form-control">
                            </div> --}}
                            <div class="mb-5">
                                <label>Total Quantity</label>
                                <input type="text" name="quantity" id="quantity_label" readonly class="form-control">
                            </div>
                            <div class="mb-5">
                                <label>Date Of Selling</label>
                                <input type="text" name="date_of_selling" id="date_of_selling_label" readonly
                                    class="form-control">
                            </div>
                            <div class="mb-5">
                                <label>Dricetion Of Use </label>
                                <input type="text" name="direction_use" readonly id="direction_use_label"
                                    class="form-control">
                            </div>
                            <div class="mb-5">
                                <label>Common Side Effect</label>
                                <input type="text" name="common_side_effect" readonly id="common_side_effect_label"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="save_label" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function disablemainbutton() {
            $('#proceede_to_pay').attr('disabled', 'true');
        }

        function enablemainbutton() {
            $('#proceede_to_pay').removeAttr('disabled');
        }

        // function submitbutton() {
        //     $('#possubmitform').removeAttr('onsubmit');
        //     $('#possubmitform').submit();
        // }

        function preventSubmit(event) {
            event.preventDefault();
        }

        $(document).ready(function() {
            $('.medicine-select').select2();


            $("#myInput").on("keyup", function() {
                if (event.key === "Enter") {
                    event.preventDefault();
                }

                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('form').on('keypress', 'input', function(e) {
                if (e.which === 13) { // 13 is the key code for "Enter"
                    e.preventDefault(); // Prevent the default form submission
                }
            });

            $('#patient_mr_number').change(function() {


                var selectElement = document.getElementById('patient_mr_number');
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                var patientName = selectedOption.getAttribute('data-patient_name');
                var patientNumber = selectedOption.getAttribute('data-patient_number');
                $('#patient_name').val(patientName);
                $('#patient_name').attr('readonly', true);
                $('#patient_number').val(patientNumber);
                $('#patient_number').attr('readonly', true);

                $.ajax({
                    type: "get",
                    url: "/pos/prescription/list",
                    data: {
                        patient_mr_number: $(this).val()
                    },
                    dataType: "json",
                    success: function(response) {
                        $("#prescription_id").empty();

                        if (response.data.length !== 0) {
                            $('#prescription_id').append(
                                `<option>Select Prescription </option>`);
                            $.each(response.data, function(index, value) {
                                (value);
                                $("#prescription_id").append(
                                    `
                            <option value="${value.id}" data-doctor="${value.doctor.user.full_name}"  data-patient="${value.patient.user.full_name}"  data-medicines='${JSON.stringify(value.get_medicine)}'>
                               (${value.patient_opd}) ${value.doctor.user.full_name}" To "${value.patient.user.full_name}
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

            $('#medicine-table-body').on('change', '.medicine-select', function() {
                var selectedOption = $(this).find(":selected");
                var selectedMedicineData = selectedOption.data("medicine-data");
            });

            $("#prescription_id").change(function() {
                var selectedOption = $(this).find(":selected");
                var selectedMedicinesAttr = selectedOption.data("medicines");
                var selectedPatientAttr = selectedOption.data("patient");
                var selectedDoctorAttr = selectedOption.data("doctor");
                (selectedMedicinesAttr);
                $("#medicine-table-body").empty();
                $('#patient_name').val(selectedPatientAttr);
                $('#doctor_name').val(selectedDoctorAttr);

                var total = 0;
                console.log(selectedMedicinesAttr);
                selectedMedicinesAttr.forEach(function(medicine, items) {
                    var row = `
                <tr scope="row" id="medicine-row${items}">
                    <input type="hidden" id="medicineID${items}" name="products[${items}][medicine_id]" value="${medicine.medicine.id}">
                    <td><input type="text" class="form-control" readonly value="${medicine.medicine.name}" name="products[${items}][product_name]" placeholder="item name" id="medicine${items}" data-medicine_id="${medicine.medicine.id}" data-medicine_name="${medicine.medicine.name}" data-brand_name="${medicine.medicine.name}" data-brand_id="${medicine.medicine.id}" data-sellingPrice="${medicine.medicine.selling_price}" data-Id="${medicine.medicine.id}" data-totalQuantity="${medicine.medicine.total_quantity}" data-generic_formula="${medicine.medicine.generic_formula}" data-totalPrice="${medicine.medicine.selling_price}"></td>
                    
                    <td>
                            <input type="number"  step="any"readonly value="${medicine.medicine.total_quantity}"  id="total_quantity${items}" class="form-control">
                        </td>
                    <td><input type="text" class="form-control" readonly id="selling_price${items}" value="${medicine.medicine.selling_price}" name="products[${items}][mrp_perunit]" placeholder="mrp perunit"></td>
                    <td><input type="text" class="form-control" readonly id="dosage${items}" value="${medicine.dosage}" name="products[${items}][product_quantity]" placeholder="dosage"></td>
                    <td>
                        <input type="number" readonly step="any"oninput="discountCalculation(${items})" id="discount_percentage${items}" value="${medicine.medicine.product.fixed_discount}" class="form-control"  name="products[${items}][discount_percentage]" >
                        <input type="hidden" value="0" readonly  name="products[${items}][discount_amount]" id="discount_amount${items}" class="form-control">
                            <input type="hidden" value="0" readonly  name="products[${items}][discount_amounts2]" id="discount_amounts2${items}" class="form-control">
                        </td>
                    <td>
                        <input type="number" readonly step="any"oninput="gstCalculation(${items})" id="gst_percentage${items}" value="${medicine.medicine.product.sale_tax_percentage}" class="form-control"  name="products[${items}][gst_percentage]" >
                        <input type="hidden" value="0" readonly  name="products[${items}][gst_amount]" id="gst_amount${items}" class="form-control">
                            <input type="hidden" value="0" readonly  name="products[${items}][gst_amounts2]" id="gst_amounts2${items}" class="form-control">
                        </td>

                    <td><input type="text" class="form-control"  name="products[${items}][product_total_price]" id="product_total_price${items}" readonly  placeholder="selling_price"></td>
                    <input type="hidden" class="form-control"  name="products[${items}][product_total_prices2]" id="product_total_prices2${items}" readonly  placeholder="selling_price">
                    <td><button type="button"  onclick="Addlabelforprescription(${items})" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-plus"></i> Label</button></td>
                    <td><a id="printlabel${items}"><button type="button" class="btn btn-success text-center" id="" disabled><i class="fa-solid fa-print"></i></button></a></td>
                    <td></td>
                </tr>`;
                    $("#medicine-table-body").append(row);

                    // total += ((medicine.medicine.selling_price) * medicine.dosage);
                    var pricerperunit = $('#selling_price' + items).val();

                    total += ((pricerperunit) * medicine.dosage);
                    gstCalculation(items);
                    ChnageDosage(items);
                    ChnageDosageTotal();
                    ChangeBatch(items);



                    var Dosage = $('#dosage' + items).val();
                    var selling_price = $('#selling_price' + items).val();
                    var product_total_price_main = Dosage * selling_price;
                    var discount_percentage = $('#discount_percentage' + items).val();
                    var product_total_price = $('#product_total_prices2' + items).val();
                    var discount_amount = (parseFloat((discount_percentage *
                        product_total_price_main) / 100)).toFixed(2);
                    var medicine__price = (parseFloat(product_total_price_main) - parseFloat(
                        discount_amount)).toFixed(2);
                    $('#product_total_price' + items).val(medicine__price);
                    $('#product_total_prices2' + items).val(medicine__price);
                    $('#discount_amount' + items).val(discount_amount);
                    $('#discount_amounts2' + items).val(discount_amount);
                    discountCalculationTotal();
                    gstCalculation(items);

                    function discountCalculationTotal() {
                        var discount_amounts2 = 0;
                        var amountwithouttax = 0;
                        $("input[id^='discount_amounts2']").each(function() {
                            if ($(this).val() != '') {
                                discount_amounts2 += parseFloat($(this).val());
                            }
                        });
                        $("input[id^='product_total_prices2']").each(function() {
                            if ($(this).val() != '') {
                                amountwithouttax += parseFloat($(this).val());

                            }
                        });
                        var TotalAmount = $('#total_amounts2').val();
                        var discount_amounts2Tofixed = discount_amounts2.toFixed(2);
                        var AmountWithDiscount = TotalAmount - discount_amounts2Tofixed;
                        var amountwithouttaxToFixed = amountwithouttax.toFixed(2);
                        $('#total_amount_ex_saletax').val(amountwithouttaxToFixed);
                        $('#total_amount_inc_saletax').val(amountwithouttaxToFixed);
                        $('#total_amount').val(parseFloat(amountwithouttaxToFixed) + 1);
                        $('#total_discount').val(discount_amounts2Tofixed);
                    }




                });

                $("#total_amount").val(total.toFixed(2));
                $("#total_amounts2").val(total.toFixed(2));

            });
            enablemainbutton();
        });


        const prescriptionSelect123 = document.getElementById('prescription_id');
        const patientInput123 = document.getElementById('patient_name');
        const doctorInput123 = document.getElementById('doctor_name');

        prescriptionSelect123.addEventListener('change', function() {
            const selectedOption = prescriptionSelect123.options[prescriptionSelect123.selectedIndex];
            const patientName = selectedOption.getAttribute('data-patient');
            const doctorName = selectedOption.getAttribute('data-doctor');

            patientInput123.value = patientName;
            doctorInput123.value = doctorName;
            patientInput123.readonly = true;
            doctorInput123.readonly = true;

        });

        function updateTotalPrice() {
            var total_amount = parseFloat($("#total_amounts2").val()) || 0;
            var advance_cost = parseFloat($("#advance_cost").val()) || 0;

            var grandTotal = total_amount + advance_cost;

            $("#total_amount").val(grandTotal.toFixed(2));

        }

        function Addmore() {
            var tableRow = document.getElementById('medicine-table-body');
            var b = tableRow.rows.length;
            var a = b + 1;
            $('#medicine' + a).select2();
            $('#medicine-table-body').append(`
           
            <tr id="medicine-row${a}">
                        <td>
                            <input type="hidden" id="medicineID${a}" name="products[${a}][medicine_id]">
                            <select style="min-width: 120px; max-width: 120px;" name="products[${a}][product_name]" class="form-control  medicine-select medicine_name${a}" id="medicine${a}"  onchange="SelectMedicine(${a})" class="form-select prescriptionMedicineId">
                                <option value="" selected disabled>Select Medicine</option>
                                @foreach ($medicines as $medicine)
                                    <option value="{{ $medicine->name }}" data-batch_pos="{{ json_encode($medicine->batchpos) }}" data-medicine_name="{{ $medicine->name }}" data-common_side_effect="{{ $medicine->product->common_side_effect }}" data-dricetion_of_use="{{ $medicine->product->dricetion_of_use }}"  data-medicine_id="{{ $medicine->id }}" data-gst="{{ $medicine->product != null ? $medicine->product->sale_tax_percentage : '' }}" data-fixed_discount="{{ $medicine->product != null ? $medicine->product->fixed_discount : '' }}" data-generic_formula="{{ $medicine->generic_formula }}" data-brand_name="{{ $medicine->brand->name }}" data-brand_id="{{ $medicine->brand->id }}" data-sellingPrice="{{ $medicine->product->unit_retail }}" data-Id="{{ $medicine->id }}" data-totalQuantity="{{ $medicine->total_quantity }}" data-totalPrice={{ $medicine->product->unit_retail }}>
                                        <div class="select2_generic">({{ $medicine->generic_formula }})</div>{{ $medicine->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td> 
                            <select name="products[${a}][batch_id]" id="batch_pos${a}" onchange="ChangeBatch(${a})" class="form-control">
                            </select>
                        <td>
                            <input type="number" step="any"readonly value="0" name="products[${a}][total_stock]"  id="total_quantity${a}" class="form-control">
                        </td>
                        <td>
                            <input type="number"  step="any"readonly  name="products[${a}][mrp_perunit]" id="selling_price${a}" class="form-control">
                        </td>
                        <td>
                            <input type="number"  step="any" value="0" name="products[${a}][product_quantity]" id="dosage${a}" class="form-control" oninput="ChnageDosage(${a})">
                        </td>
                        <td>
                            <input type="number" readonly step="any" value="0" name="products[${a}][discount_percentage]" id="discount_percentage${a}" class="form-control" oninput="discountCalculation(${a})">
                            <input type="hidden" value="0" readonly  name="products[${a}][discount_amount]" id="discount_amount${a}" class="form-control">
                            <input type="hidden" value="0" readonly  name="products[${a}][discount_amount]" id="discount_amounts2${a}" class="form-control">
                        </td>
                        <td>
                            <input type="number" readonly  step="any"value="0"  name="products[${a}][gst_percentage]" readonly id="gst_percentage${a}" class="form-control" >
                            <input type="hidden" value="0" readonly  name="products[${a}][gst_amount]" id="gst_amount${a}" class="form-control">
                            <input type="hidden" value="0" readonly  name="products[${a}][gst_amount]" id="gst_amounts2${a}" class="form-control">
                        </td>

                        <td>
                            <input type="number"  step="any"value="0" name="products[${a}][product_total_price]" id="product_total_price${a}" readonly class="form-control">
                            <input type="hidden" value="0" id="product_total_prices2${a}" readonly class="form-control">
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary text-end" onclick="Addlabel(${a})" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa-solid fa-plus">Label</i>
                            </button>
                            </td>
                        <td><a id="printlabel${a}"><button type="button" class="btn btn-success text-center" id="" disabled><i class="fa-solid fa-print"></i></button></a></td>
                        <td class="text-center">
                            <a title=" {{ __('messages.common.delete') }}"  onclick="deletevalues(${a})"
                            class="delete-prescription-medicine-item btn px-1 text-danger fs-3 pe-0">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                        <td>
                        </td>
                        </tr>
                        <input type="hidden" id="common_side_effect${a}" >
                        <input type="hidden" id="dricetion_of_use${a}" >
    `);
            $('.medicine-select').select2();
            enablemainbutton();
        }

        function SelectMedicine(id) {
            const selectMedicine = document.getElementById('medicine' + id);
            // console.log(selectMedicine);
            const totalQuantitySpan = document.getElementById('total_quantity' + id);
            const discountPercentage = document.getElementById('discount_percentage' + id);

            const sellingpriceTag = document.getElementById('selling_price' + id);
            var totalMedicineAmount = document.getElementById('product_total_price' + id);
            var totalMedicineAmount2 = document.getElementById('product_total_prices2' + id);
            var gst_perc_tag = document.getElementById('gst_percentage' + id);
            var medicineID = document.getElementById('medicineID' + id);
            var medicineName = document.getElementsByClassName('medicine_name' + id);
            var common_side_effect_tag = document.getElementById('common_side_effect' + id);
            var dricetion_of_use_tag = document.getElementById('dricetion_of_use' + id);

            // var genericformulatag = document.getElementById('generic_formula' + id);

            const selectedOption = selectMedicine.options[selectMedicine.selectedIndex];

            var batchPosSelect = document.getElementById("batch_pos" + id);

            // Clear previous options
            batchPosSelect.innerHTML = '';

            const batchPositions = JSON.parse(selectedOption.getAttribute('data-batch_pos'));

            console.log(batchPosSelect);



            // if (batchPositions) {
            //     batchPositions.forEach(function (batchPos) {
            //         console.log(batchPos);
            //         batchPosSelect.innerHTML += '<option data-quantity_oh="'+batchPos.quantity+'" data-price="'+batchPos.unit_trade+'" data-unit_retail="'+batchPos.unit_retail+'"   value="' + batchPos.id + '">' + batchPos.batch.batch_no + '</option>';
            //     });
            // }

            const totalQuantity = selectedOption.getAttribute('data-totalQuantity');
            const gstpercentage = selectedOption.getAttribute('data-gst');
            const fixedDiscount = selectedOption.getAttribute('data-fixed_discount');

            const totalPrice = selectedOption.getAttribute('data-totalPrice');
            const MedicineId = selectedOption.getAttribute('data-Id');
            const MedicineNameData = selectedOption.getAttribute('data-medicine_name');
            const CommonSideEffect = selectedOption.getAttribute('data-common_side_effect');
            const DricetionOfUse = selectedOption.getAttribute('data-dricetion_of_use');

            // const GenericFormula = selectedOption.getAttribute('data-generic_formula');
            const sellingPriceValue = selectedOption.getAttribute('data-sellingPrice');
            console.log('selling value ' + sellingPriceValue);


            totalQuantitySpan.value = totalQuantity;
            discountPercentage.value = fixedDiscount;
            totalMedicineAmount.value = totalPrice;
            totalMedicineAmount2.value = totalPrice;
            medicineName.value = MedicineNameData;
            medicineID.value = MedicineId;
            gst_perc_tag.value = gstpercentage;
            common_side_effect_tag.value = CommonSideEffect;
            dricetion_of_use_tag.value = DricetionOfUse;

            sellingpriceTag.value = sellingPriceValue;
            // genericformulatag.value = GenericFormula;

            if (batchPositions) {
                batchPositions.forEach(function(batchPos) {
                    console.log(batchPos);
                    batchPosSelect.innerHTML += '<option data-quantity_oh="' + batchPos.remaining_qty +
                        '" data-price="' + batchPos.unit_trade + '" data-unit_retail="' + batchPos.unit_retail +
                        '"  value="' + batchPos.id + '">' + batchPos.batch.batch_no + '</option>';
                    totalQuantity.value = batchPos.remaining_qty;
                    totalMedicineAmount.value = batchPos.unit_trade;
                    totalMedicineAmount2.value = batchPos.unit_trade;
                    ChangeBatch(id);
                });
            }

        }


        function ChnageDosage(id) {
            var Dosage = $('#dosage' + id).val();
            var PricePerUnit = $('#selling_price' + id).val();
            var TotalCost = parseFloat($('#total_amount').val());
            var TotalMedicineCost = (Dosage * PricePerUnit);
            console.log(TotalMedicineCost);
            $('#product_total_price' + id).val(TotalMedicineCost);
            $('#product_total_prices2' + id).val(TotalMedicineCost)
            ChnageDosageTotal();
            discountCalculation(id);
            gstCalculation(id);

        }

        function ChnageDosageTotal() {
            var TotalAmount = 0;
            $("input[id^='product_total_prices2']").each(function() {
                if ($(this).val() != '') {
                    TotalAmount += parseFloat($(this).val());
                }
            });
            $('#total_amount').val(parseFloat(TotalAmount) + 1);
            $('#total_amounts2').val(TotalAmount);
            $('#total_amount_ex_saletax').val(TotalAmount);
            $('#total_amount_inc_saletax').val(TotalAmount);

        }

        function discountCalculation(id) {
            var Dosage = $('#dosage' + id).val();
            var selling_price = $('#selling_price' + id).val();
            var product_total_price_main = Dosage * selling_price;
            var discount_percentage = $('#discount_percentage' + id).val();
            var product_total_price = $('#product_total_prices2' + id).val();
            var discount_amount = (parseFloat((discount_percentage * product_total_price_main) / 100)).toFixed(2);
            var medicine__price = (parseFloat(product_total_price_main) - parseFloat(discount_amount)).toFixed(2);
            $('#product_total_price' + id).val(medicine__price);
            $('#product_total_prices2' + id).val(medicine__price);
            $('#discount_amount' + id).val(discount_amount);
            $('#discount_amounts2' + id).val(discount_amount);
            discountCalculationTotal();
            gstCalculation(id);
        }

        function discountCalculationTotal() {
            var discount_amounts2 = 0;
            var amountwithouttax = 0;
            $("input[id^='discount_amounts2']").each(function() {
                if ($(this).val() != '') {
                    discount_amounts2 += parseFloat($(this).val());
                }
            });
            $("input[id^='product_total_prices2']").each(function() {
                if ($(this).val() != '') {
                    amountwithouttax += parseFloat($(this).val());

                }
            });
            var TotalAmount = $('#total_amounts2').val();
            var discount_amounts2Tofixed = discount_amounts2.toFixed(2);
            var AmountWithDiscount = TotalAmount - discount_amounts2Tofixed;
            var amountwithouttaxToFixed = amountwithouttax.toFixed(2);
            $('#total_amount_ex_saletax').val(amountwithouttaxToFixed);
            $('#total_amount_inc_saletax').val(amountwithouttaxToFixed);
            $('#total_amount').val(parseFloat(amountwithouttaxToFixed) + 1);
            $('#total_discount').val(discount_amounts2Tofixed);
        }



        function gstCalculation(id) {
            var Dosage = $('#dosage' + id).val();
            var selling_price = $('#selling_price' + id).val();
            var product_total_price_main = Dosage * selling_price;
            var discount_percentage = $('#discount_percentage' + id).val();
            var total_quantity_amount = (parseFloat(Dosage) * parseFloat(selling_price)).toFixed(2);
            var amountwithdiscount = (parseFloat(total_quantity_amount) - parseFloat((total_quantity_amount *
                discount_percentage) / 100)).toFixed(2);
            var gst_percentage = $('#gst_percentage' + id).val();
            console.log("amount dis = " + selling_price)
            console.log('GST AMOUNT=' + id + ' = ' + ((amountwithdiscount) / ((parseFloat(100) + parseFloat(
                gst_percentage))) * gst_percentage))
            var gst_amount = (((amountwithdiscount) / ((parseFloat(100) + parseFloat(gst_percentage))) * gst_percentage))
                .toFixed(2);
            var amount_with_gst = (parseFloat(amountwithdiscount) + parseFloat(gst_amount)).toFixed(2);

            $('#gst_amount' + id).val(gst_amount);
            $('#gst_amounts2' + id).val(gst_amount);
            gstCalculationTotal();
        }

        function gstCalculationTotal() {
            var Totalgstamount = 0;
            var TotalWithTax = 0;
            $("input[id^='gst_amounts2']").each(function() {
                if ($(this).val() != '') {
                    Totalgstamount += parseFloat($(this).val());
                }
            });
            $("input[id^='product_total_prices2']").each(function() {
                if ($(this).val() != '') {
                    TotalWithTax += parseFloat($(this).val());
                }
            });
            var TotalWithTaxToFixed = TotalWithTax.toFixed(2);
            var TotalgstamountToFixed = Totalgstamount.toFixed(2);
            var TotalAmountWithGSTFINAL = (parseFloat(TotalWithTaxToFixed) - parseFloat(TotalgstamountToFixed)).toFixed(2);
            var ForTotalAmount = TotalAmountWithGSTFINAL;

            $('#total_saletax').val(TotalgstamountToFixed);
            $('#total_amount_ex_saletax').val(TotalAmountWithGSTFINAL);
        }




        function Addlabel(id) {
            $('#save_label').attr('onclick', 'AlertLabel(' + id + ')');
            $('#labelsubmitform').removeAttr('onsubmit');
            var pos_id = $('#pos_id').val();
            $('#pos_id_label').val(pos_id);
            var paitentName = $('#patient_name').val();
            $('#patient_name_label').val(paitentName);

            const selectMedicine = document.getElementById('medicine' + id);
            const MedicineName = document.getElementById('medicine_name_label');
            const MedicineId = document.getElementById('medicine_id_label');
            const CommonSideEffect_value = $('#common_side_effect' + id).val();
            const DricetionOfUse_value = $('#dricetion_of_use' + id).val();

            console.log('DricetionOfUse_value = ' + DricetionOfUse_value);
            console.log('CommonSideEffect_value = ' + CommonSideEffect_value);


            const BrandIdTag = document.getElementById('brand_id_label');
            var medicineLabel_Id = document.getElementById('medicine_id_label');

            const selectedOption = selectMedicine.options[selectMedicine.selectedIndex];
            const medicineName = selectedOption.getAttribute('data-medicine_name');
            const medicineIDValue = selectedOption.getAttribute('data-medicine_id');
            const brandName = selectedOption.getAttribute('data-generic_formula');
            const brandId = selectedOption.getAttribute('data-brand_id');
            $('#common_side_effect_label').val(CommonSideEffect_value);
            $('#direction_use_label').val(DricetionOfUse_value);

            (medicineLabel_Id, medicineIDValue);
            var currentDate = new Date();
            var formattedDate = currentDate.toISOString().slice(0, 10);
            $('#date_of_selling_label').val(formattedDate);

            var dosage = $('#dosage' + id).val();
            $('#quantity_label').val(dosage);

            MedicineName.value = medicineName;
            MedicineId.value = medicineIDValue;
        }

        function Addlabelforprescription(id) {
            $('#save_label').attr('onclick', 'AlertLabel(' + id + ')');
            $('#labelsubmitform').removeAttr('onsubmit');
            var pos_id = $('#pos_id').val();
            $('#pos_id_label').val(pos_id);
            var paitentName = $('#patient_name').val();
            $('#patient_name_label').val(paitentName);
            const selectMedicine = document.getElementById('medicine' + id);
            const MedicineName = document.getElementById('medicine_name_label');
            const MedicineIdTag = document.getElementById('medicine_id_label');
            const BrandName = document.getElementById('generic_formula_label');
            const BrandId = document.getElementById('brand_id_label');
            const direction_use_tag = document.getElementById('direction_use_label');
            const common_side_effect_tag = document.getElementById('common_side_effect_label');
            const dricetion_of_use_tag = document.getElementById('direction_use_label');
            const medicineName = selectMedicine.getAttribute('data-medicine_name');
            const medicineId = selectMedicine.getAttribute('data-medicine_id');
            const brandName = selectMedicine.getAttribute('data-generic_formula');
            const brandId = selectMedicine.getAttribute('data-brand_id');
            const dricetion_of_use_value = selectMedicine.getAttribute('data-dricetion_of_use');
            const common_side_effect_value = selectMedicine.getAttribute('data-common_side_effect');
            var currentDate = new Date();
            var formattedDate = currentDate.toISOString().slice(0, 10);
            $('#date_of_selling_label').val(formattedDate);

            var dosage = $('#dosage' + id).val();
            $('#quantity_label').val(dosage);

            MedicineName.value = medicineName;
            MedicineIdTag.value = medicineId;
            common_side_effect_tag.value = common_side_effect_value;
            dricetion_of_use_tag.value = dricetion_of_use_value;
        }

        function AlertLabel(id) {
            $("#exampleModal").modal('hide');
            var pos_id = $('#pos_id_label').val();
            var medicine_id = $('#medicineID' + id).val();
            window.alert('Your Product Label Has been Generated');
            $('#printlabel' + id).removeAttr('disabled');
            $('#printlabel' + id).attr('href', `/lable/label-print/${pos_id}/${medicine_id}`);
            $('#printlabel' + id).attr('target', '__blank');
        }

        function ChangeBatch(id) {
            const selectBatch = document.getElementById('batch_pos' + id);

            const selectedOption = selectBatch.options[selectBatch.selectedIndex];

            const total_quantity = selectedOption.getAttribute('data-quantity_oh');
            const price = selectedOption.getAttribute('data-price');
            const unit_retail = selectedOption.getAttribute('data-unit_retail');

            $('#total_quantity' + id).val(total_quantity);
            $('#selling_price' + id).val(unit_retail);
            ChnageDosage(id);
        }

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        function addMedicine(id) {
            var tableRow = document.getElementById('medicine-table-body');
            var a = tableRow.rows.length + 1;
            var product_id = $('#search_addbtn' + id).data('product_id');
            var product_name = $('#search_addbtn' + id).data('product_name');
            var generic_formula = $('#search_addbtn' + id).data('generic_formula');
            var brand_name = $('#search_addbtn' + id).data('brand_name');
            var brand_id = $('#search_addbtn' + id).data('brand_id');
            var total_quantity = $('#search_addbtn' + id).data('total_quantity');
            var selling_price = $('#search_addbtn' + id).data('selling_price');
            var gst = $('#search_addbtn' + id).data('gst');
            var fixed_discount = $('#search_addbtn' + id).data('fixed_discount');
            var common_side_effect = $('#search_addbtn' + id).data('common_side_effect');
            var dricetion_of_use = $('#search_addbtn' + id).data('dricetion_of_use');
            var batch_pos = $('#search_addbtn' + id).data('batch_pos');
            console.log(batch_pos);

            $('#medicine-table-body').append(`
            <tr id="medicine-row${a}">
                <input type="hidden" id="medicineID${a}" value="${id}" name="products[${a}][medicine_id]">
                    <td>
                        <input name="products[${a}][product_name]" id="medicine${a}" class="form-control" type="text" readonly value="${product_name}"
                        data-medicine_name="${product_name}"
                        data-medicine_id="${id}"
                        data-generic_formula="${generic_formula}"
                        data-brand_name="${brand_name}"
                        data-brand_id="${brand_id}"
                        data-sellingPrice="${selling_price}"
                        data-Id="${id}"
                        data-totalQuantity="${total_quantity}"
                        data-totalPrice="${selling_price}"
                        data-gst="${gst}"
                        data-fixed_discount="${fixed_discount}"
                        data-common_side_effect="${common_side_effect}"
                        data-dricetion_of_use="${dricetion_of_use}"
                        data-batch_pos="${batch_pos}"
                        >
                        </td>
                        <td>
                            <select name="products[${a}][batch_id]" id="batch_pos${a}" onchange="ChangeBatch(${a})" class="batch_pos form-control">
                                ${batch_pos.length != 0  
                                    ? `${batch_pos.map(batch => {
                                                return `<option value="${batch.id}" 
                                                        data-batch-id="${batch.id}" 
                                                        data-quantity_oh="${batch.remaining_qty}"
                                                        data-expiry-date="${batch.expiry_date}"
                                                        data-unit_retail="${batch.unit_retail}"
                                                        data-price="${batch.unit_trade}">
                                                    ${batch.batch.batch_no}
                                                    </option>`;
                                            }).join('')}` :
                                        `<option value="">Not Any Batch Found</option>`
                                    }
                            </select>
                        </td>

                    <td><input name="products[${a}][total_stock]" id="total_quantity${a}" class="form-control" type="text" readonly value="${total_quantity}"></td>
                    <td><input class="form-control" type="text" step="any"readonly  name="products[${a}][mrp_perunit]" id="selling_price${a}" readonly value="${selling_price}"></td>
                    <td><input class="form-control" type="number" step="any" value="0" name="products[${a}][product_quantity]" id="dosage${a}" class="form-control" oninput="ChnageDosage(${a})"></td>
                    <td>
                        <input class="form-control" readonly type="number" step="any" value="${fixed_discount}" name="products[${a}][discount_percentage]" id="discount_percentage${a}" class="form-control" oninput="discountCalculation(${a})">
                        <input type="hidden" value="0" readonly  name="products[${a}][discount_amount]" id="discount_amount${a}" class="form-control">
                            <input type="hidden" value="0" readonly  name="products[${a}][discount_amount]" id="discount_amounts2${a}" class="form-control">
                        </td>
                    <td><input class="form-control" readonly step="any"value="${gst}"  name="products[${a}][gst_percentage]" id="gst_percentage${a}" class="form-control" oninput="gstCalculation(${a})">
                            <input type="hidden" value="0" readonly  name="products[${a}][gst_amount]" id="gst_amount${a}" class="form-control">
                            <input type="hidden" value="0" readonly  name="products[${a}][gst_amount]" id="gst_amounts2${a}" class="form-control">
                        </td>

                        <td>
                            <input type="number"  step="any"value="0" name="products[${a}][product_total_price]" id="product_total_price${a}" readonly class="form-control">
                            <input type="hidden" value="0" id="product_total_prices2${a}" readonly class="form-control">
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" onclick="Addlabelforprescription(${a})" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa-solid fa-plus">Label</i>
                            </button>
                        </td>
                        <td><a id="printlabel${a}"><button type="button" class="btn btn-success text-center" id="" disabled><i class="fa-solid fa-print"></i></button></a></td>

                        <td class="text-center">
                            <a title=" {{ __('messages.common.delete') }}"  onclick="deletevalues(${a})"
                            class="delete-prescription-medicine-item btn px-1 text-danger fs-3 pe-0">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                        <td>

                        </td>
                </tr>`);
            enablemainbutton();
            ChangeBatch(a);

        }

        $(document).ready(function() {
            $('#possubmitform').on('submit', function(e) {
                e.preventDefault();
                $('#proceede_to_pay').prop('disabled', true);


                $.ajax({
                    url: '/validate-pos',
                    type: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        console.log('Response:', response);
                        if (response.valid) {
                            console.log('Before form submission');
                            $('#possubmitform')[0].submit();
                            console.log('After form submission');
                        } else {
                            $('#validation-message').text(response.message);
                            $('#validation-message').show();
                        }

                    },
                    error: function(xhr, status, error) {
                        // $('#validation-message').html(xhr.responseJSON.message);

                        $('.wrapper').append(
                            ` <div class="alert alert-danger">
                        <div>
                            <div class="d-flex">
                                <i class="fas fa-frown me-2 my-custom-icon" style="font-size: 40px;padding-right:2px;color:orange;"></i>
                                <span class="mt-1 validationError">${xhr.responseJSON.message}</span>
                            </div>
                        </div>
                    </div>
                    <style>
                        .alert{
                            position: absolute;
                            background: white;
                            width: 290px;
                            padding: 40px;
                            box-shadow: 5px 5px 5px rgba(128, 128, 128, 0.5); 
                            top: 10px;
                            right: 10px;
                        }
                        .icon-sm {
                            font-size: 106px !important;
                        }
                        .validationError{
                            font-weight:900;
                            color:#2f2f2f;
                            letter-spacing:2px;
                        }
                    </style>
                    `
                        );
                        $('.alert').delay(5000).slideUp(300)
                        $('.alert').delay(5000).slideUp(300, function() {
                            $('.alert').attr('style', 'display:none');
                            $('#proceede_to_pay').removeAttr('disabled');
                        })
                    }
                });
            });
        });

        $(document).ready(function() {
            var count = 0;
            $("input[id^='product_total_prices2']").each(function() {
                count += 1;
                ChnageDosage(count);
                discountCalculation(count);
            });
            discountCalculationTotal();
            ChnageDosageTotal();
            gstCalculationTotal();

            if (!localStorage.getItem('pageReloaded')) {
                // If the 'pageReloaded' flag is not set, reload the page
                localStorage.setItem('pageReloaded', 'true');
                window.location.reload();
            }

        });

        $(document).ready(function() {
            var id = $('.batch_pos').val();
            ChangeBatch(id);
        });

        //    for delete values when delete row is click
        function deletevalues(id) {
            $("#product_total_prices2" + id).val(0);
            $("#discount_amounts2" + id).val(0);
            $(`#medicine-row${id}`).remove();
            enablemainbutton();
            ChnageDosageTotal();
            discountCalculationTotal();
            gstCalculationTotal();
        }
    </script>


@endsection
