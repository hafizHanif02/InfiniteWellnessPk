<div id="vendorCreateModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="vendorModalLabel">Add New Vendor</h3>
                <button type="button" onclick="clearVendorForm()" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    <div class="mb-3">
                        <label for="vendor_manufacturer_id" class="form-label">Manufacturer <sup
                                class="text-danger">*</sup></label>
                        <select name="manufacturer_id" id="vendor_manufacturer_id"
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
                                <label for="vendor_code" class="form-label">
                                    Code
                                    <sup class="text-danger" id="autocheck-true">*</sup>
                                    <input type="radio" name="autocheck" value="1" class="ms-5 form-check-input"
                                        checked>
                                </label>
                                <input type="number" name="code" id="vendor_code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ ($vendors->last()->code ?? 7780) + 1 }}" readonly title="Vendor code">
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
                        <input type="hidden" id="code_value" value="{{ ($vendors->last()->code ?? 7780) + 1 }}">
                    </div>
                    <div class="mb-3">
                        <label for="account_title" class="form-label">Account Title <sup
                                class="text-danger">*</sup></label>
                        <input type="text" name="account_title" id="account_title" class="form-control"
                            value="{{ old('account_title') }}" placeholder="Enter account title">
                        <div class="text-danger" id="vendor-account-title-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_contact_person" class="form-label">Contact Person <sup
                                class="text-danger">*</sup></label>
                        <input type="text" name="contact_person" id="supplier_contact_person" class="form-control"
                            value="{{ old('contact_person') }}" placeholder="Enter contact person name">
                        <div class="text-danger" id="vendor-contact-person-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_phone" class="form-label">Phone <sup class="text-danger">*</sup></label>
                        <input type="number" name="phone" id="supplier_phone" required class="form-control"
                            value="{{ old('phone') }}" placeholder="Phone Number" autocomplete="phone">
                        <div class="text-danger" id="vendor-phone-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_email" class="form-label">Email <sup class="text-danger">*</sup></label>
                        <input type="email" name="email" id="supplier_email" required class="form-control"
                            value="{{ old('email') }}" placeholder="Enter email address" autocomplete="email">
                        <div class="text-danger" id="vendor-email-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_address" class="form-label">Address <sup
                                class="text-danger">*</sup></label>
                        <textarea name="address" id="supplier_address" class="form-control" value="{{ old('address') }}"
                            placeholder="Enter your address" autocomplete="address"></textarea>
                        <div class="text-danger" id="vendor-address-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="ntn" class="form-label">National Tax Number (NTN) <sup
                                class="text-danger">*</sup></label>
                        <input type="number" name="ntn" id="ntn" class="form-control"
                            value="{{ old('ntn') }}" placeholder="Enter national tax number">
                        <div class="text-danger" id="vendor-ntn-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="sales_tax_reg" class="form-label">Sales Tax Registration Number (STRN) <sup
                                class="text-danger">*</sup></label>
                        <input type="number" name="sales_tax_reg" id="sales_tax_reg" class="form-control"
                            value="{{ old('sales_tax_reg') }}" placeholder="Enter sales tax registration number">
                        <div class="text-danger" id="vendor-strn-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_active" class="form-label">Active<sup
                                class="text-danger">*</sup></label>
                        <select type="active" name="active" id="supplier_active" class="form-control"
                            value="{{ old('active') }}" placeholder="Enter your status">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <div class="text-danger" id="vendor-active-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_area" class="form-label">Area <sup class="text-danger">*</sup></label>
                        <input type="text" placeholder="Enter Area" name="area" id="supplier_area"
                            class="form-control" required value="{{ old('area') }}">
                        <div class="text-danger" id="vendor-area-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_city" class="form-label">City <sup class="text-danger">*</sup></label>
                        <input type="text" placeholder="Enter city" required name="city" id="supplier_city"
                            class="form-control" value="{{ old('city') }}">
                        <div class="text-danger" id="vendor-city-error"></div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <button type="button" onclick="clearVendorForm()" class="btn btn-danger">Cancel</button>
                        <button onclick="submitVendorForm()" type="button"
                            class="btn btn-primary ms-3">Save</button>
                    </div>
                </form>
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
        });

        function submitVendorForm() {
            $.ajax({
                type: "post",
                url: "{{ route('inventory.products.vendors.store') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'code': $('#vendor_code').val(),
                    'manufacturer_id': $('#vendor_manufacturer_id').val(),
                    'account_title': $('#account_title').val(),
                    'contact_person': $('#supplier_contact_person').val(),
                    'phone': $('#supplier_phone').val(),
                    'email': $('#supplier_email').val(),
                    'address': $('#supplier_address').val(),
                    'ntn': $('#ntn').val(),
                    'sales_tax_reg': $('#sales_tax_reg').val(),
                    'active': $('#supplier_active').val(),
                    'area': $('#supplier_area').val(),
                    'city': $('#supplier_city').val(),
                },
                success: function(response) {
                    if (response.errors) {
                        $.each(response.errors, function(index, error) {
                            if (index == 'code') {
                                $.each(error, function(index, message) {
                                    $("#vendor-code-error").text(message);
                                });
                            }
                            if (index == 'account_title') {
                                $.each(error, function(index, message) {
                                    $("#vendor-account-title-error").text(message);
                                });
                            }
                            if (index == 'contact_person') {
                                $.each(error, function(index, message) {
                                    $("#vendor-contact-person-error").text(message);
                                });
                            }
                            if (index == 'phone') {
                                $.each(error, function(index, message) {
                                    $("#vendor-phone-error").text(message);
                                });
                            }
                            if (index == 'email') {
                                $.each(error, function(index, message) {
                                    $("#vendor-email-error").text(message);
                                });
                            }
                            if (index == 'address') {
                                $.each(error, function(index, message) {
                                    $("#vendor-address-error").text(message);
                                });
                            }
                            if (index == 'ntn') {
                                $.each(error, function(index, message) {
                                    $("#vendor-ntn-error").text(message);
                                });
                            }
                            if (index == 'sales_tax_reg') {
                                $.each(error, function(index, message) {
                                    $("#vendor-strn-error").text(message);
                                });
                            }
                            if (index == 'active') {
                                $.each(error, function(index, message) {
                                    $("#vendor-active-error").text(message);
                                });
                            }
                            if (index == 'area') {
                                $.each(error, function(index, message) {
                                    $("#vendor-area-error").text(message);
                                });
                            }
                            if (index == 'city') {
                                $.each(error, function(index, message) {
                                    $("#vendor-city-error").text(message);
                                });
                            }

                        });
                    } else {
                        $("#vendor_id").append(`
                        <option value="${response.data.id}" selected>${response.data.contact_person}</option>
                    `);
                        $('#vendor_code').val(parseInt($("#vendor_code").val()) + 1);
                        clearVendorForm();
                    }
                }
            });
        }

        function clearVendorForm() {
            $('#account_title').val('');
            $('#supplier_contact_person').val('');
            $('#supplier_phone').val('');
            $('#supplier_fax').val('');
            $('#supplier_email').val('');
            $('#supplier_address').val('');
            $('#ntn').val('');
            $('#sales_tax_reg').val('');
            $('#supplier_active').val('');
            $('#supplier_area').val('');
            $('#supplier_city').val('');
            $('#default_project').val('');
            $('#account_category').val('');
            $('#vendor-account-mature-error').empty();
            $('#vendor-totalling-group-error').empty();
            $('#vendor-account-title-error').empty();
            $('#vendor-invoice-to-error').empty();
            $('#vendor-contact-person-error').empty();
            $('#vendor-phone-error').empty();
            $('#vendor-fax-error').empty();
            $('#vendor-email-error').empty();
            $('#vendor-address-error').empty();
            $('#vendor-ntn-error').empty();
            $('#vendor-nic-error').empty();
            $('#vendor-sales-tax-reg-error').empty();
            $('#vendor-active-error').empty();
            $('#vendor-area-error').empty();
            $('#vendor-city-error').empty();
            $('#vendorCreateModal').modal('hide');
        }
    </script>
@endpush
