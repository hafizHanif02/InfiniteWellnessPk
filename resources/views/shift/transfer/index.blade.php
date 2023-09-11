<x-layouts.app title="Transfer List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Transfer List</h3>
                    <div>
                        <a href="{{ route('shift.transfers.create') }}" class="btn btn-primary mb-3">Add
                            New</a>
                        @if ($transfers->count() > 0)
                            <a href="{{ route('shift.transfers.export') }}" class="btn btn-secondary ms-5 mb-3">Export To
                                Excel</a>
                        @endif
                    </div>
                </div>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td>#</td>
                            <td>Code</td>
                            <td>Supply Date</td>
                            <td>Status</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transfers as $transfer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transfer->id }}</td>
                                <td>{{ $transfer->supply_date }}</td>
                                <td>{{ $transfer->status === null ? 'Pending' : ($transfer->status == 1 ? 'Approved' : 'Rejected') }}
                                </td>
                                <td class="d-flex justify-content-center gap-5">
                                    <a href="{{ route('shift.transfers.show', $transfer->id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                   
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="6" class="text-danger">No Transfer Inventory found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $transfers->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#delete-transfer-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#delete-transfer-form').submit();
            });
        </script>
    @endpush
</x-layouts.app>
