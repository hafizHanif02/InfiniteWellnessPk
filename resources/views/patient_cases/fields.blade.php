<div class="row">
    {{ Form::hidden('currency_symbol', getCurrentCurrency(), ['class' => 'currencySymbol']) }}
    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('patient_name', __('messages.case.patient').(':'),['class' => 'form-label']) }}
        <span class="required"></span>
        {{-- {{ Form::select('patient_id', $patients, null, ['class' => 'form-select select2Selector', 'required', 'id' => 'casePatientId', 'placeholder' => 'Select Patient', 'data-control' => 'select2', 'required']) }} --}}

        <select name="patient_id" class="'form-select select2Selector'"  id="casePatientId" placeholder='Select Patient' class="form-select" required>
            <option value="" selected disabled>Select Patient</option>
            @foreach ($patients as $patient)
            <option value="{{$patient->id }}">({{$patient->MR}}) {{$patient->patientUser->full_name }}</option>                
            @endforeach
        </select>
    </div>

    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('department_id','Department',['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::select('department_id', $departmentsArray, null, ['class' => 'form-select select2Selector', 'required', 'id' => 'department_id', 'placeholder' => 'Select Deparment', 'data-control' => 'select2', 'required']) }}
    </div>

    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('doctor_id','Doctor',['class' => 'form-label']) }}
        <span class="required"></span>
        <select name="doctor_id" id="doctor_id" class="form-control">
            <option value="" selected disabled>Select Department First</option>
        </select>
    </div>
   
    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('date', __('messages.case.case_date').(':'), ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('date', null, ['id'=>'caseDate','class' => (getLoggedInUser()->thememode ? 'bg-light form-control' : 'bg-white form-control'),'required', 'autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-md-6 mb-5">
        {{ Form::label('phone', __('messages.case.phone').':', ['class' => 'form-label']) }}
        <br>
        {!! Form::tel('phone', isset($patientCase) ? ($patientCase->phone ?? getCountryCode()) : getCountryCode(), ['class' => 'form-control iti phoneNumber','id' => 'casePhoneNumber']) !!}
        {!! Form::hidden('prefix_code',null,['class'=>'prefix_code']) !!}
        <span class="text-success valid-msg d-none fw-400 fs-small">✓ &nbsp; {{__('messages.valid')}}</span>
        <span class="text-danger error-msg d-none fw-400 fs-small"></span>
    </div>
    <div class="form-group col-md-6 mb-5">
        {{ Form::label('status', __('messages.common.status').':', ['class' => 'form-label']) }}
        <br>
        <div class="form-check  form-switch">
            <input name="status" class="form-check-input w-35px h-20px is-active" value="1"
                   type="checkbox" {{(!isset($patientCase))? 'checked': (($patientCase->status) ? 'checked' : '')}}>
        </div>
    </div>
    {{-- <div class="form-group col-sm-6 mb-5">
        {{ Form::label('fee', __('messages.case.fee').(':'), ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('fee', null, ['class' => 'form-control price-input price','required']) }}
    </div> --}}
    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('description', __('messages.common.description').':', ['class' => 'form-label']) }}
        {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 4]) }}
    </div>
    <div class="d-flex justify-content-end">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-2', 'id' => 'saveCaseBtn']) }}
        <a href="{{ route('patient-cases.index') }}"
           class="btn btn-secondary me-2">{{ __('messages.common.cancel') }}</a>
    </div>
</div>

<script>
     $('#department_id').change(function() {
        var department_id = $('#department_id').val();
        console.log(department_id);
        $.ajax({
                    type: "get",
                    url: "/case/doctor/list",
                    data: {
                        department_id: $(this).val()
                    },
                    dataType: "json",
                    success: function(response) {
                        $("#doctor_id").empty();

                        if (response.data.length !== 0) {
                            $('#doctor_id').select2();
                            $('#doctor_id').append(
                                `<option>Select Doctor </option>`);
                            $.each(response.data, function(index, value) {
                                console.log(value);
                                $("#doctor_id").append(
                                    `
                            <option value="${value.id}" data-doctor="${value.user.full_name}">
                               ${value.user.full_name}
                            </option>`
                                );
                            });
                        } else {
                            $("#doctor_id").html(
                                `<option value="" class="text-danger" selected disabled>No Doctor found!</option>`
                            );
                        }
                    }
                });
     });
</script>
