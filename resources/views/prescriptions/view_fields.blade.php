<div class="row">
    <div class="col-md-4 col-sm-6 co-12">
        <div class="image mb-7">
            {{-- <img src="{{ $data['app_logo'] }}" alt="user" class="img-fluid max-width-180"> --}}
        </div>
        @foreach ($prescriptions as $prescription)
            <h3>{{ !empty($prescription->doctor->doctorUser->full_name) ? $prescription->doctor->doctorUser->full_name : '' }}
            </h3>
            <h4 class="fs-5 text-gray-600 fw-light mb-0">
                {{ !empty($prescription->doctor->specialist) ? $prescription->doctor->specialist : $prescription->doctor->specialist }}
            </h4>
            @if (empty($prescription->doctor->address->address1) &&
                    empty($prescription->doctor->address->address2) &&
                    empty($prescription->doctor->address->city))
                {{-- {{ __('messages.common.n/a') }} --}}
            @else
                {{ !empty($prescription->doctor->address->address1) ? $prescription->doctor->address->address1 : '' }}
                {{ !empty($prescription->doctor->address->address2) ? (!empty($prescription->doctor->address->address1) ? ',' : '') : '' }}
                {{ empty($prescription->doctor->address->address1) || !empty($prescription->doctor->address->address2) ? (!empty($prescription->doctor->address->address2) ? $prescription->doctor->address->address2 : '') : '' }}
                {{ !empty($prescription->doctor->address->city) ? ',' : '' }}
                @if (!empty($prescription->doctor->address->city))
                    <br>
                @endif
                {{ !empty($prescription->doctor->address->city) ? $prescription->doctor->address->city : '' }}
                {{ !empty($prescription->doctor->address->zip) ? ',' : '' }}
                @if ($prescription->doctor->address->zip)
                    <br>
                @endif
                {{ !empty($prescription->doctor->address->zip) ? $prescription->doctor->address->zip : '' }}
                <p class="text-gray-600 mb-3">
                    {{ !empty($prescription->doctor->user->phone) ? $prescription->doctor->user->phone : '' }}
                </p>
                <p class="text-gray-600 mb-3">
                    {{ !empty($prescription->doctor->user->email) ? $prescription->doctor->user->email : '' }}
                </p>
            @endif
    </div>
    <div class="col-md-4 col-sm-6 co-12 mt-sm-0 mt-5">
        <h3>patient Information</h3>
        <div class="d-flex flex-row">
            <label for="name" class="pb-2 fs-5 text-gray-600 me-1">{{ __('messages.bill.patient_name') }}:</label>
            <span class="fs-5 text-gray-800">
                {{ !empty($prescription->patient->patientUser->full_name) ? $prescription->patient->patientUser->full_name : '' }}
            </span>
        </div>
        <div class="d-flex flex-row">
            <label for="name" class="pb-2 fs-5 text-gray-600 me-1">{{ __('messages.expense.date') }}:</label>
            <span class="fs-5 text-gray-800">
                {{ !empty(\Carbon\Carbon::parse($prescription->created_at)->isoFormat('DD/MM/Y')) ? \Carbon\Carbon::parse($prescription->created_at)->isoFormat('DD/MM/Y') : '' }}
            </span>
        </div>
        @if (isset($prescription->health_insurance) && !empty($prescription->health_insurance))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Health Insurance:</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->health_insurance)
                        {{ $prescription->health_insurance }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
        @if (isset($prescription->low_income) && !empty($prescription->low_income))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Low Income:</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->low_income)
                        {{ $prescription->low_income }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
        @if (isset($prescription->reference) && !empty($prescription->reference))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Reference :</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->reference)
                        {{ $prescription->reference }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
    </div>


    <div class="col-md-4 col-sm-6 co-12 mt-sm-0 mt-5">
        <h3>Physical Information</h3>
        @if (isset($prescription->high_blood_pressure) && !empty($prescription->high_blood_pressure))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">High Blood Pressure :</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->high_blood_pressure)
                        {{ $prescription->high_blood_pressure }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
        @if (isset($prescription->food_allergies) && !empty($prescription->food_allergies))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Food Allergies :</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->food_allergies)
                        {{ $prescription->food_allergies }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
        @if (isset($prescription->tendency_bleed) && !empty($prescription->tendency_bleed))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Tendency Bleed :</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->tendency_bleed)
                        {{ $prescription->tendency_bleed }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
        @if (isset($prescription->heart_disease) && !empty($prescription->heart_disease))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Heart Disease :</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->heart_disease)
                        {{ $prescription->heart_disease }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
        @if (isset($prescription->diabetic) && !empty($prescription->diabetic))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Diabetic :</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->diabetic)
                        {{ $prescription->diabetic }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
        @if (isset($prescription->medical_history) && !empty($prescription->medical_history))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Medical History :</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->medical_history)
                        {{ $prescription->medical_history }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
        @if (isset($prescription->female_pregnancy) && !empty($prescription->female_pregnancy))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Female Pregnancy :</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->female_pregnancy)
                        {{ $prescription->female_pregnancy }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
        @if (isset($prescription->breast_feeding) && !empty($prescription->breast_feeding))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Breast Feeding :</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->breast_feeding)
                        {{ $prescription->breast_feeding }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
        @if (isset($prescription->current_medication) && !empty($prescription->current_medication))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Current Medication :</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->current_medication)
                        {{ $prescription->current_medication }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
        @if (isset($prescription->surgery) && !empty($prescription->surgery))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Surgery :</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->surgery)
                        {{ $prescription->surgery }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
        @if (isset($prescription->accident) && !empty($prescription->accident))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Accident :</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->accident)
                        {{ $prescription->accident }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
        @if (isset($prescription->others) && !empty($prescription->others))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Others :</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->others)
                        {{ $prescription->others }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
        @if (isset($prescription->plus_rate) && !empty($prescription->plus_rate))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Pulse Rate :</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->plus_rate)
                        {{ $prescription->plus_rate }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
        @if (isset($prescription->temperature) && !empty($prescription->temperature))
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">Temperature :</label>
                <span class="fs-5 text-gray-800">
                    @if ($prescription->temperature)
                        {{ $prescription->temperature }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </span>
            </div>
        @endif
    </div>


    <div class="col-12 px-0">
        <hr class="line my-lg-10 mb-6 mt-4">
    </div>
    @if (isset($prescription->problem_description) && !empty($prescription->problem_description))
        <div class="col-md-4 col-sm-6 co-12">
            <h6>{{ __('messages.prescription.problem') }}:</h6>
            @if ($prescription->problem_description != null)
                <p class="text-gray-600 mb-2 fs-4">{{ $prescription->problem_description }}</p>
            @else
                {{ __('messages.common.n/a') }}
            @endif
        </div>
    @endif
    @if (isset($prescription->test) && !empty($prescription->test))
        <div class="col-md-4 col-sm-6 co-12 mt-sm-0 mt-5">
            <h6>{{ __('messages.prescription.test') }}:</h6>
            @if ($prescription->test != null)
                <p class="text-gray-600 mb-2 fs-4">{{ $prescription->test }}</p>
            @else
                {{ __('messages.common.n/a') }}
            @endif
        </div>
    @endif
    @if (isset($prescription->advice) && !empty($prescription->advice))
        <div class="col-md-4 col-sm-6 co-12 mt-md-0 mt-5">
            <h6>{{ __('messages.prescription.advice') }}:</h6>
            @if ($prescription->advice != null)
                <p class="text-gray-600  mb-2 fs-4">{{ $prescription->advice }}</p>
            @else
                {{ __('messages.common.n/a') }}
            @endif
        </div>
    @endif
    <div class="col-12 mt-6">
        <h6>{{ __('messages.prescription.rx') }}:</h6>
        <div class="table-responsive">
            <table class="table box-shadow-none">
                <thead>
                    <tr>
                        <th scope="col">{{ __('messages.prescription.medicine_name') }}</th>
                        <th scope="col">{{ __('messages.ipd_patient_prescription.dosage') }}</th>
                        <th scope="col">{{ __('messages.prescription.duration') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (empty($prescription->getMedicine))
                        <tr>
                            <td class="text-center" colspan="3">
                                {{ __('messages.prescription.no_data_available') }}
                            </td>
                        </tr>
                    @else
                        {{-- {{dd($prescription) }} --}}
                        @foreach ($prescription->getMedicine as $medicine)
                            <tr>
                                <td class="py-4 border-bottom-0">
                                    {{ $medicine->medicine === null ? 'Medicine Not Found' : $medicine->medicine->name }}
                                </td>
                                <td class="py-4 border-bottom-0">
                                    {{ $medicine->dosage === null ? 'Not Available' : $medicine->dosage }}
                                    @if ($medicine->time == 0)
                                        ({{ __('messages.prescription.after_meal') }})
                                    @else
                                        ({{ __('messages.prescription.before_meal') }})
                                    @endif
                                </td>
                                <td class="py-4 border-bottom-0">
                                    {{ $medicine->day === null ? 'Not Available' : $medicine->day }} Day</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between flex-wrap mt-5">
            <h4 class="mb-0 me-3 mt-3">
                @if ($prescription->next_visit_qty != null)
                    {{ __('messages.prescription.next_visit') }} : {{ $prescription->next_visit_qty }}
                    @if ($prescription->next_visit_time == 0)
                        {{ __('messages.prescription.days') }}
                    @elseif($prescription->next_visit_time == 1)
                        {{ __('messages.prescription.month') }}
                    @else
                        {{ __('messages.prescription.year') }}
                    @endif
                @endif
            </h4>
            <div class="mt-3">
                <br>
                <h4>{{ 'Dr. ' . $prescription->doctor->doctorUser->full_name }}</h4>
                <h6 class="text-gray-600 fw-light mb-0">{{ $prescription->doctor->specialist }}</h6>
            </div>
        </div>
    </div>
    @endforeach
</div>
