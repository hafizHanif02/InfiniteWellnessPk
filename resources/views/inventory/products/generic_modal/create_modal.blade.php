<div id="genericCreateModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="categoryModalLabel">Add new Generic Formula</h3>
                <button type="button" onclick="clearGenericForm()" class="btn-close"></button>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="generic_code" class="form-label">Code<sup class="text-danger">*</sup></label>
                                <input type="text" name="code" value="{{ ($generics->last()->id ?? 18880) + 1 }}"
                                    id="generic_code" required class="form-control @error('code') is-invalid @enderror" readonly>
                                    <div class="text-danger" id="generic-code-error"></div>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="mb-3">
                                <label for="formula" class="form-label">Formula<sup class="text-danger">*</sup></label>
                                <input type="text" id="formula" name="formula" value="{{ old('formula') }}"
                                    placeholder="Enter Generic Formula" required id="formula"
                                    class="form-control  @error('formula') is-invalid @enderror">
                                    <div class="text-danger" id="generic-formula-error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="generic_detail" class="form-label">Generic Details </label>
                                <textarea type="text" name="generic_detail" id="generic_detail"
                                    class="form-control @error('generic_detail') is-invalid @enderror" placeholder="Enter Generic Details">{{ old('generic_detail') }}</textarea>
                                    <div class="text-danger" id="generic-details-error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" onclick="clearGenericForm()" class="btn btn-danger">Cancel</button>
                        <button type="button" onclick="submitGenericForm()" class="btn btn-primary ms-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
            // Capture the key press event on all input fields within the form
              $('form').on('keypress', 'input', function(e) {
                if (e.which === 13) { // 13 is the key code for "Enter"
                  e.preventDefault(); // Prevent the default form submission
                }
              }); 
        });
    function submitGenericForm() {
        $.ajax({
            type: "post",
            url: "{{ route('inventory.products.generics.store') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'formula': $("#formula").val(),
                'code': $("#generic_code").val(),
                'generic_detail': $("#generic_detail").val(),

            },
            success: function(response) {
                if (response.errors) {
                    $.each(response.errors, function(index, error) {
                        if(index == 'code') {
                            $.each(error, function(index, message) {
                                $("#generic-code-error").text(message);
                            });
                        }
                        if(index == 'formula') {
                            $.each(error, function(index, message) {
                                $("#generic-formula-error").text(message);
                            });
                        }
                        if(index == 'generic_detail') {
                            $.each(error, function(index, message) {
                                $("#generic-details-error").text(message);
                            });
                        }
                    });
                } else {
                    if ($("#no-formula-found").text() == 'No formula found!') {
                        $("#no-formula-found").remove();
                    }
                    $("#generic_id").append(`
                        <option value="${response.data.id}" selected>${response.data.formula}</option>
                    `);
                    $("#code").val(parseInt($("#code").val()) + 1);
                    clearGenericForm();
                }
            }
        });
    }
    function clearGenericForm() {
        $("#generic_detail").val('');
        $("#formula").val('');
        $("#generic-code-error").empty();
        $("#generic-formula-error").empty();
        $("#generic-details-error").empty();
        $('#genericCreateModal').modal('hide');
    }
</script>
