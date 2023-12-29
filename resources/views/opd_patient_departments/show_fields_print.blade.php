<div>
    <thead>
        <div style="text-align: right; " class="mt-2">
            <p>{{ __(' Date:') }} {{ now()->toDateString() }}</p>
        </div>
        <center>
            <div style="margin-top: 25px !important; margin-bottom: 25px !important; margin-left: 20px !important">
                <img src="https://app.infinitewellnesspk.com/logo.png" width="120px" alt="logo">
            </div>

            <div style="margin-top: 25px !important; margin-bottom: 10px !important; margin-left: 20px !important">
                <h2>Infinite Wellness PK</h2>
            </div>
        </center>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-4">
                                            <strong>{{ __('Patient MR #') }}</strong><br>
                                            <span
                                                class="badge bg-light-primary">{{ $opdPatientDepartment->patient->MR }}</span><br><br>
                                        </div>
                                        <div class="col-4">
                                            <strong>{{ __('Name') }}</strong><br>
                                            <h2 style="margin-top: -5px;"><a href="#"
                                                    class="text-decoration-none">{{ $opdPatientDepartment->patient->patientUser->full_name }}</a>
                                            </h2><br>
                                        </div>
                                        <div class="col-4">
                                            <strong>{{ __('Email') }}</strong><br>
                                            <a href="mailto:{{ $opdPatientDepartment->patient->patientUser->email }}"
                                                class="text-gray-600 text-decoration-none">
                                                {{ $opdPatientDepartment->patient->patientUser->email }}
                                            </a>
                                        </div>
                                        @if (
                                            !empty($opdPatientDepartment->patient->address->address1) ||
                                                !empty($opdPatientDepartment->patient->address->address2) ||
                                                !empty($opdPatientDepartment->patient->address->city) ||
                                                !empty($opdPatientDepartment->patient->address->zip))
                                            <hr style="border-top: 1px solid #000;"><br>
                                        @endif
                                        <!-- Address -->
                                        <p>
                                            {{ !empty($opdPatientDepartment->patient->address->address1) ? $opdPatientDepartment->patient->address->address1 : '' }}{{ !empty($opdPatientDepartment->patient->address->address2) ? ', ' . $opdPatientDepartment->patient->address->address2 : '' }}<br>
                                            {{ !empty($opdPatientDepartment->patient->address->city) ? $opdPatientDepartment->patient->address->city . ', ' : '' }}{{ !empty($opdPatientDepartment->patient->address->zip) ? $opdPatientDepartment->patient->address->zip : '' }}
                                        </p>
                                    </div>
                                    <!-- Patient Details -->
                                    <hr style="border-top: 1px solid #000;"><br>
                                    <div class="row">
                                        <div class="col-4">
                                            <strong>{{ __('Opd No#') }}</strong><br>
                                            <span
                                                class="badge bg-light-warning">{{ !empty($opdPatientDepartment->opd_number) ? '#' . $opdPatientDepartment->opd_number : __('messages.common.n/a') }}</span><br><br>
                                        </div>
                                        <div class="col-4">
                                            <strong>{{ __('messages.case.case_id') }}</strong><br>
                                            <span
                                                class="badge bg-light-info">{{ !empty($opdPatientDepartment->case_id) ? $opdPatientDepartment->patientCase->case_id : __('messages.common.n/a') }}</span><br><br>
                                        </div>
                                        <div class="col-4">
                                            <strong>{{ __('messages.ipd_patient.doctor_id') }}</strong><br>
                                            {{ $opdPatientDepartment->doctor->doctorUser->full_name }}<br><br>
                                        </div>
                                    </div>
                                    <hr style="border-top: 1px solid #000;"><br>
                                    <div class="row">
                                        <div class="col-4">
                                            <strong>{{ __('messages.opd_patient.appointment_date') }}</strong><br>
                                            <span
                                                title="{{ \Carbon\Carbon::parse($opdPatientDepartment->appointment_date)->diffForHumans() }}">
                                                {{ date('jS M, Y h:i A', strtotime($opdPatientDepartment->appointment_date)) }}
                                            </span>
                                            <br><br>
                                        </div>
                                        <div class="col-4">
                                            <strong>{{ __('messages.ipd_payments.payment_mode') }}</strong><br>
                                            {{ !empty($opdPatientDepartment->payment_mode_name) ? $opdPatientDepartment->payment_mode_name : __('messages.common.n/a') }}<br><br>
                                        </div>
                                        <div class="col-4">
                                            <strong>{{ __('messages.doctor_opd_charge.standard_charge') }}</strong><br>
                                            {{ !empty($opdPatientDepartment->standard_charge) ? checkNumberFormat($opdPatientDepartment->standard_charge, strtoupper($opdPatientDepartment->currency_symbol ?? getCurrentCurrency())) : __('messages.common.n/a') }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
            <div style="position: fixed; left: 0; bottom: 0; width: 100%;text-align: center">
                <div class="row">
                    <div class="col">
                        <div style="  text-align: center;">
                            <p>Ntn # 4459721-1</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div style="text-align: center;">
                            <p>Plot No.35/135. CP & Berar Cooperative Housing Society,PECHS, Block 7/8, Karachi East.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
