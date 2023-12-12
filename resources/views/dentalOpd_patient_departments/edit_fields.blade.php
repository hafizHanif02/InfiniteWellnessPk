{{ Form::hidden('revisit', isset($data['last_visit']) ? $data['last_visit']->id : null) }}
{{ Form::hidden('currency_symbol', getCurrentCurrency(), ['class' => 'currencySymbol']) }}
<div class="row gx-10 mb-5">

    <div class="col-md-3">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('patient_id', __('MR / Patient name') . ':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::select('patient_id', $data['patients'], isset($data['last_visit']) ? $data['last_visit']->patient_id : null, ['class' => 'form-select', 'required', 'id' => 'opdPatientId', 'placeholder' => 'Select Patient', 'data-control' => 'select2','readonly']) }}
            </div>
        </div>
    </div>
    <input type="hidden" name="appointment_id" value="{{ $dentalOpdPatientDepartment->appointment_id }}">
    <div class="col-md-3">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('case_id', __('messages.ipd_patient.case_id') . ':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::select('case_id', [null], null, ['class' => 'form-select', 'required', 'id' => 'opdCaseId', 'disabled', 'data-control' => 'select2', 'placeholder' => 'Choose Case']) }}
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('opd_number', __('messages.opd_patient.opd_number') . ':', ['class' => 'form-label']) }}
                {{ Form::text('opd_number', $data['opdNumber'], ['class' => 'form-control', 'readonly']) }}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('appointment_date', __('messages.opd_patient.appointment_date') . ':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::datetime('appointment_date', $dentalOpdPatientDepartment->appointment_date, ['class' => getLoggedInUser()->thememode ? 'bg-light form-control' : 'bg-white form-control', 'id' => 'opdAppointmentDate', 'autocomplete' => 'off', 'required']) }}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('doctor_id', __('messages.ipd_patient.doctor_id') . ':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::select('doctor_id', $data['doctors'], isset($data['last_visit']) ? $data['last_visit']->doctor_id : null, ['class' => 'form-select', 'required', 'id' => 'opdDoctorId', 'placeholder' => 'Select Doctor', 'data-control' => 'select2']) }}
            </div>
        </div>
    </div>
    @if ($dentalOpdPatientDepartment->standard_charge != 0)
        <div class="col-md-3">
            <div class="mb-5">
                <div class="mb-5">
                    <div class="form-group">
                        <label id="opdStandardChargeLabel" for="opdStandardCharge">Standard Charge</label>
                        <span class="required"></span>
                        <div class="input-group">
                            {{ Form::text('standard_charge', $dentalOpdPatientDepartment->standard_charge, ['class' => 'form-control price-input', 'id' => 'opdStandardCharge', 'required','readonly']) }}
                            <div class="input-group-text border-0"><a><span>{{ getCurrencySymbol() }}</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-md-3">
            <div class="mb-5">
                <div class="mb-5">
                    <div class="form-group">
                        <label id="opdStandardChargeLabel" for="opdStandardCharge">Followup Charge</label>
                        <span class="required"></span>
                        <div class="input-group">
                            {{ Form::text('followup_charge', $dentalOpdPatientDepartment->followup_charge, ['class' => 'form-control price-input', 'id' => 'opdStandardCharge', 'required','readonly']) }}
                            <div class="input-group-text border-0"><a><span>{{ getCurrencySymbol() }}</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <div class="col-md-3">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('payment_mode', __('messages.ipd_payments.payment_mode') . ':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::select('payment_mode', $data['paymentMode'], null, ['class' => 'form-select', 'required', 'id' => 'opdPaymentMode', 'data-control' => 'select2', 'placeholder' => 'Choose Payment']) }}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('is_old_patient', __('messages.ipd_patient.is_old_patient') . ':', ['class' => 'form-label']) }}<br>
                <div class="form-check form-switch">
                    <input id="is_old_patient_checkbox" class="form-check-input w-35px h-20px" name="is_old_patient"
                        type="checkbox" value="1" >
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('symptoms', __('messages.ipd_patient.symptoms') . ':', ['class' => 'form-label']) }}
                {{ Form::textarea('symptoms', null, ['class' => 'form-control', 'rows' => 4]) }}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('notes', __('messages.ipd_patient.notes') . ':', ['class' => 'form-label']) }}
                {{ Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 4]) }}
            </div>
        </div>
    </div>
    <input name="chargesList" type="hidden" value="" id="charges" />
    {{-- @foreach ($chargeCate as $cat)
        <h3>{{ $cat->name }}</h3>
        @foreach ($cat->allCharges as $services)
            <div class="col-md-4">
                <div class="mb-5">
                    <div class="input-group d-flex flex-nowrap">
                        <div class="input-group-text">
                            <input class='serviceAmount' data-amount="{{ $services->standard_charge }}" data-text="{{ $services->code }}"
                                type="checkbox" value="{{ $services->id }}"
                                aria-label="Checkbox for following text input" onclick="addAmount()">
                        </div>
                        <div class="input-group-append" style="width: 80%;">
                            <span class="input-group-text bg-white font-weight-bold"
                                style="font-weight: bold;">{{ $services->code }}</span>
                            <span
                                class="input-group-text bg-white">{{ number_format($services->standard_charge, 2) }}</span>
                            <input type="hidden" id="service_charge_{{ $services->id }}"
                                value="{{ number_format($services->standard_charge, 2) }}">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <hr>
    @endforeach --}}


    @php
    $selectedServicesData = $dentalOpdPatientDepartment->service_id;
    $selectedServices = json_decode($selectedServicesData, true);
@endphp

@foreach ($chargeCate as $cat)
    <h3>{{ $cat->name }}</h3>
    @foreach ($cat->allCharges as $service)
        <div class="col-md-4">
            <div class="mb-5">
                <div class="input-group d-flex flex-nowrap">
                    <div class="input-group-text">
                        <input class='serviceAmount' data-amount="{{ $service->standard_charge }}" data-text="{{ $service->code }}"
                            type="checkbox" value="{{ $service->id }}"
                            aria-label="Checkbox for following text input" onclick="addAmount()" {{ in_array((string) $service->id, array_column($selectedServices, 'id')) ? 'checked' : '' }}>
                    </div>
                    <div class="input-group-append" style="width: 80%;">
                        <span class="input-group-text bg-white font-weight-bold"
                            style="font-weight: bold;">{{ $service->code }}</span>
                        <span class="input-group-text bg-white">{{ number_format($service->standard_charge, 2) }}</span>
                        <input type="hidden" id="service_charge_{{ $service->id }}"
                            value="{{ number_format($service->standard_charge, 2) }}">
                    </div>
                </div>
            </div>
        </div>
    @endforeach
        
    <hr>
@endforeach



</div>
<div class="d-flex justify-content-between">
    <div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Total Amount</span>
            </div>
            <input type="text" name="total_amount" class="form-control" placeholder="0.00" value="{{ $dentalOpdPatientDepartment->total_amount }}" id="totalAmount">
        </div>
    </div>
    <div>
        {!! Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3', 'id' => 'btnOpdSave']) !!}
        <a href="{!! route('opd.patient.index') !!}" class="btn btn-secondary">{!! __('messages.common.cancel') !!}</a>
    </div>

</div>

<script>
    const checkbox = document.getElementById('is_old_patient_checkbox');
    const inputField = document.getElementById('opdStandardCharge');

    // Function to update the name attribute of the input field
    function updateInputFieldName(isChecked) {
        if (isChecked) {
            // Checkbox is checked, change the name attribute
            inputField.setAttribute('name', 'followup_charge');
            document.getElementById('opdStandardChargeLabel').innerHTML = 'Followup Charge';
        } else {
            // Checkbox is unchecked, change the name attribute back to its original value
            inputField.setAttribute('name', 'standard_charge');
            document.getElementById('opdStandardChargeLabel').innerHTML = 'Standard Charge';

        }

        $.ajax({
            url: '/get-doctor-opd-charge',
            type: "get",
            dataType: "json",
            data: {
                id: $('#opdDoctorId')[0].value
            },
            success: function(e) {
                
                if ($('#is_old_patient_checkbox')[0].checked) {
                    0 !== e.data.length ?
                        $("#opdStandardCharge,#editOpdStandardCharge").val(
                            e.data[0].followup_charge
                        ) :
                        $("#opdStandardCharge,#editOpdStandardCharge").val(0);
                        addAmount();
                } else {
                    0 !== e.data.length ?
                        $("#opdStandardCharge,#editOpdStandardCharge").val(
                            e.data[0].standard_charge
                        ) :
                        $("#opdStandardCharge,#editOpdStandardCharge").val(0);
                        addAmount();
                }

                
            }
        });

       

    }

    // Add an event listener to detect changes in the checkbox
    checkbox.addEventListener('change', function() {
        // Update the name attribute when the checkbox state changes
        updateInputFieldName(this.checked);
        

    });


    let allServices = [];
    let docFeeAdded = false;

    function addAmount() {
    let amunnt = 0;
    let allCheckBox = document.getElementsByClassName('serviceAmount');
    allServices = [];

    for (let i = 0; i < allCheckBox.length; i++) {
        if (allCheckBox[i].checked) {
            amunnt += parseFloat(allCheckBox[i].getAttribute('data-amount'));

            let serviceName = allCheckBox[i].getAttribute('data-text');
            allServices.push({
                'id': allCheckBox[i].value,
                'service': serviceName,
                'amount': allCheckBox[i].getAttribute('data-amount')
            });
        }
    }

    document.getElementById('charges').value = JSON.stringify(allServices);
    console.log(allServices);
    console.log(amunnt);
    
    let standardCharge = parseFloat($('#opdStandardCharge').val().replace(/,/g, '')) || 0;
    let amount = parseFloat(amunnt) + standardCharge;
    
    document.getElementById('totalAmount').value = amount.toFixed(2); // Ensure two decimal places
}


</script>
