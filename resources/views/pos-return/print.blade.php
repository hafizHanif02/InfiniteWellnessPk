{{-- {{dd($posReturn->posReturn,$posReturn->posReturnProduct) }} --}}
{{-- {{dd($posReturn)}} --}}
<x-layouts.print>
    <table class="table table-bordered">
        <thead class="table-dark text-dark">
            <tr>
                <th colspan="16" class="text-center"><h3>POS RETURN SLIP</h3></th>
            </tr>
          <tr class="padding-row">
            <th colspan="2">POS Date</th>
            <th colspan="2">{{$posReturn->pos->created_at }}</th>
            <th colspan="1">POS#</th>
            <th colspan="2">{{$posReturn->pos->id }}</th>
            <th colspan="2">Return No</th>
            <th colspan="2">{{$posReturn->id }}</th>
            <th colspan="2">Return Date/Time</th>
            <th colspan="2">{{$posReturn->created_at }}</th>
           <tr>
            <tr>
                <th colspan="2">Name</th>
                <th colspan="2">{{$posReturn->pos->patient_name }}</th>
                <th colspan="12"></th>
            </tr>
            <tr>
                <th colspan="2">Contact No</th>
                <th colspan="2">034124782147</th>
                <th colspan="12"></th>
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

            @foreach ($posReturn->Pos_Product_Return as $product)
            <tr>
                <td class="text-center" colspan="2">{{ $loop->iteration }}</td>
                <td class="text-center" colspan="2">{{ $product->medicine->brand->name }}</td>
                <td class="text-center" colspan="2">14714{{ $loop->iteration  }}</td>
                <td class="text-center" colspan="2">{{ $product->product_quantity }}</td>
                <td class="text-center" colspan="2">{{ $product->mrp_perunit }}</td>
                <td class="text-center" colspan="2">{{ $product->gst_percentage }}</td>
                <td class="text-center" colspan="2">{{ $product->discount_percentage }}</td>
                <td class="text-center" colspan="2">{{ $product->product_total_price }}</td>
            </tr>
            @endforeach    
            <tr>
                <th colspan="8"></th>
                <th colspan="6" style="background-color: black; color:white;">TOTAL REFUND AMOUNT</th>
                <th colspan="2">{{$posReturn->total_amount }}</th>
            </tr>
        </thead>
    </table>
</x-layouts.print>
<style>
    .padding-row th{
        padding-left: 40px;
        padding-right: 40px;
    }
    .text-center{
        text-align: center;
    }
   
</style>
<script>
    window.print();
</script>