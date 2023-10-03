{{ Form::hidden('revisit', (isset($data['last_visit'])) ? $data['last_visit']->id : null) }}
{{ Form::hidden('currency_symbol', getCurrentCurrency(), ['class' => 'currencySymbol']) }}
<div class="row gx-10 mb-5">

    <div class="col-md-4">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('patient_id',__('MR / Patient name').':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::select('patient_id', $data['patients'], (isset($data['last_visit'])) ? $data['last_visit']->patient_id : null, ['class' => 'form-select', 'required', 'id' => 'opdPatientId', 'placeholder' => 'Select Patient', 'data-control' => 'select2']) }}
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('case_id', __('messages.ipd_patient.case_id').':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::select('case_id', [null], null, ['class' => 'form-select', 'required', 'id' => 'opdCaseId', 'disabled', 'data-control' => 'select2', 'placeholder' => 'Choose Case']) }}
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('opd_number', __('messages.opd_patient.opd_number').':', ['class' => 'form-label']) }}
                {{ Form::text('opd_number', $data['opdNumber'], ['class' => 'form-control', 'readonly']) }}
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('height', __('messages.ipd_patient.height').':', ['class' => 'form-label']) }}
                {{ Form::number('height', (isset($data['last_visit'])) ? $data['last_visit']->height : 0, ['class' => 'form-control', 'max' => '7', 'step' => '.01']) }}
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('weight', __('messages.ipd_patient.weight').':', ['class' => 'form-label']) }}
                {{ Form::number('weight', (isset($data['last_visit'])) ? $data['last_visit']->weight : 0, ['class' => 'form-control', 'max' => '200', 'step' => '.01']) }}
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('bp', __('messages.ipd_patient.bp').':', ['class' => 'form-label']) }}
                {{ Form::number('bp', (isset($data['last_visit'])) ? $data['last_visit']->bp : null, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('appointment_date', __('messages.opd_patient.appointment_date').':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::text('appointment_date', null, ['class' => (getLoggedInUser()->thememode ? 'bg-light form-control' : 'bg-white form-control'),'id' => 'opdAppointmentDate','autocomplete' => 'off', 'required']) }}
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
    <div class="col-md-3">
        <div class="mb-5">
            <div class="mb-5">
                <div class="form-group">
                    <label id="opdStandardChargeLabel" for="opdStandardCharge">Standard Charge</label>
                    <span class="required"></span>
                    <div class="input-group">
                        {{ Form::text('standard_charge', null , ['class' => 'form-control price-input', 'id' => 'opdStandardCharge', 'required']) }}
                        <div class="input-group-text border-0"><a><span>{{ getCurrencySymbol() }}</span></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('payment_mode', __('messages.ipd_payments.payment_mode').':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::select('payment_mode', $data['paymentMode'], null, ['class' => 'form-select', 'required', 'id' => 'opdPaymentMode', 'data-control' => 'select2', 'placeholder' => 'Choose Payment']) }}
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('symptoms',__('messages.ipd_patient.symptoms').':', ['class' => 'form-label']) }}
                {{ Form::textarea('symptoms', null, ['class' => 'form-control', 'rows' => 4]) }}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('notes',__('messages.ipd_patient.notes').':', ['class' => 'form-label']) }}
                {{ Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 4]) }}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('is_old_patient', __('messages.ipd_patient.is_old_patient').':', ['class' => 'form-label']) }}<br>
                <div class="form-check form-switch">
                    <input id="is_old_patient_checkbox" class="form-check-input w-35px h-20px" name="is_old_patient" type="checkbox" value="1">
                </div>
            </div>
        </div>
        
    </div>
</div>
<div class="d-flex justify-content-end">
    {!! Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3','id' => 'btnOpdSave']) !!}
    <a href="{!! route('opd.patient.index') !!}"
       class="btn btn-secondary">{!! __('messages.common.cancel') !!}</a>
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
        document.getElementById('opdStandardChargeLabel').innerHTML='Followup Charge';
    } else {
        // Checkbox is unchecked, change the name attribute back to its original value
        inputField.setAttribute('name', 'standard_charge');
        document.getElementById('opdStandardChargeLabel').innerHTML='Standard Charge';

    }
              
                $.ajax({
                  url: '/get-doctor-opd-charge',
                  type: "get",
                  dataType: "json",
                  data: { id: $('#opdDoctorId')[0].value },
                  success: function (e) {
                    console.log(e);
                    if($('#is_old_patient_checkbox')[0].checked){
                        0 !== e.data.length
                        ? $("#opdStandardCharge,#editOpdStandardCharge").val(
                            e.data[0].followup_charge
                            )
                        : $("#opdStandardCharge,#editOpdStandardCharge").val(0);
                    }else {
                        0 !== e.data.length
                        ? $("#opdStandardCharge,#editOpdStandardCharge").val(
                            e.data[0].standard_charge
                            )
                        : $("#opdStandardCharge,#editOpdStandardCharge").val(0);
                    }
                    
                  }});
   
}

// Add an event listener to detect changes in the checkbox
checkbox.addEventListener('change', function () {
    // Update the name attribute when the checkbox state changes
    updateInputFieldName(this.checked);
  
});

</script>

