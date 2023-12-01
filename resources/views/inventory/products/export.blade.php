<table id="tbl_exporttable_to_xls">
    <tr>
        <th>code</th>
        <th>product_category</th>
        <th>product_name</th>
        <th>dricetion_of_use</th>
        <th>generic_formula</th>
        <th>common_side_effect</th>
        <th>package_detail</th>
        <th>dosage</th>
        <th>manufacturer</th>
        <th>unit_of_measurement</th>
        <th>manufacturer_retail_price</th>
        <th>pieces_per_pack</th>
        <th>quantity</th>
        <th>trade_price_percentage</th>
        <th>unit_retail</th>
        <th>fixed_discount</th>
        <th>trade_price</th>
        <th>unit_trade</th>
        <th>sale_tax_percentage</th>
        <td>discount_trade_price</td>
        <th>cost_price</th>
        {{-- <th>unit_of_measurement</th> --}} 
          <th>number_of_pack</th> 
        <th>barcode</th>
    </tr>
    <tbody>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->category_name }}</td>
                <td>{{ $product->product_name }}</td>
                @if ($product->dricetion_of_use == null)
                    <td>N/A</td>
                @else
                    <td>{{ $product->dricetion_of_use }}</td>
                @endif
                <td>{{ $product->generic_formula }}</td>
                @if ($product->common_side_effect == null)
                    <td>N/A</td>
                @else
                    <td>{{ $product->common_side_effect }}</td>
                @endif

                @if ($product->package_detail == null)
                    <td>N/A</td>
                @else
                    <td>{{ $product->package_detail }}</td>
                @endif
                <td>{{ $product->dosage_name }}</td>
                <td>{{ $product->manufacturer_name }}</td>

                @if ($product->unit_of_measurement == 1)
                    <td>Pcs</td>
                @else
                    <td>Packet</td>
                @endif

                <td>{{ $product->manufacturer_retail_price }}</td>
                <td>{{ $product->pieces_per_pack }}</td>
                <td>{{ $product->total_quantity }}</td>
                <td>{{ $product->trade_price_percentage }}</td>
                <td>{{ $product->unit_retail }}</td>
                <td>{{ $product->fixed_discount }}</td>
                <td>{{ $product->trade_price }}</td>
                <td>{{ $product->unit_trade }}</td>
                <td>{{ $product->sale_tax_percentage }}</td>
                <td>{{ $product->discount_trade_price }}</td>
                <td>{{ $product->cost_price }}</td>
                <td>{{ $product->number_of_pack }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
{{-- {{ dd('hello') }} --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.6/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        ExportToExcel('xlsx');

        function ExportToExcel(type) {
            var elt = document.getElementById('tbl_exporttable_to_xls');
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "sheet1"
            });
            var currentDate = new Date();
            var day = currentDate.getDate().toString().padStart(2, '0');
            var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            var year = currentDate.getFullYear();
            var formattedDate = day + '-' + month + '-' + year;
            var fileName = 'All-Products (' + formattedDate + ').xlsx';

            // You can use the return statement as needed for your application.
            // If you want to trigger a download, use 'XLSX.writeFile'.
            // If you want to generate a base64 string, use 'XLSX.write'.

            // For example, to trigger a download:
            XLSX.writeFile(wb, fileName);
            window.close();
        }
    });
</script>
