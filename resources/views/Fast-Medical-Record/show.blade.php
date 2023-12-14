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
            {{-- <form action="{{ route('fast-medical-record.store') }}" method="POST">
                @csrf --}}
            <div class="card-body">
                <div class="row mb-5 mt-3">
                    <div class="col-md-4">
                        <label for="patient_name" class="form-label">Patient Name<sup class="text-danger">*</sup></label>
                        <input type="text" id="patient_name" value="{{ $Fast_Medical_Record->patient_name }}" disabled
                            class="form-control">
                    </div>

                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="dob" class="form-label">Date of Birth<sup class="text-danger">*</sup></label>
                            <input type="text" name="dob" value="{{ $Fast_Medical_Record->dob }}" disabled
                                id="dob" disabled class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="contact_no" class="form-label">Contact No.<sup class="text-danger">*</sup></label>
                            <input type="text" name="contact" value="{{ $Fast_Medical_Record->contact }}" id="contact_no"
                                disabled class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row mb-5 mt-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="referred_by" class="form-label">Referred By<sup class="text-danger">*</sup></label>
                            <input type="text" name="referred_by" value="{{ $Fast_Medical_Record->referred_by }}"
                                id="referred_by" disabled class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="referral_date" class="form-label">Referral Date<sup
                                    class="text-danger">*</sup></label>
                            <input type="date" name="referrel_date" value="{{ $Fast_Medical_Record->referrel_date }}"
                                id="referral_date" disabled class="form-control">
                        </div>
                    </div>
                </div>
            </div>


            <div class="card-body">
                <h4>Pre-Test Consulation:</h4>
                <div class="row mt-3">

                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="pretest-date" class="form-label">Date<sup class="text-danger">*</sup></label>
                            <input type="date" name="pre_test_date" value="{{ $Fast_Medical_Record->pre_test_date }}"
                                id="pretest-date" disabled class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="pretest-status" class="form-label">Status<sup class="text-danger">*</sup></label>
                            @if ($Fast_Medical_Record->pre_test_status == 1)
                                <input type="text" name="pre_test_status" value="Completed" id="pretest-status" disabled
                                    class="form-control">
                            @else
                                <input type="text" name="pre_test_status" value="In Completed" id="pretest-status"
                                    disabled class="form-control">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <h4>Blood Collection Appointment:</h4>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="bloodCollection-date" class="form-label">Date<sup
                                    class="text-danger">*</sup></label>
                            <input type="date" value="{{ $Fast_Medical_Record->blood_collection_date }}"
                                name="blood_collection_date" id="bloodCollection-date" disabled class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="bloodCollection-amount" class="form-label">Amount<sup
                                    class="text-danger">*</sup></label>
                            <input type="number" disabled value="{{ $Fast_Medical_Record->blood_collection_amount }}"
                                name="blood_collection_amount" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label for="bloodCollection-status" class="form-label">Status<sup
                                    class="text-danger">*</sup></label>
                                    @if ($Fast_Medical_Record->blood_collection_status == 1)
                                        <input type="text" name="blood_collection_status"
                                            value="Completed" id="bloodCollection-status" disabled
                                            class="form-control">
                                    @else
                                        <input type="text" name="blood_collection_status"
                                            value="In Completed" id="bloodCollection-status" disabled
                                            class="form-control">
                                        
                                    @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label for="dateOfShipment" class="form-label">Date Of Shipment<sup
                                    class="text-danger">*</sup></label>
                            <input type="date" value="{{ $Fast_Medical_Record->date_of_shipment }}"
                                name="date_of_shipment" id="dateOfShipment" disabled class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <h4>Fast Test Report:</h4>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="fastTest-date" class="form-label">Date<sup class="text-danger">*</sup></label>
                            <input type="date" value="{{ $Fast_Medical_Record->fast_test_report_date }}"
                                name="fast_test_report_date" id="fastTest-date" disabled class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="fastTest-status" class="form-label">Status<sup
                                    class="text-danger">*</sup></label>
                            @if ($Fast_Medical_Record->fast_test_report_status == 1)
                                <input type="text" name="fast_test_report_status" value="Provided"
                                    id="fastTest-status" disabled class="form-control">
                            @else
                                <input type="text" name="fast_test_report_status" value="Not Provided"
                                    id="fastTest-status" disabled class="form-control">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <h4>Report Review Session:</h4>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="reportReview-date" class="form-label">Date<sup
                                    class="text-danger">*</sup></label>
                            <input type="date" value="{{ $Fast_Medical_Record->report_session_date }}"
                                name="report_session_date" id="reportReview-date" disabled class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="reportReview-status" class="form-label">Status<sup
                                    class="text-danger">*</sup></label>
                            @if ($Fast_Medical_Record->report_session_status == 1)
                                <input type="text" name="report_session_status" value="Provided"
                                    id="reportReview-status" disabled class="form-control">
                            @else
                                <input type="text" name="report_session_status" value="Not Provided"
                                    id="reportReview-status" disabled class="form-control">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <h4>Post-Test Consulation:</h4>
                <div class="row mt-3">

                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="post-date" class="form-label">Date<sup class="text-danger">*</sup></label>
                            <input type="date" value="{{ $Fast_Medical_Record->post_test_consult_date }}"
                                name="post_test_consult_date" id="post-date" disabled class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="post-status" class="form-label">Status<sup class="text-danger">*</sup></label>
                            @if ($Fast_Medical_Record->post_test_consult_status == 1)
                                <input type="text" name="post_test_consult_status" value="Completed" id="post-status"
                                    disabled class="form-control">
                            @else
                                <input type="text" name="post_test_consult_status" value="In Completed"
                                    id="post-status" disabled class="form-control">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <h4>POST Post-Test Consulation:</h4>
                <div class="row mt-3">

                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="postpost-date" class="form-label">Date<sup class="text-danger">*</sup></label>
                            <input type="date" value="{{ $Fast_Medical_Record->post_post_test_date }}"
                                name="post_post_test_date" id="postpost-date" disabled class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="postpost-status" class="form-label">Status<sup
                                    class="text-danger">*</sup></label>
                            @if ($Fast_Medical_Record->post_post_test_status == 1)
                                <input type="text" name="post_post_test_status" value="Completed"
                                    id="postpost-status" disabled class="form-control">
                            @else
                                <input type="text" name="post_post_test_status" value="In Completed"
                                    id="postpost-status" disabled class="form-control">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <h4>RE-Test Consulation:</h4>
                <div class="row mt-3">

                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="retest-date" class="form-label">Date<sup class="text-danger">*</sup></label>
                            <input type="date" value="{{ $Fast_Medical_Record->retest_date }}" name="retest_date"
                                id="retest-date" disabled class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="retest-status" class="form-label">Status<sup class="text-danger">*</sup></label>
                            @if ($Fast_Medical_Record->retest_date_status == 1)
                                <input type="text" name="retest_status" value="Completed" id="retest-status" disabled
                                    class="form-control">
                            @else
                                <input type="text" name="retest_status" value="In Completed" id="retest-status"
                                    disabled class="form-control">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="dietitian" class="form-label">Dietitian<sup class="text-danger">*</sup></label>
                            <input type="text" value="{{ $Fast_Medical_Record->dietitian }}" name="dietitian"
                                id="dietitian" disabled class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="retest-status" class="form-label">Comment<sup class="text-danger">*</sup></label>
                            <textarea name="comment" disabled id="comment" cols="30" rows="10" class="form-control">
                                    {{ $Fast_Medical_Record->comment }}
                                </textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                        <a href="{{ route('fast-medical-record.index') }}" class="text-white text-decoration-none">
                            <button type="button" class="btn btn-primary w-25">Back</button>
                        </a>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>

            {{-- </form> --}}

        </div>


        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            let allInput = document.getElementsByTagName("input");
            for (let index = 0; index < allInput.length; index++) {
                allInput[index].value = allInput[index].value.trim();
            }
            let allInput2 = document.getElementsByTagName("textarea");
            for (let index = 0; index < allInput2.length; index++) {
                allInput2[index].value = allInput2[index].value.trim();
            }
        </script>
    @endsection
