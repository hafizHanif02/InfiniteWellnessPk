<div>
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
            <div class="row">
                <div class="col-xxl-4 col-4">
                    <div class="d-sm-flex align-items-center text-sm-start">

                        <div class="">
                            <span class="badge bg-light-warning ">{{ !empty($opdPatientDepartment->opd_number) ? "#".$opdPatientDepartment->opd_number : __('messages.common.n/a') }}</span>
                            <div class="badge bg-light-primary ">MR: {{ $opdPatientDepartment->patient->id }}</div>
                            <h2><a href="#"
                                   class="text-decoration-none">{{ $opdPatientDepartment->patient->patientUser->full_name }}</a>
                            </h2>
                            <a href="mailto:{{ $opdPatientDepartment->patient->patientUser->email }}"
                               class="text-gray-600 text-decoration-none ">
                                {{ $opdPatientDepartment->patient->patientUser->email }}
                            </a>
                            <span class="mt-5">
                                @if(!empty($opdPatientDepartment->patient->address->address1) || !empty($opdPatientDepartment->patient->address->address2) || !empty($opdPatientDepartment->patient->address->city) || !empty($opdPatientDepartment->patient->address->zip))
                                    <span><i class="fas fa-location"></i></span>
                                @endif
                                <span class="">
                                    {{ !empty($opdPatientDepartment->patient->address->address1) ? $opdPatientDepartment->patient->address->address1 : '' }}{{ !empty($opdPatientDepartment->patient->address->address2) ? !empty($opdPatientDepartment->patient->address->address1) ? ',' : '' : '' }}
                                    {{ empty($opdPatientDepartment->patient->address->address1) || !empty($opdPatientDepartment->patient->address->address2)  ? !empty($opdPatientDepartment->patient->address->address2) ? $opdPatientDepartment->patient->address->address2 : '' : '' }}
                                    {{ empty($opdPatientDepartment->patient->address->address1) && empty($opdPatientDepartment->patient->address->address2) ? '' : '' }}{{ !empty($opdPatientDepartment->patient->address->city) ? ','.$opdPatientDepartment->patient->address->city : '' }}{{ !empty($opdPatientDepartment->patient->address->zip) ? ','.$opdPatientDepartment->patient->address->zip : '' }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-8 col-8">
                    <div class="row justify-content-center">
                        <div class="col-md-4 col-sm-4 col-4 col-4 ">
                            <div class="d-flex justify-content-between border rounded-10 p-2 ">
                                <h2 class="text-primary mb-3">{{ !empty($opdPatientDepartment->patient->cases) ? $opdPatientDepartment->patient->cases->count() : 0 }}</h2>
                                <h3 class="fs-5 fw-light text-gray-600 mb-0">{{__('messages.patient.total_cases')}}</h3>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-4 col-4 ">
                            <div class="d-flex justify-content-between border rounded-10 p-2 ">
                                <h2 class="text-primary mb-3">{{ !empty($opdPatientDepartment->patient->admissions) ? $opdPatientDepartment->patient->admissions->count() : 0 }}</h2>
                                <h3 class="fs-5 fw-light text-gray-600 mb-0">{{__('messages.patient.total_admissions')}}</h3>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-4 col-4">
                            <div class="d-flex justify-content-between border rounded-10 p-2 ">
                                <h2 class="text-primary mb-3">{{ !empty($opdPatientDepartment->patient->appointments) ? $opdPatientDepartment->patient->appointments->count() : 0 }}</h2>
                                <h3 class="fs-5 fw-light text-gray-600 mb-0">{{__('messages.patient.total_appointments')}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="mt-2 overflow-hidden">

        {{-- <ul class="nav nav-tabs mb-5 pb-1 overflow-auto flex-nowrap text-nowrap" id="myTab" role="tablist">
            <li class="nav-item position-relative me-7 mb-3" role="presentation">
                <button class="nav-link active p-0" id="opdPatientOverview" data-bs-toggle="tab"
                        data-bs-target="#opdOverview"
                        type="button" role="tab" aria-controls="overview" aria-selected="true">
                    {{ __('messages.overview') }}
                </button>
            </li>
            <li class="nav-item position-relative me-7 mb-3" role="presentation">
                <button class="nav-link p-0" id="opdVisitTab" data-bs-toggle="tab" data-bs-target="#opdVisits"
                        type="button" role="tab" aria-controls="cases" aria-selected="false">
                    {{ __('messages.opd_patient.visits') }}
                </button>
            </li>
            <li class="nav-item position-relative me-7 mb-3" role="presentation">
                <button class="nav-link p-0" id="opdDiagnosisTab" data-bs-toggle="tab" data-bs-target="#opdDiagnosis"
                        type="button" role="tab" aria-controls="patients" aria-selected="false">
                    {{ __('messages.ipd_diagnosis') }}
                </button>
            </li>
            <li class="nav-item position-relative me-7 mb-3" role="presentation">
                <button class="nav-link p-0" id="opdPatientsTimelinesTab" data-bs-toggle="tab"
                        data-bs-target="#opdPatientsTimelines"
                        type="button" role="tab" aria-controls="patients" aria-selected="false">
                    {{ __('messages.ipd_timelines') }}
                </button>
            </li>
        </ul> --}}
        <style>
            @media print {
            /* All your print styles go here */
            .btn-print { display: none !important; }
            }
        </style>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="opdOverview" role="tabpanel"
                 aria-labelledby="opdPatientOverview">

                <div class="card">
                    <a href="/dentalOpds" class="btn-print btn btn-warning" style="width: 200px;margin-left: 20px;">Back</a>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-4 col-4 d-flex flex-column mb-md-10 mb-5">
                                <label for="name"
                                       class="pb-2 fs-5 text-gray-600">{{ __('messages.case.case_id').':'  }}</label>
                                <p>
                                    <span class="badge bg-light-info">{{ !empty($opdPatientDepartment->case_id) ? $opdPatientDepartment->patientCase->case_id : __('messages.common.n/a') }}</span>
                                </p>
                            </div>
                            <div class="col-sm-4 col-4 d-flex flex-column mb-md-10 mb-5">
                                <label for="name"
                                       class="pb-2 fs-5 text-gray-600"> {{ __('messages.ipd_patient.height').':'  }}</label>
                                <span class="fs-5 text-gray-800">{{ !empty($opdPatientDepartment->height) ? $opdPatientDepartment->height : __('messages.common.n/a') }}</span>
                            </div>
                            <div class="col-sm-4 col-4 d-flex flex-column mb-md-10 mb-5">
                                <label for="name"
                                       class="pb-2 fs-5 text-gray-600">{{ __('messages.ipd_patient.weight').':' }}</label>
                                <span class="fs-5 text-gray-800">{{ !empty($opdPatientDepartment->weight) ? $opdPatientDepartment->weight : __('messages.common.n/a') }}</span>
                            </div>
                            <hr>
                            <div class="col-sm-4 col-4 d-flex flex-column mb-md-10 mb-5">
                                <label for="name"
                                       class="pb-2 fs-5 text-gray-600">{{ __('messages.ipd_patient.bp').':' }}</label>
                                <span class="fs-5 text-gray-800">{{ !empty($opdPatientDepartment->bp) ? $opdPatientDepartment->bp : __('messages.common.n/a') }}</span>
                            </div>
                            <div class="col-sm-4 col-4 d-flex flex-column mb-md-10 mb-5">
                                <label for="name"
                                       class="pb-2 fs-5 text-gray-600">{{ __('messages.opd_patient.appointment_date') }}</label>
                                <span class="fs-5 text-gray-800"
                                      title="{{ \Carbon\Carbon::parse($opdPatientDepartment->appointment_date)->diffForHumans() }}">{{ date('jS M, Y h:i A', strtotime($opdPatientDepartment->appointment_date)) }}</span>
                            </div>
                            <div class="col-sm-4 col-4 d-flex flex-column mb-md-10 mb-5">
                                <label for="name"
                                       class="pb-2 fs-5 text-gray-600">{{ __('messages.ipd_payments.payment_mode') }}</label>
                                <span class="fs-5 text-gray-800">{{ !empty($opdPatientDepartment->payment_mode_name) ? $opdPatientDepartment->payment_mode_name : __('messages.common.n/a') }}</span>
                            </div>
                            <hr>
                            <div class="col-sm-4 col-4 d-flex flex-column mb-md-10 mb-5">
                                <label for="name"
                                       class="pb-2 fs-5 text-gray-600">{{ __('messages.doctor_opd_charge.standard_charge') }}</label>
                                <span class="fs-5 text-gray-800">
                                    {{ !empty($opdPatientDepartment->standard_charge) ?
checkNumberFormat($opdPatientDepartment->standard_charge, strtoupper($opdPatientDepartment->currency_symbol ?? getCurrentCurrency()))
:
                                        __('messages.common.n/a') }}
                                </span>
                            </div>
                            <div class="col-sm-4 col-4 d-flex flex-column mb-md-10 mb-5">
                                <label for="name"
                                       class="pb-2 fs-5 text-gray-600">Followup Charge</label>
                                <span class="fs-5 text-gray-800">
                                    {{ !empty($opdPatientDepartment->followup_charge) ?
checkNumberFormat($opdPatientDepartment->followup_charge, strtoupper($opdPatientDepartment->currency_symbol ?? getCurrentCurrency()))
:
                                        __('messages.common.n/a') }}
                                </span>
                            </div>
                            <div class="col-sm-4 col-4 d-flex flex-column mb-md-10 mb-5">
                                <label for="name"
                                       class="pb-2 fs-5 text-gray-600">{{ __('messages.ipd_patient.is_old_patient').':' }}</label>
                                <span class="fs-5 text-gray-800">{{ ($opdPatientDepartment->is_old_patient) ? __('messages.common.yes') : __('messages.common.no') }}</span>
                            </div>
                            <hr>
                            <div class="col-sm-4 col-4 d-flex flex-column mb-md-10 mb-5">
                                <label for="name"
                                       class="pb-2 fs-5 text-gray-600">{{ __('messages.common.created_at').':' }}</label>
                                <span class="fs-5 text-gray-800">{{ !empty($opdPatientDepartment->created_at) ? $opdPatientDepartment->created_at->diffForHumans() : __('messages.common.n/a') }}</span>
                            </div>
                            <div class="col-sm-4 col-4 d-flex flex-column mb-md-10 mb-5">
                                <label for="name"
                                       class="pb-2 fs-5 text-gray-600">{{ __('messages.common.updated_at').':' }}</label>
                                <span class="fs-5 text-gray-800">{{ !empty($opdPatientDepartment->updated_at) ? $opdPatientDepartment->updated_at->diffForHumans() : __('messages.common.n/a') }}</span>
                            </div>
                            <div class="col-sm-4 col-4 d-flex flex-column mb-md-10 mb-5">
                                <label for="name"
                                       class="pb-2 fs-5 text-gray-600">{{ __('messages.ipd_patient.symptoms').':' }}</label>
                                <span class="fs-5 text-gray-800">{!!  !empty($opdPatientDepartment->symptoms)?nl2br(e($opdPatientDepartment->symptoms)) : __('messages.common.n/a')  !!}</span>
                            </div>
                            <hr>
                            <div class="col-sm-4 col-4 d-flex flex-column mb-md-10 mb-5">
                                <label for="name"
                                       class="pb-2 fs-5 text-gray-600">{{ __('messages.ipd_patient.notes').':' }}</label>
                                <span class="fs-5 text-gray-800">{!! !empty($opdPatientDepartment->notes)?nl2br(e($opdPatientDepartment->notes)) : __('messages.common.n/a')  !!}</span>

                            </div>
                            <div class="col-sm-4 col-4 d-flex flex-column mb-md-10 mb-5">
                                <label for="name"
                                       class="pb-2 fs-5 text-gray-600">Total Amount</label>
                                <span class="fs-5 text-gray-800">
                                    {{ !empty($opdPatientDepartment->total_amount) ?
    checkNumberFormat($opdPatientDepartment->total_amount, strtoupper($opdPatientDepartment->currency_symbol ?? getCurrentCurrency()))
    :
                                        __('messages.common.n/a') }}
                                </span>
                            </div>
                            <hr>
                        </div>
                        <h3>Services</h3>
                        <input type="hidden" id="serviceData" value="{{$opdPatientDepartment->service_id}}" />
                        <div class="row" id="allServices">



                        </div>
                            <script>
                                function serverDataUpdate(){
                                    let dataAll = document.getElementById("serviceData").value;
                                dataAll = JSON.parse(dataAll);
                                let htl = "";
                                dataAll.forEach((element, key) => {
                                    htl += '<div class="col-sm-3 col-2 d-flex flex-column mb-md-10 mb-5"><label for="name"' +
                                       'class="pb-2 fs-5 text-gray-600">'+ (key+1) + ") "+element.service +'</label>' +
                                '<span class="fs-5 text-gray-800"></span></div>';
                                });
                                console.log(htl);
                                document.getElementById("allServices").innerHTML = htl;
                                }

                                serverDataUpdate();
                            </script>
                    </div>
                </div>
            </div>
            {{-- <div class="tab-pane fade" id="opdVisits" role="tabpanel" aria-labelledby="opdVisitTab">
                <a href="{{ route('opd.patient.create').'?revisit='.$opdPatientDepartment->id }}"
                   class="btn btn-primary float-end">
                    {{ __('messages.opd_patient.revisits') }}
                </a>
                <livewire:opd-patient-visitor-table
                        opdPatientDepartment="{{$opdPatientDepartment->patient_id}}"
                        opdPatientDepartmentId="{{ $opdPatientDepartment->id }}"/>
            </div>
            <div class="tab-pane fade" id="opdDiagnosis" role="tabpanel" aria-labelledby="opdDiagnosisTab">
                <a href="javascript:void(0)" class="btn btn-primary float-end" data-bs-toggle="modal"
                   data-bs-target="#add_opd_diagnoses_modal">
                    {{ __('messages.ipd_patient_diagnosis.new_ipd_diagnosis') }}
                </a>
                <livewire:opd-diagnoses-table opdDiagnoses="{{$opdPatientDepartment->id}}"/>
            </div>
            <div class="tab-pane fade" id="opdPatientsTimelines" role="tabpanel"
                 aria-labelledby="opdPatientsTimelinesTab">
                <div id="opdPatientTimelines"></div>
            </div> --}}
        </div>
    </div>
</div>
