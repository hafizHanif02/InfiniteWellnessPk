@if(!empty($row->patient->id))
    {{$row->patient->MR}}
@else
    {{ __('messages.common.n/a') }}
@endif


