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
            </tr>
            <tr>
                <th>Contact No</th>
                <th>034124782147</th>
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
            </tr>
            <tr>
                <th colspan="11"></th>
                <th>Cash</th>
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
          {{-- </tr>
            <tr class="bg-green padding-topbottom padding-row">
                <th colspan="7">ORDER</th>
                <th colspan="4">LAST PURCHASE</th>
                <th colspan="4">STOCK MOVEMENT</th>
            </tr>
            <tr class="padding-row">
                <th>Item No.</th>
                <th>Description of items</th>
                <th>Request Quantity</th>
                <th>PRICE</th>
                <th>DIS%</th>
                <th>TAX%</th>
                <th>TOTAL AMOUNT</th>
                <th>DATE</th>
                <th>QTY</th>
                <th>PRICE</th>
                <th>DIS%</th>
                <th>OPENING</th>
                <th>CONSUM.</th>
                <th>CLOSING</th>
                <th>MONTH AVERAGE.</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requistionProducts as $requistionProduct)
                <tr class="text-center-data">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $requistionProduct->product->product_name }}</td>
                    <td>{{ $requistionProduct->total_piece }}</td>
                    <td>{{ $requistionProduct->total_amount / $requistionProduct->total_piece }}</td>
                    <td>{{ $requistionProduct->discount_percentage }}%</td>
                    <td>{{ ($requistionProduct->sale_tax == 0)?'-':$requistionProduct->sale_tax.'%' }}</td>
                    <td>{{ $requistionProduct->total_amount }}</td>
                    @if($last_purchase)
                    @foreach ($last_purchase->goodReceiveProducts as $goodReceiveProducts)
                    @if ($requistionProduct->product->id == $goodReceiveProducts->product_id)
                    <td>{{$last_purchase->date}}</td>
                    <td>{{$goodReceiveProducts->deliver_qty}}</td>
                    <td>{{$goodReceiveProducts->item_amount}}</td>
                    <td>{{$goodReceiveProducts->discount}}</td>
                    <td>{{$openQuantity->deliver_qty}}</td>
                    <td>{{($requistionProduct->consume== 0)?'-':$requistionProduct->consume}}</td>
                    <td>{{$goodReceiveProducts->product->total_quantity }}</td>
                    <td>{{($requistionProduct->averageMonthly == 0)?'-':$requistionProduct->averageMonthly }}</td>
                    @endif
                    @endforeach
                    @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @endif
                </tr>
            @empty
                <tr>
                    <th colspan="15"><span class="text-danger">Not Any Product Found</span></th>
                </tr>
            @endforelse

            <tr class="padding-row">
                <th colspan="15"></th>
            </tr>
            <tr class="padding-row">
                <th colspan="1">Line Manager</th>
                <th colspan="2"></th>
                <th colspan="1">Project Manager</th>
                <th colspan="3"></th>
            </tr>
            <tr class="padding-row">
                <th colspan="1">Signature</th>
                <th colspan="2"></th>
                <th colspan="1">Signature</th>
                <th colspan="3"></th>
            </tr>
            <tr class="padding-row">
                <th colspan="1">Finance Dept:</th>
                <th colspan="2"></th>
                <th colspan="1">Purchase Dept.:</th>
                <th colspan="3"></th>
            </tr>
        </tbody>
    </table>

    <style nonce="{{ csp_nonce() }}">
        @media print {
            @page {
                size: landscape;
            }

            body {
                background-image: initial !important;
            }
        }
    </style>
    <script>
        window.print();
    </script> --}}
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