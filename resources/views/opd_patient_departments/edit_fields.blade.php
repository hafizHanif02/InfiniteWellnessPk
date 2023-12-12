<div class="row gx-10 mb-5">
    <div class="col-md-4">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('patient_id', __('messages.ipd_patient.patient_id') . ':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::hidden('currency_symbol', getCurrentCurrency(), ['class' => 'currencySymbol']) }}
                {{-- {{ Form::select('patient_id', $data['patients2'], null, ['class' => 'form-select', 'required', 'id' => 'editOpdPatientId', 'placeholder' => 'Select Patient', 'data-control' => 'select2']) }} --}}
                <input type="text" readonly class="form-control"
                    value="{{ $opdPatientDepartment->patient->MR . ' ' . $opdPatientDepartment->patient->user->full_name }}">
                <input type="hidden" name="patient_id" value="{{ $opdPatientDepartment->patient_id }}">
            </div>
        </div>
    </div>
    <input type="hidden" name="appointment_id" value="{{ $opdPatientDepartment->appointment_id }}">
    <div class="col-md-2">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('case_id', __('messages.ipd_patient.case_id') . ':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{-- {{ Form::select('case_id', [null], null, ['class' => 'form-select', 'required', 'id' => 'editOpdCaseId', 'disabled', 'data-control' => 'select2', 'placeholder' => 'Choose Case']) }}
                {{ Form::hidden('patient_case_id', !empty($opdPatientDepartment->patientCase) ? $opdPatientDepartment->patientCase->case_id : '', ['class' => 'patientCaseId']) }} --}}
                <input type="text" class="form-control" readonly
                    value="{{ $opdPatientDepartment->patientCase->case_id }}">
                <input type="hidden" class="form-control" name="case_id" readonly
                    value="{{ $opdPatientDepartment->case_id }}">
                <input type="hidden" class="form-control" name="patient_case_id" readonly
                    value="{{ $opdPatientDepartment->case_id }}">
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('opd_number', __('messages.opd_patient.opd_number') . ':', ['class' => 'form-label']) }}
                {{-- {{ Form::text('opd_number', null, ['class' => 'form-control', 'readonly']) }} --}}
                <input type="text" readonly name="opd_number" value="{{ $opdPatientDepartment->opd_number }}"
                    class="form-control">
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('height', __('messages.ipd_patient.height') . ':', ['class' => 'form-label']) }}
                {{-- {{ Form::number('height', null, ['class' => 'form-control', 'max' => '7', 'step' => '.01']) }} --}}
                <input type="number" name="height" step=".01" value="{{ $opdPatientDepartment->height }}"
                    class="form-control">
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('weight', __('messages.ipd_patient.weight') . ':', ['class' => 'form-label']) }}
                {{-- {{ Form::number('weight', null, ['class' => 'form-control', 'max' => '200', 'step' => '.01']) }} --}}
                <input type="number" name="weight" step=".01" value="{{ $opdPatientDepartment->weight }}"
                    class="form-control">
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('bp', __('messages.ipd_patient.bp') . ':', ['class' => 'form-label']) }}
                {{-- {{ Form::text('bp', null, ['class' => 'form-control']) }} --}}
                <input type="number" name="bp" value="{{ $opdPatientDepartment->bp }}" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('appointment_date', __('messages.opd_patient.appointment_date') . ':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::text('appointment_date', null, ['class' => getLoggedInUser()->thememode ? 'bg-light form-control' : 'bg-white form-control', 'id' => 'editOpdAppointmentDate', 'autocomplete' => 'off', 'required']) }}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('doctor_id',__('messages.ipd_patient.doctor_id').':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::select('doctor_id', $data['doctors'], (isset($data['last_visit'])) ? $data['last_visit']->doctor_id : null, ['class' => 'form-select', 'required', 'id' => 'opdDoctorId', 'placeholder' => 'Select Doctor', 'data-control' => 'select2']) }}
            </div>
        </div>
    </div>
    @if ($opdPatientDepartment->standard_charge != 0)
        <div class="col-md-3">
            <div class="mb-5">
                <div class="mb-5">
                    <div class="form-group">
                        <label id="opdStandardChargeLabel" for="opdStandardCharge">Standard Charge</label>
                        <span class="required"></span>
                        <div class="input-group">
                            {{ Form::text('standard_charge', null, ['class' => 'form-control price-input', 'id' => 'opdStandardCharge', 'required']) }}
                            <div class="input-group-text border-0"><a><span>{{ getCurrencySymbol() }}</span></a></div>
                        </div>
                        {{ Form::hidden('doctor_id_for_schedule', null, ['class' => 'form-control price-input', 'id' => 'doctor_id_for_schedule', 'required']) }}
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
                            {{ Form::text('followup_charge', null, ['class' => 'form-control price-input', 'id' => 'opdStandardCharge', 'required']) }}
                            <div class="input-group-text border-0"><a><span>{{ getCurrencySymbol() }}</span></a></div>
                        </div>
                        {{ Form::hidden('doctor_id_for_schedule', null, ['class' => 'form-control price-input', 'id' => 'doctor_id_for_schedule', 'required']) }}
                    </div>
                </div>
            </div>
        </div>
    @endif

        <div class="col-md-3">
            <div class="mb-5">
                <div class="mb-5">
                    <div class="form-group">
                        <label id="advance_amount" class="form-label" for="advance_amount">Advance Amount</label>
                        <div class="input-group">
                            {{ Form::text('advance_amount', null, ['class' => 'form-control price-input', 'id' => 'advance_amount']) }}
                            <div class="input-group-text border-0"><a><span>{{ getCurrencySymbol() }}</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="col-md-3">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('payment_mode', __('messages.ipd_payments.payment_mode') . ':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::select('payment_mode', $data['paymentMode'], null, ['class' => 'form-select', 'required', 'id' => 'editOpdPaymentMode', 'data-control' => 'select2', 'placeholder' => 'Choose Payment']) }}
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
    <div class="col-md-3">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('is_old_patient', __('messages.ipd_patient.is_old_patient') . ':', ['class' => 'form-label']) }}<br>
                <div class="form-check form-switch">
                    <input id="is_old_patient_checkbox" class="form-check-input w-35px h-20px" name="is_old_patient"
                        type="checkbox" value="1">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-end">
    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3', 'id' => 'btnEditOpdSave']) }}
    <a href="{!! route('opd.patient.index') !!}" class="btn btn-secondary">{!! __('messages.common.cancel') !!}</a>
</div>

<script>
    // Get references to the checkbox and input field
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
                console.log(e);
                if ($('#is_old_patient_checkbox')[0].checked) {
                    0 !== e.data.length ?
                        $("#opdStandardCharge,#editOpdStandardCharge").val(
                            e.data[0].followup_charge
                        ) :
                        $("#opdStandardCharge,#editOpdStandardCharge").val(0);
                } else {
                    0 !== e.data.length ?
                        $("#opdStandardCharge,#editOpdStandardCharge").val(
                            e.data[0].standard_charge
                        ) :
                        $("#opdStandardCharge,#editOpdStandardCharge").val(0);
                }

            }
        });

    }

    function fetchDoctorSchedule() {
    const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const selectedDate = new Date($('#opdAppointmentDate').val());
    const dayName = daysOfWeek[selectedDate.getDay()];

    $.ajax({
    url: '/doctor-schedule-list',
    type: 'get',
    dataType: 'json',
    data: {
        doctor_id: $('#doctor_id_for_schedule').val(),
        day_name: dayName // Get the day name from the selected date
    },
    success: function(data) {
        console.log(data);
    },
    error: function(jqXHR, textStatus, errorThrown) {
        // Handle errors
    }
});

}

    // Add an event listener to detect changes in the checkbox
    checkbox.addEventListener('change', function() {
        // Update the name attribute when the checkbox state changes
        updateInputFieldName(this.checked);

    });
</script>
