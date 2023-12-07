<center>
    <div style="margin-top: 25px !important; margin-bottom: 25px !important">
        <img src="https://app.infinitewellnesspk.com/logo.png" width="120px" alt="logo">
    </div>
    <div style="margin-top: 25px !important; margin-bottom: 10px !important">
        <h2>InfinitewellnessPK</h2>
    </div>
    <div style="margin-bottom: 25px !important;">
        <p>Plot No.35/135. CP & Berar Cooperative Housing Society, PECHS, Block 7/8, Karachi East.</p>
    </div>
</center>

<table>
    <thead>      
        <tr style="border-top: 1px solid rgb(29, 29, 29);" class="text-start">
            <th colspan="3" class="text-start">POS Date :</th>
            <th colspan="5">{{ $posReturn->pos->created_at }}</th>
        </tr>
        <tr class="text-start">
            <th colspan="3" class="text-start">POS # :</th>
            <th colspan="5">{{ $posReturn->pos->id }}</th>
        </tr>
        
        <tr class="text-start">
            <th colspan="3" class="text-start">Return No :</th>
            <th colspan="5">{{ $posReturn->id }}</th>
        </tr>
        <tr class="text-start">
            <th colspan="3" class="text-start">Return Date :</th>
            <th colspan="5">{{ $posReturn->created_at }}</th>
        </tr>
        <tr class="text-start">
            <th colspan="3" class="text-start">Name :</th>
            <th colspan="5">{{ $posReturn->pos->patient_name }}</th>
        </tr>
        <tr class="text-start">
            <th colspan="3" class="text-start">Contact No :</th>
            {{-- <th colspan="5">034124782147</th> --}}
            <th colspan="5">{{ $posReturn->pos->patient_number ? $posReturn->pos->patient_number : '-' }}</th>

        </tr>

        <tr style="border-top: 1px solid rgb(29, 29, 29); border-bottom: 1px solid rgb(29, 29, 29);">
            <th class="text-start">S No</th>
            {{-- <th colspan="3" class="text-start">Brand Name</th> --}}
            <th colspan="3" class="text-start">Product</th>
            {{-- <th colspan="2">Barcode on Product </th> --}}
            <th colspan="1">Qty ( Unit )</th>
            <th colspan="1">M.R.P </th>
            <th colspan="1">GST </th>
            <th colspan="1">Disc %</th>
            <th>Total</th>
        </tr>

        
        @foreach ($posReturn->Pos_Product_Return as $product)
        <tr>
            <th class="text-start">{{ $loop->iteration }}</th>
            {{-- <th colspan="3"  class="text-start">{{ $product->medicine->brand->name }}</th> --}}
            <th colspan="3"  class="text-start">{{ $product->product_name}}</th>
            {{-- <th colspan="5">14714{{ $loop->iteration }}</th> --}}
            <th colspan="1">{{ $product->product_quantity }}</th>
            <th colspan="1">{{ $product->mrp_perunit }}</th>
            <th colspan="1">{{ $product->gst_percentage }}</th>
            <th colspan="1">{{ $product->discount_percentage }}</th>
            <th>{{ $product->product_total_price }}</th>
        </tr>
        @endforeach


        <tr>
            <th class="text-end" colspan="10" style="padding: 0px !important; padding-right: 10px !important; background-color:black;color:white;">TOTAL REFUND AMOUNT</th>
            <th>{{ $posReturn->total_amount }}</th>
        </tr>

        <tr>
            <th style="padding-top: 20px !important;" class="text-start" colspan="12">
                -Prices are inclusive of sales tax where applicable.
            </th>
        </tr>
        <tr>
            <th class="text-start" colspan="12">
                -Please check and varify your medicines, expiry dates and balance cash before leaving the counter to
                avoid inconvenience of claim later.
            </th>
        </tr>
        <tr>
            <th class="text-start" colspan="12">
               -No return, No exchange policy.
            </th>
        </tr>
        <tr>
            <th class="text-start" colspan="12">
                -Customer data may be utilized for sharing promotions, offers, <br>
                market research and analysis.
            </th>
        </tr>
        <tr>
            <th class="text-start" colspan="12">
                -Terms and conditions apply.
            </th>
        </tr>




        {{-- <tr>
            <th colspan="8"></th>
            <th colspan="6" style="background-color: black; color:white;">TOTAL REFUND AMOUNT</th>
            <th colspan="2">{{ $posReturn->total_amount }}</th>
        </tr> --}}
    </thead>
</table>
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
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    });
</script>
