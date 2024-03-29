<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-5">
            {!! Form::label('name', __('messages.item.name').':', ['class' => 'form-label']) !!}
            <span class="required"></span>
            {!! Form::text('name', null, ['id'=>'itemName','class' => 'form-control', 'required']) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-5">
            {!! Form::label('itemcategory_id', __('messages.item.item_category').':', ['class' => 'form-label']) !!}
            <span class="required"></span>
            {{ Form::select('itemcategory_id', $itemCategories, null, ['class' => 'form-select', 'required', 'id' => 'itemCategory', 'data-control' => 'select2', 'placeholder' => 'Select Item Category']) }}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-5">
            {!! Form::label('unit', __('messages.item.unit').':', ['class' => 'form-label']) !!}
            <span class="required"></span>
            {!! Form::text('unit', null, ['id'=>'itemUnit','class' => 'form-control', 'required', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'maxlength' => '4','minlength' => '1']) !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group mb-5">
            {!! Form::label('description', __('messages.item.description').':', ['class' => 'form-label']) !!}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 4]) }}
        </div>
    </div>
    <div class="d-flex justify-content-end">
        {{ Form::submit(__('messages.common.save'), ['class' => 'myBtnPrimary me-3', 'id' => 'itemSave']) }}
        <a href="{!! route('items.index') !!}"
           class="myBtnSecondary me-2">{!! __('messages.common.cancel') !!}</a>
    </div>
</div>
