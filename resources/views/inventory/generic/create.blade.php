<x-layouts.app title="Add Generic Formula">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Add New Generic Formula</h3>
                <a href="{{ route('inventory.generics.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form id="save-generic-form" action="{{ route('inventory.generics.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="code" class="form-label">Code<sup class="text-danger">*</sup></label>
                                <input type="text" name="code" value="{{ ($code ? $code : 18880) + 1 }}"
                                    id="code" required class="form-control @error('code') is-invalid @enderror" readonly
                                    title="Generic code">
                                @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label for="formula" class="form-label">Generic Formula<sup class="text-danger">*</sup></label>
                                <input type="text" name="formula" value="{{ old('formula') }}"
                                    placeholder="Enter generic formula" id="formula" required
                                    class="form-control  @error('formula') is-invalid @enderror"
                                    title="Generic formula">
                                @error('formula')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="generic_detail" class="form-label">Generic Details</label>
                        <textarea type="text" name="generic_detail" id="generic_detail"
                            class="form-control @error('generic_detail') is-invalid @enderror" placeholder="Enter generic details"
                            title="Generic details">{{ old('generic_detail') }}</textarea>
                        @error('generic_detail')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('inventory.generics.index') }}" class="btn btn-danger">Cancel</a>
                        <button type="button" id="save-generic-button" class="btn btn-primary ms-3">Save</button>
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
            $('#save-generic-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#save-generic-form').submit();
            });
        </script>
    @endpush
</x-layouts.app>
