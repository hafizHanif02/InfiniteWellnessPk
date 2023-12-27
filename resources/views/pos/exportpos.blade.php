<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <table  id="tbl_exporttable_to_xls" class="table table-bordered">
        <tr>
            <th>Index</th>
            <th>Date</th>
            <th>Time</th>
            <th>Bill No</th>
            <th>User Id</th>
            <th>Item Name</th>
            <th>Qty Sold</th>
            <th>MRP rate</th>
            <th>Infinite Discount</th>
            <th>Infinite Discount %</th>
            <th>Selling Price Per Unit</th>
            <th>Total sale Amount </th>
            <th>Mode of Payment</th>
            <th>Type</th>
            <th>Product Return Qty</th>
            <th>Product Return Amount</th>
            <th>Category</th>
            <th>Dosage Form</th>        
        </tr>
        <tr>
            @foreach($pos as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->created_at->format('Y-m-d') }}</td>
                <td>{{ $item->created_at->format('H:i:s') }}</td>
                <td>{{ $item->pos->id }}</td>
                <td>{{ $item->user_id }}</td>                 
                <td>{{ $item->product_name }}</td>                     
                <td>{{ $item->product_quantity }}</td>
                <td>{{ $item->mrp_perunit }}</td>
                <td>{{ $item->discount_amount }}</td>
                <td>{{ $item->discount_percentage }}</td>
                <td>{{( $item->mrp_perunit  * $item->product_quantity - $item->discount_amount) / $item->product_quantity }}</td>
                <td>{{  $item->mrp_perunit   * $item->product_quantity - $item->discount_amount}}</td>
                {{-- <td>{{ $item->pos->enter_payment_amount }}</td> --}}
                <td>{{ $item->pos->is_cash == 1 ? 'Cash' : 'Card' }}</td>
               <td>{{ count($item->pos->PosProductReturn) > 0 ? 'Return' : 'Sale' }}</td>
               <td>{{ $item->pos->PosProductReturn->sum('product_quantity') }}</td>
               <td>{{ $item->pos->PosProductReturn->sum('product_total_price') }}</td>
                <td>{{ $item->medicine->category->name}}</td> 
                 <td>{{ $item->medicine->dosage_form}}</td>     
            </tr>
        @endforeach
        </tr>
    </table>  
</body>
</html>
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