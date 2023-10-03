<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xxl-5 col-12">
                    <div class="d-sm-flex align-items-center mb-5 mb-xxl-0 text-center text-sm-start">
                        <div class="image image-circle image-small">
                            <img src="{{ !empty($data->patientUser->image_url) ? $data->patientUser->image_url : '' }}" alt="image"/>
                        </div>
                        <div class="ms-0 ms-md-10 mt-5 mt-sm-0">
                            <h2><a href="javascript:void(0)"
                                   class="text-decoration-none">{{ !empty($data->patientUser->full_name) ? $data->patientUser->full_name : '' }}</a>
                            </h2>

                            <a href="mailto:{{ !empty($data->patientUser->email) ? $data->patientUser->email : '' }}"
                               class="text-gray-600 text-decoration-none fs-5">
                                {{ !empty($data->patientUser->email) ? $data->patientUser->email : '' }}
                            </a>
                            <span class="d-flex align-items-center me-2 mb-2 mt-2">
                                @if(!empty($data->address->address1) || !empty($data->address->address2) || !empty($data->address->city) || !empty($data->address->zip))
                                    <span><i class="fas fa-location"></i></span>
                                @endif
                                <span class="p-2">
                                    {{ !empty($data->address->address1) ? $data->address->address1 : '' }}{{ !empty($data->address->address2) ? !empty($data->address->address1) ? ',' : '' : '' }}
                                    {{ empty($data->address->address1) || !empty($data->address->address2)  ? !empty($data->address->address2) ? $data->address->address2 : '' : '' }}
                                    {{ empty($data->address->address1) && empty($data->address->address2) ? '' : '' }}{{ !empty($data->address->city) ? ','.$data->address->city : '' }}{{ !empty($data->address->zip) ? ','.$data->address->zip : '' }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-7 col-12">
                    <div class="row justify-content-center">
                        <div class="col-md-4 col-sm-6 col-12 mb-6 mb-md-0">
                            <div class="border rounded-10 p-5 h-100">
                                <h2 class="text-primary mb-3">{{!empty($data->cases) ? $data->cases->count() : 0}}</h2>
                                <h3 class="fs-5 fw-light text-gray-600 mb-0">{{__('messages.patient.total_cases')}}</h3>
                            </div>
                        </div>
                        {{-- <div class="col-md-4 col-sm-6 col-12 mb-6 mb-md-0">
                            <div class="border rounded-10 p-5 h-100">
                                <h2 class="text-primary mb-3">{{!empty($data->admissions) ? $data->admissions->count() : 0}}</h2>
                                <h3 class="fs-5 fw-light text-gray-600 mb-0">{{__('messages.patient.total_admissions')}}</h3>
                            </div>
                        </div> --}}
                        <div class="col-md-4 col-sm-6 col-12 mb-6 mb-md-0">
                            <div class="border rounded-10 p-5 h-100">
                                <h2 class="text-primary mb-3">{{!empty($data->appointments) ? $data->appointments->count() : 0}}</h2>
                                <h3 class="fs-5 fw-light text-gray-600 mb-0">{{__('messages.patient.total_appointments')}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-7 overflow-hidden">
        <ul class="nav nav-tabs mb-5 pb-1 overflow-auto flex-nowrap text-nowrap">
            @role('Admin')
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link active p-0" data-bs-toggle="tab"
                   href="#PatientOverview">{{ __('messages.overview') }}</a>
            </li>
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientCases">{{ __('messages.cases') }}</a>
            </li>
            {{-- <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientAdmissions">{{ __('messages.patient_admissions') }}</a>
            </li> --}}
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientAppointments">{{ __('messages.appointments') }}</a>
            </li>
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientBills">{{ __('messages.bills') }}</a>
            </li>
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientInvoices">{{ __('messages.invoices') }}</a>
            </li>
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientAdvancedPayments">{{ __('messages.advanced_payments') }}</a>
            </li>
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientDocument">{{ __('messages.documents') }}</a>
            </li>
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientVaccinated">{{ __('messages.vaccinations') }}</a>
            </li>
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#addonForms">Addon Forms</a>
            </li>
            {{-- <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#nutritionassessment">Dietitian Assessment</a>
            </li> --}}
            @endrole

            @role('Doctor')
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link active p-0" data-bs-toggle="tab"
                   href="#PatientOverview">{{ __('messages.overview') }}</a>
            </li>
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientCases">{{ __('messages.cases') }}</a>
            </li>

            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientAppointments">{{ __('messages.appointments') }}</a>
            </li>

            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientDocument">{{ __('messages.documents') }}</a>
            </li>
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientVaccinated">{{ __('messages.vaccinations') }}</a>
            </li>
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#addonForms">Addon Forms</a>
            </li>

            @endrole

            @role('Nurse')
                <li class="nav-item position-relative me-7 mb-3">
                    <a class="nav-link active p-0" data-bs-toggle="tab"
                    href="#PatientOverview">{{ __('messages.overview') }}</a>
                </li>
                <li class="nav-item position-relative me-7 mb-3">
                    <a class="nav-link p-0" data-bs-toggle="tab"
                    href="#showPatientCases">{{ __('messages.cases') }}</a>
                </li>
                <li class="nav-item position-relative me-7 mb-3">
                    <a class="nav-link p-0" data-bs-toggle="tab"
                       href="#addonForms">Addon Forms</a>
                </li>
                <li class="nav-item position-relative me-7 mb-3">
                    <a class="nav-link p-0" data-bs-toggle="tab"
                       href="#nutritionassessment">Dietitian Assessment</a>
                </li>
            @endrole

            @role('Dietitian')
                <li class="nav-item position-relative me-7 mb-3">
                    <a class="nav-link active p-0" data-bs-toggle="tab"
                    href="#PatientOverview">{{ __('messages.overview') }}</a>
                </li>
                <li class="nav-item position-relative me-7 mb-3">
                    <a class="nav-link p-0" data-bs-toggle="tab"
                    href="#showPatientCases">{{ __('messages.cases') }}</a>
                </li>
 
            @endrole
        </ul>
    </div>
</div>
<div class="tab-content" id="myPatientTabContent">
    <div class="tab-pane fade show active" id="PatientOverview" role="tabpanel">
        <div class="card mb-5 mb-xl-10">
            <div>
                <div class="card-body  border-top p-9">
                    <div class="row">
                        <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name"
                                   class="pb-2 fs-5 text-gray-600">{{ __('messages.user.phone') }}</label>
                            <p>
                                <span class="fs-5 text-gray-800">{{ !empty($data->patientUser->phone) ? $data->patientUser->phone :__('messages.common.n/a') }}</span>
                            </p>
                        </div>
                        <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name"
                                   class="pb-2 fs-5 text-gray-600">{{ __('messages.user.gender') }}</label>
                            <p>
                                <span class="fs-5 text-gray-800">{{ !empty($data->patientUser->phone) ? ($data->patientUser->gender != 1) ? __('messages.user.male') : __('messages.user.female') : '' }}</span>
                            </p>
                        </div>
                        <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name"
                                   class="pb-2 fs-5 text-gray-600">{{ __('messages.user.blood_group') }}</label>
                            <p>
                                @if(!empty($data->patientUser->blood_group))
                                    <span
                                            class="badge fs-6 bg-light-{{ !empty($data->patientUser->blood_group) ? 'success' : 'danger'  }}"> {{ $data->patientUser->blood_group }} </span>
                                @else
                                    <span
                                            class="fs-5 text-gray-800">{{ __('messages.common.n/a')}}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name"
                                   class="pb-2 fs-5 text-gray-600">{{ __('messages.user.dob') }}</label>
                            <p>
                                <span class="fs-5 text-gray-800">{{ !empty($data->patientUser->dob) ? \Carbon\Carbon::parse($data->patientUser->dob)->translatedFormat('jS M, Y') : __('messages.common.n/a') }}</span>
                            </p>
                        </div>
                        <div class="col-sm-6 d-flex flex-column">
                            <label for="name"
                                   class="pb-2 fs-5 text-gray-600">{{ __('messages.common.created_at') }}</label>
                            <p>
                                <span class="fs-5 text-gray-800">{{ !empty($data->patientUser->created_at) ? $data->patientUser->created_at->diffForHumans() : __('messages.common.n/a') }}</span>
                            </p>
                        </div>
                        <div class="col-sm-6 d-flex flex-column">
                            <label for="name"
                                   class="pb-2 fs-5 text-gray-600">{{ __('messages.common.updated_at') }}</label>
                            <p>
                                <span class="fs-5 text-gray-800">{{ !empty($data->patientUser->updated_at) ? $data->patientUser->updated_at->diffForHumans() : __('messages.common.n/a') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane fade" id="showPatientCases" role="tabpanel">
        <livewire:patient-case-table patientId="{{ $data->id }}"/>
    </div>
    <div class="tab-pane fade" id="showPatientAdmissions" role="tabpanel">
        <livewire:patient-admission-detail-table patientId="{{ $data->id }}"/>
    </div>
    <div class="tab-pane fade" id="showPatientAppointments" role="tabpanel">
        <livewire:patient-appoinment-detail-table patientId="{{ $data->id }}"/>
    </div>
    <div class="tab-pane fade" id="showPatientBills" role="tabpanel">
        <livewire:patient-bill-detail-table patientId="{{ $data->id }}"/>
    </div>
    <div class="tab-pane fade" id="showPatientInvoices" role="tabpanel">
        <livewire:patient-invoice-detail-table patientId="{{ $data->id}}"/>
    </div>
    <div class="tab-pane fade" id="showPatientAdvancedPayments" role="tabpanel">
        <livewire:patient-advance-payment-detail-table patient-id="{{ $data->id }}"/>
    </div>
    <div class="tab-pane fade" id="showPatientDocument" role="tabpanel">
        <livewire:patient-document-table patient-id="{{ $data->id }}"/>
    </div>
    <div class="tab-pane fade" id="showPatientVaccinated" role="tabpanel">
        <livewire:patient-vaccination-detail-table patient-id="{{ $data->id }}"/>
    </div>


    <div class="tab-pane fade" id="addonForms" role="tabpanel">

        <div class="card mb-5 mb-xl-10">
            <div>
                <div class="card-body  border-top p-9">

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Add New Form
                      </button>
                      <!--<div style="margin-top: 25px;display: flex;justify-content: space-between;flex-wrap: wrap;">-->

                    <div class="row" >





                      @foreach($currentForm as $form)
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <a href="/patients/{{$form->patientID}}/{{$form->id}}" target="_blank" ><div style="border: 1px solid #0ac074;margin: 20px 0;font-size: 20px;border-radius: 15px; padding: 50px 25px;background: #f6f6f6;">{{$form->formName}} | {{$form->formDate}}</div></a>
                      </div>
                      @endforeach

                    </div>
                      <!-- Modal -->
                      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <form method="post" action="/forms/{{ $data->id }}">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">New Form</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="patientID" value="{{$data->id}}"/>
                                <select class="form-select" aria-label="Default select example" name="formName">
                                    <option selected>Select Form</option>
                                    @foreach ($forms as $frData)
                                        <option value="{{$frData->id}}">{{$frData->formName}}</option>
                                    @endforeach
                                  </select>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                           </form>
                        </div>
                      </div>
                </div>
            </div>

            <div id="cardContainer"></div>
        </div>
    </div>
    <div class="tab-pane fade" id="nutritionassessment" role="tabpanel">

        <div class="card mb-5 mb-xl-10">
            <div>
                <div class="card-body  border-top p-9">
                    <!-- Tabs navs -->
                    <ul class="nav nav-tabs nav-fill mb-3" id="ex1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="ex2-tab-1" data-mdb-toggle="tab" href="#ex2-tabs-1" role="tab" aria-controls="ex2-tabs-1" aria-selected="true">Anthropometric Measurements</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="ex2-tab-2" data-mdb-toggle="tab" href="#ex2-tabs-2" role="tab" aria-controls="ex2-tabs-2" aria-selected="false">Nutritional Considerations</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="ex2-tab-3" data-mdb-toggle="tab" href="#ex2-tabs-3" role="tab" aria-controls="ex2-tabs-3" aria-selected="false">History</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="ex2-tab-4" data-mdb-toggle="tab" href="#ex2-tabs-4" role="tab" aria-controls="ex2-tabs-4" aria-selected="false">Nutritional Intervention Plan</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="ex2-tab-5" data-mdb-toggle="tab" href="#ex2-tabs-5" role="tab" aria-controls="ex2-tabs-5" aria-selected="false">Nutrition Requirements</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="ex2-tab-6" data-mdb-toggle="tab" href="#ex2-tabs-6" role="tab" aria-controls="ex2-tabs-6" aria-selected="false">Patient Follow Up</a>
                        </li>
                    </ul>
                    <!-- Tabs navs -->

                    <!-- Tabs content -->
                    <div class="tab-content" id="ex2-content">
                        <div class="tab-pane fade show active" id="ex2-tabs-1" role="tabpanel" aria-labelledby="ex2-tab-1">
                            <div style="
                    justify-content: center;
                    display: flex;">
                                <div style="background-color: aliceblue;
                    padding: 20px;

                    border-radius: 29px;
                    ">



                                    <form id="Anthropometric" class="row g-3" method="POST" >
@csrf

<div class="col-md-6">
    <label for="age" class="form-label">Age (years)</label>
    <input value="{{($dietdata === null)?'':$dietdata->age}}" placeholder="add your age"  type="number" name="age"  class="form-control" id="age" >
</div>


<div class="col-md-6">
    <label for="weight" class="form-label">Weight (kg)</label>
    <input type="number" name="weight" value="{{($nursingData === null) ? '' : $nursingData->weight }}" class="form-control" id="weight" placeholder="add you weight">
</div>


<div class="col-6">
    <label for="height" class="form-label">Height (cm)</label>
    <input type="number" name="height" value="{{($nursingData === null) ? '' : $nursingData->height }}" class="form-control" id="height" placeholder="Add your height">
</div>

                                        <div class="col-6"></div>

                                        <div class="col-md-3">
                                            <label for="bmi" class="form-label">Body Mass Index (BMI)</label>
                                            <div class="input-group">
                                                <input disabled type="text" name="bmi" value="0" class="form-control" name="bmi" id="bmi" aria-describedby="button-addon2">
                                            </div>
                                        </div>


                                        <div class="col-md-3 ">
                                            <label for="ibw" class="form-label">Ideal Body Weight (IBW)</label>
                                            <div class="input-group">
                                                <input disabled type="number" name="ibw" value="0" class="form-control" id="ibw" aria-describedby="button-addon2">
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <label for="nutritionalStatusCategory" class="form-label">Nutritional Status Category</label>
                                            <select name="nutritionalStatusCategory" id="nutritionalStatusCategory" class="form-select">
                                        <option value="Severely malnourished">Severely malnourished</option>
                                        <option value="Moderately malnourished">Moderately malnourished </option>
                                        <option value="Well nourished">Well nourished </option>
                                        <option value="Over nourished">Over nourished</option>
                                       </select>
                                         </div>


                                        <div class="col-md-3">
                                            <label for="pastDietaryPattern" class="form-label">Past Dietary Pattern</label>
                                            <select name="pastDietaryPattern" id="pastDietaryPattern" class="form-select">
                                        <option value="Severely malnourished">Compliant</option>
                                        <option value="Moderately malnourished">Partially- compliant</option>
                                        <option value="Well nourished">Non Compliant</option>
                                    </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="pastFluidIntake" class="form-label">Past Fluid Intake</label>
                                            <input type="number" name="pastFluidIntake" value="30" class="form-control" name="bmi" id="pastFluidIntake" placeholder="30">
                                        </div>


                                        <div class="col-md-3">
                                            <label for="foodAllergy" class="form-label">Previous Food Allergy (if any)</label>
                                            <input type="number" name="foodAllergy" value="30" class="form-control" name="foodAllergy" id="foodAllergy" placeholder="30">
                                        </div>


                                        <div class="col-md-3">
                                            <label for="activityFactor" class="form-label">Activity Factor</label>
                                            <select name="activityFactor" id="activityFactor" class="form-select">
                                        <option value="Sedentary: 1.2">Sedentary: 1.2</option>
                                        <option value="Active: (Exercise thrice a week) 1.4">Active: (Exercise thrice a week) 1.4
                                        </option>
                                        <option value="Very Active: (Exercise daily) 1.6">Very Active: (Exercise daily) 1.6</option>
                                    </select>
                                        </div>


                                        <div class="col-md-3">
                                            <label for="appetite" class="form-label">Appetite</label>
                                            <select name="appetite" id="appetite" class="form-select">
                                        <option value="Decreased">Decreased</option>
                                        <option value="Fair">Fair</option>
                                        <option value="Polyphagia">Polyphagia</option>
                                    </select>
                                        </div>



                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ex2-tabs-2" role="tabpanel" aria-labelledby="ex2-tab-2">
                            <div>
                                <div style="background-color: aliceblue;
                    padding: 20px;

                    border-radius: 29px;
                    ">


                                    <form id="Comorbidity" class="row g-3">

                                        <div class="col-md-12">
                                            <h2 style="    justify-content: center;
                                    display: flex;">Co-morbidity-Specific Nutritional Considerations</h2>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="Diabetes" value="Diabetes" id="diabetes">
                                                <label class="form-check-label" for="diabetes">
                                            Diabetes
                                        </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="Hypertension" value="Hypertension" id="hypertension">
                                                <label class="form-check-label" for="hypertension">
                                            Hypertension
                                        </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="Stroke" value="Stroke" id="stroke">
                                                <label class="form-check-label" for="stroke">
                                            Stroke
                                        </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="Cancer" value="Cancer" id="cancer">
                                                <label class="form-check-label" for="cancer">
                                            Cancer
                                        </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="Arthritis" value="Arthritis" id="arthritis">
                                                <label class="form-check-label" for="arthritis">
                                            Arthritis
                                        </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="chronicKidneyDisease" value="chronicKidneyDisease" id="chronicKidneyDisease">
                                                <label class="form-check-label" for="chronicKidneyDisease">
                                            Chronic Kidney Disease
                                        </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="copd" value="copd" id="copd">
                                                <label class="form-check-label" for="copd">
                                            Chronic Obstructive Pulmonary Disease (COPD)
                                        </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="Thyroid" value="Thyroid" id="thyroid">
                                                <label class="form-check-label" for="thyroid">
                                            Thyroid
                                        </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="Asthma" value="Asthma" id="asthma">
                                                <label class="form-check-label" for="asthma">
                                            Asthma
                                        </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="Alzheimer" value="Alzheimer" id="alzheimer">
                                                <label class="form-check-label" for="alzheimer">
                                            Alzheimer's
                                        </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="cysticFibrosis" value="cysticFibrosis" id="cysticFibrosis">
                                                <label class="form-check-label" for="cysticFibrosis">
                                            Cystic Fibrosis

                                        </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="inflammatoryBowelDisease" value="inflammatoryBowelDisease" id="inflammatoryBowelDisease">
                                                <label class="form-check-label" for="inflammatoryBowelDisease">
                                            Inflammatory Bowel Disease

                                        </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="osteoporosis" value="osteoporosis" id="osteoporosis">
                                                <label class="form-check-label" for="osteoporosis">
                                            Osteoporosis

                                        </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="mentalIllness" value="mentalIllness" id="mentalIllness">
                                                <label class="form-check-label" for="mentalIllness">
                                            Any other Mental Illness
                                        </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="polycysticOvarySyndrome" value="polycysticOvarySyndrome" id="polycysticOvarySyndrome">
                                                <label class="form-check-label" for="polycysticOvarySyndrome">
                                            Polycystic Ovary Syndrome

                                        </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="Depression" value="Depression" id="depression">
                                                <label class="form-check-label" for="depression">
                                            Depression

                                        </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="multipleSclerosis" name="multipleSclerosis" id="multipleSclerosis">
                                                <label class="form-check-label" for="multipleSclerosis">
                                            Multiple Sclerosis

                                        </label>
                                            </div>
                                            <div class="form-check">


                                                <div class="row mb-3">
                                                    <label for="inputEmail3" style="padding-right: inherit;margin-right: inherit;" class="col-sm-6 col-form-label">Any other specific:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="inputEmail3" id="inputEmail3">
                                                    </div>
                                                </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2"></div>


                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ex2-tabs-3" role="tabpanel" aria-labelledby="ex2-tab-3">
                            <div style="
                    justify-content: center;
                    display: flex;">
                                <div style="background-color: aliceblue;
                    padding: 20px;

                    border-radius: 29px;
                    ">




                                    <form id="History" class="row g-3">
                                        <div class="col-md-12">
                                            <h2 style="    justify-content: center;
                                    display: flex;">History</h2>
                                        </div>


                                        <div class="col-md-12">
                                            <h3> 24 hours dietary recall</h3>
                                        </div>


                                        <div class="col-md-6">
                                            <label for="Breakfast" class="form-label">Breakfast:
                                    </label>
                                            <input type="text" class="form-control" id="Breakfast" name="Breakfast">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="Midmorning" class="form-label"> Mid-morning / Evening snack:
                                    </label>
                                            <input type="text" class="form-control" id="Midmorning" name="Midmorning">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="Midmorning2" class="form-label"> Mid-morning / Evening snack:
                                    </label>
                                            <input type="text" class="form-control" id="Midmorning2" name="Midmorning2">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="Lunch" class="form-label"> Lunch:
                                    </label>
                                            <input type="text" class="form-control" id="Lunch" name="Lunch">
                                        </div>

                                        <div class="col-md-12">
                                            <h3> Exercise Regimen Followed in the Past
                                            </h3>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Regimen" class="form-label"> Exercise Regimen Followed in the Past
                                    </label>
                                            <input type="text" class="form-control" id="Regimen" name="Regimen">
                                        </div>




                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ex2-tabs-4" role="tabpanel" aria-labelledby="ex2-tab-4">
                            <div style="
                            justify-content: center;
                            display: flex;">
                                <div style="background-color: aliceblue;
                            padding: 20px;

                            border-radius: 29px;
                            ">




                                    <form id="Intervention" class="row g-3">
                                        <div class="col-md-12">
                                            <h2 style="    justify-content: center;
                                            display: flex;">Nutritional Intervention Plan</h2>
                                            <h2 style="    justify-content: center;
                         display: flex;">(Post Test)</h2>
                                        </div>


                                        <div class="col-md-12">
                                            <h3>Recommended Diet </h3>
                                        </div>


                                        <div class="col-md-6">
                                            <label for="Breakfastpost" class="form-label">Breakfast:
                                            </label>
                                            <input type="text" class="form-control" id="Breakfastpost" name="Breakfastpost">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="Midmorningpost" class="form-label"> Mid-morning / Evening snack:
                                            </label>
                                            <input type="text" class="form-control" id="Midmorningpost" name="Midmorningpost">
                                        </div>



                                        <div class="col-md-6">
                                            <label for="Lunchpost" class="form-label"> Lunch:
                                            </label>
                                            <input type="text" class="form-control" id="Lunchpost" name="Lunchpost">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="Dinnerpost" class="form-label"> Dinner:
                                            </label>
                                            <input type="text" class="form-control" id="Dinnerpost" name="Dinnerpost">
                                        </div>

                                        <div class="col-md-12">
                                            <h3> Clinical Exercise Recommendations

                                            </h3>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Regimenpost" class="form-label"> Clinical Exercise Recommendations

                                            </label>
                                            <input type="text" class="form-control" id="Regimenpost" name="Regimenpost">
                                        </div>




                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ex2-tabs-5" role="tabpanel" aria-labelledby="ex2-tab-5">
                            <div>
                                <div style="background-color: aliceblue;
                    padding: 20px;

                    border-radius: 29px;
                    ">



                                    <form id="Nutritiona" class="row g-3">
                                        <div class="col-md-12">
                                            <h2 style="    justify-content: center;
                                    display: flex;">Nutritional Requirement</h2>
                                        </div>


                                        <div class="col-md-4">
                                            <h3> Percent of Nutrients</h3>
                                            <div class="col-md-8 pt-4 pb-4">
                                                <label for="Protein" class="form-label">Protein %:
                                        </label>
                                                <input type="text" class="form-control" id="Protein" name="Protein">
                                            </div>
                                            <div class="col-md-8 pb-4">
                                                <label for="Carbohydrates" class="form-label">Carbohydrates %:
                                        </label>
                                                <input type="text" class="form-control" id="Carbohydrates" name="Carbohydrates">
                                            </div>
                                            <div class="col-md-8 pb-4">
                                                <label for="Fat" class="form-label">Fat %:
                                        </label>
                                                <input type="text" class="form-control" id="Fat" name="Fat">
                                            </div>
                                            <div class="col-md-8 pb-4">
                                                <label for="Fluid" class="form-label">Fluid Requirement as per body weight:

                                        </label>
                                                <input type="text" disabled class="form-control" id="Fluid" name="Fluid">
                                            </div>
                                            <div class="col-md-8 pb-4">
                                                <label for="Restriction" class="form-label">Fluid Restriction if any:

                                        </label>
                                                <input type="text" class="form-control" id="Restriction" name="Restriction">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <h3> Calorie Of Nutrients </h3>
                                            <div class="col-md-8 pt-4 pb-4">
                                                <label for="Proteincalories" class="form-label">
                                        </label>
                                                <input type="text" disabled class="form-control" id="Proteincaloriesval" name="Proteincalories">
                                            </div>
                                            <div class="col-md-8 pb-4">
                                                <label for="Carbohydratescalories" class="form-label">
                                        </label>
                                                <input type="text" disabled class="form-control" id="Carbohydratescaloriesval" name="Carbohydratescalories">
                                            </div>
                                            <div class="col-md-8 pb-4">
                                                <label for="Fatcalories" class="form-label">
                                        </label>
                                                <input type="text" disabled class="form-control" id="Fatcaloriesval" name="Fatcalories">
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <h3> Content of Nutrients in gm </h3>
                                            <div class="col-md-8 pt-4 pb-4">
                                                <label for="ProteinNutrients" class="form-label">
                                        </label>
                                                <input type="text" disabled class="form-control" id="ProteinNutrients" name="ProteinNutrients">
                                            </div>
                                            <div class="col-md-8 pb-4">
                                                <label for="CarbohydratesNutrients" class="form-label">
                                        </label>
                                                <input type="text" disabled class="form-control" id="CarbohydratesNutrients" name="CarbohydratesNutrients">
                                            </div>
                                            <div class="col-md-8 pb-4">
                                                <label for="FatNutrients" class="form-label">
                                        </label>
                                                <input type="text" disabled class="form-control" id="FatNutrients" name="FatNutrients">
                                            </div>

                                        </div>
                                        <div class="col-md-6">

                                            <div class="col-md-8 pt-4 pb-4">
                                                <label for="BasalEnergy" class="form-label">Basal Energy Expenditure (BEE)

                                        </label>
                                                <input type="text" disabled class="form-control" id="BasalEnergy" name="BasalEnergy">
                                            </div>


                                        </div>
                                        <div class="col-md-6">

                                            <div class="col-md-8 pt-4 pb-4">
                                                <label for="TotalCalories" disabled class="form-label">Total Calories

                                        </label>
                                                <input type="text" disabled class="form-control" id="TotalCalories" name="TotalCalories">
                                            </div>


                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ex2-tabs-6" role="tabpanel" aria-labelledby="ex2-tab-6">
                            <div style="background-color: aliceblue;
                            padding: 20px;

                            border-radius: 29px;
                            ">



                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" colspan="1">Date</th>
                                            <th scope="col" colspan="1">Time</th>
                                            <th scope="col" colspan="2">Weekly Follow Up</th>
                                            <th scope="col" colspan="2">Progress Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- //! First table starts -->

                                        <tr>
                                            <td>

                                            </td>
                                            <td>

                                            </td>
                                            <td>
                                                <h3>First Month</h3>
                                            </td>
                                            <td colspan="3">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="date" name="date1" class="form-control" id="date1" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <input type="time" name="time1" class="form-control" id="time1" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <p>First Week</p>
                                            </td>
                                            <td colspan="3">
                                                <input type="text" name="week1" class="form-control" id="week1" placeholder="ENTER TEXT HERE">
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <input type="date" name="date2" class="form-control" id="date2" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <input type="time" name="time2" class="form-control" id="time2" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <p>Second Week</p>
                                            </td>
                                            <td colspan="3">
                                                <input type="text" name="week2" class="form-control" id="week2" placeholder="ENTER TEXT HERE">
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <input type="date" name="date3" class="form-control" id="date3" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <input type="time" name="time3" class="form-control" id="time3" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <p>Third Week</p>
                                            </td>
                                            <td colspan="3">
                                                <input type="text" name="week3" class="form-control" id="week3" placeholder="ENTER TEXT HERE">
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <input type="date" name="date4" class="form-control" id="date4" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <input type="time" name="time4" class="form-control" id="time4" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <p>Fourth Week</p>
                                            </td>
                                            <td colspan="3">
                                                <input type="text" name="week4" class="form-control" id="week4" placeholder="ENTER TEXT HERE">
                                            </td>
                                        </tr>
                                        <!-- //! First table starts -->



                                        <!-- //! PART 2 -->
                                        <tr>
                                            <td>

                                            </td>
                                            <td>

                                            </td>
                                            <td>
                                                <h3>Second Month</h3>
                                            </td>
                                            <td colspan="3">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="date" name="date21" class="form-control" id="date21" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <input type="time" name="time21" class="form-control" id="time21" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <p>First Week</p>
                                            </td>
                                            <td colspan="3">
                                                <input type="text" name="week21" class="form-control" id="week21" placeholder="ENTER TEXT HERE">
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <input type="date" name="date22" class="form-control" id="date22" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <input type="time" name="time22" class="form-control" id="time22" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <p>Second Week</p>
                                            </td>
                                            <td colspan="3">
                                                <input type="text" name="week22" class="form-control" id="week22" placeholder="ENTER TEXT HERE">
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <input type="date" name="date33" class="form-control" id="date33" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <input type="time" name="time33" class="form-control" id="time33" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <p>Third Week</p>
                                            </td>
                                            <td colspan="3">
                                                <input type="text" name="week33" class="form-control" id="week33" placeholder="ENTER TEXT HERE">
                                            </td>
                                        </tr>
                                        <!-- //! PART 2 ends -->



                                        <!-- //! PART 333 -->
                                        <tr>
                                            <td>

                                            </td>
                                            <td>

                                            </td>
                                            <td>
                                                <h3>Third Month</h3>
                                            </td>
                                            <td colspan="3">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="date" name="date31" class="form-control" id="date31" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <input type="time" name="time31" class="form-control" id="time31" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <p>First Week</p>
                                            </td>
                                            <td colspan="3">
                                                <input type="text" name="week31" class="form-control" id="week31" placeholder="ENTER TEXT HERE">
                                            </td>
                                        </tr>



                                        <tr>
                                            <td>
                                                <input type="date" name="date88" class="form-control" id="date88" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <input type="time" name="time88" class="form-control" id="time88" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <p>Third Week</p>
                                            </td>
                                            <td colspan="3">
                                                <input type="text" name="week88" class="form-control" id="week88" placeholder="ENTER TEXT HERE">
                                            </td>
                                        </tr>
                                        <!-- //! PART 3333 ends -->






                                        <!-- //! PART 44 -->
                                        <tr>
                                            <td>

                                            </td>
                                            <td>

                                            </td>
                                            <td>
                                                <h3>Third Month</h3>
                                            </td>
                                            <td colspan="3">

                                            </td>
                                        </tr>



                                        <tr>
                                            <td>
                                                <input type="date" name="date42" class="form-control" id="date42" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <input type="time" name="time42" class="form-control" id="time42" placeholder="ENTER TEXT HERE">
                                            </td>
                                            <td>
                                                <p>Second Week</p>
                                            </td>
                                            <td colspan="3">
                                                <input type="text" name="week42" class="form-control" id="week42" placeholder="ENTER TEXT HERE">
                                            </td>
                                        </tr>




                                        <!-- //! PART 444 ends -->




                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div style="display: flex;
                                justify-content: center;" class="col-12">
                                    <button id="submitButton" style="
                                    padding: 5px 20px 5px 20px;
                                " type="submit" class="btn btn-primary">Save</button>
                                </div>
                    </div>
                    <!-- Tabs content -->
                      </div>
                </div>
            </div>


        </div>
    </div>

    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $("#saveChangesBtn").click(function() {
            var selectedForm = $("#formSelect").val();
            if (selectedForm !== "Select Form") {
                var newCard = '<div class="card mb-3">' +
                    '<div class="card-body">' +
                    '<h5 class="card-title">Selected Form: ' + selectedForm + '</h5>' +
                    '<p class="card-text">This is a new card added dynamically.</p>' +
                    '</div>' +
                    '</div>';
                $("#cardContainer").append(newCard);
            }
            $('#exampleModal').modal('hide'); // Close the modal after saving changes
        });
    });
</script>


<script>
    // Add event listeners to the height and weight input fields
const heightInput = document.getElementById("height");
const weightInput = document.getElementById("weight");
const bmiInput = document.getElementById("bmi");
const ibwInput = document.getElementById("ibw");

heightInput.addEventListener("input", calculateBMI);
weightInput.addEventListener("input", calculateBMI);
heightInput.addEventListener("input", calculateIBW);
weightInput.addEventListener("input", calculateIBW);

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

// Function to calculate IBW
function calculateIBW() {
    // Get height in centimeters
    const heightCm = parseFloat(heightInput.value);
    const gender = "male"; // Static variable to specify gender ("male" or "female")

    // Calculate IBW based on gender
    let ibw;

    if (gender === "male") {
        ibw = 50 + 2.3 * ((heightCm - 152.4) / 2.54); // Convert height from cm to inches
    } else if (gender === "female") {
        ibw = 45.5 + 2.3 * ((heightCm - 152.4) / 2.54); // Convert height from cm to inches
    } else {
        ibw = NaN; // Invalid gender
    }

    // Update the IBW input field with the calculated value
    ibwInput.value = isNaN(ibw) ? "" : ibw.toFixed(2); // Display IBW with two decimal places
}

// Initial calculations when the page loads
calculateBMI();
calculateIBW();


document.addEventListener("DOMContentLoaded", function() {
    // var TotalCalories = "50"; // Initial value for Total Calories
    var totalCaloriesField = document.getElementById("TotalCalories");
    totalCaloriesField.value = TotalCalories;

    var proteinField = document.getElementById("Protein");
    var carbohydratesField = document.getElementById("Carbohydrates");
    var fatField = document.getElementById("Fat");

    // Event listener for the "Protein" input field
    proteinField.addEventListener("input", function() {
        calculateProtienCalories();
    });

    // Event listener for the "Carbohydrates" input field
    carbohydratesField.addEventListener("input", function() {
        calculateCarbohydratesCalories();
    });

    // Event listener for the "Fat" input field
    fatField.addEventListener("input", function() {
        calculateFatCalories();
    });


    function calculateProtienCalories() {
        var ProteinenteredValue = parseFloat(proteinField.value);
        var proteincaloriesVal = document.getElementById("Proteincaloriesval");
        var proteincaloriesgmVal = document.getElementById("ProteinNutrients");

        if (!isNaN(ProteinenteredValue)) {
            var protiencalories = (TotalCalories / 100) * (ProteinenteredValue / 100);
            var protiencaloriesgm = (TotalCalories / 100) * (ProteinenteredValue / 100) / 4;
            console.log("Protein Calories Value:", protiencalories);
            console.log("Protein Calories gm Value:", protiencaloriesgm);
            proteincaloriesVal.value = protiencalories.toFixed(2);
            proteincaloriesgmVal.value = protiencaloriesgm.toFixed(2);

        } else {
            console.log("Invalid input. Please enter a valid number for Protein.");
        }
    }

    function calculateCarbohydratesCalories() {
        var CarbohydratesenteredValue = parseFloat(carbohydratesField.value);
        var CarbohydratescaloriesVal = document.getElementById("Carbohydratescaloriesval");
        var CarbohydratescaloriesgmVal = document.getElementById("CarbohydratesNutrients");

        if (!isNaN(CarbohydratesenteredValue)) {
            var carbohydratescalories = (TotalCalories / 100) * (CarbohydratesenteredValue / 100);
            var carbohydratescaloriesgm = (TotalCalories / 100) * (CarbohydratesenteredValue / 100) / 4;
            console.log("Carbohydrates Calories Value:", carbohydratescalories);
            console.log("Carbohydrates Calories gm Value:", carbohydratescaloriesgm);

            CarbohydratescaloriesVal.value = carbohydratescalories.toFixed(2);
            CarbohydratescaloriesgmVal.value = carbohydratescaloriesgm.toFixed(2);


        } else {
            console.log("Invalid input. Please enter a valid number for Carbohydrates.");
        }
    }


    function calculateFatCalories() {
        var FatenteredValue = parseFloat(fatField.value);
        var FatcaloriesVal = document.getElementById("Fatcaloriesval");
        var FatcaloriesgmVal = document.getElementById("FatNutrients");


        if (!isNaN(FatenteredValue)) {
            var fatcalories = (TotalCalories / 100) * (FatenteredValue / 100);
            var fatcaloriesgm = (TotalCalories / 100) * (FatenteredValue / 100) / 9;
            console.log("Fat Calories Value:", fatcalories);
            console.log("Fat Calories gm Value:", fatcaloriesgm);
            FatcaloriesVal.value = fatcalories.toFixed(2);
            FatcaloriesgmVal.value = fatcaloriesgm.toFixed(2);


        } else {
            console.log("Invalid input. Please enter a valid number for Fat.");
        }
    }
});


// bmr
var gender = "male"; // Change to "female" if needed

// Hardcoded values for weight, height, and age
var weightKg = 70; // Example weight in kilograms
var heightCm = 175; // Example height in centimeters
var ageYears = 30; // Example age in years
var activityFactor = 1.375; // Example activity factor

// Function to calculate BMR based on gender
function calculateBMR(gender, weight, height, age) {
    if (gender === "male") {
        return 10 * weight + 6.25 * height - 5 * age + 5;
    } else if (gender === "female") {
        return 10 * weight + 6.25 * height - 5 * age - 161;
    }
    return 0; // Default if gender is not recognized
}

// Calculate BMR based on hardcoded gender and values
var bmr = calculateBMR(gender, weightKg, heightCm, ageYears);
var TotalCalories = bmr * activityFactor;

var fluidRequirement;
if (ageYears >= 16 && ageYears <= 30) {
    fluidRequirement = 40 * weightKg;
} else if (ageYears >= 31 && ageYears <= 55) {
    fluidRequirement = 35 * weightKg;
} else if (ageYears >= 56 && ageYears <= 75) {
    fluidRequirement = 30 * weightKg;
} else {
    fluidRequirement = 0; // Default if age is not within specified ranges
}

console.log('bmd', bmr)
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("BasalEnergy").value = bmr.toFixed(2);
    document.getElementById("Fluid").value = fluidRequirement.toFixed(2);
});


console.log("totallllll", TotalCalories)
</script>
<script>
    $(document).ready(function() {
        $("#submitButton").click(function() {
          var formData = $("#Anthropometric").serialize();


          var csrfToken = $('input[name="_token"]').val();


          var apiUrl = "/patients/{{$data->id}}";

          $.ajax({
            type: "POST",
            url: apiUrl,
            data: formData,
            headers: {
              'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {

              console.log("Form submitted successfully:", response);
            },
            error: function(error) {

              console.error("Error submitting the form:", error);
            }
          });
        });
      });

</script>
<script>
    <script>
    $(document).ready(function() {
        $("#submitButton").click(function() {
            var formData = new FormData();

            formData.append('Anthropometric', $("#Anthropometric").serialize());
            formData.append('Comorbidity', $("#Comorbidity").serialize());
            formData.append('History', $("#History").serialize());
            formData.append('Intervention', $("#Intervention").serialize());
            formData.append('Nutritiona', $("#Nutritiona").serialize());

            $("table tbody tr").each(function(index, row) {
                formData.append('date[]', $(row).find("input[type='date']").val());
                formData.append('time[]', $(row).find("input[type='time']").val());
                formData.append('week[]', $(row).find("input[type='text']").val());
            });

            var csrfToken = $('input[name="_token"]').val();
            formData.append('_token', csrfToken);

            $.ajax({
                type: "POST",
                url: "/patients/{{$data->id}}",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                                contentType: false,
                success: function(response) {
                    console.log("Forms submitted successfully:", response);
                },
                error: function(error) {
                    console.error("Error submitting the forms:", error);
                }
            });
        });
    });
</script>

    </script>
