<div class="row">
    {{ Form::hidden('currency_symbol', getCurrentCurrency(), ['class' => 'currencySymbol']) }}
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('patient_opd_id', 'Patient OPD ID'.(':'),['class'=>'form-label']) }}
        <span class="required"></span>
        
        {{ Form::select('patient_opd_id', $opd, null, ['class' => 'form-select', 'id' => 'patientOPDId', 'placeholder' => 'Select OPD Id','data-control' => 'select2', 'required']) }}
    </div>
    {{ Form::hidden('patient_admission_id', null, ['id' => 'pAdmissionId']) }}
    {{ Form::hidden('patient_id', null, ['id' => 'billsPatientId']) }}
    @if(isset($bill))
        <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
            {{ Form::label('bill_date', __('messages.bill.bill_date').(':'),['class'=>'form-label']) }}
            <span class="required"></span>
            {{ Form::text('bill_date', null, ['class' => (getLoggedInUser()->thememode ? 'bg-light form-control' : 'bg-white form-control'), 'id' => 'editBillDate', 'autocomplete' => 'off']) }}
        </div>
    @else
        <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
            {{ Form::label('bill_date', __('messages.bill.bill_date').(':'),['class'=>'form-label']) }}
            <span class="required"></span>
            {{ Form::text('bill_date', null, ['class' => (getLoggedInUser()->thememode ? 'bg-light form-control' : 'bg-white form-control'), 'id' => 'bill_date', 'autocomplete' => 'off']) }}
        </div>
    @endif
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5 myclass">
        {{ Form::label('name', __('messages.case.patient').(':'),['class'=>'form-label']) }}
        {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'readonly']) }}
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('email', __('messages.bill.patient_email').(':'),['class'=>'form-label']) }}
        {{ Form::text('email', null, ['class' => 'form-control', 'id' => 'userEmail', 'readonly']) }}
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('phone', __('messages.bill.patient_cell_no').(':'),['class'=>'form-label']) }}
        {{ Form::text('phone', null, ['class' => 'form-control', 'id' => 'userPhone', 'readonly']) }}
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('gender', __('messages.bill.patient_gender').(':'),['class'=>'form-label']) }}
        <br>
        <div class="d-flex align-items-center mt-3">
            <div class="form-check me-10 mb-0">
                {{ Form::radio('gender', '0', true, ['class' => 'form-check-input', 'tabindex' => '6', 'id' => 'genderMale']) }} &nbsp;
                <label class="form-check-label"
                       for="genderMale">{{ __('messages.user.male') }}</label>
            </div>
            <div class="form-check mb-0">
                {{ Form::radio('gender', '1', false, ['class' => 'form-check-input', 'tabindex' => '7', 'id' => 'genderFemale']) }}
                <label class="form-check-label"
                       for="genderFemale">{{ __('messages.user.female') }}</label>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('dob', __('messages.bill.patient_dob').(':'),['class'=>'form-label']) }}
        {{ Form::text('dob', null, ['class' => 'form-control', 'id' => 'dob', 'readonly']) }}
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('doctor_id', __('messages.case.doctor').(':'),['class'=>'form-label']) }}
        {{ Form::text('doctor_id', null, ['class' => 'form-control', 'id' => 'billDoctorId', 'readonly']) }}
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('admission_date', 'OBD Date'.(':'),['class'=>'form-label']) }}
        {{ Form::text('admission_date', null, ['class' => 'form-control', 'id' => 'opdDate', 'readonly']) }}
    </div>
    
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('charges', 'Standard Charges'.(':'),['class'=>'form-label']) }}
        {{ Form::text('charges', null, ['class' => 'form-control', 'id' => 'opdCharge', 'readonly']) }}
    </div>
    
</div>

<div class="com-sm-12">
    <div  class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end mb-4">
        <button type="button" class="btn btn-primary text-star" id="addBillItem"> {{ __('messages.invoice.add') }}</button>
    </div>
    <div class="table-responsive-sm" >
        <table class="table table-striped" id="billTbl">
            <thead>
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                <th class="text-center">#</th>
                <th class="required">{{ __('messages.bill.item_name') }}</th>
                <th class="required">{{ __('messages.bill.qty') }}</th>
                <th class="required">{{ __('messages.bill.price') }}</th>
                <th class="text-right">{{ __('messages.bill.amount') }}</th>
                <th class="text-center">
                    {{ __('messages.common.action') }}
                </th>
            </tr>
            </thead>
            <tbody class="bill-item-container text-gray-600 fw-bold">
            @if(isset($bill))
                @foreach($bill->billItems as $billItem)
                    <tr>
                        <td class="text-center item-number">{{ $loop->iteration }}</td>
                        <td class="table__item-desc">
                            {{ Form::text('item_name[]', $billItem->item_name, ['class' => 'form-control itemName','required']) }}
                        </td>
                        <td class="table__qty">
                            {{ Form::number('qty[]', $billItem->qty, ['class' => 'form-control qty quantity','required']) }}
                        </td>
                        <td>
                            {{ Form::text('price[]', number_format($billItem->price), ['class' => 'form-control price-input price','required']) }}
                        </td>
                        <td class="amount text-right itemTotal">{{ number_format($billItem->amount) }}
                        </td>
                        <td class="text-center">
                            <i class="fa fa-trash text-danger delete-bill-add-item pointer"></i>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center item-number">1</td>
                    <td class="table__item-desc">
                        {{ Form::text('item_name[]', null, ['class' => 'form-control itemName','required']) }}
                    </td>
                    <td class="table__qty">
                        {{ Form::number('qty[]', null, ['class' => 'form-control qty quantity','required',]) }}
                    </td>
                    <td>
                        {{ Form::text('price[]', null, ['class' => 'form-control price-input price','required']) }}
                    </td>
                    <td class="amount text-right itemTotal">
                    </td>
                    <td class="text-center">
                        <i class="fa fa-trash text-danger delete-invoice-item pointer"></i>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-4 float-right p-0">
        <table class="w-100">
            <tbody class="bill-item-footer">
            <tr>
                <td class="form-label text-right">{{ __('messages.bill.total_amount').(':') }}</td>
                <td class="text-right">
                    <span id="totalPrice" class="price">{{ isset($bill) ? getCurrencySymbol() . '' . number_format($bill->amount,2) : getCurrencySymbol() . '' . 0 }}</span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Total Amount Field -->
{{ Form::hidden('total_amount', null, ['class' => 'form-control', 'id' => 'totalAmount']) }}

<!-- Submit Field -->
<div class="float-end">
    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-2','id' => 'billSave']) }}
    <a href="{{ route('bills.index') }}"
       class="btn btn-secondary">{{ __('messages.common.cancel') }}</a>
</div>

<script>
    var input = document.getElementById('patientOPDId');

input.onchange  = function() {
    var selectedText = input.value;
    let txt = input.options[input.selectedIndex].innerHTML;
    console.log('Selected Text:', selectedText);
    
    $.ajax({
      url: '/bills/opd/getPatient',
      method: 'GET',
      data: { patientID: selectedText, opdID: txt},
      success: function(response) {
        // Handle the successful response here
        let data = response;
        console.log('Response:', data);
        
        console.log(data['first_name'] );
        
            document.getElementById('billsPatientId').value = selectedText;
            document.getElementById('pAdmissionId').value = txt;
            document.getElementById('name').value = data['first_name'] + " " + data['last_name'];
            document.getElementById('userEmail').value = data['email'];
            document.getElementById('userPhone').value = data['phone'];
            document.getElementById('dob').value = data['dob'];
            document.getElementById('billDoctorId').value = data['doctor']["first_name"] + " " + data['doctor']["last_name"];
            document.getElementById('opdDate').value = data['created_at'];
            document.getElementById('opdCharge').value = data['charges'];
            document.getElementById('totalPrice').innerHTML = "Rs " + data['charges'];
            
            document.getElementsByClassName('itemName')[0].value = "OPD";
            document.getElementsByClassName('quantity')[0].value = "1";
            document.getElementsByClassName('price')[0].value = data['charges'];
            document.getElementsByClassName('itemTotal')[0].innerHTML = data['charges'];
        
      },
      error: function(xhr, status, error) {
        // Handle any errors that occurred during the request
        console.error('Error:', error);
      }
    });
};
    
</script>
