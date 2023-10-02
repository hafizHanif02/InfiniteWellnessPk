@extends('layouts.app3')
@section('title')
    Nursing From List
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Nursing Assessment Form</h3>
                <a href="/nursing-form" class="btn btn-secondary">Back</a>
            </div>

            <form action="{{route('nursing-form.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row mb-5 mt-5">
                        <div class="col-md-6">
                            <label for="patient_mr_number" class="form-label">MR #<sup class="text-danger">*</sup></label>
                            <input class="form-control" value="{{$patients->MR}} - {{$patients->user->first_name}} {{$patients->user->last_name}}" disabled/>
                        </div>
                        <div class="col-md-6">
                            <label for="opd_id" class="form-label">OPD<sup class="text-danger">*</sup></label>
                            <input class="form-control" value="{{$nursing->opd_id}}" disabled/>
                        </div>
                    </div>
                </div>
            <div class="card-body">
                <h4>VITAL SIGNS:</h4>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-5">
                                <label for="blood_pressure" class="form-label">Blood Pressure<sup class="text-danger">*</sup></label>
                                <input class="form-control" value="{{$nursing->blood_pressure}}" disabled/>
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
                                <input class="form-control" value="{{$nursing->heart_rate}}" disabled/>
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
                                <input class="form-control" value="{{$nursing->respiratory_rate}}" disabled/>
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
                                <input class="form-control" value="{{$nursing->temperature}}" disabled/>
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
                                <input class="form-control" value="{{$nursing->height}}" disabled/>
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
                                <input class="form-control" value="{{$nursing->weight}}" disabled/>
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
                                <input class="form-control" value="{{$nursing->blood_pressure}}" disabled/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                        <h4>Current Medications:</h4>

                    <table class="table table-bordered">
                        <thead>

                            <tr>
                                <td>Medication Name</td>
                                <td>Dosage </td>
                                <td>Frequency </td>
                                <td>Prescribing Physician</td>

                            </tr>
                        </thead>
                        <tbody id="current_medications_table" >
                            @foreach ($medication as $med)
                                <tr>
                                    <td><input class="form-control" value="{{$med->medication_name}}" disabled/></td>
                                    <td><input class="form-control" value="{{$med->dosage}}" disabled/></td>
                                    <td><input class="form-control" value="{{$med->frequency}}" disabled/></td>
                                    <td><input class="form-control" value="{{$med->prescribing_physician}}" disabled/></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-body">
                        <h4>Allergies:</h4>
                    <table class="table table-bordered">
                        <thead>

                            <tr>
                                <td>Allergen</td>
                                <td>Reaction</td>
                                <td>Severity</td>

                            </tr>
                        </thead>
                        <tbody id="allergies_table">
                            @foreach ($allergies as $alle)
                            <tr>
                                <td><input class="form-control" value="{{$alle->allergen}}" disabled/></td>
                                <td><input class="form-control" value="{{$alle->reaction}}" disabled/></td>
                                <td><input class="form-control" value="{{$alle->severity}}" disabled/></td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>



                    <div class="row">
                        <div class="col-md-6">
                            <label for="assessment_date" class="form-label">Assessment Date</label>
                            <input class="form-control" value="{{$nursing->assessment_date}}" disabled/>
                        </div>
                        <div class="col-md-6">
                            <label for="nurse_name" class="form-label">Nurse's Name</label>
                            <input class="form-control" value="{{$nursing->nurse_name}}" disabled/>
                        </div>
                    </div>

                    <div class="row mb-5 mt-5">
                        <div class="col-md-12">
                            <label for="signature" class="form-label">Signature</label>
                            <input class="form-control" value="{{$nursing->signature}}" disabled/>
                        </div>
                    </div>

                    <div class="row text-center mb-5 mt-10">
                        <div class="col-md-12">
                            <a href="/nursing-form" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>


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
                if (response.data.length !== 0) {
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
                else {
                    $("#opd_id").html(
                        `<option value="" class="text-danger" selected disabled>No any opd found!</option>`
                    );
                }
            }
        });
    });
});

    </script>

@endsection
