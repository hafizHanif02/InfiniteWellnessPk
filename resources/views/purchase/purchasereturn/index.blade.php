<x-layouts.app title="Purchase Return List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Purchase Return List</h3>
                    <a href="{{ route('purchase.return.create') }}" class="btn btn-primary float-end mr-5 mb-3">Add
                        New</a>
                </div>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td>#</td>
                            <td>Code</td>
                            <td>GRN #</td>
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
                                    <a href="{{ route('purchase.return.show', $purchasereturn->id) }}"><i
                                            class="fa fa-eye"></i></a>
                                    <form id="delete-purchasereturn-form"
                                        action="{{ route('purchase.return.destroy', $purchasereturn->id) }}"
                                        class="d-inline" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" id="delete-purchasereturn-button"
                                            class="bg-transparent border-0 text-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="4" class="text-danger">No purchase return found!</td>
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
            $('#delete-purchasereturn-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#delete-purchasereturn-form').submit();
            });
        </script>
    @endpush
</x-layouts.app>
