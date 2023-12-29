<x-layouts.app title="Good Receive Note List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Good Receive Note</h3>
                    <div>
                        @role('Admin|PharmacistAdmin')
                        <a href="{{route('purchase.grnExport') }}" target="_blank" class="btn btn-secondary float-end mr-5 mb-3">Vender Ledger Report</a>
                        @endrole
                        <a href="{{route('purchase.good_receive_note.create') }}" class="btn btn-primary float-end me-4 mr-5 mb-3">Add New</a>
                    </div>
                </div>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td>#</td>
                            <td>Invoice #</td>
                            <td>Code</td>
                            <td>Requistion</td>
                            <td>Vendor</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($goodReceiveNotes as $grn)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $grn->invoice_number }}</td>
                                <td>{{ $grn->id }}</td>
                                <td>{{ $grn->requistion->delivery_date }}</td>
                                <td>{{ $grn->requistion->vendor->account_title }}</td>
                                <td class="d-flex justify-content-center gap-5">
                                    <a href="{{ route('purchase.good_receive_note.edit', $grn->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ route('purchase.good_receive_note.show', $grn->id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <form id="delete-goodreceivenote-form" action="{{ route('purchase.good_receive_note.destroy', $grn->id) }}" class="d-inline"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" id="delete-goodreceivenote-button" class="bg-transparent border-0 text-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5" class="text-danger">No Receive Note found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $goodReceiveNotes->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#delete-goodreceivenote-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#delete-goodreceivenote-form').submit();
            });
        </script>
    @endpush
</x-layouts.app>
