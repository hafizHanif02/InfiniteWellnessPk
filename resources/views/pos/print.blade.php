{{-- <x-layouts.print> --}}
    <table>
        <thead>
            <center>
                <div style="margin-top: 25px !important; margin-bottom: 25px !important">
                    <img src="https://app.infinitewellnesspk.com/logo.png" width="120px" alt="logo">
                </div>
                <div style="margin-top: 25px !important; margin-bottom: 10px !important">
                    <h2>InfinitewellnessPK</h2>
                </div>
                <div style="margin-top: 25px !important; margin-bottom: 10px !important">
                    <p>Ntn # 4459721-1</p>
                </div>
                <div style="margin-bottom: 25px !important;">
                    <p>Plot No.35/135. CP & Berar Cooperative Housing Society, PECHS, Block 7/8, Karachi East.</p>
                </div>
            </center>
    
            <tr style="border-top: 1px solid rgb(29, 29, 29);" class="text-start">
                <th colspan="3">Cashier :</th>
                <th colspan="5">{{ $pos->cashier_name }}</th>
            </tr>
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
                @if (isset($mr_barcode))
                <th colspan="5">
                    {!! $mr_barcode !!}
                    {{ $pos->patient_mr_number }}
                </th>
                @endif
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
                <th colspan="2">Brand</th>
                <th colspan="2">Qty</th>
                <th colspan="2">M.R.P</th>
                <th colspan="2">GST</th>
                <th colspan="2">Disc</th>
                <th>Total</th>
            </tr>
    
            @foreach ($pos->PosProduct as $product)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <th colspan="2">
                        {{ $product->medicine->brand->name }} <br>
                        ({{ $product->medicine->generic_formula }})
                    </th>
                    <th colspan="2">{{ $product->product_quantity }}</th>
                    <th colspan="2">{{ $product->mrp_perunit }}</th>
                    <th colspan="2">{{ $product->gst_percentage }}</th>
                    <th colspan="2">{{ $product->discount_percentage }}</th>
                    <th>{{ $product->product_total_price }}</th>
                </tr>
            @endforeach
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
                <th style="text-align: start !important;" colspan="9">
                    TOTAL AMOUNT Exclusive of Sales Tax :
                </th>
                <th style="text-align: end !important;" colspan="3">
                    {{ $pos->total_amount_ex_saletax }}
                </th>
            </tr>
            <tr>
                <th style="text-align: start !important;" colspan="9">
                    Total Discount :
                </th>
                <th style="text-align: end !important;" colspan="3">
                    {{ $pos->total_discount }}
                </th>
            </tr>
            <tr>
                <th style="text-align: start !important;" colspan="9">
                    Total Sales Tax :
                </th>
                <th style="text-align: end !important;" colspan="3">
                    {{ $pos->total_saletax }}
                </th>
            </tr>
            <tr>
                <th style="text-align: start !important;" colspan="9">
                    Net Total Inclusive of Sales Tax :
                </th>
                <th style="text-align: end !important;" colspan="3">
                    {{ $pos->total_amount_inc_saletax }}
                </th>
            </tr>
            <tr>
                <th style="text-align: start !important;" colspan="9">
                    FBR POS FEE :
                </th>
                <th style="text-align: end !important;" colspan="3">
                    1.00
                </th>
            </tr>
            <tr style="border-bottom: 1px solid rgb(29, 29, 29);">
                <th style="text-align: start !important;" colspan="9">
                    GRAND TOTAL :
                </th>
                <th style="text-align: end !important;" colspan="3">
                    {{ $pos->total_amount + 1 }}
                </th>
            </tr>
    
    
            @if ($pos->is_cash == 0)
            <tr>
                <th colspan="8" style="padding: 0px !important; background-color:black;color:white;">Payment
                    Method</th>
                <th style="padding-top: 10px !important;" colspan="4">Card</th>
            </tr>
        @endif

        @if ($pos->is_cash == 1)
            <tr>
                <th colspan="8" style="padding-top: 10px !important; background-color:black;color:white;">Payment
                    Method</th>
                <th style="padding-top: 10px !important;" colspan="4">Cash</th>
            </tr>
        @endif
    
    
            <tr>
                <th style="padding-top: 20px !important;" colspan="12">
                    -Prices are inclusive of sales tax where applicable.
                </th>
            </tr>
            <tr>
                <th colspan="12">
                    -Please check and varify your medicines, expiry dates and balance cash before leaving the counter to
                    avoid inconvenience of claim later.
                </th>
            </tr>
            <tr>
                <th colspan="12">
                    -Products can be returned or exchanged within 24 hours of sale.
                </th>
            </tr>
            <tr>
                <th colspan="12">
                    -For returns/exchange or claims original receipt is required.
                </th>
            </tr>
            <tr>
                <th colspan="12">
                    -Refrigerated items, Medical devices without warranty.<br>
                    Loose tablets/capsules, milk products, surgical items are neithe<br>
                    refundable/exchangeable.
    
                </th>
            </tr>
            <tr>
                <th colspan="12">
                    -Customer data may be utilized for sharing promotions, offers, <br>
                    market research and analysis.
                </th>
            </tr>
            <tr>
                <th colspan="12">
                    -Terms and conditions apply.
                </th>
            </tr>

            <tr>
                <th colspan="4"></th>
                <th colspan="2">{!! $invoice_barcode !!}</th> 
                <th colspan="6"></th>
            </tr>
            <tr>
                <th colspan="4"></th>
                <th colspan="2">{{ $pos->id }}</th> 
                <th colspan="6"></th>
            </tr>
    
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
            text-align: start;
        }
    </style>
    <script>
        window.print();
    </script>