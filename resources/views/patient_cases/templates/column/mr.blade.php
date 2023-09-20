@if(!empty($row->patient->id))
    {{$row->patient->id}}
@else
    {{ __('messages.common.n/a') }}
@endif


