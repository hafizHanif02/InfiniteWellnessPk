<div id="categoryCreateModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="categoryModalLabel">Add new Dosage Form</h3>
                <button type="button" onclick="clearCategoryForm()" class="btn-close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="dosage_name" class="form-label">Name <sup class="text-danger">*</sup></label>
                                <input type="text" name="dosage_name" required id="dosage_name" class="form-control"
                                    placeholder="Enter Dosage Form" autocomplete="name">
                                <div class="text-danger" id="category-name-error"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="code" class="form-label">Code <sup class="text-danger">*</sup></label>
                                <input type="number" name="code" required id="code" class="form-control"
                                    value="{{ ($dosage_id ? $dosage_id : 1210) + 1 }}" readonly>
                                <div class="text-danger" id="category-code-error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" onclick="clearCategoryForm()" class="btn btn-danger">Cancel</button>
                        <button type="button" onclick="submitCategoryForm()" class="btn btn-primary ms-3">Save</button>
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
        function submitCategoryForm() {
            $.ajax({
                type: "post",
                url: "{{ route('inventory.products.dosages.store') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'name': $("#dosage_name").val(),
                    'code': $("#code").val(),
                },
                success: function(response) {
                    if (response.errors) {
                        $.each(response.errors, function(index, error) {
                            if(index == 'code') {
                            $.each(error, function(index, message) {
                                $("#dosage-code-error").text(message);
                            });
                        }
                        if(index == 'name') {
                            $.each(error, function(index, message) {
                                $("#dosage-name-error").text(message);
                            });
                        }
                        });
                    } else {
                        if ($("#no-dosage-found").text() == 'No Dosage found!') {
                            $("#no-dosage-found").remove();
                        }
                        $("#dosage_id").append(`
                        <option value="${response.data.id}" selected>${response.data.name}</option>
                    `);
                        $("#code").val(parseInt($("#code").val()) + 1);
                        clearCategoryForm();
                    }
                }
            });
        }

        function clearCategoryForm() {
            $("#dosage_name").val('');
            $("#dosage-name-error").empty();
            $('#categoryCreateModal').modal('hide');
        }
    </script>
@endpush
