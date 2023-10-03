<div class="d-flex justify-content-end pe-25 mt-4">
    @if(!empty($row->followup_charge))
        <p class="cur-margin">
            {{ checkNumberFormat($row->followup_charge, $row->currency_symbol ? strtoupper($row->currency_symbol) : strtoupper($row->currency_symbol ?? getCurrentCurrency())) }}
        </p>
    @else
        {{ __('messages.common.n/a')}}
    @endif    
</div>

