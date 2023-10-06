@extends('layouts.app3')
@section('title')
    Nursing From List
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Nursing Assessment Form</h3>
                <a href="{{ route('nursing.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <form action="{{route('nursing-form.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row mb-5 mt-5">
                        <div class="col-md-6">
                            <label for="patient_mr_number" class="form-label">MR #<sup class="text-danger">*</sup></label>
                            <select class="form-control" name="patient_mr_number" id="patient_mr_number" required>
                                <option value="" selected disabled>select mr number</option>
                                @foreach ($patients as $patient)
                                <option value="{{$patient->MR }}">{{$patient->MR }} ~ {{$patient->user->full_name }}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="opd_id" class="form-label">OPD<sup class="text-danger">*</sup></label>
                            <select class="form-control" name="opd_id" id="opd_id" required>
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
                    <div class="col-md-3">
                        <div class="mb-5">
                            <label for="bmi" class="form-label">BMI<sup class="text-danger">*</sup></label>
                            <input disabled type="text"  name="bmi" id="bmi" class="form-control">
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
                                    <button type="button" class="btn btn-primary" onclick="Addmore()" id="addmore-btn">Add More</button>
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
                        <tbody id="current_medications_table" >
                            <tr>
                                <td><input type="text" name="medications[0][medication_name]" class="form-control"></td>
                                <td><input type="text" class="form-control" name="medications[0][dosage]"></td>
                                <td><input type="text" class="form-control" name="medications[0][frequency]"></td>
                                <td><input type="text" class="form-control" name="medications[0][prescribing_physician]"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-body">
                        <h4>Allergies:</h4>
                    <table class="table table-bordered">
                        <thead>
                            <div class="row ">
                                <div class="col-md-2 mb-5 mt-5">
                                    <button type="button" class="btn btn-primary" onclick="addmoreallergy()" id="addmore-btn">Add More</button>
                                </div>
                            </div>
                            <tr>
                                <td>Allergen</td>
                                <td>Reaction</td>
                                <td>Severity</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody id="allergies_table">
                            <tr>
                                <td><input type="text" class="form-control" name="allergies[0][allergen]"></td>
                                <td><input type="text" class="form-control" name="allergies[0][reaction]"></td>
                                <td><input type="text" class="form-control" name="allergies[0][severity]"></td>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    function deleteRowCMT(){
        var table = document.querySelector("#current_medications_table");
        var lastRow = table.lastElementChild;
        table.removeChild(lastRow);
    }

    function deleteRowAllergy(){
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

    function Addmore(){
        var tableRow = document.getElementById('current_medications_table');
            var a = tableRow.rows.length;
            console.log('AAA '+a);
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

        $.ajax({
            type: "get",
            url: "/nursing-form/opd/list",
            data: {
                patient_mr_number: $(this).val()
            },
            dataType: "json",
            success: function(response) {
                $("#opd_id").empty();
                console.log(response);
                let isOPDavailabel = false;
                if (response.data.length !== 0) {
                    isOPDavailabel =true;
                    $('#opd_id').append(
                        `<option selected disabled>Select OPD </option>`);
                    $.each(response.data, function(index, value) {
                        $("#opd_id").append(
                            `
                    <option value="${value.opd_number}" data-doctor="${value.doctor.user.full_name}"  data-patient="${value.patient.user.full_name}" >
                    ${value.opd_number}
                    </option>`
                        );
                    });
                }
                if (response.data2.length !== 0) {
                    isOPDavailabel =true;
                    $.each(response.data2, function(index, value2) {
                        console.log(value2);
                        $("#opd_id").append(
                            `
                    <option value="${value2.opd_number}" data-patient="${value2.patient.user.full_name}" >
                    ${value2.opd_number}
                    </option>`
                        );
                    });
                }
                if(!isOPDavailabel) {
                    $("#opd_id").html(
                        `<option value="" class="text-danger" selected disabled>No any opd found!</option>`
                    );
                }
            }
        });
    });
});

    </script>
<script>
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


    </script>
@endsection
