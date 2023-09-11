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
                        <label for="account_mature" class="form-label">Account Mature <sup
                                class="text-danger">*</sup></label>
                        <select name="account_mature" id="account_mature" class="form-control" required>
                            <option value="" disabled selected>Select Account Mature</option>
                            <option value="assets">ASSETS</option>
                            <option value="laibilities">LIABILITIES</option>
                            <option value="captal">CAPITAL</option>
                            <option value="revenue">REVENUE</option>
                            <option value="expenses">EXPENSES</option>
                        </select>
                        <div class="text-danger" id="vemdor-account-mature-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="totalling_group" class="form-label">Totalling Group <sup
                                class="text-danger">*</sup></label>
                        <select name="totalling_group" id="totalling_group" class="form-control"
                            value="{{ old('totalling_group') }}" required>
                            <option value="creditors" selected>CREDITORS</option>
                        </select>
                        <div class="text-danger" id="vendor-totalling-group-error"></div>
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
                        <label for="invoice_to" class="form-label">Invoice To <sup
                                class="text-danger">*</sup></label>
                        <textarea type="text" name="invoice_to" id="invoice_to" class="form-control" value="{{ old('invoice_to') }}"
                            placeholder="Enter invoice to"></textarea>
                        <div class="text-danger" id="vendor-invoice-to-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_phone" class="form-label">Phone <sup class="text-danger">*</sup></label>
                        <input type="number" name="phone" id="supplier_phone" class="form-control"
                            value="{{ old('phone') }}" placeholder="Phone Number" autocomplete="phone">
                        <div class="text-danger" id="vendor-phone-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_fax" class="form-label">Fax <sup class="text-danger">*</sup></label>
                        <input type="number" name="fax" id="supplier_fax" class="form-control"
                            value="{{ old('fax') }}" placeholder="Enter fax number">
                        <div class="text-danger" id="vendor-fax-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_email" class="form-label">Email <sup class="text-danger">*</sup></label>
                        <input type="email" name="email" id="supplier_email" class="form-control"
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
                        <label for="nic" class="form-label">National Identity Card (NIC) <sup
                                class="text-danger">*</sup></label>
                        <input type="number" name="nic" id="nic" class="form-control"
                            value="{{ old('nic') }}" placeholder="Enter Your national identity card number">
                        <div class="text-danger" id="vendor-nic-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="sales_tax_reg" class="form-label">Sales Tax Registration Number (STRN) <sup
                                class="text-danger">*</sup></label>
                        <input type="number" name="sales_tax_reg" id="sales_tax_reg" class="form-control"
                            value="{{ old('sales_tax_reg') }}" placeholder="Enter sales tax registration number">
                        <div class="text-danger" id="vendor-strn-error"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
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
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="old_code" class="form-label">Old Code</label>
                                <input type="number" placeholder="Enter Old Code" name="old_code" id="old_code"
                                    class="form-control" value="{{ old('old_code') }}">
                                <div class="text-danger" id="vendor-old-code-error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_area" class="form-label">Area <sup class="text-danger">*</sup></label>
                        <input type="text" placeholder="Enter Area" name="area" id="supplier_area"
                            class="form-control" value="{{ old('area') }}">
                        <div class="text-danger" id="vendor-area-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_city" class="form-label">City <sup class="text-danger">*</sup></label>
                        <input type="text" placeholder="Enter city" name="city" id="supplier_city"
                            class="form-control" value="{{ old('city') }}">
                        <div class="text-danger" id="vendor-city-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="default_project" class="form-label">Default Project <sup
                                class="text-danger">*</sup></label>
                        <input type="text" placeholder="Enter default project" name="default_project"
                            id="default_project" class="form-control" value="{{ old('default_project') }}">
                        <div class="text-danger" id="vendor-default-project-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="account_category" class="form-label">Account Category <sup
                                class="text-danger">*</sup></label>
                        <input type="text" placeholder="Enter account category" name="account_category"
                            id="account_category" class="form-control" value="{{ old('account_category') }}">
                        <div class="text-danger" id="vendor-account-category-error"></div>
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
                    'account_mature': $('#account_mature').val(),
                    'totalling_group': $('#totalling_group').val(),
                    'code': $('#vendor_code').val(),
                    'account_title': $('#account_title').val(),
                    'invoice_to': $('#invoice_to').val(),
                    'contact_person': $('#supplier_contact_person').val(),
                    'phone': $('#supplier_phone').val(),
                    'fax': $('#supplier_fax').val(),
                    'email': $('#supplier_email').val(),
                    'address': $('#supplier_address').val(),
                    'ntn': $('#ntn').val(),
                    'nic': $('#nic').val(),
                    'sales_tax_reg': $('#sales_tax_reg').val(),
                    'active': $('#supplier_active').val(),
                    'old_code': $('#old_code').val(),
                    'area': $('#supplier_area').val(),
                    'city': $('#supplier_city').val(),
                    'default_project': $('#default_project').val(),
                    'account_category': $('#account_category').val(),
                },
                success: function(response) {
                    if (response.errors) {
                        $.each(response.errors, function(index, error) {
                            if (index == 'code') {
                                $.each(error, function(index, message) {
                                    $("#vendor-code-error").text(message);
                                });
                            }
                            if (index == 'account_mature') {
                                $.each(error, function(index, message) {
                                    $("#vendor-account-mature-error").text(message);
                                });
                            }
                            if (index == 'totalling_group') {
                                $.each(error, function(index, message) {
                                    $("#vendor-totalling-group-error").text(message);
                                });
                            }
                            if (index == 'account_title') {
                                $.each(error, function(index, message) {
                                    $("#vendor-account-title-error").text(message);
                                });
                            }
                            if (index == 'invoice_to') {
                                $.each(error, function(index, message) {
                                    $("#vendor-invoice-to-error").text(message);
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
                            if (index == 'fax') {
                                $.each(error, function(index, message) {
                                    $("#vendor-fax-error").text(message);
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
                            if (index == 'nic') {
                                $.each(error, function(index, message) {
                                    $("#vendor-nic-error").text(message);
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
                            if (index == 'old_code') {
                                $.each(error, function(index, message) {
                                    $("#vendor-old-code-error").text(message);
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
                            if (index == 'default_project') {
                                $.each(error, function(index, message) {
                                    $("#vendor-default-project-error").text(message);
                                });
                            }
                            if (index == 'account_category') {
                                $.each(error, function(index, message) {
                                    $("#vendor-account-category-error").text(message);
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
            $('#account_mature').val('');
            $('#totalling_group').val('');
            $('#account_title').val('');
            $('#invoice_to').val('');
            $('#supplier_contact_person').val('');
            $('#supplier_phone').val('');
            $('#supplier_fax').val('');
            $('#supplier_email').val('');
            $('#supplier_address').val('');
            $('#ntn').val('');
            $('#nic').val('');
            $('#sales_tax_reg').val('');
            $('#supplier_active').val('');
            $('#old_code').val('');
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
            $('#vendor-old-code-error').empty();
            $('#vendor-area-error').empty();
            $('#vendor-city-error').empty();
            $('#vendor-default-project-error').empty();
            $('#vendor-account-category-error').empty();
            $('#vendorCreateModal').modal('hide');
        }
    </script>
@endpush
