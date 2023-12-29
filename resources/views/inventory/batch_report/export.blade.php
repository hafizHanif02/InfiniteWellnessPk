<table id="tbl_exporttable_to_xls">
        
    <tr>
        <th></th>
        <th></th>
        @foreach ($days as $key => $day)
        <th colspan="4">{{ $key }}</th>
        @endforeach

        <th colspan="3">GRAND TOTAL - As of Date</th>
    </tr>
    
    <tr>
        <th>Batch ID</th>
        <th>Product Name</th>
        
        @foreach ($days as $day)
            <th>Opening Qty</th>
            <th>Purchase</th>
            <th>Sales</th>
            <th>Current Qty</th>
        @endforeach

        <th>Total Purchase</th>
        <th>Total Sales</th>
        <th>Closing</th>
    </tr>

    @foreach ($results as $key => $record)
        <tr>
            <td>{{ \App\Models\BatchPOS::where('product_id', $key)->first()->batch_id }}</td>
            <td>{{ \App\Models\Inventory\Product::where('id', $key)->first()->product_name }}</td>

            @foreach ($record->sortBy('date') as $values)

                @foreach ($values as $key => $val)

                    @if ($key != 'date')
                        <td>{{ $val }}</td>
                    @endif

                @endforeach

            @endforeach

            <td>{{ $record->sum('purchase') }}</td>
            <td>{{ $record->sum('sold_qty') }}</td>
            <td>{{ $record->sum('purchase') > 0 && $record->sum('sold_qty') > 0 ? $record->sum('purchase') - $record->sum('sold_qty') : $record->sum('purchase') }}</td>
        </tr>
    @endforeach

    <tr>
        <td></td>
        <td>Total:</td>
        @foreach ($days as $value)
            <td>{{ $value['opening_qty'] }}</td>
            <td>{{ $value['purchase'] }}</td>
            <td>{{ $value['sold_qty'] }}</td>
            <td>{{ $value['closing_qty'] }}</td>
        @endforeach
        <td>{{ $grand_total['total_purchase'] }}</td>
        <td>{{ $grand_total['total_sold'] }}</td>
        <td>{{ $grand_total['closing'] }}</td>
    </tr>
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