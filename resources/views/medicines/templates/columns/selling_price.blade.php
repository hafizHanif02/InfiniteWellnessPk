<div class="text-center">
    @if($row->selling_price)
        {{ checkNumberFormat($row->selling_price, $row->currency_symbol ? strtoupper($row->currency_symbol) : strtoupper(getCurrentCurrency())) }}
    @else
        {{__('messages.common.n/a')}}
    @endif    
</div>

