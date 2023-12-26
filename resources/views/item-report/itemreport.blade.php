@extends('layouts.app')
@section('title')
    POS Item Report
@endsection
{{-- {{dd($medicines[0])}} --}}
@section('content')
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="d-flex flex-column">
                @include('flash::message')
                <div class="table-responsive">
                    <div class="card-header">
                        <h3>POS Item Report</h3>
                        <a href="{{ route('itemReport.print', ['date_from' => request('date_from'), 'date_to' => request('date_to')]) }}"
                            target="_blank" class="btn btn-primary mt-3">Print</a>
                    </div>
                    <div class="card-body">

                        <div class="d-flex justify-content-center gap-5 mb-5">
                            <div class="d-flex gap-5">
                                <div>
                                    <label for="date_from" class="form-label">Date From</label>
                                    <input type="date" value="{{ request('date_from', date('Y-m-d')) }}"
                                        class="form-control" name="date_from" id="date_from"
                                        onchange="updateQueryString('date_from', this.value)">
                                </div>
                                <div>
                                    <label for="date_to" class="form-label">Date To</label>
                                    <input type="date" value="{{ request('date_to', date('Y-m-d')) }}"
                                        class="form-control" name="date_to" id="date_to"
                                        onchange="updateQueryString('date_to', this.value)">
                                </div>
                            </div>
                            <div class="mt-5">
                                <a href="{{ route('itemReport.itemreport') }}" class="btn btn-secondary mt-3">Reset</a>
                                <button class="btn btn-primary mt-3" onclick="ExportToExcel('xlsx')">Export to
                                    Excel</button>

                            </div>
                        </div>
                        <table id="tbl_exporttable_to_xls" class="table table-striped">
                            <thead>
                                {{-- {{ dd($medicines[0]) }} --}}
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Piece Per Pack</th>
                                    <th>Manufacturer</th>
                                    <th>Sell QTY</th>
                                    <th>Return QTY</th>
                                    <th>Current QTY</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($medicines as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->product->productCategory->name }}</td>
                                        <td>{{ $product->product->pieces_per_pack }}</td>
                                        <td>{{ $product->product->manufacturer->company_name }}</td>
                                        <td>{{ $product->sell_qty }}</td>
                                        <td>{{ $product->return_qty }}</td>
                                        <td>{{ $product->total_quantity }}</td>
                                    </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateQueryString(key, value) {
            var searchParams = new URLSearchParams(window.location.search);

            if (searchParams.has(key)) {
                searchParams.set(key, value);
            } else {
                searchParams.append(key, value);
            }

            var newUrl = window.location.pathname + '?' + searchParams.toString();
            history.pushState({}, '', newUrl);
            window.location.reload();

        }


        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('tbl_exporttable_to_xls');
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "sheet1"
            });
            var currentDate = new Date();
            var day = currentDate.getDate().toString().padStart(2, '0');
            var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            var year = currentDate.getFullYear();
            var formattedDate = day + '-' + month + '-' + year;
            var fileName = 'POS-Report (' + formattedDate + ').xlsx';

            return dl ?
                XLSX.write(wb, {
                    bookType: type,
                    bookSST: true,
                    type: 'base64'
                }) :
                XLSX.writeFile(wb, fn || fileName);
        }
    </script>
@endsection
