@extends('layouts.app')
@section('title')
    {{ __('messages.bill.pos') }}
@endsection
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column">
        @include('flash::message')
        <div class="table-responsive">
                <table class="table table-striped" id="tbl_exporttable_to_xls">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Bill No.</th>
                            <th>Item Name</th>
                            <th>Qty Sold</th>
                            {{-- <th>Posted By</th> --}}
                            <th>Cost Per Unit</th>
                            <th>Total Cost</th>
                            <th>MRP Rate</th>
                            <th>Infinite Discount</th>
                            <th>Infinite Discount %</th>
                            <th>Selling Price Per Unit</th>
                            <th>Total Sell Amount</th>
                            <th>Bank Charges</th>
                            <th>Sales Tax</th>
                            <th>Keenu Charges</th>
                            <th>Net Profit</th>
                            <th>Profit/Loss</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tbody>
                            @foreach ($posProducts as $product)
                            <tr>
                                <td>{{ $product->date }}</td>
                                <td>{{ $product->pos_id }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->product_quantity }}</td>
                                {{-- <td>{{ $product->user->name }}</td> --}}
                                <td>{{ $product->cost_per_unit }}</td>
                                <td>{{ $product->cost_per_unit * $product->product_quantity }}</td>
                                <td>{{ $product->mrp_perunit }}</td>
                                <td>{{ $product->discount_amount }}</td>
                                <td>{{ $product->discount_percentage }}</td>
                                <td>{{ $product->mrp_perunit - ($product->mrp_perunit * $product->discount_percentage / 100) }}</td>
                                {{-- <td>{{ ($product->mrp_perunit - $product->discount_amount) * $product->product_quantity }}</td> --}}
                                <td> {{ $product->product_total_price }} </td>
                                <td> - </td>
                                <td>{{ $product->gst_amount }}</td>
                                <td> - </td>
                                <td>{{ $product->product_total_price - ($product->cost_per_unit * $product->product_quantity) }}</td>
                                <td>@if (($product->mrp_perunit - $product->discount_amount) * $product->product_quantity - ($product->cost_per_unit * $product->product_quantity) > 0)
                                    Profit
                                @else
                                    Loss
                                @endif</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </tbody>
                </table>
                <div>
                </div>
            </div>
        </div>
    </div>
@endsection
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