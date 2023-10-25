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

<table border="1">
    <thead>
        {{-- {{ dd($poses[0]->medicine_id) }} --}}
        <tr>
            <th>Product Name</th>
            <th>Sell QTY</th>
            <th>Return QTY</th>
            <th>Current QTY</th>
        </tr>
    </thead>
    <tbody>
        {{-- {{ dd($poses) }} --}}
        @foreach ($poses as $posProduct)
            @if ($posProduct != null)
                @php
                    // Find the corresponding return quantity for the current product
                    $returnProduct = $posReturnQuantity->where('productName', $posProduct->productName)->first();
                @endphp
                <tr>
                    <td>{{ $posProduct->productName }}</td>
                    <td>{{ $posProduct->productQty }}</td>
                    <td>
                        @if ($returnProduct)
                            {{ $returnProduct->totalquantity }}
                        @else
                            0
                        @endif
                    <td>{{ $posProduct->total_quantity }}</td>
                    </td>
                </tr>
            @else
                <tr>
                    <td colspan="5" class="text-danger">No Record found!</td>
                </tr>
            @endif
        @endforeach

    </tbody>
</table>

{{-- <table border="1">
    <thead>
        <tr>
            <th colspan="4">Product Name</th>
            <th colspan="4">Product QTY</th>
            <th colspan="4">Return QTY</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th colspan="4">{{ $product->product_name }}</th>
            <th colspan="4">{{ $totalQuantity }}</th>
            <th colspan="4">{{ $totalReturnQuantity }}</th>
        </tr>
    </tbody>

</table> --}}
<style>
    * {
        padding: 0px 10px 0px 10px !important;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table tr,
    table th {
        margin: 10px !important;
        padding: 7px 17px 7px 17px !important;
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
