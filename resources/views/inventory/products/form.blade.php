<x-layouts.app title="New Product">
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Nursing Assessment Form</h3>
                <a href="{{ route('inventory.products.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row mb-5 mt-5">
                        <div class="col-md-6">
                            <label for="mr_number" class="form-label">MR #</label>
                            <select class="form-control" name="mr_number" id="mr_number">
                                <option value="" selected disabled>select mr number</option>
                                @foreach ($patients as $patient)
                                <option value="{{$patient->id }}">{{$patient->MR }} ~ {{$patient->user->full_name }}</option>
                                    
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="opd_id" class="form-label">OPD</label>
                            <select class="form-control" name="opd_id" id="opd_id">
                                <option value="" selected disabled>select mr number first</option>
                            </select>
                        </div>
                    </div>
                </div>
            <div class="card-body">
                <h4>VITAL SIGNS:</h4>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-5">
                                <label for="blood_pressure" class="form-label">Blood Pressure<sup class="text-danger">*</sup></label>
                                <input type="text"  name="blood_pressure" id="blood_pressure" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mt-5">
                            mmHg
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-5">
                                <label for="heart_rate" class="form-label">Heart Rate<sup class="text-danger">*</sup></label>
                                <input type="text"  name="heart_rate" id="heart_rate" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mt-5">
                                bpm
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-5">
                                <label for="respiratory_rate" class="form-label">Respiratory Rate<sup class="text-danger">*</sup></label>
                                <input type="text"  name="respiratory_rate" id="respiratory_rate" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mt-5">
                                breaths/min
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-5">
                                <label for="temperature" class="form-label">Temperature<sup class="text-danger">*</sup></label>
                                <input type="text"  name="temperature" id="temperature" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mt-5">
                                °C/°F
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-5">
                                <label for="height" class="form-label">Height<sup class="text-danger">*</sup></label>
                                <input type="text"  name="height" id="height" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mt-5">
                                cm/in
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-5">
                                <label for="weight" class="form-label">Weight<sup class="text-danger">*</sup></label>
                                <input type="text"  name="weight" id="weight" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mt-5">
                                kg/lb
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-5">
                                <label for="pain_level" class="form-label">Pain Level (0-10)<sup class="text-danger">*</sup></label>
                                <input type="text"  name="pain_level" id="pain_level" required class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                        <h4>Current Medications:</h4>
                    <table class="table table-bordered">
                        <thead>
                            <div class="row">
                                <div class="col-md-2 mb-5 mt-5">
                                    <button type="button" class="btn btn-primary" onclick="addMoreRowCMT()" id="addmore-btn">Add More</button>
                                </div>
                            </div>
                            <tr>
                                <td>Medication Name</td>
                                <td>Dosage </td>
                                <td>Frequency </td>
                                <td>Prescribing Physician</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody class="current_medications_table">
                            <tr>
                                <td><input type="text" name="medication_name[]" class="form-control"></td>
                                <td><input type="text" class="form-control" name="dosage[]"></td>
                                <td><input type="text" class="form-control" name="frequency[]"></td>
                                <td><input type="text" class="form-control" name="prescribing_physician[]"></td>
                                <td><button onclick="deleteRowCMT()"  class="btn-danger"><i class="fa fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-body">
                        <h4>Allergies:</h4>
                    <table class="table table-bordered">
                        <thead>
                            <div class="row text-end">
                                <div class="col-md-2 mb-5 mt-5">
                                    <button type="button" class="btn btn-primary" onclick="addmore()" id="addmore-btn">Add More</button>
                                </div>
                            </div>
                            <tr>
                                <td>Allergen</td>
                                <td>Reaction</td>
                                <td>Severity</td>
                            </tr>
                        </thead>
                        <tbody class="allergies_table">
                            <tr>
                                <td><input type="text" class="form-control" name="allergen[]"></td>
                                <td><input type="text" class="form-control" name="reaction[]"></td>
                                <td><input type="text" class="form-control" name="severity[]"></td>
                            </tr>
                        </tbody>
                    </table>



                    <div class="row">
                        <div class="col-md-6">
                            <label for="assessment_date" class="form-label">Assessment Date</label>
                            <input type="date" name="assessment_date" id="assessment_date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="nurse_name" class="form-label">Nurse's Name</label>
                            <input type="text" placeholder="Enter Nurse's Name" name="nurse_name" id="nurse_name" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-5 mt-5">
                        <div class="col-md-12">
                            <label for="signature" class="form-label">Signature</label>
                            <input type="text" placeholder="Enter Signature" name="signature" id="signature" class="form-control">
                        </div>
                    </div>

                    <div class="row text-center mb-5 mt-10">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-secondary">SUBMIT</button>
                        </div>
                    </div>
                </div>
                </form>
            
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#mr_number').select2();
        });
        function addMoreRowCMT() {
        var table = document.querySelector(".current_medications_table");
        var lastRow = table.lastElementChild;
        var newRow = lastRow.cloneNode(true); 
        table.appendChild(newRow); 
    }

    function deleteRowCMT(){
        var table = document.querySelector(".current_medications_table");
        var lastRow = table.lastElementChild;
        table.removeChild(lastRow); 
    }





    // function Addmore() {
    //         var tableRow = document.getElementByClass('current_medications_table');
    //         var a = tableRow.rows.length;
    //         $('#medicine' + a).select2();
    //         $('#medicine-table-body').append(`
    //         <tr id="medicine-row${a}">
    //                     <td>
    //                         <input type="hidden" id="medicineID${a}" name="products[${a}][medicine_id]">
    //                         <select name="products[${a}][product_name]" class="form-control medicine-select" id="medicine${a}" onchange="SelectMedicine(${a})" class="form-select prescriptionMedicineId">
    //                             <option value="" selected disabled>Select Medicine</option>
    //                             @foreach ($medicines as $medicine)
    //                                 <option value=" {{ $medicine->id }}" data-medicine_name="{{ $medicine->name }}"  data-medicine_id="{{ $medicine->id }}" data-gst="{{ ($medicine->product != null)?$medicine->product->sale_tax_percentage:'' }}" data-generic_formula="{{ $medicine->generic_formula }}" data-brand_name="{{ $medicine->brand->name }}" data-brand_id="{{ $medicine->brand->id }}" data-sellingPrice="{{ $medicine->selling_price }}" data-Id="{{ $medicine->id }}" data-totalQuantity="{{ $medicine->total_quantity }}" data-totalPrice={{ $medicine->selling_price }}>
    //                                     <div class="select2_generic">({{ $medicine->generic_formula }})</div>{{ $medicine->name }}
    //                                 </option>
    //                             @endforeach
    //                         </select>
    //                     </td>
    //                     <td>
    //                         <input type="text" readonly  name="products[${a}][generic_formula]" id="generic_formula${a}" class="form-control">
    //                     </td>
    //                     <td>
    //                         <input type="number"  step="any"readonly value="0"  id="total_quantity${a}" class="form-control">
    //                     </td>
    //                     <td>
    //                         <input type="number"  step="any"readonly  name="products[${a}][mrp_perunit]" id="selling_price${a}" class="form-control">
    //                     </td>
    //                     <td>
    //                         <input type="number"  step="any" value="0" name="products[${a}][product_quantity]" id="dosage${a}" class="form-control" onkeyup="ChnageDosage(${a})">
    //                     </td>
    //                     <td>
    //                         <input type="number"  step="any" value="0" name="products[${a}][discount_percentage]" id="discount_percentage${a}" class="form-control" onkeyup="discountCalculation(${a})">
    //                         <input type="hidden" value="0" readonly  name="products[${a}][discount_amount]" id="discount_amount${a}" class="form-control">
    //                         <input type="hidden" value="0" readonly  name="products[${a}][discount_amount]" id="discount_amounts2${a}" class="form-control">
    //                     </td>
    //                     <td>
    //                         <input type="number"  step="any"value="0"  name="products[${a}][gst_percentage]" readonly id="gst_percentage${a}" class="form-control" >
    //                         <input type="hidden" value="0" readonly  name="products[${a}][gst_amount]" id="gst_amount${a}" class="form-control">
    //                         <input type="hidden" value="0" readonly  name="products[${a}][gst_amount]" id="gst_amounts2${a}" class="form-control">
    //                     </td>
    //                     <td>
    //                         {{ Form::select('time[]', \App\Models\Prescription::MEAL_ARR, null, ['class' => 'form-select prescriptionMedicineMealId']) }}
    //                     </td>
    //                     <td>
    //                         {{ Form::textarea('comment[]', null, ['class' => 'form-control', 'rows' => 1]) }}
    //                     </td>
    //                     <td>
    //                         <input type="number"  step="any"value="0" name="products[${a}][product_total_price]" id="product_total_price${a}" readonly class="form-control">
    //                         <input type="hidden" value="0" id="product_total_prices2${a}" readonly class="form-control">
    //                     </td>
    //                     <td>
    //                         <button type="button" class="btn btn-primary" onclick="Addlabel(${a})" data-bs-toggle="modal" data-bs-target="#exampleModal">
    //                             Add Label
    //                         </button>
    //                     </td>
    //                     <td><button type="button" id="labelprintbtn${a}" disabled class="btn btn-success" id="labelshow${a}"><a id="anchorlabel${a}" target="_blank"  style="text-decoration:none;color:white;""><i class="fa fa-eye"></i>View</button></a></td>
    //                     <td class="text-center">
    //                         <a href="javascript:void(0)" title=" {{ __('messages.common.delete') }}"
    //                         class="delete-prescription-medicine-item btn px-1 text-danger fs-3 pe-0">
    //                             <i class="fa-solid fa-trash"></i>
    //                         </a>
    //                     </td>
    //                     <td>
    //                     </td>
    //                 </tr>
    //         `);
    //     }

    // </script>

</x-layouts.app>