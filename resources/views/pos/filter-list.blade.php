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
                            name="date_from" id="date_from">
                    </div>
                    <div>
                        <label for="date_to" class="form-label">Date To</label>
                        <input type="date" value="{{ request('date_to') }}" class="form-control" name="date_to"
                            id="date_to">
                    </div>
                </div>
                <div class="mb-5">
                    <label for="is_cash" class="form-label">Payment Method</label>
                    <select class="form-control" name="is_cash" id="is_cash">
                        <option value="" selected disabled>Select Pay Method</option>
                        <option value="1">Cash</option>
                        <option value="0">Card</option>
                    </select>
                </div>
                <div class="mt-5">
                    <a href="{{ route('purchase.purchaseorderlist.index') }}" class="btn btn-secondary mt-3">Reset</a>
                </div>
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
                            <td>{{ $ps->total_amount }}</td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="8" class="text-danger">No purchase order found!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{-- {{ $purchaseOrders->links() }} --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(document).ready(function() {
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
                    url: "/posreturninv/filter/?" + searchParams.toString(),
                    dataType: "json",
                    success: function(response) {
                        $("#pos-list").empty();
                        if (response.data.length > 0) {
                            $.each(response.data, function(index, value) {
                                console.log(value);
                                $("#pos-list").append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                    </tr>
                                 `);
                            });
                        } else {
                            $("#pos-list").append(`
                            <tr class="text-center">
                                <td colspan="6" class="text-danger">No purchase order found!</td>
                            </tr>
                            `);
                        }
                    }
                });
            }

            $("#is_cash").change(function() {
                updateQueryString('is_cash', $(this).val());
            });

            $("#date_from").change(function() {
                updateQueryString('date_from', $(this).val());
            });

            $("#date_to").change(function() {
                updateQueryString('date_to', $(this).val());
            });
        });
    </script>
@endpush
