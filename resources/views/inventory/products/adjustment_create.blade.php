<x-layouts.app title="Adjustment Products">
    @push('styles')
        <link nonce="{{ csp_nonce() }}" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
            rel="stylesheet" />
    @endpush
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Adjustment Products</h3>
                <a href="{{ route('inventory.products.adjustment') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('inventory.adjustments.store') }}" method="POST" id="save-adjustment-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <label for="adjustment_id" class="form-label">Adjustment # <sup
                                    class="text-danger">*</sup></label>
                            <input type="text" name="id"
                                value="{{ ($adjustment_id ? $adjustment_id : 85000) + 1 }}" id="adjustment_id"
                                class="form-control" readonly title="Product order number">
                            @error('remarks')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-12 mt-5">
                            <label for="product_id" class="form-label">(Generic Formula) Product <sup
                                    class="text-danger">*</sup></label>
                            <select name="product_id[]" id="product_id" class="form-control p-5" multiple>
                                <option value="" selected disabled>Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">({{ $product->generic->formula }})
                                        {{ $product->product_name }}</option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="add-btn" class="btn btn-primary">Add</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr class="text-white">
                                    <td style="min-width: 200px">Product</td>
                                    <td style="min-width: 120px">Current Qty</td>
                                    <td style="min-width: 200px">Adjustment Qty</td>
                                    <td style="min-width: 150px">Difference Qty</td>
                                    <td style="min-width: 50px">Action</td>
                                </tr>
                            </thead>
                            <tbody id="add-products">
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('inventory.products.adjustment') }}" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary ms-3">Save</button>
            </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js">
        </script>
        <script nonce="{{ csp_nonce() }}">
            $(document).ready(function() {
                $('#manufacturer_id, #product_id').select2();
                $('form').on('keypress', 'input', function(e) {
                    if (e.which === 13) {
                        e.preventDefault();
                    }
                });
            });
            $("#add-btn").click(function(e) {
                e.preventDefault();
                addProduct();
                $("#product_id").empty();
            });

            function addProduct(type, callback) {
                var productId = $("#product_id").val();
                if (productId && $('tbody tr#' + productId).length == 0) {
                    $.ajax({
                        type: "post",
                        url: "/purchase/requistions/product/",
                        data: {
                            _token: "{{ csrf_token() }}",
                            product_id: productId
                        },
                        success: function(response) {
                            $("#product_id option[value='" + productId + "']").remove();
                            var items = $("tbody tr").length;
                            $.each(response.product, function(index, value) {
                                $("#add-products").append(`
                                    <tr id="${value.id}">
                                        <input type="hidden" name="products[${index}][product_id]" value="${value.id}">
                                        <td>
                                            <input type="text" id="product_name" name="products[${index}][product_name]" class="form-control" value="${value.product_name}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" id="current_qty${index}" name="products[${index}][current_qty]" class="form-control" value="${value.total_quantity}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" id="adjustment_qty${index}" name="products[${index}][adjustment_qty]" class="form-control" onkeyup="calculate(${index})" value="">
                                        </td>
                                        <td>
                                            <input type="text" id="different_qty${index}" name="products[${index}][different_qty]" class="form-control" value="" readonly>
                                        </td>
                                        <td>
                                            <i onclick="removeRaw(${value.id})" class="text-danger fa fa-trash"></i>
                                        </td>
                                    </tr>
                                    
                                `);
                            });
                        }
                    });
                }
            }

            function removeRaw(id) {
                $("#" + id).remove();
            }

            function calculate(index) {
                var current_qty = $("#current_qty" + index).val();
                var adjustment_qty = $("#adjustment_qty" + index).val();
                var different_qty = current_qty - adjustment_qty;
                $("#different_qty" + index).val(different_qty);
                console.log(current_qty,adjustment_qty,different_qty);
            }

            // $(document).ready(function() {
            //     $('#save-adjustment-form').on('submit', function(e) {
            //         e.preventDefault(); // Prevent the default form submission

            //         // Perform your AJAX request here
            //         $.ajax({
            //             url: '/inventory/adjustment/store',
            //             type: 'post',
            //             data: $(this).serialize(),
            //             dataType: 'json',
            //             success: function(response) {
            //                 console.log('Response:', response);
            //                 if (response.valid) {
            //                     console.log('Before form submission');
            //                     $('#save-adjustment-form')[0].submit();
            //                     console.log('After form submission');
            //                 } else {
            //                     $('#validation-message').text(response.message);
            //                     $('#validation-message').show();
            //                 }

            //             },
            //             error: function(xhr, status, error) {
            //                 // $('#validation-message').html(xhr.responseJSON.message);

            //                 $('.wrapper').append(
            //                     ` <div class="alert alert-danger">
            //             <div>
            //                 <div class="d-flex">
            //                     <i class="fas fa-frown me-2 my-custom-icon" style="font-size: 40px;padding-right:2px;color:orange;"></i>
            //                     <span class="mt-1 validationError">${xhr.responseJSON.message}</span>
            //                 </div>
            //             </div>
            //         </div>
            //         <style>
            //             .alert{
            //                 position: absolute;
            //                 background: white;
            //                 width: 290px;
            //                 padding: 40px;
            //                 box-shadow: 5px 5px 5px rgba(128, 128, 128, 0.5); 
            //                 top: 10px;
            //                 right: 10px;
            //             }
            //             .icon-sm {
            //                 font-size: 106px !important;
            //             }
            //             .validationError{
            //                 font-weight:900;
            //                 color:#2f2f2f;
            //                 letter-spacing:2px;
            //             }
            //         </style>
            //         `
            //                 );
            //                 $('.alert').delay(5000).slideUp(300)
            //                 $('.alert').delay(50000).slideUp(300, function() {
            //                     $('.alert').attr('style', 'display:none')
            //                 })
            //             }
            //         });
            //     });
            // });
        </script>
    @endpush
</x-layouts.app>
