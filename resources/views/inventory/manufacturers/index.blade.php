<x-layouts.app title="Manufacturers List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Manufacturers</h3>
                    <div class="d-flex gap-5">
                        <div>
                            <a href="{{ asset('csv/Manufacturers.xlsx') }}" class="btn btn-danger" download>Download
                                sample</a>
                        </div>
                        <form id="csv-form" action="{{ route('inventory.manufacturers.import-excel') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="manufacturer_csv" id="manufacturer_csv" style="display: none;">
                            <label for="manufacturer_csv" class="btn btn-secondary float-end mr-5 mb-3">Import
                                Excel</label>
                            <button type="submit" class="btn btn-secondary float-end mr-5 mb-3"
                                style="display: none;">button</button>
                        </form>
                        <a href="{{ route('inventory.manufacturers.create') }}"
                            class="btn btn-primary float-end mr-5 mb-3">Add New</a>
                    </div>
                </div>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td scope="col" id="serial_number">#</td>
                            <td scope="col" id="code">Code</td>
                            <td scope="col" id="company">Company</td>
                            <td scope="col" id="actions">Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($manufacturers as $manufacturer)
                            <tr>
                                <td scope="row" headers="serial_number">{{ $loop->iteration }}</td>
                                <td headers="code">{{ $manufacturer->id }}</td>
                                <td headers="company">{{ $manufacturer->company_name }}</td>
                                <td headers="actions" class="d-flex justify-content-center gap-5">
                                    <a href="{{ route('inventory.manufacturers.edit', $manufacturer->id) }}"
                                        class="bg-transparent border-0 text-primary"><i class="fa fa-edit"></i></a>
                                    <form id="delete-manufacturere-form{{ $manufacturer->id }}"
                                        action="{{ route('inventory.manufacturers.destroy', $manufacturer->id) }}"
                                        class="d-inline" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="deleteManufacturer({{ $manufacturer->id }})"
                                            id="delete-manufacturere-button"
                                            class="bg-transparent border-0 text-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="10" class="text-danger">No manufacturer found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $manufacturers->links() }}
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
            $('input[name="manufacturer_csv"]').change(function() {
                $('#csv-form').submit();
            });

            function deleteManufacturer(manufacturerId) {
                $(this).prop('disabled', true);
                $('#delete-manufacturere-form' + manufacturerId).submit();
            };
        </script>
    @endpush
</x-layouts.app>
