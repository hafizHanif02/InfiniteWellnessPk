@extends('layouts.app3')
@section('title')
    F.A.S.T Medical Record
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>F.A.S.T Medical Record</h3>
                <a href="{{ route('nursing.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <form action="{{ route('fast-medical-record.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row mb-5 mt-5">
                        <div class="col-md-4">
                            <label for="patient_mr_number" class="form-label">MR #<sup class="text-danger">*</sup></label>
                            <select class="form-select" name="patient" id="patient_mr_number" required>
                                <option selected disabled>select mr number</option>
                                @foreach ($patients as $patient)
                                    <option value="{{ $patient->id }}"
                                        data-blood_pressure="{{ $patient->blood_pressure }}"
                                        data-patient_id="{{ $patient->id }}" data-heart_rate="{{ $patient->heart_rate }}"
                                        data-respiratory_rate="{{ $patient->respiratory_rate }}"
                                        data-temperature="{{ $patient->temperature }}" data-height="{{ $patient->height }}"
                                        data-weight="{{ $patient->weight }}" data-bmi="{{ $patient->bmi }}"
                                        data-dob="{{ $patient->user->dob }}"
                                        data-contact_no="{{ $patient->user->phone }}"
                                        data-first_name="{{ $patient->user->first_name }}"
                                        data-last_name="{{ $patient->user->last_name }}"
                                        >
                                        {{ $patient->MR }}
                                        ~ {{ $patient->user->full_name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="patient_name" id="patient_name">
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date of Birth<sup
                                        class="text-danger">*</sup></label>
                                <input type="text" name="dob" id="dob" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="contact_no" class="form-label">Contact No.<sup
                                        class="text-danger">*</sup></label>
                                <input type="text" name="contact" id="contact_no" required class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5 mt-5">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="referred_by" class="form-label">Referred By<sup
                                        class="text-danger">*</sup></label>
                                <input type="text" name="referred_by" id="referred_by" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="referral_date" class="form-label">Referral Date<sup
                                        class="text-danger">*</sup></label>
                                <input type="date" name="referrel_date" id="referral_date" required class="form-control">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    <h4>Pre-Test Consulation:</h4>
                    <div class="row mt-3">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pretest-date" class="form-label">Date<sup class="text-danger">*</sup></label>
                                <input type="date" name="pre_test_date" id="pretest-date" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pretest-status" class="form-label">Status<sup
                                        class="text-danger">*</sup></label>
                                <select name="pre_test_status" class="form-select" id="pretest-status">
                                    <option value="" selected disabled>select status</option>
                                    <option value="1">Positive</option>
                                    <option value="0">Negative</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h4>Blood Collection Appointment:</h4>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="bloodCollection-date" class="form-label">Date<sup
                                        class="text-danger">*</sup></label>
                                <input type="date" name="blood_collection_date" id="bloodCollection-date" required
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="bloodCollection-amount" class="form-label">Amount<sup
                                        class="text-danger">*</sup></label>
                                        <input type="number" name="blood_collection_amount" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="bloodCollection-status" class="form-label">Status<sup
                                        class="text-danger">*</sup></label>
                                <select name="blood_collection_status" class="form-select" id="bloodCollection-status">
                                    <option value="" selected disabled>select status</option>
                                    <option value="1">Positive</option>
                                    <option value="0">Negative</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="dateOfShipment" class="form-label">Date Of Shipment<sup
                                        class="text-danger">*</sup></label>
                                <input type="date" name="date_of_shipment" id="dateOfShipment" required
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h4>Fast Test Report:</h4>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fastTest-date" class="form-label">Date<sup
                                        class="text-danger">*</sup></label>
                                <input type="date" name="fast_test_report_date" id="fastTest-date" required
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fastTest-status" class="form-label">Status<sup
                                        class="text-danger">*</sup></label>
                                <select name="fast_test_report_status" class="form-select" id="fastTest-status">
                                    <option value="" selected disabled>select status</option>
                                    <option value="1">Positive</option>
                                    <option value="0">Negative</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h4>Report Review Session:</h4>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reportReview-date" class="form-label">Date<sup
                                        class="text-danger">*</sup></label>
                                <input type="date" name="report_session_date" id="reportReview-date" required
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reportReview-status" class="form-label">Status<sup
                                        class="text-danger">*</sup></label>
                                <select name="report_session_status" class="form-select" id="reportReview-status">
                                    <option value="" selected disabled>select status</option>
                                    <option value="1">Positive</option>
                                    <option value="0">Negative</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h4>Post-Test Consulation:</h4>
                    <div class="row mt-3">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="post-date" class="form-label">Date<sup class="text-danger">*</sup></label>
                                <input type="date" name="post_test_consult_date" id="post-date" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="post-status" class="form-label">Status<sup
                                        class="text-danger">*</sup></label>
                                <select name="post_test_consult_status" class="form-select" id="post-status">
                                    <option value="" selected disabled>select status</option>
                                    <option value="1">Positive</option>
                                    <option value="0">Negative</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h4>POST Post-Test Consulation:</h4>
                    <div class="row mt-3">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="postpost-date" class="form-label">Date<sup class="text-danger">*</sup></label>
                                <input type="date" name="post_post_test_date" id="postpost-date" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="postpost-status" class="form-label">Status<sup
                                        class="text-danger">*</sup></label>
                                <select name="post_post_test_status" class="form-select" id="postpost-status">
                                    <option value="" selected disabled>select status</option>
                                    <option value="1">Positive</option>
                                    <option value="0">Negative</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h4>RE-Test Consulation:</h4>
                    <div class="row mt-3">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="retest-date" class="form-label">Date<sup class="text-danger">*</sup></label>
                                <input type="date" name="retest_date" id="retest-date" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="retest-status" class="form-label">Status<sup
                                        class="text-danger">*</sup></label>
                                <select name="retest_date_status" class="form-select" id="retest-status">
                                    <option value="" selected disabled>select status</option>
                                    <option value="1">Positive</option>
                                    <option value="0">Negative</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dietitian" class="form-label">Dietitian<sup class="text-danger">*</sup></label>
                                <input type="text" name="dietitian" id="dietitian" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="retest-status" class="form-label">Comment<sup
                                        class="text-danger">*</sup></label>
                                <textarea name="comment" id="comment" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>

        </div>


        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            function deleteRowCMT() {
                var table = document.querySelector("#current_medications_table");
                var lastRow = table.lastElementChild;
                table.removeChild(lastRow);
            }

            function deleteRowAllergy() {
                var table = document.querySelector("#allergies_table");
                var lastRow = table.lastElementChild;
                table.removeChild(lastRow);
            }

            function addmoreallergy() {
                var tableRow = document.getElementById('allergies_table');
                var a = tableRow.rows.length;
                $('#allergies_table').append(`
            <tr id="allery-row${a}">
                <td><input type="text" class="form-control" name="allergies[${a}][allergen]"></td>
                                <td><input type="text" class="form-control" name="allergies[${a}][reaction]"></td>
                                <td><input type="text" class="form-control" name="allergies[${a}][severity]"></td>
                                <td><button onclick="deleteRowAllergy()"  class="btn-danger"><i class="fa fa-trash"></i></button></td>

                    </tr>
            `);
            }

            function Addmore() {
                var tableRow = document.getElementById('current_medications_table');
                var a = tableRow.rows.length;
                console.log('AAA ' + a);
                $('#current_medications_table').append(`
            <tr id="medicine-row${a}">
                                <td><input type="text" name="medications[${a}][medication_name]" class="form-control"></td>
                                <td><input type="text" class="form-control" name="medications[${a}][dosage]"></td>
                                <td><input type="text" class="form-control" name="medications[${a}][frequency]"></td>
                                <td><input type="text" class="form-control" name="medications[${a}][prescribing_physician]"></td>
                                <td><button onclick="deleteRowCMT()"  class="btn-danger"><i class="fa fa-trash"></i></button></td>

                    </tr>
            `);
            }


            $(document).ready(function() {
                $('#patient_mr_number').select2();
                $('#opd_id').select2();
                $('#patient_mr_number').change(function() {
                    var selectElement = document.getElementById('patient_mr_number');
                    var selectedOption = selectElement.options[selectElement.selectedIndex];

                    const PatientId = selectedOption.getAttribute('data-patient_id');
                    const BloodPressure = selectedOption.getAttribute('data-blood_pressure');
                    const HeartRate = selectedOption.getAttribute('data-heart_rate');
                    const RespiratoryRate = selectedOption.getAttribute('data-respiratory_rate');
                    const Temperature = selectedOption.getAttribute('data-temperature');
                    const Height = selectedOption.getAttribute('data-height');
                    const Weight = selectedOption.getAttribute('data-weight');
                    const BMI = selectedOption.getAttribute('data-bmi');
                    const dob = selectedOption.getAttribute('data-dob');
                    const contact_no = selectedOption.getAttribute('data-contact_no');
                    const first_name = selectedOption.getAttribute('data-first_name');
                    const last_name = selectedOption.getAttribute('data-last_name');

                    // Check if the data values are null and set the input field values accordingly
                    $("#patient_id").val(((PatientId !== null) ? PatientId : ``));
                    $("#blood_pressure").val(((BloodPressure !== null) ? BloodPressure : ``));
                    $("#heart_rate").val(((HeartRate !== null) ? HeartRate : ``));
                    $("#respiratory_rate").val(((RespiratoryRate !== null) ? RespiratoryRate : ``));
                    $("#temperature").val(((Temperature !== null) ? Temperature : ``));
                    $("#height").val(((Height !== null) ? Height : ``));
                    $("#weight").val(((Weight !== null) ? Weight : ``));
                    $("#bmi").val(((BMI !== null) ? BMI : ``));
                    $("#dob").val(((dob !== null) ? dob : ``));
                    $("#contact_no").val(((contact_no !== null) ? contact_no : ``));
                    var fullname = first_name + " " + last_name;
                    $("#fullname").val(((fullname !== null) ? fullname : ``)); 
                    console.log(fullname);
                    $("#patient_name").val(((fullname !== null) ? fullname : ``));



                    $.ajax({
                        type: "get",
                        url: "/nursing-form/opd/list",
                        data: {
                            patient_mr_number: $(this).val()
                        },
                        dataType: "json",
                        success: function(response) {
                            $("#opd_id").empty();
                            let isOPDavailabel = false;

                        }
                    });
                });
            });
        </script>
        {{-- <script>
            const heightInput = document.getElementById("height"); //height k inoput ki id
            const weightInput = document.getElementById("weight"); //weigh k input ki id 
            const bmiInput = document.getElementById("bmi"); // yhn p jonsi jagah p value show karani h whn ki id dedooo

            heightInput.addEventListener("input", calculateBMI);
            weightInput.addEventListener("input", calculateBMI);

            // Function to calculate BMI
            function calculateBMI() {
                const weightKg = parseFloat(weightInput.value);
                const heightCm = parseFloat(heightInput.value);

                // Convert height to meters (1 meter = 100 cm)
                const heightM = heightCm / 100;

                // Calculate BMI
                const bmi = (weightKg / (heightM * heightM)).toFixed(2);

                // Update the BMI input field
                bmiInput.value = isNaN(bmi) ? "" : bmi;

                // Determine BMI category based on the calculated BMI
                let bmiCategory = "";

                if (bmi < 18.5) {
                    bmiCategory = "Underweight";
                } else if (bmi >= 18.5 && bmi < 23) {
                    bmiCategory = "Normal";
                } else if (bmi >= 23 && bmi < 27) {
                    bmiCategory = "Overweight";
                } else if (bmi >= 27) {
                    bmiCategory = "Obese";
                }

                // Add the BMI category to the BMI input field
                if (bmiCategory) {
                    bmiInput.value += " (" + bmiCategory + ")";
                }
            }
        </script> --}}
    @endsection
