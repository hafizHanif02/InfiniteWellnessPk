<x-layouts.print>
    <table class="table table-bordered">
        <thead class="table-dark text-dark">
          <tr class="padding-row">
            <th colspan="3">Date</th>
            <th colspan="3">{{$pos->created_at }}</th>
            <th colspan="3">Invoice No</th>
            <th colspan="3">{{$pos->id }}</th>
            <th colspan="4">Time</th>
           <tr>
            <tr>
                <th>Name</th>
                <th>{{$pos->patient_name }}</th>
                <th colspan="14"></th>
            </tr>
            <tr>
                <th>Contact No</th>
                <th>034124782147</th>
                <th colspan="14"></th>
            </tr>
            <tr>
                <th colspan="2" rowspan="2">S No</th>
                <th colspan="2">Brand Name</th>
                <th colspan="2">Barcode on Product ( For limited items )</th>
                <th colspan="2">Qty ( Unit )</th>
                <th colspan="2">M.R.P /Unit </th>
                <th colspan="2">GST %</th>
                <th colspan="2">Disc %age</th>
                <th colspan="2">Total Price</th>
            </tr>
            <tr></tr>

            @foreach ($pos->PosProduct as $product)
            <tr>
                <th colspan="2">{{ $loop->iteration }}</th>
                <th colspan="2">{{ $product->brand_name }}</th>
                <th colspan="2">14714{{ $loop->iteration  }}</th>
                <th colspan="2">{{ $product->product_quantity }}</th>
                <th colspan="2">{{ $product->mrp_perunit }}</th>
                <th colspan="2">{{ $product->gst_percentage }}</th>
                <th colspan="2">{{ $product->discount_percentage }}</th>
                <th colspan="2">{{ $product->product_total_price }}</th>
            </tr>
            @endforeach
            <tr>
                <th colspan="10"></th>
                <th style="background-color:black;color:white; ">Payment Method</th>
                <th>Card</th>
                <th colspan="4">
                    @if ($pos->is_cash == 0)
                    <i class="fas fa-check"></i>
                    @endif
                </th>
            </tr>
            <tr>
                <th colspan="11"></th>
                <th>Cash</th>
                <th colspan="4">
                    @if ($pos->is_cash == 1)
                    <i class="fas fa-check"></i>
                    @endif
                </th>
            </tr>

            <tr><th colspan="16"></th></tr>
            <tr>
                <th colspan="16" style="background-color:#ff8b61;color:black;">Proceed To Transaction</th>
            </tr>

            <tr><th colspan="16"></th></tr>


            <tr>
                <th colspan="8"></th>
                <th colspan="6">TOTAL AMOUNT Exclusive of Sales Tax</th>
                <th colspan="2">{{$pos->total_amount_ex_saletax }}</th>
            </tr>
            <tr>
                <th colspan="8"></th>
                <th colspan="6">Total Discount </th>
                <th colspan="2">{{$pos->total_discount }}</th>
            </tr>
            <tr>
                <th colspan="8"></th>
                <th colspan="6">Total Sales Tax </th>
                <th colspan="2">{{$pos->total_saletax }}</th>
            </tr>
            <tr>
                <th colspan="8"></th>
                <th colspan="6">Net Total Inclusive of Sales Tax </th>
                <th colspan="2">{{$pos->total_amount_inc_saletax }}</th>
            </tr>
            <tr>
                <th colspan="8"></th>
                <th colspan="6">FBR POS FEE </th>
                <th colspan="2">1/</th>
            </tr>
            <tr>
                <th colspan="8"></th>
                <th colspan="6">GRAND TOTAL</th>
                <th colspan="2">{{$pos->total_amount }}</th>
            </tr>
        </thead>
    </table>
</x-layouts.print>
<style>
    .padding-row th{
        padding-left: 40px;
        padding-right: 40px;
    }
</style>
<script>
    window.print();
</script>