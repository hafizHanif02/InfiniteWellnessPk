<div id="add_doctor_opd_charges_modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"
                    id="exampleModalLabel">{{__('messages.doctor_opd_charge.new_doctor_opd_charge')}}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'addDoctorChargesForm']) }}
            {{ Form::hidden('currency_symbol', getCurrentCurrency(), ['class' => 'currencySymbol']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none hide" id="doctorChargesErrorsBox"></div>
                <div class="row">
                    <div class="col-md-12 mb-5">
                        {{ Form::label('doctor_id', __('messages.doctor_opd_charge.doctor').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::select('doctor_id',$doctors, null, ['class' => 'form-select', 'required', 'id' => 'chargesDoctorId','placeholder'=>'Select Doctor']) }}
                    </div>

                    <div class="col-md-12 mt-3">
                        {{ Form::label('standard_charge', __('messages.doctor_opd_charge.standard_charge').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('standard_charge', null, ['class' => 'form-control price-input', 'autocomplete' => 'off', 'required', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
                    </div>
                    <div class="col-md-12 mt-3">
                        {{-- {{ Form::label('followup_charge', __('messages.doctor_opd_charge.followup_charge').(':'), ['class' => 'form-label']) }} --}}
                        <label class="form-label" for="followup_charge">Followup Charge:</label>
                        <span class="required"></span>
                        {{ Form::text('followup_charge', null, ['class' => 'form-control price-input', 'autocomplete' => 'off', 'required', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button( __('messages.common.save'), ['type'=>'submit','class' => 'myBtnPrimary m-0','id'=>'doctorChargesSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                <button type="button" aria-label="Close" class="myBtnSecondary"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
