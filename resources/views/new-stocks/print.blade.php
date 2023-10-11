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
        <tr class="text-start">
            <th colspan="3" class="text-start">Code :</th>
            <th colspan="5">{{ $stockReport->id }}</th>
        </tr>
        <tr class="text-start">
            <th colspan="3" class="text-start">Total Supply Quantity :</th>
            <th colspan="5">{{ $stockReport->total_supply_quantity }}</th>
        </tr>
    </thead>
</table>

<table border="1">
    <thead>
        <tr>
            <th colspan="4">Code</th>
            <th colspan="4">QTY transfered</th>
            <th colspan="4">Name</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($stockReport->transferProducts as $transferProduct)
            <tr>
                <th colspan="4">{{ $transferProduct->product->id }}</th>
                <th colspan="4">{{ $transferProduct->total_piece }}</th>
                <th colspan="4">{{ $transferProduct->product->product_name }}</th>
            </tr>
        @empty
            <tr>
                <th colspan="5">No products Found!</th>
            </tr>
        @endforelse
    </tbody>

</table>
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
