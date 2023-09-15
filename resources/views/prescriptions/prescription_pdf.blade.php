<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "//www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="icon" href="{{ asset('web/img/hms-saas-favicon.ico') }}" type="image/png">
    <title>{{ __('messages.prescription.prescription') }}</title>
    <link href="{{ asset('assets/css/prescriptions-pdf.css') }}" rel="stylesheet" type="text/css"/>
    @if(getCurrentCurrency() == 'inr')
        <style>
            body {
                font-family: DejaVu Sans, sans-serif !important;
            }
        </style>
    @endif
</head>
<body>
    {{-- {{dd($prescription) }} --}}
    <div class="row">
        <div class="col-md-4 col-sm-6 co-12">
            <div class="image mb-7">
                {{-- <img src="{{ $data['app_logo'] }}" alt="user" class="img-fluid max-width-180"> --}}
            </div>
            <h3>
                {{ !empty($prescription->doctor->doctorUser->full_name) ? $prescription->doctor->doctorUser->full_name : '' }}
            </h3>
            <h4 class="fs-5 text-gray-600 fw-light mb-0">
                {{ !empty($prescription->doctor->specialist) ? $prescription->doctor->specialist : '' }}
            </h4>
        </div>
        <div class="col-md-4 col-sm-6 co-12 mt-sm-0 mt-5 header-right">
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">{{ __('messages.bill.patient_name') }}:</label>
                <span class="fs-5 text-gray-800">
                    {{ !empty($prescription->patient->patientUser->full_name) ? $prescription->patient->patientUser->full_name : '' }}
                </span>
            </div>
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">{{ __('messages.expense.date') }}:</label>
                <span class="fs-5 text-gray-800">
                    {{ !empty(\Carbon\Carbon::parse($prescription->created_at)->isoFormat('DD/MM/Y')) ? \Carbon\Carbon::parse($prescription->created_at)->isoFormat('DD/MM/Y') : ''}}
                </span>
            </div>
            <div class="d-flex flex-row">
                <label for="name" class="pb-2 fs-5 text-gray-600 me-1">{{ __('messages.blood_donor.age') }}:</label>
                <span class="fs-5 text-gray-800">
                    @if($prescription->patient->patientUser->dob)
                        {{ \Carbon\Carbon::parse($prescription->patient->patientUser->dob)->diff(\Carbon\Carbon::now())->y }}
                        {{ __('messages.prescription.year') }}
                    @else
                        {{-- {{ __('messages.common.n/a') }} --}}
                    @endif
                </span>
            </div>
        </div>
        <div class="col-md-4 co-12 mt-md-0 mt-5">
            {{-- {{dd($prescription)}} --}}
                {{-- {{ !empty($prescription->doctor->address->address1) ? $prescription->doctor->address->address1 : '' }}
                {{ !empty($prescription->doctor->address->address2) ? !empty($prescription->doctor->address->address1) ? ',' : '' : '' }}
                {{ empty($prescription->doctor->address->address1) || !empty($prescription->doctor->address->address2)  ? !empty($prescription->doctor->address->address2) ? $prescription->doctor->address->address2  : '' : ''  }}
                {{ !empty($prescription->doctor->address->city) ? ',' : '' }}
                @if(!empty($prescription->doctor->address->city))
                    <br>
                @endif --}}
                {{-- {{ !empty($prescription->doctor->address->city) ? $prescription->doctor->address->city : '' }}
                {{ !empty($prescription->doctor->address->zip) ? ',' : '' }}
                @if($prescription->doctor->address->zip)
                    <br>
                @endif --}}
                {{-- {{ !empty($prescription->doctor->address->zip) ? $prescription->doctor->address->zip : '' }} --}}
                <p class="text-gray-600 mb-3">
                    {{ !empty($prescription->doctor->doctorUser->phone) ? $prescription->doctor->doctorUser->phone : '' }}
                </p>
                <p class="text-gray-600 mb-3">
                    {{ !empty($prescription->doctor->doctorUser->email) ? $prescription->doctor->doctorUser->email : '' }}
                </p>
        </div>
        <div class="col-12 px-0">
            <hr class="line my-lg-10 mb-6 mt-4">
        </div>
        <div class="col-md-4 col-sm-6 co-12">
            <h3>{{ __('messages.prescription.problem') }}:</h3>
            @if($prescription->problem_description != null)
                <p class="text-gray-600 mb-2 fs-4">{{ $prescription->problem_description }}</p>
            @else
                {{ __('messages.common.n/a') }}
            @endif
        </div>
        <div class="col-md-4 col-sm-6 co-12 mt-sm-0 mt-5">
            <h3>{{ __('messages.prescription.test') }}:</h3>
            @if($prescription->test != null)
                <p class="text-gray-600 mb-2 fs-4">{{ $prescription->test }}</p>
            @else
                {{ __('messages.common.n/a') }}
            @endif
        </div>
        <div class="col-md-4 col-sm-6 co-12 mt-md-0 mt-5">
            <h3>{{ __('messages.prescription.advice') }}:</h3>
            @if($prescription->advice != null)
                <p class="text-gray-600  mb-2 fs-4">{{ $prescription->advice }}</p>
            @else
                {{ __('messages.common.n/a') }}
            @endif
        </div>
        <div class="col-12 mt-6">
            <h3>{{ __('messages.prescription.rx') }}:</h3>
            <table class="items-table">
                <thead>
                <tr>
                    <th scope="col">{{ __('messages.prescription.medicine_name') }}</th>
                    <th scope="col">{{ __('messages.ipd_patient_prescription.dosage') }}</th>
                    <th scope="col">{{ __('messages.prescription.duration') }}</th>
                </tr>
                </thead>
                <tbody>
                
                    @foreach($prescription->getMedicine as $medicine)
         
                            <tr>
                                <td class="py-4 border-bottom-0">{{ $medicine->medicine->name }}</td>
                                <td class="py-4 border-bottom-0">
                                    {{ $medicine->dosage }}
                                    @if($medicine->time == 0)
                                        ({{ __('messages.prescription.after_meal') }})
                                    @else
                                        ({{  __('messages.prescription.before_meal')}})
                                    @endif
                                </td>
                                <td class="py-4 border-bottom-0">{{ $medicine->day }} Day</td>
                            </tr>
                         
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between flex-wrap mt-5">
                <h4 class="mb-0 me-3 mt-3">
                    @if($prescription->next_visit_qty != null)
                        {{ __('messages.prescription.next_visit') }} : {{ $prescription->next_visit_qty }}
                        @if($prescription->next_visit_time == 0)
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
                    <h4>{{ !empty($prescription->doctor->doctorUser->full_name) ? $prescription->doctor->doctorUser->full_name : '' }}</h4>
                    <h5 class="text-gray-600 fw-light mb-0">{{ !empty($prescription->doctor->specialist) ? $prescription->doctor->specialist : '' }}</h5>
                </div>
            </div>
        </div>
    </div>
{{-- @endforeach --}}
<style media="print">
    @page {
            size: A4;
            margin: 0;
            background: true; 
        }
</style>
<script>
    window.print();
</script>
</body>
