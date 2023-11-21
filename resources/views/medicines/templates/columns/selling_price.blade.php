<div class="text-center">
    @if($row->product->unit_retail)
        {{ checkNumberFormat($row->product->unit_retail, $row->currency_symbol ? strtoupper($row->currency_symbol) : strtoupper(getCurrentCurrency())) }}
    @else
        {{__('messages.common.n/a')}}
    @endif    
</div>

