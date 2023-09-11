<x-layouts.app title="Edit Manufacturer">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Edit manufacturer</h3>
                    <a href="{{ route('inventory.manufacturers.index') }}"
                        class="btn btn-secondary float-end mr-5 mb-3">Back</a>
                </div>
                <form id="save-manufacturere-form" action="{{ route('inventory.manufacturers.update', $manufacturer->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Company Name <sup
                                        class="text-danger">*</sup></label>
                                <input type="text" name="company_name"
                                    value="{{ old('company_name', $manufacturer->company_name) }}" id="company_name"
                                    class="form-control @error('company_name') is-invalid @enderror"
                                    placeholder="Enter Company name" title="Company name">
                                @error('company_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="code" class="form-label">Code <sup class="text-danger">*</sup></label>
                                <input type="number" name="code" id="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ $manufacturer->id }}" readonly title="Manufacturer code">
                                @error('code')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('inventory.manufacturers.index') }}" class="btn btn-danger">Cancel</a>
                        <button type="button" id="save-manufacturere-button" class="btn btn-primary ms-3">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#save-manufacturere-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#save-manufacturere-form').submit();
            });
        </script>
    @endpush
</x-layouts.app>
