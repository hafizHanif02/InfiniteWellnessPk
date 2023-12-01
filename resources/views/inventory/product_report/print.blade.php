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
        {{-- this route in web.php (products_report.print)--}}
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Open Qty</th>
            <th>Current Qty</th>
            <th>Stock In</th>
            <th>Stock Out</th>
        </tr>
    </thead>
    <tbody>
        {{-- {{dd($products)}} --}}
       {{-- @php echo"<pre>";
        print_r($products);
        exit;
        @endphp --}}
        @foreach ($products as $product)
        <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->product_name }} {{ ($product->generic->formula != NULL ? '(' . $product->generic->formula . ')' : '-') }}</td>
        {{-- <td>{{ $product->open_quantity }}</td> --}}
        <td>{{ $product->stock_current }}</td>
        <td>{{ $product->total_quantity }}</td>
        <td>{{ $product->stock_in }}</td>
        <td>{{ $product->stock_out }}</td>
        
    </tr>
        @endforeach 

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
