@extends('layouts.app')
@section('title')
    POS
@endsection




@section('content')
<div class="container-fluid mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Point Of Sale List</h3>
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
                        <option value="1">Cash</option>
                        <option value="0">Card</option>
                    </select>
                </div>
                <div class="mt-5">
                    <a href="{{ route('posinv.index') }}" class="btn btn-secondary mt-3">Reset</a>
                    <a href="{{ route('posinv.export') }}" class="btn btn-primary mt-3">Export To Excel</a>
                </div>
                {{-- <div class="mt-5">
                    <button onclick="gettotal()" class="btn btn-primary mt-3">
                        Get Total
                    </button>
                </div> --}}
            </div>
            <table class="table table-bordered text-center table-hover">
                <thead class="table-dark">
                    <tr>
                        <td>POS date</td>
                        <td>POS No.</td>
                        <td>Patient Name</td>
                        <td>Method</td>
                        <td>Amount</td>
                    </tr>
                   
                </thead>
                <tbody id="pos-list">

                    @forelse ($pos as $ps)
                        <tr>
                            <td>{{ $ps->pos_date }}</td>
                            <td>{{ $ps->id }}</td>
                            <td>{{ $ps->patient_name }}</td>
                            <td>{{($ps->is_cash == 0)?'Card':'Cash' }}</td>
                            <td class="totalamount">
                                {{ $ps->total_amount }}
                            <input type="hidden" value="{{ $ps->total_amount }}" class="totalamount" id="totalamount" >
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="8" class="text-danger">No purchase order found!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <table class="table table-bordered">
               <tbody>
                <tr>
                    <td ></td>
                 <td class="text-start">Total Revenue</td>
                
                 <td class="text-start totalrevenuetd" >
                        {{-- <span class="totalrevenuetd"></span> --}}
                        {{-- <input type="hidden" class="form-control" id="totalrevenue"> --}}
                    </td>
                   
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
            $("[id^='totalamount']").each(function() {
                if ($(this).val() != '') {
                    totalAmount += parseFloat($(this).val());
               
                }
            }); 
            $('#totalrevenue').val(totalAmount);
            $(".totalrevenuetd").text(totalAmount.toFixed(2));

            
            $("#totalrevenue").text(totalAmount.toFixed(2));         
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
                $.ajax({
                    type: "get",
                    url: "/reportpos/filter/?" + searchParams.toString(),
                    dataType: "json",
                    success: function(response) {
                        $("#pos-list").empty();
                        if (response.data.length > 0) {
                            $.each(response.data, function(index, value) {
                                console.log(value);
                                $("#pos-list").append(`
                                    <tr>
                                        <td>${value.pos_date}</td>
                                        <td>${value.id}</td>
                                        <td>${value.patient_name}</td>
                                        <td>${value.is_cash? 'Cash':'Card' }</td>
                                        <td class="totalamount">
                                            ${value.total_amount}
                            <input type="hidden" value="${value.total_amount}" class="totalamount" id="totalamount" >
                                            
                                            </td>
                                    </tr>
                                 `);
                            });
                            window.location.reload();
                        } else {
                            $("#pos-list").append(`
                            <tr class="text-center">
                                <td colspan="6" class="text-danger">No POS found!</td>
                            </tr>
                            `);
                            window.location.reload();
                        }
                        }
                });

            }

        function runthis(){
            console.log("sadfsfsdfsadfsadfsfdsf");
        }


        // function gettotal(){
          
         
        // }
        
       

    </script>





