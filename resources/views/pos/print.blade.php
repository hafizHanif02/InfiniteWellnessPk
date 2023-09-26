{{-- <x-layouts.print> --}}
    <table>
        
        <thead>
            <tr class="text-start">
                <th colspan="3">INV #</th>
                <th colspan="5">{{$pos->id }}</th>
            </tr>
            <tr class="text-start">
                <th colspan="3">Name</th>
                <th colspan="5">{{$pos->patient_name }}</th>
            </tr>
          <tr class="text-start">
            <th colspan="3">Date</th>
            <th colspan="6">{{$pos->created_at }}</th>
          </tr>
            <tr class="text-start">
                <th colspan="3">Contact #</th>
                <th colspan="5">034124782147</th>
            </tr>
            <tr style="border-top: 1px solid rgb(29, 29, 29); border-bottom: 1px solid rgb(29, 29, 29);">
                <th>S No</th>
                <th colspan="2">Brand Name</th>
                <th colspan="2">Barcode</th>
                <th colspan="2">Qty</th>
                <th colspan="2">M.R.P</th>
                <th colspan="2">GST</th>
                <th colspan="2">Disc</th>
                <th>Total</th>
            </tr>

            @foreach ($pos->PosProduct as $product)
            <tr>
                <th>{{ $loop->iteration }}</th>
                <th colspan="2">{{ $product->medicine->brand->name }}</th>
                <th colspan="2">14714{{ $loop->iteration  }}</th>
                <th colspan="2">{{ $product->product_quantity }}</th>
                <th colspan="2">{{ $product->mrp_perunit }}</th>
                <th colspan="2">{{ $product->gst_percentage }}</th>
                <th colspan="2">{{ $product->discount_percentage }}</th>
                <th>{{ $product->product_total_price }}</th>
            </tr>
            @endforeach
            <tr>
                <th colspan="3" style="background-color:black;color:white; ">Payment Method</th>
                <th colspan="9"></th>
                <th>Card</th>
                <th colspan="4">
                    @if ($pos->is_cash == 0)
                    <i class="fas fa-check"></i>
                    @endif
                </th>
            </tr>
            <tr>
                <th colspan="12"></th>
                <th>Cash</th>
                <th colspan="4">
                    @if ($pos->is_cash == 1)
                    <i class="fas fa-check"></i>
                    @endif
                </th>
            </tr>

            <tr ><th colspan="16"></th></tr>
            <tr>
                <th colspan="16" style="background-color:#ff8b61;color:black;">Proceed To Transaction</th>
            </tr>

            <tr><th colspan="16"></th></tr>


            <tr>
                <th colspan="8"></th>
                <th colspan="6">TOTAL AMOUNT Exclusive of Sales Tax:</th>
                <th colspan="2">{{$pos->total_amount_ex_saletax }}</th>
            </tr>
            <tr>
                <th colspan="8"></th>
                <th colspan="6">Total Discount:</th>
                <th colspan="2">{{$pos->total_discount }}</th>
            </tr>
            <tr>
                <th colspan="8"></th>
                <th colspan="6">Total Sales Tax:</th>
                <th colspan="2">{{$pos->total_saletax }}</th>
            </tr>
            <tr>
                <th colspan="8"></th>
                <th colspan="6">Net Total Inclusive of Sales Tax:</th>
                <th colspan="2">{{$pos->total_amount_inc_saletax }}</th>
            </tr>
            <tr>
                <th colspan="8"></th>
                <th colspan="6">FBR POS FEE:</th>
                <th colspan="2">1/</th>
            </tr>
            <tr>
                <th colspan="8"></th>
                <th colspan="6">GRAND TOTAL:</th>
                <th colspan="2">{{$pos->total_amount+1 }}</th>
            </tr>
        </thead>
    </table>
{{-- </x-layouts.print> --}}
<style>
    .padding-row th{
        padding-left: 40px;
        padding-right: 40px;
    }
    table {
            border-collapse: collapse;
            width: 100%;
        }
        table tr, table td, table th {
            /* border: 1px solid black; */
            border: none;
            margin: 10px !important;
        }
        table th, table td {
            /* border: 1px solid black; */
            border: none;


        }
        
        .text-start{
            text-align: left;
        }
  
</style>
<script>
    // window.print();
</script>