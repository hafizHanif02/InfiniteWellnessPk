<x-layouts.app title="Good Receive Status List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <h3>Good Receive Status</h3>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td>#</td>
                            <td>Code</td>
                            <td>Requistion</td>
                            <td>Vendor</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($goodReceiveNotes as $grn)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $grn->id }}</td>
                                <td>{{ $grn->requistion->delivery_date }}</td>
                                <td>{{ $grn->requistion->vendor->account_title }}</td>
                                <td>
                                    @if ($grn->is_approved === null)
                                    {{-- @role('PharmacistAdmin') --}}
                                    @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('PharmacistAdmin'))
                                        <form id="approve-goodreceivestatus-form"
                                            action="{{ route('purchase.good-receive-statuses.status', $grn->id) }}"
                                            class="d-inline" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="1">
                                            <button type="button" id="approve-goodreceivestatus-button"
                                                class="bg-transparent border-0 text-success ms-5">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </form>
                                        <form id="reject-goodreceivestatus-form"
                                            action="{{ route('purchase.good-receive-statuses.status', $grn->id) }}"
                                            class="d-inline" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="0">
                                            <button type="button" id="reject-goodreceivestatus-button"
                                                class="bg-transparent border-0 text-danger ms-5">
                                                <i class="fa fa-close"></i>
                                            </button>
                                        </form>
                                    {{-- @endrole --}}
                                    @else
                                        <div class="badge badge-warning">Only Admin Can Approve</div>
                                    @endif
                                    @elseif($grn->is_approved == 1)
                                        <div class="badge badge-success">Approved</div>
                                    @else
                                        <div class="badge badge-danger">Rejected</div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('purchase.good-receive-statuses.show', $grn->id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="6" class="text-danger">No Receive Note found!</td>
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
            $('#approve-goodreceivestatus-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#approve-goodreceivestatus-form').submit();
            });
            $('#reject-goodreceivestatus-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#reject-goodreceivestatus-form').submit();
            });
        </script>
    @endpush
</x-layouts.app>
