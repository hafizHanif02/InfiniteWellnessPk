@extends('layouts.app')
@section('title')
    {{ __('messages.bill.pos') }}
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
                    <form action="{{ route('pos.store') }}" id="possubmitform" onsubmit="return false;" method="post">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="pos_id">INV #</label>
                                <input type="number" step="any"name="pos_id" id="pos_id" class="form-control"
                                    value="{{ ($pos_id ? $pos_id : 1210) + 1 }}" required readonly title="Invoice Number">
                            </div>
                            <div class="col-md-6">
                                <label for="cashier_name">Cashier Name</label>
                                <input type="text" id="cashier_name" name="cashier_name" placeholder="Enter Cashier Name"
                                    class="form-control">
                                @error('cashier_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 mt-3">
                            <div class="mb-3 col-md-6">
                                <div class="col-md-12">
                                    <label for="mr_number">MR No.</label>
                                    <select class="form-control" name="patient_mr_number" id="patient_mr_number">
                                        <option value="" selected disabled>Select Patient MR#</option>
                                        @foreach ($patients as $patient)
                                            <option data-patient_name="{{ $patient->user->full_name }}"
                                                data-patient_number="{{ $patient->user->phone }}"
                                                value="{{ $patient->MR }}">({{ $patient->MR }})
                                                {{ $patient->user->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="prescription_id">Prescription</label>
                                <select name="prescription_id" id="prescription_id" class="form-control">
                                    <option value="" selected disabled>Select MR# First</option>
                                </select>
                                @error('prescription_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="patient_name">Patient Name<sup class="text-danger">*</sup></label>
                                <input type="text" name="patient_name" id="patient_name" class="form-control"
                                    placeholder="Enter Patient Name">
                                @error('patient_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="patient_name">Contact Number<sup class="text-danger">*</sup></label>
                                <input type="text" name="patient_number" id="patient_number" class="form-control"
                                    placeholder="Enter Patient Number">
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
                                                        <td>Generic Formula</td>
                                                        <td>Barcode</td>
                                                        <td>Action</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="myTable">

                                                    @foreach ($medicines as $medicine)
                                                        <tr>
                                                            <td>{{ $medicine->name }}</td>
                                                            <td>{{ $medicine->product->generic->formula }}</td>
                                                            <td>{{ $medicine->barcode }}</td>
                                                            <td><button class="btn btn-success" type="button"
                                                                    onclick="addMedicine({{ $medicine->id }})"><i
                                                                        class="fa fa-plus"></i></button>
                                                                <input type="hidden"
                                                                    id="search_addbtn{{ $medicine->id }}"
                                                                    data-product_id="{{ $medicine->id }}"
                                                                    data-product_name="{{ $medicine->name }}"
                                                                    data-generic_formula="{{ $medicine->product->generic->formula }}"
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
                                        <th class="col" style="min-width: 100px; max-width: 100px;">Product</th>
                                        <th class="col" style="min-width: 130px">Batch No</th>
                                        <th class="col" style="min-width: 130px">Qty OH</th>
                                        <th class="col" style="min-width: 130px">MRP Per Unit</th>
                                        <th class="col" style="min-width: 130px">Qty</th>
                                        <th class="col" style="min-width: 130px">DST %</th>
                                        <th class="col" style="min-width: 130px">GST %</th>
                                        <th class="col" style="min-width: 130px">Amount</th>
                                        <th class="col" style="text-align: end">Label</th>
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
                                <input type="number" step="any"class="form-control" id="total_saletax"
                                    name="total_saletax" readonly value="0">
                            </div>
                            <div class="col-md-6">
                                <label for="total_discount">Total Discount</label>
                                <input type="number" step="any"class="form-control" id="total_discount"
                                    name="total_discount" readonly value="0">
                            </div>
                        </div>
                        <div class="row mb-5 mt-5">
                            <div class="col-md-6">
                                <label for="total_amount_ex_saletax">Total Amount Exclusive Sale Tax</label>
                                <input type="number" step="any"class="form-control" id="total_amount_ex_saletax"
                                    name="total_amount_ex_saletax" readonly value="0">
                            </div>
                            <div class="col-md-6">
                                <label for="total_amount_inc_saletax">Total Amount Inclusive Sale Tax</label>
                                <input type="number" step="any"class="form-control" id="total_amount_inc_saletax"
                                    name="total_amount_inc_saletax" readonly value="0">
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
                                    name="total_amount" readonly value="0" placeholder="Total Price">
                                <input type="hidden" id="total_amounts2">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-success" type="submit" id="proceede_to_pay"
                                onclick="submitbutton()">Proceed To Pay</button>
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
       function disablemainbutton(){$("#proceede_to_pay").attr("disabled","true")}function enablemainbutton(){$("#proceede_to_pay").removeAttr("disabled")}function submitbutton(){$("#possubmitform").removeAttr("onsubmit"),$("#proceede_to_pay").attr("disabled","true"),$("#possubmitform").submit()}function preventSubmit(t){t.preventDefault()}$(document).ready(function(){$("#patient_mr_number").select2(),$("#prescription_id").select2(),$(".medicine-select").select2(),$("#myInput").on("keyup",function(){"Enter"===event.key&&event.preventDefault();var t=$(this).val().toLowerCase();$("#myTable tr").filter(function(){$(this).toggle($(this).text().toLowerCase().indexOf(t)>-1)})}),$("form").on("keypress","input",function(t){13===t.which&&t.preventDefault()}),$("#patient_mr_number").change(function(){var t=document.getElementById("patient_mr_number"),e=t.options[t.selectedIndex],a=e.getAttribute("data-patient_name"),n=e.getAttribute("data-patient_number");$("#patient_name").val(a),$("#patient_name").attr("readonly",!0),$("#patient_number").val(n),$("#patient_number").attr("readonly",!0),$.ajax({type:"get",url:"/pos/prescription/list",data:{patient_mr_number:$(this).val()},dataType:"json",success:function(t){$("#prescription_id").empty(),0!==t.data.length?($("#prescription_id").append("<option>Select Prescription </option>"),$.each(t.data,function(t,e){$("#prescription_id").append(`
                            <option value="${e.id}" data-doctor="${e.doctor.user.full_name}"  data-patient="${e.patient.user.full_name}" data-medicines='${JSON.stringify(e.get_medicine)}'>
                            (${e.patient_opd}) ${e.doctor.user.full_name}" To "${e.patient.user.full_name}
                            </option>`)})):$("#prescription_id").html('<option value="" class="text-danger" selected disabled>No Prescription found!</option>')}})}),$("#medicine-table-body").on("change",".medicine-select",function(){$(this).find(":selected").data("medicine-data")}),$("#prescription_id").change(function(){var t=$(this).find(":selected"),e=t.data("medicines"),a=t.data("patient"),n=t.data("doctor");$("#medicine-table-body").empty(),$("#patient_name").val(a),$("#doctor_name").val(n),e.forEach(function(t,e){var a=`
                <tr scope="row" id="medicine-row${e}">
                    <input type="hidden" id="medicineID${e}" name="products[${e}][medicine_id]" value="${t.medicine.id}">
                    <td><input type="text" class="form-control" readonly value="${t.medicine.name}" name="products[${e}][product_name]" placeholder="item name" id="medicine${e}" data-medicine_id="${t.medicine.id}" data-medicine_name="${t.medicine.name}" data-brand_name="${t.medicine.name}" data-brand_id="${t.medicine.id}" data-sellingPrice="${t.medicine.selling_price}" data-Id="${t.medicine.id}" data-totalQuantity="${t.medicine.total_quantity}" data-generic_formula="${t.medicine.generic_formula}" data-totalPrice="${t.medicine.selling_price}" data-dricetion_of_use="${t.medicine.product.dricetion_of_use}" data-common_side_effect="${t.medicine.product.common_side_effect}"></td>
                    <td>
                        <select name="products[${e}][batch_id]" id="batch_pos${e}" onchange="ChangeBatch(${e})" class="batch_pos form-control">
                                ${0!=t.medicine.batchpos.length?`${t.medicine.batchpos.map(t=>`<option  value="${t.id}"
                                                                data-batch-id="${t.id}"
                                                                data-quantity_oh="${t.remaining_qty}"
                                                                data-remaining_qty="${t.remaining_qty}"
                                                                data-expiry-date="${t.expiry_date}"
                                                                data-unit_retail="${t.unit_retail}"
                                                                data-price="${t.unit_trade}">
                                                            ${t.batch.batch_no}
                                                            </option>`).join("")}`:'<option value="">Not Any Batch Found</option>'}
                            </select>
                    </td>
                    <td>
                            <input type="number"  step="any"readonly value="${t.medicine.total_quantity}" name="products[${e}][total_stock]"  id="total_quantity${e}" class="form-control">
                        </td>
                    <td><input type="number" class="form-control" id="selling_price${e}" value="${t.medicine.product.unit_retail}" oninput="ChnageDosage(${e})" name="products[${e}][mrp_perunit]" placeholder="mrp perunit"></td>
                    <td><input type="text" class="form-control" readonly id="dosage${e}" value="${t.dosage}" name="products[${e}][product_quantity]" placeholder="dosage"></td>
                    <td>
                        <input type="number" step="any"oninput="discountCalculation(${e})" id="discount_percentage${e}" value="${t.medicine.product.fixed_discount}" class="form-control"  name="products[${e}][discount_percentage]" >
                        <input type="hidden" value="0" readonly  name="products[${e}][discount_amount]" id="discount_amount${e}" class="form-control">
                            <input type="hidden" value="0" readonly  name="products[${e}][discount_amounts2]" id="discount_amounts2${e}" class="form-control">
                        </td>
                    <td>
                        <input type="number" readonly step="any"oninput="gstCalculation(${e})" id="gst_percentage${e}" value="${t.medicine.product.sale_tax_percentage}" class="form-control"  name="products[${e}][gst_percentage]" >
                        <input type="hidden" value="0" readonly  name="products[${e}][gst_amount]" id="gst_amount${e}" class="form-control">
                            <input type="hidden" value="0" readonly  name="products[${e}][gst_amounts2]" id="gst_amounts2${e}" class="form-control">
                        </td>


                    <td><input type="text" class="form-control"  name="products[${e}][product_total_price]" id="product_total_price${e}" readonly  placeholder="selling_price"></td>
                    <input type="hidden" class="form-control"  name="products[${e}][product_total_prices2]" id="product_total_prices2${e}" readonly  placeholder="selling_price">
                    <td>
                        <button type="button" class="btn btn-primary"  onclick="Addlabelforprescription(${e})" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-plus"></i></button>
                    </td>
                    <td><a id="printlabel${e}"><button type="button" class="btn btn-success text-center" id="" disabled><i class="fa-solid fa-print"></i></button></a></td>
                    <td></td>
                </tr>`;$("#medicine-table-body").append(a),$("#selling_price"+e).val(),gstCalculation(e),ChangeBatch(e),ChnageDosage(e),ChnageDosageTotal();var n=$("#dosage"+e).val(),i=$("#selling_price"+e).val(),d=n*i,o=$("#discount_percentage"+e).val();$("#product_total_prices2"+e).val();var l,c,r,s,u=parseFloat(o*d/100).toFixed(2),p=(parseFloat(d)-parseFloat(u)).toFixed(2);$("#product_total_price"+e).val(p),$("#product_total_prices2"+e).val(p),$("#discount_amount"+e).val(u),$("#discount_amounts2"+e).val(u),l=0,c=0,$("input[id^='discount_amounts2']").each(function(){""!=$(this).val()&&(l+=parseFloat($(this).val()))}),$("input[id^='product_total_prices2']").each(function(){""!=$(this).val()&&(c+=parseFloat($(this).val()))}),$("#total_amounts2").val(),r=l.toFixed(2),s=c.toFixed(2),$("#total_amount_ex_saletax").val(s),$("#total_amount_inc_saletax").val(s),$("#total_amount").val(parseFloat(s)+1),$("#total_discount").val(r),gstCalculation(e)})}),enablemainbutton()});const prescriptionSelect123=document.getElementById("prescription_id"),patientInput123=document.getElementById("patient_name"),doctorInput123=document.getElementById("doctor_name");function updateTotalPrice(){var t=parseFloat($("#total_amounts2").val())||0,e=parseFloat($("#advance_cost").val())||0;$("#total_amount").val((t+e).toFixed(2))}function Addmore(){var t=document.getElementById("medicine-table-body").rows.length;$("#medicine"+t).select2(),$("#medicine-table-body").append(`

            <tr id="medicine-row${t}">
                        <td>
                            <input type="hidden" id="medicineID${t}" name="products[${t}][medicine_id]">
                            <select style="min-width: 120px; max-width: 120px;" name="products[${t}][product_name]" class="form-control  medicine-select medicine_name${t}" id="medicine${t}"  onchange="SelectMedicine(${t})" class="form-select prescriptionMedicineId">
                                <option value="" selected disabled>Select Medicine</option>
                                @foreach ($medicines as $medicine)
                                    <option value="{{ $medicine->name }}" data-batch_pos="{{ json_encode($medicine->batchpos) }}" data-medicine_name="{{ $medicine->name }}" data-common_side_effect="{{ $medicine->product->common_side_effect }}" data-dricetion_of_use="{{ $medicine->product->dricetion_of_use }}"  data-medicine_id="{{ $medicine->id }}" data-gst="{{ $medicine->product != null ? $medicine->product->sale_tax_percentage : '' }}" data-fixed_discount="{{ $medicine->product != null ? $medicine->product->fixed_discount : '' }}" data-generic_formula="{{ $medicine->generic_formula }}" data-brand_name="{{ $medicine->brand->name }}" data-brand_id="{{ $medicine->brand->id }}" data-sellingPrice="{{ $medicine->product->unit_retail }}" data-Id="{{ $medicine->id }}" data-totalQuantity="{{ $medicine->total_quantity }}" data-totalPrice={{ $medicine->product->unit_retail }}>
                                        <div class="select2_generic">({{ $medicine->product->generic->formula }})</div>{{ $medicine->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="products[${t}][batch_id]" id="batch_pos${t}" onchange="ChangeBatch(${t})" class=" batch_pos form-control">
                            </select>
                        <td>
                            <input type="number" step="any"readonly value="0" name="products[${t}][total_stock]"  id="total_quantity${t}" class="form-control">
                        </td>
                        <td>
                            <input type="number"  step="any"  name="products[${t}][mrp_perunit]" id="selling_price${t}" class="form-control" oninput="ChnageDosage(${t})">
                        </td>
                        <td>
                            <input type="number"  step="any" value="0" name="products[${t}][product_quantity]" id="dosage${t}" class="form-control" oninput="ChnageDosage(${t})">
                        </td>
                        <td>
                            <input type="number" step="any" value="0" name="products[${t}][discount_percentage]" id="discount_percentage${t}" class="form-control" oninput="discountCalculation(${t})">
                            <input type="hidden" value="0" readonly  name="products[${t}][discount_amount]" id="discount_amount${t}" class="form-control">
                            <input type="hidden" value="0" readonly  name="products[${t}][discount_amount]" id="discount_amounts2${t}" class="form-control">
                        </td>
                        <td>
                            <input type="number" readonly  step="any"value="0"  name="products[${t}][gst_percentage]" readonly id="gst_percentage${t}" class="form-control" >
                            <input type="hidden" value="0" readonly  name="products[${t}][gst_amount]" id="gst_amount${t}" class="form-control">
                            <input type="hidden" value="0" readonly  name="products[${t}][gst_amount]" id="gst_amounts2${t}" class="form-control">
                        </td>

                        <td>
                            <input type="number"  step="any"value="0" name="products[${t}][product_total_price]" id="product_total_price${t}" readonly class="form-control">
                            <input type="hidden" value="0" id="product_total_prices2${t}" readonly class="form-control">
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary text-end" onclick="Addlabel(${t})" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            </td>
                        <td><a id="printlabel${t}"><button type="button" class="btn btn-success text-center" id="" disabled><i class="fa-solid fa-print"></i></button></a></td>
                        <td class="text-center">
                            <a title=" {{ __('messages.common.delete') }}" onclick="deletevalues(${t})"
                            class="delete-prescription-medicine-item btn px-1 text-danger fs-3 pe-0">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                        <td>
                        </td>
                        </tr>
                        <input type="hidden" id="common_side_effect${t}" >
                        <input type="hidden" id="dricetion_of_use${t}" >
        `),$(".medicine-select").select2(),enablemainbutton()}function deletevalues(t){$(`#medicine-row${t}`).remove(),enablemainbutton(),ChnageDosageTotal(),discountCalculationTotal(),gstCalculationTotal()}function SelectMedicine(t){let e=document.getElementById("medicine"+t),a=document.getElementById("total_quantity"+t),n=document.getElementById("discount_percentage"+t),i=document.getElementById("selling_price"+t);var d=document.getElementById("product_total_price"+t),o=document.getElementById("product_total_prices2"+t),l=document.getElementById("gst_percentage"+t),c=document.getElementById("medicineID"+t),r=document.getElementsByClassName("medicine_name"+t),s=document.getElementById("common_side_effect"+t),u=document.getElementById("dricetion_of_use"+t);let p=e.options[e.selectedIndex];var m=document.getElementById("batch_pos"+t);m.innerHTML="";let g=JSON.parse(p.getAttribute("data-batch_pos")),b=p.getAttribute("data-totalQuantity"),v=p.getAttribute("data-gst"),f=p.getAttribute("data-fixed_discount"),y=p.getAttribute("data-totalPrice"),h=p.getAttribute("data-Id"),x=p.getAttribute("data-medicine_name"),I=p.getAttribute("data-common_side_effect"),A=p.getAttribute("data-dricetion_of_use"),B=p.getAttribute("data-sellingPrice");a.value=b,n.value=f,d.value=y,o.value=y,r.value=x,c.value=h,l.value=v,s.value=I,u.value=A,i.value=B,g&&g.forEach(function(e){m.innerHTML+='<option data-quantity_oh="'+e.remaining_qty+'" data-price="'+e.unit_trade+'" data-unit_retail="'+e.unit_retail+'"  value="'+e.id+'">'+e.batch.batch_no+"</option>",b.value=e.remaining_qty,d.value=e.unit_trade,o.value=e.unit_trade,ChangeBatch(t)})}function ChnageDosage(t){var e=$("#dosage"+t).val(),a=$("#selling_price"+t).val();parseFloat($("#total_amount").val());var n=e*a;$("#product_total_price"+t).val(n),$("#product_total_prices2"+t).val(n),ChnageDosageTotal(),discountCalculation(t),gstCalculation(t)}function ChnageDosageTotal(){var t=0;$("input[id^='product_total_prices2']").each(function(){""!=$(this).val()&&(t+=parseFloat($(this).val()))}),$("#total_amount").val(parseFloat(t)+1),$("#total_amounts2").val(t),$("#total_amount_ex_saletax").val(t),$("#total_amount_inc_saletax").val(t)}function discountCalculation(t){var e=$("#dosage"+t).val(),a=$("#selling_price"+t).val(),n=e*a,i=$("#discount_percentage"+t).val();$("#product_total_prices2"+t).val();var d=parseFloat(i*n/100).toFixed(2),o=(parseFloat(n)-parseFloat(d)).toFixed(2);$("#product_total_price"+t).val(o),$("#product_total_prices2"+t).val(o),$("#discount_amount"+t).val(d),$("#discount_amounts2"+t).val(d),discountCalculationTotal(),gstCalculation(t)}function discountCalculationTotal(){var t=0,e=0;$("input[id^='discount_amounts2']").each(function(){""!=$(this).val()&&(t+=parseFloat($(this).val()))}),$("input[id^='product_total_prices2']").each(function(){""!=$(this).val()&&(e+=parseFloat($(this).val()))}),$("#total_amounts2").val();var a=t.toFixed(2),n=e.toFixed(2);$("#total_amount_ex_saletax").val(n),$("#total_amount_inc_saletax").val(n),$("#total_amount").val(parseFloat(n)+1),$("#total_discount").val(a)}function gstCalculation(t){var e=$("#dosage"+t).val(),a=$("#selling_price"+t).val(),n=$("#discount_percentage"+t).val(),i=(parseFloat(e)*parseFloat(a)).toFixed(2),d=(parseFloat(i)-parseFloat(i*n/100)).toFixed(2),o=$("#gst_percentage"+t).val(),l=(d/(parseFloat(100)+parseFloat(o))*o).toFixed(2);(parseFloat(d)+parseFloat(l)).toFixed(2),$("#gst_amount"+t).val(l),$("#gst_amounts2"+t).val(l),gstCalculationTotal()}function gstCalculationTotal(){var t=0,e=0;$("input[id^='gst_amounts2']").each(function(){""!=$(this).val()&&(t+=parseFloat($(this).val()))}),$("input[id^='product_total_prices2']").each(function(){""!=$(this).val()&&(e+=parseFloat($(this).val()))});var a=e.toFixed(2),n=t.toFixed(2),i=(parseFloat(a)-parseFloat(n)).toFixed(2);$("#total_saletax").val(n),$("#total_amount_ex_saletax").val(i)}function Addlabel(t){$("#save_label").attr("onclick","AlertLabel("+t+")"),$("#labelsubmitform").removeAttr("onsubmit");var e=$("#pos_id").val();$("#pos_id_label").val(e);var a=$("#patient_name").val();$("#patient_name_label").val(a);let n=$("#common_side_effect"+t).val(),i=$("#dricetion_of_use"+t).val(),d=document.getElementById("medicine"+t),o=document.getElementById("medicine_name_label"),l=document.getElementById("medicine_id_label");document.getElementById("generic_formula_label"),document.getElementById("brand_id_label"),document.getElementById("medicine_id_label");let c=d.options[d.selectedIndex],r=c.getAttribute("data-medicine_name"),s=c.getAttribute("data-medicine_id");c.getAttribute("data-generic_formula"),c.getAttribute("data-brand_id"),$("#common_side_effect_label").val(n),$("#direction_use_label").val(i);var u=new Date().toISOString().slice(0,10);$("#date_of_selling_label").val(u);var p=$("#dosage"+t).val();$("#quantity_label").val(p),o.value=r,l.value=s}function Addlabelforprescription(t){$("#save_label").attr("onclick","AlertLabel("+t+")"),$("#labelsubmitform").removeAttr("onsubmit");var e=$("#pos_id").val();$("#pos_id_label").val(e);var a=$("#patient_name").val();$("#patient_name_label").val(a);let n=document.getElementById("medicine"+t),i=document.getElementById("medicine_name_label"),d=document.getElementById("medicine_id_label");document.getElementById("generic_formula_label"),document.getElementById("brand_id_label"),document.getElementById("direction_use_label");let o=document.getElementById("common_side_effect_label"),l=document.getElementById("direction_use_label"),c=n.getAttribute("data-medicine_name"),r=n.getAttribute("data-medicine_id");n.getAttribute("data-generic_formula"),n.getAttribute("data-brand_id");let s=n.getAttribute("data-dricetion_of_use"),u=n.getAttribute("data-common_side_effect");var p=new Date().toISOString().slice(0,10);$("#date_of_selling_label").val(p);var m=$("#dosage"+t).val();$("#quantity_label").val(m),i.value=c,d.value=r,o.value=u,l.value=s}function AlertLabel(t){$("#exampleModal").modal("hide");var e=$("#pos_id_label").val(),a=$("#medicineID"+t).val();window.alert("Your Product Label Has been Generated"),$("#printlabel"+t).removeAttr("disabled"),$("#printlabel"+t).attr("href",`/lable/label-print/${e}/${a}`),$("#printlabel"+t).attr("target","__blank")}function ChangeBatch(t){let e=document.getElementById("batch_pos"+t),a=e.options[e.selectedIndex],n=a.getAttribute("data-quantity_oh");a.getAttribute("data-price");let i=a.getAttribute("data-unit_retail");$("#total_quantity"+t).val(n),$("#selling_price"+t).val(i),ChnageDosage(t)}function sleep(t){return new Promise(e=>setTimeout(e,t))}function addMedicine(t){var e=document.getElementById("medicine-table-body").rows.length;$("#search_addbtn"+t).data("product_id");var a=$("#search_addbtn"+t).data("product_name"),n=$("#search_addbtn"+t).data("generic_formula"),i=$("#search_addbtn"+t).data("brand_name"),d=$("#search_addbtn"+t).data("brand_id"),o=$("#search_addbtn"+t).data("total_quantity"),l=$("#search_addbtn"+t).data("selling_price"),c=$("#search_addbtn"+t).data("gst"),r=$("#search_addbtn"+t).data("fixed_discount"),s=$("#search_addbtn"+t).data("common_side_effect"),u=$("#search_addbtn"+t).data("dricetion_of_use"),p=$("#search_addbtn"+t).data("batch_pos");$("#medicine-table-body").append(`
            <tr id="medicine-row${e}">
                <input type="hidden" id="medicineID${e}" value="${t}" name="products[${e}][medicine_id]">
                    <td>
                        <input name="products[${e}][product_name]" id="medicine${e}" class="form-control" type="text" readonly value="${a}"
                        data-medicine_name="${a}"
                        data-medicine_id="${t}"
                        data-generic_formula="${n}"
                        data-brand_name="${i}"
                        data-brand_id="${d}"
                        data-sellingPrice="${l}"
                        data-Id="${t}"
                        data-totalQuantity="${o}"
                        data-totalPrice="${l}"
                        data-gst="${c}"
                        data-fixed_discount="${r}"
                        data-common_side_effect="${s}"
                        data-dricetion_of_use="${u}"
                        data-batch_pos="${p}"
                        >
                        </td>
                        <td>
                        <select name="products[${e}][batch_id]" id="batch_pos${e}" onchange="ChangeBatch(${e})" class="batch_pos form-control">
                            ${0!==p.length?`${p.map(t=>`<option  value="${t.id}"
                                                data-batch-id="${t.id}"
                                                data-quantity_oh="${t.remaining_qty}"
                                                data-remaining_qty="${t.remaining_qty}"
                                                data-expiry-date="${t.expiry_date}"
                                                data-unit_retail="${t.unit_retail}"
                                                data-price="${t.unit_trade}">
                                            ${t.batch.batch_no}
                                            </option>`).join("")}`:'<option value="">Not Any Batch Found</option>'}
                        </select>
                    </td>





                    <td><input name="products[${e}][total_stock]"t id="total_quantity${e}" class="form-control" type="text" readonly value="${o}"></td>
                    <td><input class="form-control" type="number" step="any"  name="products[${e}][mrp_perunit]" id="selling_price${e}" value="${l}" oninput="ChnageDosage(${e})"></td>
                    <td><input class="form-control" type="number" step="any" value="0" name="products[${e}][product_quantity]" id="dosage${e}" class="form-control" oninput="ChnageDosage(${e})"></td>
                    <td>
                        <input class="form-control"  type="number" step="any" value="${r}" name="products[${e}][discount_percentage]" id="discount_percentage${e}" class="form-control" oninput="discountCalculation(${e})">
                        <input type="hidden" value="0" readonly  name="products[${e}][discount_amount]" id="discount_amount${e}" class="form-control">
                            <input type="hidden" value="0" readonly  name="products[${e}][discount_amount]" id="discount_amounts2${e}" class="form-control">
                        </td>
                    <td><input class="form-control" readonly step="any"value="${c}"  name="products[${e}][gst_percentage]" id="gst_percentage${e}" class="form-control" oninput="gstCalculation(${e})">
                            <input type="hidden" value="0" readonly  name="products[${e}][gst_amount]" id="gst_amount${e}" class="form-control">
                            <input type="hidden" value="0" readonly  name="products[${e}][gst_amount]" id="gst_amounts2${e}" class="form-control">
                        </td>

                        <td>
                            <input type="number"  step="any"value="0" name="products[${e}][product_total_price]" id="product_total_price${e}" readonly class="form-control">
                            <input type="hidden" value="0" id="product_total_prices2${e}" readonly class="form-control">
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" onclick="Addlabelforprescription(${e})" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </td>
                        <td><a id="printlabel${e}"><button type="button" class="btn btn-success text-center" id="" disabled><i class="fa-solid fa-print"></i></button></a></td>

                        <td class="text-center">
                            <a title=" {{ __('messages.common.delete') }}" onclick="deletevalues(${e})"
                            class="delete-prescription-medicine-item btn px-1 text-danger fs-3 pe-0">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                        <td>

                        </td>
                </tr>`),enablemainbutton(),ChangeBatch(e)}prescriptionSelect123.addEventListener("change",function(){let t=prescriptionSelect123.options[prescriptionSelect123.selectedIndex],e=t.getAttribute("data-patient"),a=t.getAttribute("data-doctor");patientInput123.value=e,doctorInput123.value=a,patientInput123.readonly=!0,doctorInput123.readonly=!0}),$(document).ready(function(){$("#possubmitform").on("submit",function(t){t.preventDefault(),$.ajax({url:"/validate-pos",type:"post",data:$(this).serialize(),dataType:"json",success:function(t){t.valid?$("#possubmitform")[0].submit():($("#validation-message").text(t.message),$("#validation-message").show())},error:function(t,e,a){$(".wrapper").append(` <div class="alert alert-danger">
                        <div>
                            <div class="d-flex">
                                <i class="fas fa-frown me-2 my-custom-icon" style="font-size: 40px;padding-right:2px;color:orange;"></i>
                                <span class="mt-1 validationError">${t.responseJSON.message}</span>
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
                    `),$(".alert").delay(5e3).slideUp(300),$(".alert").delay(5e3).slideUp(300,function(){$(".alert").attr("style","display:none"),$("#proceede_to_pay").removeAttr("disabled")})}})})}),$(document).ready(function(){ChangeBatch($(".batch_pos").val())});
    </script>
@endsection
