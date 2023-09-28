<x-layouts.app title="Vendor List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Vendors</h3>
                    <div class="d-flex gap-5">
                        <div>
                            <a href="{{ asset('csv/Vendors.xlsx') }}" class="btn btn-danger" download>Download
                                sample</a>
                        </div>
                        <form id="csv-form" action="{{ route('inventory.vendors.import-excel') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="vendor_csv" id="vendor_csv" style="display: none;">
                            <label for="vendor_csv" class="btn btn-secondary float-end mr-5 mb-3">Import
                                Excel</label>
                            <button type="submit" class="btn btn-secondary float-end mr-5 mb-3"
                                style="display: none;">button</button>
                        </form>
                        <a href="{{ route('inventory.vendors.create') }}"
                            class="btn btn-primary float-end mr-5 mb-3">Add New</a>
                    </div>
                </div>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td scope="col" id="serial_number">#</td>
                            <td scope="col" id="name">Name</td>
                            <td scope="col" id="actions">Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vendors as $vendor)
                            <tr>
                                <td scope="row" headers="serial_number">{{ $loop->iteration }}</td>
                                <td headers="name">{{ $vendor->account_title }}</td>
                                <td headers="actions" class="d-flex justify-content-center gap-5">
                                    <a href="{{ route('inventory.vendors.edit', $vendor->id) }}"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="{{ route('inventory.vendors.show', $vendor->id) }}"><i
                                            class="fa fa-eye"></i></a>
                                    <form id="delete-vendor-form{{ $vendor->id }}"
                                        action="{{ route('inventory.vendors.destroy', $vendor->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="deleteVendor({{ $vendor->id }})"
                                            id="delete-vendor-button" class="bg-transparent border-0 text-danger"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="3" class="text-danger">No vendor found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $vendors->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>

        $(document).ready(function() {
            // Capture the key press event on all input fields within the form
              $('form').on('keypress', 'input', function(e) {
                if (e.which === 13) { // 13 is the key code for "Enter"
                  e.preventDefault(); // Prevent the default form submission
                }
              }); 
        });

            $('input[name="vendor_csv"]').change(function() {
                $('#csv-form').submit();
            });

            function deleteVendor(vendorId) {
                $(this).prop('disabled', true);
                $('#delete-vendor-form' + vendorId).submit();
            };
        </script>
    @endpush
</x-layouts.app>
