<x-layouts.app title="Purchase Return Status List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Purchase Return Status List</h3>
                </div>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td>#</td>
                            <td>Code</td>
                            <td>GRN #</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchasereturns as $purchasereturn)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $purchasereturn->id }}</td>
                                <td>{{ $purchasereturn->goodReceiveNote->id }}</td>
                                <td>
                                    @if ($purchasereturn->status === null)
                                    @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('PharmacistAdmin'))
                                        <form id="approve-purchasereturnstatus-form"
                                            action="{{ route('purchase.purchase-return-status.update', $purchasereturn->id) }}"
                                            class="d-inline" method="POST">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="status" value="1">
                                            <button type="button" id="approve-purchasereturnstatus-button"
                                                class="bg-transparent border-0 text-success ms-5">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </form>
                                        <form id="reject-purchasereturnstatus-form"
                                            action="{{ route('purchase.purchase-return-status.update', $purchasereturn->id) }}"
                                            class="d-inline" method="POST">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="status" value="0">
                                            <button type="button" id="reject-purchasereturnstatus-button"
                                                class="bg-transparent border-0 text-danger ms-5">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        </form>
                                        @else
                                        <div class="badge badge-warning">Only Admin Can Approve</div>
                                    @endif
                                    @elseif($purchasereturn->status === 1)
                                        <div class="badge badge-success">Approved</div>
                                    @else
                                        <div class="badge badge-danger">Rejected</div>
                                        <a href="{{route('purchase.purchase-return-status.retransfer',$purchasereturn->id) }}">
                                            {{-- <button type="button" title="Retransfer"
                                                class="bg-transparent border-0 text-primary ms-5">
                                                <i class="fa fa-recycle"></i>
                                            </button> --}}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('purchase.purchase-return-status.show', $purchasereturn->id) }}"><i
                                            class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5" class="text-danger">No purchase return found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $purchasereturns->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#approve-purchasereturnstatus-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#approve-purchasereturnstatus-form').submit();
            });
            $('#reject-purchasereturnstatus-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#reject-purchasereturnstatus-form').submit();
            });
        </script>
    @endpush
</x-layouts.app>
