@extends('layouts.app3')
@section('title')
    F.A.S.T Medical Record
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>F.A.S.T Medical Record</h3>
                <a href="{{ route('fast-medical-record.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <form action="{{ route('fast-medical-record.store') }}" method="POST" id="myForm">
                @csrf
                <div class="card-body">
                    <div class="row mb-5 mt-5">
                        <div class="col-md-4">
                            <label for="patient_name" class="form-label">MR #<sup class="text-danger">*</sup></label>
                            <select class="form-select" name="patient_name" id="patient_name">
                                <option selected disabled>select mr number</option>
                                @foreach ($patients as $patient)
                                    <option value="{{ $patient->user->full_name }}"
                                        {{ old('patient_name') == $patient->user->full_name ? 'selected' : '' }}
                                        data-blood_pressure="{{ $patient->blood_pressure }}"
                                        data-patient_id="{{ $patient->id }}" data-heart_rate="{{ $patient->heart_rate }}"
                                        data-respiratory_rate="{{ $patient->respiratory_rate }}"
                                        data-temperature="{{ $patient->temperature }}" data-height="{{ $patient->height }}"
                                        data-weight="{{ $patient->weight }}" data-bmi="{{ $patient->bmi }}"
                                        data-dob="{{ $patient->user->dob }}" data-contact_no="{{ $patient->user->phone }}"
                                        data-first_name="{{ $patient->user->first_name }}"
                                        data-last_name="{{ $patient->user->last_name }}">
                                        {{ $patient->MR }}
                                        ~ {{ $patient->user->full_name }}</option>
                                @endforeach
                            </select>
                            @error('patient_name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="dob" class="form-label">Date of Birth<sup
                                        class="text-danger">*</sup></label>
                                <input type="text" name="dob" value="{{ old('dob') }}" id="dob"
                                    class="form-control">
                                @error('dob')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="contact_no" class="form-label">Contact No.<sup
                                        class="text-danger">*</sup></label>
                                <input type="text" name="contact" value="{{ old('contact') }}" id="contact"
                                    class="form-control">
                                @error('contact')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5 mt-5">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="referred_by" class="form-label">Referred By<sup
                                        class="text-danger">*</sup></label>
                                <input type="text" value="{{ old('referred_by') }}" name="referred_by" id="referred_by"
                                    class="form-control">
                                @error('referred_by')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="referral_date" class="form-label">Referral Date<sup
                                        class="text-danger">*</sup></label>
                                <input type="date" value="{{ old('referrel_date') }}" name="referrel_date"
                                    id="referrel_date" class="form-control">
                                @error('referrel_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    <h4>Pre-Test Consulation:</h4>
                    <div class="row mt-2">

                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="pretest-date" class="form-label">Date<sup class="text-danger">*</sup></label>
                                <input type="date" value="{{ old('pre_test_date') }}" name="pre_test_date"
                                    id="pre_test_date" class="form-control">
                                @error('pre_test_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="pretest-status" class="form-label">Status<sup
                                        class="text-danger">*</sup></label>
                                <select name="pre_test_status" class="form-select" id="pre_test_status">
                                    <option value="" selected disabled>select status</option>
                                    <option value="1" {{ old('pre_test_status') == '1' ? 'selected' : '' }}>Completed
                                    </option>
                                    <option value="0" {{ old('pre_test_status') == '0' ? 'selected' : '' }}>In
                                        Completed</option>
                                </select>
                                @error('pre_test_status')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h4>Blood Collection Appointment:</h4>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="bloodCollection-date" class="form-label">Date<sup
                                        class="text-danger">*</sup></label>
                                <input type="date" value="{{ old('blood_collection_date') }}"
                                    name="blood_collection_date" id="blood_collection_date" class="form-control">
                                @error('blood_collection_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="bloodCollection-amount" class="form-label">Amount<sup
                                        class="text-danger">*</sup></label>
                                <input type="number" value="{{ old('blood_collection_amount') }}"
                                    name="blood_collection_amount" class="form-control" id="blood_collection_amount">
                                @error('blood_collection_amount')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="bloodCollection-status" class="form-label">Status<sup
                                        class="text-danger">*</sup></label>
                                <select name="blood_collection_status" class="form-select" id="blood_collection_status">
                                    <option value="" selected disabled>select status</option>
                                    <option value="1" {{ old('blood_collection_status') == '1' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="0" {{ old('blood_collection_status') == '0' ? 'selected' : '' }}>
                                        In Completed</option>
                                </select>
                                @error('blood_collection_status')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label for="date_of_shipment" class="form-label">Date Of Shipment<sup
                                        class="text-danger">*</sup></label>
                                <input type="date" value="{{ old('date_of_shipment') }}" name="date_of_shipment"
                                    id="date_of_shipment" class="form-control">
                                @error('date_of_shipment')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h4>Fast Test Report:</h4>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="fast_test_report_date" class="form-label">Date<sup
                                        class="text-danger">*</sup></label>
                                <input type="date" value="{{ old('fast_test_report_date') }}"
                                    name="fast_test_report_date" id="fast_test_report_date" class="form-control">
                                @error('fast_test_report_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="fast_test_report_status" class="form-label">Status<sup
                                        class="text-danger">*</sup></label>
                                <select name="fast_test_report_status" class="form-select" id="fast_test_report_status">
                                    <option value="" selected disabled>select status</option>
                                    <option value="1" {{ old('fast_test_report_status') == '1' ? 'selected' : '' }}>
                                        Provided</option>
                                    <option value="0" {{ old('fast_test_report_status') == '0' ? 'selected' : '' }}>
                                        Not Provided</option>
                                </select>
                                @error('fast_test_report_status')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h4>Report Review Session:</h4>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="report_session_date" class="form-label">Date<sup
                                        class="text-danger">*</sup></label>
                                <input type="date" value="{{ old('report_session_date') }}"
                                    name="report_session_date" id="report_session_date" class="form-control">
                                @error('report_session_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="report_session_status" class="form-label">Status<sup
                                        class="text-danger">*</sup></label>
                                <select name="report_session_status" class="form-select" id="report_session_status">
                                    <option value="" selected disabled>select status</option>
                                    <option value="1" {{ old('report_session_status') == '1' ? 'selected' : '' }}>
                                        Provided</option>
                                    <option value="0" {{ old('report_session_status') == '0' ? 'selected' : '' }}>Not
                                        Provided</option>
                                </select>
                                @error('report_session_status')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h4>Post-Test Consulation:</h4>
                    <div class="row mt-2">

                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="post_test_consult_date" class="form-label">Date<sup
                                        class="text-danger">*</sup></label>
                                <input type="date" value="{{ old('post_test_consult_date') }}"
                                    name="post_test_consult_date" id="post_test_consult_date" class="form-control">
                                @error('post_test_consult_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="post_test_consult_status" class="form-label">Status<sup
                                        class="text-danger">*</sup></label>
                                <select name="post_test_consult_status" class="form-select"
                                    id="post_test_consult_status">
                                    <option value="" selected disabled>select status</option>
                                    <option value="1" {{ old('post_test_consult_status') == '1' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="0" {{ old('post_test_consult_status') == '0' ? 'selected' : '' }}>
                                        In Completed</option>
                                </select>
                                @error('post_test_consult_status')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h4>POST Post-Test Consulation:</h4>
                    <div class="row mt-2">

                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="post_post_test_date" class="form-label">Date<sup
                                        class="text-danger">*</sup></label>
                                <input type="date" value="{{ old('post_post_test_date') }}"
                                    name="post_post_test_date" id="post_post_test_date" class="form-control">
                                @error('post_post_test_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="post_post_test_status" class="form-label">Status<sup
                                        class="text-danger">*</sup></label>
                                <select name="post_post_test_status" class="form-select" id="post_post_test_status">
                                    <option value="" selected disabled>select status</option>
                                    <option value="1" {{ old('post_post_test_status') == '1' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="0" {{ old('post_post_test_status') == '0' ? 'selected' : '' }}>In
                                        Completed</option>
                                </select>
                                @error('post_post_test_status')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h4>RE-Test Consulation:</h4>
                    <div class="row mt-2">

                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="retest_date" class="form-label">Date<sup class="text-danger">*</sup></label>
                                <input type="date" value="{{ old('retest_date') }}" name="retest_date"
                                    id="retest_date" class="form-control">
                                @error('retest_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="retest_date_status" class="form-label">Status<sup
                                        class="text-danger">*</sup></label>
                                <select name="retest_date_status" class="form-select" id="retest_date_status">
                                    <option value="" selected disabled>select status</option>
                                    <option value="1" {{ old('retest_date_status') == '1' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="0" {{ old('retest_date_status') == '0' ? 'selected' : '' }}>In
                                        Completed</option>
                                </select>
                                @error('retest_date_status')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="dietitian" class="form-label">Dietitian<sup
                                        class="text-danger">*</sup></label>
                                <input type="text" value="{{ old('dietitian') }}" name="dietitian" id="dietitian"
                                    class="form-control">
                                @error('dietitian')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="retest-status" class="form-label">Comment<sup
                                        class="text-danger">*</sup></label>
                                <textarea name="comment" id="comment" cols="30" rows="10" class="form-control">
                                    {{ old('comment') }}
                                </textarea>
                                @error('comment')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mt-2">

                        <div class="col-md-4"></div>
                        <div class="col-md-4 text-center">
                            <button type="submit" id="submit" class="btn btn-primary w-25">Submit</button>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                </div>

        </div>

        </form>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            let allInput = document.getElementsByTagName("input");
            for (let index = 0; index < allInput.length; index++) {
                allInput[index].value = allInput[index].value.trim();
            }
            let allInput2 = document.getElementsByTagName("textarea");
            for (let index = 0; index < allInput2.length; index++) {
                allInput2[index].value = allInput2[index].value.trim();
            }
            $('#patient_name').select2();
            $('#opd_id').select2();
            $('#patient_name').change(function() {
                var selectElement = document.getElementById('patient_name');
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
                $("#contact").val(((contact_no !== null) ? contact_no : ``));
                var fullname = first_name + " " + last_name;
                $("#fullname").val(((fullname !== null) ? fullname : ``));
                console.log(fullname);
                $("#patient_name").val(((fullname !== null) ? fullname : ``));



                $.ajax({
                    type: "get",
                    url: "/nursing-form/opd/list",
                    data: {
                        patient_name: $(this).val()
                    },
                    dataType: "json",
                    success: function(response) {
                        $("#opd_id").empty();
                        let isOPDavailabel = false;

                    }
                });
            });
        });

        $(document).ready(function() {
            $('#submit').prop('disabled', true);
            $('form input, form select, form textarea').on('input change', function() {
                console.log("first");
                if (
                    $('#patient_name').val() !== '' &&
                    $('#referred_by').val() !== '' &&
                    $('#dob').val() !== '' &&
                    $('#contact').val() !== '' &&
                    $('#referrel_date').val() !== '' &&
                    $('#pre_test_date').val() !== '' &&
                    $('#pre_test_status').val() !== '' &&
                    $('#blood_collection_date').val() !== '' &&
                    $('#blood_collection_amount').val() !== '' &&
                    $('#blood_collection_status').val() !== '' &&
                    $('#date_of_shipment').val() !== '' &&
                    $('#fast_test_report_date').val() !== '' &&
                    $('#fast_test_report_status').val() !== '' &&
                    $('#report_session_date').val() !== '' &&
                    $('#report_session_status').val() !== '' &&
                    $('#post_test_consult_date').val() !== '' &&
                    $('#post_test_consult_status').val() !== '' &&
                    $('#post_post_test_date').val() !== '' &&
                    $('#post_post_test_status').val() !== '' &&
                    $('#retest_date').val() !== '' &&
                    $('#retest_date_status').val() !== '' &&
                    $('#dietitian').val() !== '' &&
                    $('#comment').val() !== ''
                ) {
                    $('#submit').prop('disabled', false);
                    console.log('if condition');
                } else {
                    $('#submit').prop('disabled', true);
                    console.log('else condition');
                }
            });
        });
    </script>
@endsection
