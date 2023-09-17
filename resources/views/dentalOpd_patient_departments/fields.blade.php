{{ Form::hidden('revisit', (isset($data['last_visit'])) ? $data['last_visit']->id : null) }}
{{ Form::hidden('currency_symbol', getCurrentCurrency(), ['class' => 'currencySymbol']) }}
<div class="row gx-10 mb-5">

    <div class="col-md-3">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('patient_id',__('MR / Patient name').':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::select('patient_id', $data['patients'], (isset($data['last_visit'])) ? $data['last_visit']->patient_id : null, ['class' => 'form-select', 'required', 'id' => 'opdPatientId', 'placeholder' => 'Select Patient', 'data-control' => 'select2']) }}
            </div>
        </div>
    </div>
    <div class="col-md-3">
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
    <div class="col-md-3">
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

    <div class="col-md-3">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('payment_mode', __('messages.ipd_payments.payment_mode').':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::select('payment_mode', $data['paymentMode'], null, ['class' => 'form-select', 'required', 'id' => 'opdPaymentMode', 'data-control' => 'select2', 'placeholder' => 'Choose Payment']) }}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('is_old_patient', __('messages.ipd_patient.is_old_patient').':', ['class' => 'form-label']) }}<br>
                <div class="form-check form-switch">
                    <input class="form-check-input w-35px h-20px" name="is_old_patient" type="checkbox" value="1">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('symptoms',__('messages.ipd_patient.symptoms').':', ['class' => 'form-label']) }}
                {{ Form::textarea('symptoms', null, ['class' => 'form-control', 'rows' => 4]) }}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-5">
            <div class="mb-5">
                {{ Form::label('notes',__('messages.ipd_patient.notes').':', ['class' => 'form-label']) }}
                {{ Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 4]) }}
            </div>
        </div>
    </div>
    <input name="chargesList" type="hidden" value="" id="charges"/>
    @foreach ($chargeCate as $cat)

        <h3>{{$cat->name}}</h3>
        @foreach ($cat->allCharges as $services)
        <div class="col-md-4">
            <div class="mb-5">
                <div class="input-group d-flex flex-nowrap">
                    <div class="input-group-text">
                        <input  data-amount="{{$services->standard_charge}}" data-text="{{$services->code}}" type="checkbox" value="{{$services->id}}" aria-label="Checkbox for following text input" onclick="addAmount(this)">
                      </div>
                    <div class="input-group-append" style="width: 80%;">
                      <span class="input-group-text bg-white font-weight-bold" style="font-weight: bold;">{{$services->code}}</span>
                      <span class="input-group-text bg-white">{{number_format($services->standard_charge, 2)}}</span>
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
        <input type="text" class="form-control" placeholder="0.00" name="standard_charge" id="totalAmount">
    </div>
</div>
    <div>
        {!! Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3','id' => 'btnOpdSave']) !!}
        <a href="{!! route('opd.patient.index') !!}" class="btn btn-secondary">{!! __('messages.common.cancel') !!}</a>
    </div>

</div>

<script>
    let allServices = [];
    function addAmount(checkBox){
        //console.log(checkBox.value + " - " + checkBox.checked );
        let amount = checkBox.getAttribute('data-amount');
        //console.log(checkBox.value + " - " + amount );
        if(checkBox.checked){

            let serviceName = checkBox.getAttribute('data-text');
            allServices.push({'id': checkBox.value, 'service': serviceName, 'amount': amount});
            let oldAmout = document.getElementById('totalAmount').value;
            if(!oldAmout){
                oldAmout = 0;
            }
            oldAmout = parseFloat(oldAmout);
            amount = parseFloat(amount);
            document.getElementById('totalAmount').value = (oldAmout + amount).toFixed(2);
        }else {
            let oldAmout = document.getElementById('totalAmount').value;
            if(!oldAmout){
                oldAmout = 0;
            }
            oldAmout = parseFloat(oldAmout);
            amount = parseFloat(amount);
            document.getElementById('totalAmount').value = (oldAmout - amount).toFixed(2);

            allServices.forEach((e, key)=>{

                if(e.id == checkBox.value){

                    allServices.splice(key, 1);

                }
            })

        }
        document.getElementById('charges').value = JSON.stringify(allServices);
    }
</script>
