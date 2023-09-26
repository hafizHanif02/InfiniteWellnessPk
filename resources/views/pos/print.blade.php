{{-- <x-layouts.print> --}}
<table>
    <thead>
        <center>
            <div style="margin-top: 25px !important; margin-bottom: 25px !important">
                <img src="https://app.infinitewellnesspk.com/logo.png" width="120px" alt="logo">
            </div>
            <div style="margin-top: 25px !important; margin-bottom: 25px !important">
                <h2>infinitewellness</h2>
            </div>
            <div style="margin-top: 25px !important; margin-bottom: 25px !important">
                <p>infinitewellness</p>
            </div>
        </center>

        <tr class="text-start">
            <th colspan="3">INV #</th>
            <th colspan="5">{{ $pos->id }}</th>
        </tr>
        <tr class="text-start">
            <th colspan="3">Name</th>
            <th colspan="5">{{ $pos->patient_name }}</th>
        </tr>
        <tr class="text-start">
            <th colspan="3">EMR #</th>
            <th colspan="5">
            {!!DNS1D::getBarcodeHtml($pos->patient_mr_number,'CODABAR')!!}
            </th>
        </tr>
        <tr class="text-start">
            <th colspan="3">Date</th>
            <th colspan="6">{{ $pos->created_at }}</th>
        </tr>
        <tr class="text-start">
            <th colspan="3">Contact #</th>
            <th colspan="5">034124782147</th>
        </tr>
        <tr style="border-top: 1px solid rgb(29, 29, 29); border-bottom: 1px solid rgb(29, 29, 29);">
            <th>#</th>
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
                <th colspan="2">14714{{ $loop->iteration }}</th>
                <th colspan="2">{{ $product->product_quantity }}</th>
                <th colspan="2">{{ $product->mrp_perunit }}</th>
                <th colspan="2">{{ $product->gst_percentage }}</th>
                <th colspan="2">{{ $product->discount_percentage }}</th>
                <th>{{ $product->product_total_price }}</th>
            </tr>
        @endforeach
        {{-- <tr>
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
        </tr> --}}

        <tr>
            <th colspan="16"></th>
        </tr>
        <tr>
            <th colspan="16"
                style="background-color:#ff8b61;color:black; border-top: 1px solid rgb(29, 29, 29); border-bottom: 1px solid rgb(29, 29, 29);">
                Proceed To Transaction</th>
        </tr>

        <tr>
            <th colspan="16"></th>
            <th colspan="16"></th>
        </tr>
        <tr>
            <th colspan="6">
                TOTAL AMOUNT Exclusive of Sales Tax :
            </th>
            <th colspan="6">
                {{ $pos->total_amount_ex_saletax }}
            </th>
        </tr>
        <tr>
            <th colspan="6">
                Total Discount :
            </th>
            <th colspan="6">
                {{ $pos->total_discount }}
            </th>
        </tr>
        <tr>
            <th colspan="6">
                Total Sales Tax :
            </th>
            <th colspan="6">
                {{ $pos->total_saletax }}
            </th>
        </tr>
        <tr>
            <th colspan="6">
                Net Total Inclusive of Sales Tax :
            </th>
            <th colspan="6">
                {{ $pos->total_amount_inc_saletax }}
            </th>
        </tr>
        <tr>
            <th colspan="6">
                FBR POS FEE :
            </th>
            <th colspan="6">
                1
            </th>
        </tr>
        <tr style="border-bottom: 1px solid rgb(29, 29, 29);">
            <th colspan="6">
                GRAND TOTAL :
            </th>
            <th colspan="6">
                {{ $pos->total_amount + 1 }}
            </th>
        </tr>


        <tr>
            <th colspan="3" style="padding-top: 10px !important; background-color:black;color:white;">Payment Method</th>
            <th colspan="9"></th>
            <th style="padding-top: 10px !important;">Card</th>
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


        <tr>
            <th style="padding-top: 20px !important;" colspan="9">
                -Prices are inclusive of sales tax where applicable.
            </th>
        </tr>
        <tr>
            <th colspan="9">
                -Please check and varify your medicines, expiry dates and balance cash before leaving the counter to avoid inconvenience of claim later. 
            </th>
        </tr>
        <tr>
            <th colspan="9">
                -Products can be returned or exchanged within 24 hours of sale. 
            </th>
        </tr>
        <tr>
            <th colspan="9">
                -For returns/exchange or claims original receipt is required. 
            </th>
        </tr>
        <tr>
            <th colspan="9">
                -Refrigerated items, Medical devices without warranty.<br>
                Loose tablets/capsules, milk products, surgical items are neithe<br>
                refundable/exchangeable.

            </th>
        </tr>
        <tr>
            <th colspan="9">
                -Customer data may be utilized for sharing promotions, offers, <br>
                market research and analysis.
            </th>
        </tr>
        <tr>
            <th colspan="9">
                -Terms and conditions apply.
            </th>
        </tr>

        <center>
            <tr>
                <th colspan="1">

                <th colspan="6">
                    <div style="margin-top: 13px !important;">
                        <img src="{{ asset('images/fbr.png') }}" width="150px" alt="">
                    </div>
                </th>

                <th colspan="1">
                    
                </th>
                
                <th colspan="6">
                    <div style="margin-top: 13px !important;">
                        <img src="{{ asset('images/qrcode.png') }}" width="110px" alt="">
                    </div>
                </th>
            </tr>
        </center>

    </thead>
</table>
{{-- </x-layouts.print> --}}
<style>
    .padding-row th {
        padding-left: 40px;
        padding-right: 40px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table tr,
    table td,
    table th {
        /* border: 1px solid black; */
        border: none;
        margin: 10px !important;
    }

    table th,
    table td {
        /* border: 1px solid black; */
        border: none;


    }

    .text-start {
        text-align: left;
    }
</style>
<script>
    // window.print();
</script>
