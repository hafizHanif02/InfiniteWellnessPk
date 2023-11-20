@extends('layouts.app')
@section('title')
    POS Item Report
@endsection
@section('content')
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="d-flex flex-column">
                @include('flash::message')
                <div class="table-responsive">
                    <div class="card-header">
                        <h3>POS Item Report</h3>
                        <a href="{{ route('posItemReport.print', ['date_from' => request('date_from'), 'date_to' => request('date_to')]) }}"
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
                                <a href="{{ route('posItemReport.index') }}" class="btn btn-secondary mt-3">Reset</a>
                                <button class="btn btn-primary mt-3" onclick="ExportToExcel('xlsx')">Export to
                                    Excel</button>

                            </div>
                        </div>
                        <table id="tbl_exporttable_to_xls" class="table table-striped">
                            <thead>
                                {{-- {{ dd($poses[0]->medicine_id) }} --}}
                                <tr>
                                    <th>Product Name</th>
                                    <th>Manufacturer</th>
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
                                            <td>{{ $posProduct->company_name }}</td>
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
