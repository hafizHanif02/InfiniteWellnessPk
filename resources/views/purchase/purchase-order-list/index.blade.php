<x-layouts.app title="Purchase Order List">
    @push('styles')
        <link nonce="{{ csp_nonce() }}" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
        <style nonce="{{ csp_nonce() }}">
            .select2-hidden-accessible {
                position: relative !important;
            }
        </style>
    @endpush
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Purchase Order List</h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center gap-5 mb-5">
                    <div class="d-flex gap-5">
                        <div>
                            <label for="date_from" class="form-label">Date From (Delivery Date)</label>
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
                        <label for="vendor_id" class="form-label">Vendor</label>
                        <select class="form-control" name="vendor_id" id="vendor_id">
                            <option value="" selected disabled>Select vendor</option>
                            @forelse ($vendors as $vendor)
                                <option value="{{ $vendor->id }}">
                                    {{ $vendor->account_title }}</option>
                            @empty
                                <option value="" class="text-danger" disabled>No vendor found!</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="mt-5">
                        <a href="{{ route('purchase.purchaseorderlist.index') }}" class="btn btn-secondary mt-3">Reset</a>
                    </div>
                </div>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td>#</td>
                            <td>Code</td>
                            <td>Vendor</td>
                            <td>Delivery Date</td>
                            <td>P/O Date</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody id="order-list">
                        @forelse ($purchaseOrders as $requistion)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $requistion->id }}</td>
                                <td>{{ $requistion->vendor->account_title }}</td>
                                <td>{{ $requistion->delivery_date ?? '-' }}</td>
                                <td>{{$requistion->purchase_order_date ?? '-' }}</td>
                                <td>
                                    @if ($requistion->is_approved == 1)
                                        <span class="badge badge-success">Approved</span>
                                    @elseif ($requistion->is_approved === 0)
                                        <span class="badge badge-danger">Rejected</span>
                                    @else
                                    <span class="text-dark badge badge-warning">Pending</span>

                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('purchase.purchaseorderlist.show', $requistion->id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('purchase.purchaseorderlist.edit', $requistion->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="8" class="text-danger">No purchase order found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $purchaseOrders->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script nonce="{{ csp_nonce() }}">
            $(document).ready(function() {
                $("#vendor_id").select2();

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
                        url: "/purchase/purchase-order-list/filter?" + searchParams.toString(),
                        dataType: "json",
                        success: function(response) {
                            $("#order-list").empty();
                            if (response.data.length > 0) {
                                $.each(response.data, function(index, value) {
                                    console.log(value);
                                    $("#order-list").append(`
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${value.id}</td>
                                            <td>${value.vendor.account_title}</td>
                                            <td>${(value.delivery_date == null) ?'-':value.delivery_date}</td>
                                            <td>${value.purchase_order_date}</td>
                                            <td>
                                                <div class="badge badge-${value.is_approved == 1 ? 'success' : (value.is_approved === 0 ? 'danger' : 'warning')}">
                                                    ${value.is_approved == 1 ? 'Approved' : (value.is_approved === 0 ? 'Disapproved' : 'Pending')}
                                                </div>
                                            </td>
                                            <td>
                                                <a href="/purchase/purchaseorderlist/${value.id}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="/purchase/purchaseorderlist/${value.id}/edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                     `);
                                });
                            } else {
                                $("#order-list").append(`
                                <tr class="text-center">
                                    <td colspan="6" class="text-danger">No purchase order found!</td>
                                </tr>
                                `);
                            }
                        }
                    });
                }

                $("#vendor_id").change(function() {
                    updateQueryString('vendor_id', $(this).val());
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
</x-layouts.app>
