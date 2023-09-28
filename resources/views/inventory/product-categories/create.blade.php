<x-layouts.app title="New Category">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Add New Category</h3>
                <a href="{{ route('inventory.product-categories.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form id="save-category-form" action="{{ route('inventory.product-categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label for="name" class="form-label">Name <sup class="text-danger">*</sup></label>
                        <input type="text" name="name" id="name" required
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                            placeholder="Enter product categories name" title="Group name" autocomplete="name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <a href="{{ route('inventory.product-categories.index') }}" class="btn btn-danger">Cancel</a>
                        <button type="button" class="btn btn-primary ms-3" id="save-category-button">Save</button>
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
