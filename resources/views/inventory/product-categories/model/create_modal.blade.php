<div id="ProductCategoriesCreateModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="groupModalLabel">Add new Product Category</h3>
                <button type="button" onclick="clearGroupForm()" class="btn-close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-5">
                        <label for="product_category_name" class="form-label">Name <sup class="text-danger">*</sup></label>
                        <input type="text" name="name" id="product_category_name" required value="{{ old('product_category_name') }}"
                            class="form-control" placeholder="Enter category name" autocomplete="product_category_name">
                        <div class="text-danger" id="group-name-error"></div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <button type="button" onclick="clearGroupForm()" class="btn btn-danger">Cancel</button>
                        <button type="button" onclick="submitGroupForm()" class="btn btn-primary ms-3">Save</button>
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
        function submitGroupForm() {
            $.ajax({
                type: "post",
                url: "{{ route('inventory.products.product-categories.store') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'name': $("#product_category_name").val()
                },
                success: function(response) {
                    if (response.errors) {
                        $.each(response.errors, function(index, error) {
                            $.each(error, function(index, message) {
                                $("#group-name-error").text(message);
                            });
                        });
                    } else {
                        if ($("#no-product-category-found").text() == 'No Product Category found!') {
                            $("#no-product-category-found").remove();
                        }
                        $("#product_category_id").append(`
                            <option value="${response.data.id}" selected>${response.data.name}</option>
                        `);
                        clearGroupForm();
                    }
                }
            });
        }
        function clearGroupForm() {
            $("#product_category_name").val('');
            $("#group-name-error").empty();
            $('#ProductCategoriesCreateModal').modal('hide');
        }
    </script>
@endpush
