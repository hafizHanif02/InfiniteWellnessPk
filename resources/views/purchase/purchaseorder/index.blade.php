<x-layouts.app title="Purchase Order List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <h3>Purchase Order</h3>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td>#</td>
                            <td>Code</td>
                            <td>Vendor</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requistions as $requistion)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $requistion->id }}</td>
                                <td>{{ $requistion->vendor->account_title }}</td>
                                <td class="d-flex justify-content-center gap-5">
                                    @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('PharmacistAdmin'))
                                    <form id="approve-purchaseorder-form" action="{{ route('purchase.purchaseorder.status', $requistion->id) }}"
                                        class="d-inline" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="1">
                                        <button type="submit" id="approve-purchaseorder-button" class="bg-transparent border-0 text-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </form>
                                    <form id="reject-purchaseorder-form" action="{{ route('purchase.purchaseorder.status', $requistion->id) }}"
                                        class="d-inline" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="0">
                                        <button type="submit" id="reject-purchaseorder-reject" class="bg-transparent border-0 text-danger">
                                            <i class="fa fa-close"></i>
                                        </button>
                                    </form>
                                    @else
                                    <div class="badge badge-warning">Only Admin Can Approve</div>
                                @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-5">
                                        <a href="{{ route('purchase.purchaseorder.show', $requistion->id) }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('purchase.purchaseorder.edit', $requistion->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="7" class="text-danger">No purchase order found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $requistions->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#approve-purchaseorder-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#approve-purchaseorder-form').submit();
            });
            $('#reject-purchaseorder-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#reject-purchaseorder-form').submit();
            });
        </script>
    @endpush
</x-layouts.app>
