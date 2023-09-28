<x-layouts.app title="Edit Dosage Form">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Edit Dosage Form</h3>
                <a href="{{ route('inventory.dosages.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form id="save-category-form" action="{{ route('inventory.dosages.update', $dosage->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Name <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="category_name"
                                    value="{{ old('name', $dosage->name) }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter Dosage name" required title="Category name" autocomplete="name">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="id" class="form-label">Code <sup class="text-danger">*</sup></label>
                                <input type="number" name="id" id="id" class="form-control"
                                    value="{{ $dosage->id }}" required readonly title="Category id">
                                @error('id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <a href="{{ route('inventory.dosages.index') }}" class="btn btn-danger">Cancel</a>
                        <button type="button" id="save-category-button" class="btn btn-primary ms-3">Update</button>
                    </div>
                </form>
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
            $('#save-category-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#save-category-form').submit();
            });
        </script>
    @endpush
</x-layouts.app>
