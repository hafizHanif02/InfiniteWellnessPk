<div id="manufacturerCreateModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="manufacturerModalLabel">Add new Manufacturer</h3>
                <button type="button" onclick="clearManufacturerForm()" class="btn-close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Company Name <sup
                                        class="text-danger">*</sup></label>
                                <input type="text" name="company_name" id="company_name" class="form-control"
                                    placeholder="Enter Company name">
                                <div class="text-danger" id="manufacturer-company-error"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="manu_code" class="form-label">Code <sup class="text-danger">*</sup></label>
                                <input type="number" name="code" id="manu_code" class="form-control" required
                                    value="{{ ($manufacturer_id ? $manufacturer_id : 1960) + 1 }}" readonly>
                                <div class="text-danger" id="manufacturer-code-error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" onclick="clearManufacturerForm()"
                            class="btn btn-danger">Cancel</button>
                        <button type="button" onclick="submitManufacturerForm()"
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
        });
        function submitManufacturerForm() {
            $.ajax({
                type: "post",
                url: "{{ route('inventory.products.manufacturers.store') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'company_name': $("#company_name").val(),
                    'code': $("#manu_code").val(),
                    'contact_person': $("#contact_person").val(),
                    'phone': $("#manufacturer_phone").val(),
                    'fax': $("#fax").val(),
                    'email': $("#email").val(),
                    'website': $("#website").val(),
                    'address': $("#address").val(),
                },
                success: function(response) {
                    if (response.errors) {
                        $.each(response.errors, function(index, error) {
                            if (index == 'code') {
                                $.each(error, function(index, message) {
                                    $("#manufacturer-code-error").text(message);
                                });
                            }
                            if (index == 'company_name') {
                                $.each(error, function(index, message) {
                                    $("#manufacturer-company-error").text(message);
                                });
                            }
                            if (index == 'contact_person') {
                                $.each(error, function(index, message) {
                                    $("#manufacturer-contact-person-error").text(message);
                                });
                            }
                            if (index == 'phone') {
                                $.each(error, function(index, message) {
                                    $("#manufacturer-phone-error").text(message);
                                });
                            }
                            if (index == 'fax') {
                                $.each(error, function(index, message) {
                                    $("#manufacturer-fax-error").text(message);
                                });
                            }
                            if (index == 'email') {
                                $.each(error, function(index, message) {
                                    $("#manufacturer-email-error").text(message);
                                });
                            }
                            if (index == 'website') {
                                $.each(error, function(index, message) {
                                    $("#manufacturer-website-error").text(message);
                                });
                            }
                            if (index == 'address') {
                                $.each(error, function(index, message) {
                                    $("#manufacturer-address-error").text(message);
                                });
                            }
                        });
                    } else {
                        if ($("#no-manufacturer-found").text() == 'No manufacturer found!') {
                            $("#no-manufacturer-found").remove();
                        }
                        $("#manufacturer_id").append(`
                        <option value="${response.data.id}" selected>${response.data.company_name}</option>
                    `);
                        $("#manu_code").val(parseInt($("#manu_code").val()) + 1);
                        clearManufacturerForm();
                    }
                }
            });
        }

        function clearManufacturerForm() {
            $("#company_name").val('');
            $("#contact_person").val('');
            $("#manufacturer_phone").val('');
            $("#fax").val('');
            $("#email").val('');
            $("#website").val('');
            $("#address").val('');
            $("#manufacturer-company-error").empty();
            $("#manufacturer-contact-person-error").empty();
            $("#manufacturer-phone-error").empty();
            $("#manufacturer-fax-error").empty();
            $("#manufacturer-email-error").empty();
            $("#manufacturer-website-error").empty();
            $("#manufacturer-address-error").empty();
            $('#manufacturerCreateModal').modal('hide');
        }
    </script>
@endpush
