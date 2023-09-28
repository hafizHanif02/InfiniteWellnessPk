<x-layouts.app title="Add Vendor">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Add New Vendor</h3>
                <a href="{{ route('inventory.vendors.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form id="save-vendor-form" action="{{ route('inventory.vendors.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="manufacturer_id" class="form-label">Manufacturer <sup
                                class="text-danger">*</sup></label>
                        <select name="manufacturer_id" id="manufacturer_id"
                            class="form-control @error('manufacturer_id') is-invalid @enderror" title="Manufacturer">
                            <option value="" disabled selected>Select Manufacturer</option>
                            @forelse ($manufacturers as $manufacturer)
                                <option value="{{ $manufacturer->id }}"
                                    {{ old('manufacturer_id') == $manufacturer->id ? 'selected' : '' }}>
                                    {{ $manufacturer->company_name }}</option>
                            @empty
                                <option value="" class="text-danger" disabled>No manfacturer found!</option>
                            @endforelse
                        </select>
                        @error('manufacturer_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code" class="form-label">
                                    Code
                                    <sup class="text-danger" id="autocheck-true">*</sup>
                                    <input type="radio" name="autocheck" value="1" class="ms-5 form-check-input"
                                        checked>
                                </label>
                                <input type="number" name="code" id="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ ($code ? $code : 7780) + 1 }}" readonly title="Vendor code">
                                @error('code')
                                    <small class="text-danger">{{ $code }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code2" class="form-label">
                                    Custom Code
                                    <sup class="text-danger" id="autocheck-false">*</sup>
                                    <input type="radio" name="autocheck" value="0" class="ms-5 form-check-input">
                                </label>
                                <input type="number" id="code2"
                                    class="form-control @error('code2') is-invalid @enderror" title="Custom vendor code"
                                    disabled>
                                @error('code')
                                    <small class="text-danger">{{ $code }}</small>
                                @enderror
                            </div>
                        </div>
                        <input type="hidden" id="code_value" value="{{ ($code ? $code : 7780) + 1 }}">
                    </div>
                    <div class="mb-3">
                        <label for="account_title" class="form-label">Account Title <sup
                                class="text-danger">*</sup></label>
                        <input type="text" name="account_title" id="account_title"
                            class="form-control @error('account_title') is-invalid @enderror"
                            value="{{ old('account_title') }}" placeholder="Enter account title" title="Account title">
                        @error('account_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="contact_person" class="form-label">Contact Person Name <sup
                                class="text-danger">*</sup></label>
                        <input type="text" name="contact_person" id="contact_person"
                            class="form-control @error('contact_person') is-invalid @enderror"
                            value="{{ old('contact_person') }}" placeholder="Enter contact person name"
                            title="Contact person name">
                        @error('contact_person')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                   
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone <sup class="text-danger">*</sup></label>
                        <input type="number" name="phone" id="phone" required
                            class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                            placeholder="Enter phone number" title="Phone number" autocomplete="phone">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <sup class="text-danger">*</sup></label>
                        <input type="email" name="email" id="email" required
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            placeholder="Enter email address" title="Email address" autocomplete="email">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address <sup class="text-danger">*</sup></label>
                        <textarea name="address" id="address" required class="form-control @error('address') is-invalid @enderror"
                            placeholder="Enter Your Address" title="Address" autocomplete="address">{{ old('address') }}</textarea>
                        @error('address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="ntn" class="form-label">National Tax Number (NTN) <sup
                                class="text-danger">*</sup></label>
                        <input type="number" name="ntn" id="ntn"
                            class="form-control @error('ntn') is-invalid @enderror" value="{{ old('ntn') }}"
                            placeholder="Enter your national tax number" title="National Tax Number">
                        @error('ntn')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
               
                    <div class="mb-3">
                        <label for="sales_tax_reg" class="form-label">Sales Tax Registration Number (STRN) <sup
                                class="text-danger">*</sup></label>
                        <input type="number" name="sales_tax_reg" id="sales_tax_reg"
                            class="form-control @error('sales_tax_reg') is-invalid @enderror"
                            value="{{ old('sales_tax_reg') }}" placeholder="Enter your sales tax registration number"
                            title="Sales Tax Registration Number">
                        @error('sales_tax_reg')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="active" class="form-label">Active<sup
                                        class="text-danger">*</sup></label>
                                <select name="active" id="active"
                                    class="form-control @error('active') is-invalid @enderror" title="Status">
                                    <option value="" selected disabled>Select status</option>
                                    <option value="1" {{ old('active') == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>No</option>
                                </select>
                                @error('active')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="area" class="form-label">Area <sup class="text-danger">*</sup></label>
                        <input type="text" placeholder="Enter your area" name="area" id="area" required
                            class="form-control @error('area') is-invalid @enderror" value="{{ old('area') }}"
                            title="Area">
                        @error('area')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City <sup class="text-danger">*</sup></label>
                        <input type="text" placeholder="Enter city" name="city" id="city" required
                            class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}"
                            title="City">
                        @error('city')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <a href="{{ route('inventory.vendors.index') }}" class="btn btn-danger">Cancel</a>
                        <button type="button" id="save-vendor-button" class="btn btn-primary ms-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
<script>
    $(document).ready(function() {
        
            // Capture the key press event on all input fields within the form
              $('form').on('keypress', 'input', function(e) {
                if (e.which === 13) { // 13 is the key code for "Enter"
                  e.preventDefault(); // Prevent the default form submission
                }
              }); 


        $("#autocheck-false").hide();
        $('input[name="autocheck"]').on('change keypress', function() {
            if ($(this).val() == 1) {
                $("#code").val($("#code_value").val());
                $("#code").attr('name', 'code');
                $("#code2").attr('disabled', 'true');
                $("#code2").removeAttr('placeholder');
                $("#autocheck-true").toggle();
                $("#autocheck-false").toggle();
            } else {
                $("#code").val('');
                $("#code").removeAttr('name', 'code');
                $("#code2").attr('name', 'code');
                $("#code2").removeAttr('disabled');
                $("#code2").attr('placeholder', 'Enter custom code');
                $("#autocheck-false").toggle();
                $("#autocheck-true").toggle();
            }
        });
        $('#save-vendor-button').on('click', function() {
            $(this).prop('disabled', true);
            $('#save-vendor-form').submit();
        });
    });
</script>
