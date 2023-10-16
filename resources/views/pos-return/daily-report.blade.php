@extends('layouts.app')
@section('title')
    POS Daily Report
@endsection
@section('content')
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

<div class="container-fluid mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Point Of Sale Daily List</h3>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center gap-5 mb-5">
                <div class="d-flex gap-5">
                    <div>
                        <label for="date_from" class="form-label">Date From</label>
                        <input type="date" value="{{ request('date_from') }}" class="form-control"
                            name="date_from" id="date_from" onchange="updateQueryString('date_from',this.value)">
                    </div>
                    <div>
                        <label for="date_to" class="form-label">Date To</label>
                        <input type="date" value="{{ request('date_to') }}" class="form-control" name="date_to"
                            id="date_to" onchange="updateQueryString('date_to',this.value)">
                    </div>
                </div>
                <div class="mb-5">
                    <label for="is_cash" class="form-label">Payment Method</label>
                    <select class="form-control" name="is_cash" id="is_cash" onchange="updateQueryString('is_cash',this.value)">
                        <option value="" selected disabled>Select Pay Method</option>
                        <option @if(request('is_cash') == '1') selected @endif value="1">Cash</option>
                        <option @if(request('is_cash') == '0') selected @endif value="0">Card</option>
                    </select>
                </div>
                <div class="mt-5">
                    <a href="{{ route('returnposreport.daily') }}" class="btn btn-secondary mt-3">Reset</a>
                    <button class="btn btn-primary mt-3" onclick="ExportToExcel('xlsx')">Export to Excel</button>

                </div>
            </div>
            <table class="table table-bordered text-center table-hover" id="tbl_exporttable_to_xls">
                <thead class="table-dark">
                    <tr>
                        <td>POS date</td>
                        <td>POS No.</td>
                        <td>Patient Name</td>
                        <td>Method</td>
                        <td>Type</td>
                        <td>Total Amount</td>
                    </tr>
                </thead>
                <tbody id="pos-list">
                    {{-- {{dd($pos)}} --}}
                    @forelse ($pos as $ps)
                        <tr>
                            <td>{{ $ps->created_at->format('Y-m-d') }}</td>
                            <td>{{ $ps->id }}</td>
                            <td>{{ $ps->patient_name }}</td>
                            <td>{{$ps->is_cash ?'Cash':'Card' }}</td>
                            <td>Sale</td>
                            <td>{{ $ps->total_amount }}
                                <input type="hidden" value="{{ $ps->total_amount }}" class="totalamount" id="totalamount" >
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="8" class="text-danger">No purchase order found!</td>
                        </tr>
                    @endforelse
                </tbody>
                <tbody id="pos-return-list">
                    {{-- {{dd($pos)}} --}}
                    @forelse ($posreturns as $posreturn)
                        <tr>
                            <td>{{ $posreturn->created_at->format('Y-m-d') }}</td>
                            <td>{{ $posreturn->id }}</td>
                            <td>{{ $posreturn->pos->patient_name }}</td>
                            <td>{{$posreturn->pos->is_cash ?'Cash':'Card' }}</td>
                            <td>Return Sale</td>
                            <td>-{{ $posreturn->total_amount }}
                                <input type="hidden" value="{{ $posreturn->total_amount }}" class="totalamountdetect" id="totalamountdetect" >
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="9" class="text-danger">No POS Return found!</td>
                        </tr>
                    @endforelse
                </tbody>
                <tbody>
                    <tr>
                     <td colspan="4"></td>
                     <td class="text-start bg-dark text-white">Total Revenue</td>
                     <td class="text-start bg-dark text-white totalrevenuetd" ></td>   
                    </tr>
                   </tbody>
            </table>
            <div>
                {{-- {{ $purchaseOrders->links() }} --}}
            </div>
        </div>
    </div>
</div>
<script>
  $(document).ready(function() {
       var totalAmount = 0;
       var totalAmountDetect = 0;
           $("[id^='totalamount']").each(function() {
               if ($(this).val() != '') {
                   totalAmount += parseFloat($(this).val());   
               }
           }); 
           $("[id^='totalamountdetect']").each(function() {
               if ($(this).val() != '') {
                totalAmountDetect += parseFloat($(this).val()); 
                
            }
        }); 
        
        var TotalAmountwithReturn = totalAmount - (totalAmountDetect * 2);
         console.log(totalAmountDetect);
           $('#totalrevenue').val(TotalAmountwithReturn);
           $(".totalrevenuetd").text(TotalAmountwithReturn.toFixed(2));

           
           $("#totalrevenue").text(TotalAmountwithReturn.toFixed(2));   
           
           });

</script>
@endsection


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
                var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
                var currentDate = new Date();
                var day = currentDate.getDate().toString().padStart(2, '0');
                var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
                var year = currentDate.getFullYear();         
                var formattedDate = day + '-' + month + '-' + year;
                var fileName = 'POS-Return-Report (' + formattedDate + ').xlsx';

                return dl ?
                    XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
                    XLSX.writeFile(wb, fn || fileName);
            }
    </script>
