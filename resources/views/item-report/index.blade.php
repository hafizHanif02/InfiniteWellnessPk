@extends('layouts.app')
@section('title')
    Item Report
@endsection
@section('content')
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <div class="table-responsive">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary mt-3 mb-3" onclick="ExportToExcel('xlsx')">Export to Excel</button>
                </div>
                <table id="tbl_exporttable_to_xls" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Product QTY</th>
                            <th>Return QTY</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($poses as $posProduct)
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div>
                    {{-- {{ $poses->links() }} --}}
                </div>
            </div>
        </div>
    </div>
    <script>

         function ExportToExcel(type, fn, dl) {
                var elt = document.getElementById('tbl_exporttable_to_xls');
                var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
                var currentDate = new Date();
                var day = currentDate.getDate().toString().padStart(2, '0');
                var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
                var year = currentDate.getFullYear();         
                var formattedDate = day + '-' + month + '-' + year;
                var fileName = 'POS-Report (' + formattedDate + ').xlsx';

                return dl ?
                    XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
                    XLSX.writeFile(wb, fn || fileName);
            }
    </script>
@endsection
