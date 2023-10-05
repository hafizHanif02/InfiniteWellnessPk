<div class="d-flex justify-content-end pe-12">
    {{ checkNumberFormat($row->total_amount, strtoupper($row->currency_symbol ?? getCurrentCurrency())) }}
</div>

