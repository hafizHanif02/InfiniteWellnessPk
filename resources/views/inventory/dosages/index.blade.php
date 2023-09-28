<x-layouts.app title="Dosage Form List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Dosage Form</h3>
                    <div class="d-flex gap-5">
                        <div>
                            <a href="{{ asset('csv/Dosages.xlsx') }}" class="btn btn-danger" download>Download
                                sample</a>
                        </div>
                        <form id="csv-form" action="{{ route('inventory.dosages.import-excel') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="dosages_csv" id="dosages_csv" style="display: none;">
                            <label for="dosages_csv" class="btn btn-secondary float-end mr-5 mb-3">Import
                                Excel</label>
                            <button type="submit" class="btn btn-secondary float-end mr-5 mb-3"
                                style="display: none;">button</button>
                        </form>
                        <a href="{{ route('inventory.dosages.create') }}"
                            class="btn btn-primary float-end mr-5 mb-3">Add New</a>
                    </div>
                </div>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td scope="col" id="serial_number">#</td>
                            <td scope="col" id="code">Code</td>
                            <td scope="col" id="name">Name</td>
                            <td scope="col" id="action">Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dosages as $dosage)
                            <tr>
                                <td scope="row" headers="serial_number">{{ $loop->iteration }}</td>
                                <td headers="code">{{ $dosage->id }}</td>
                                <td headers="name">{{ $dosage->name }}</td>
                                <td headers="action">
                                    <a href="{{ route('inventory.dosages.edit', $dosage->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form id="delete-dosage-form{{ $dosage->id }}"
                                        action="{{ route('inventory.dosages.destroy', $dosage->id) }}" class="d-inline"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="deleteDosage({{ $dosage->id }})"
                                            id="delete-dosage-button" class="bg-transparent border-0 text-danger ms-5">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="4" class="text-danger">No dosages form found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $dosages->links() }}
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
            $('input[name="dosages_csv"]').change(function() {
                $('#csv-form').submit();
            });

            function deleteDosage(dosageId) {
                $(this).prop('disabled', true);
                $('#delete-dosage-form' + dosageId).submit();
            };
        </script>
    @endpush
</x-layouts.app>
