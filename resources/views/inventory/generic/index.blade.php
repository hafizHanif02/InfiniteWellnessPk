<x-layouts.app title="Generic Formula List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Generic Formulas</h3>
                    <div class="d-flex gap-5">
                        <div>
                            <a href="{{ asset('csv/Generics.xlsx') }}" class="btn btn-danger" download>Download
                                sample</a>
                        </div>
                        <form id="csv-form" action="{{ route('inventory.generics.import-excel') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="generic_csv" id="generic_csv" style="display: none;">
                            <label for="generic_csv" class="btn btn-secondary float-end mr-5 mb-3">Import
                                Excel</label>
                            <button type="submit" class="btn btn-secondary float-end mr-5 mb-3"
                                style="display: none;">button</button>
                        </form>
                        <a href="{{ route('inventory.generics.create') }}"
                            class="btn btn-primary float-end mr-5 mb-3">Add
                            New</a>
                    </div>
                </div>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td scope="col" id="serial_number" class="col-md-1">#</td>
                            <td scope="col" id="code" class="col-md-1">Code</td>
                            <td scope="col" id="formula" class="col-md-2">Generic Formula</td>
                            <td scope="col" id="generic_detail" class="col-md-5">Generic Detail</td>
                            <td scope="col" id="action" class="col-md-3">Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($generics as $generic)
                            <tr>
                                <td scope="row" headers="serial_number" class="col-md-1">{{ $loop->iteration }}</td>
                                <td headers="code" class="col-md-1">{{ $generic->id }}</td>
                                <td headers="formula" class="col-md-2">{{ $generic->formula }}</td>
                                <td headers="generic_detail" class="col-md-5">{{ $generic->generic_detail }}</td>
                                <td headers="action" class="col-md-3">
                                    <a href="{{ route('inventory.generics.edit', $generic->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form id="delete-generic-form{{ $generic->id }}"
                                        action="{{ route('inventory.generics.destroy', $generic->id) }}"
                                        class="d-inline" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="deleteGeneric({{ $generic->id }})"
                                            id="delete-generic-button" class="bg-transparent border-0 text-danger ms-5">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5" class="text-danger">No generic found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $generics->links() }}
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
            $('input[name="generic_csv"]').change(function() {
                $('#csv-form').submit();
            });

            function deleteGeneric(genericId) {
                $(this).prop('disabled', true);
                $('#delete-generic-form' + genericId).submit();
            };
        </script>
    @endpush
</x-layouts.app>
