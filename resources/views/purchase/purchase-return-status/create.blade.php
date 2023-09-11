<x-layouts.app title="Purchase Item Return Create">
    @push('styles')
        <link nonce="{{ csp_nonce() }}" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Purchase Item Return</h3>
                <a href="{{ route('purchase.return.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form id="save-purchasereturn-form" action="{{ route('purchase.return.store') }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label for="vendor_id" class="form-label">Vendor<sup class="text-danger">*</sup></label>
                        <select name="vendor_id" id="vendor_id" class="form-control" value="{{ old('vendor_id') }}">
                            <option value="" selected disabled>Select Vendor</option>
                            @forelse ($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->account_title }}</option>
                            @empty
                                <option value="" class="text-danger">no vendor found!</option>
                            @endforelse
                        </select>
                        @error('vendor_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                   <div class="mb-5">
                    <label for="product_id" class="form-label">Products<sup class="text-danger">*</sup></label>
                    <div class="row">
                        <div class="col-md-10">
                            <select name="products[]product_id[]" id="product_id" class="form-control mb-3">
                                <option value="" selected>Select vendor first</option>
                            </select>
                            @error('product_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <span class="text-muted">*Can only one product at single entry</span>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="add-btn"  class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </div>
                    <div class="mb-5">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <td>Product</td>
                                        <td>Packing</td>
                                        <td>Limit</td>
                                        <td>Qty</td>
                                        <td>Pcs Qty</td>
                                        <td>Pur Rate</td>
                                        <td>S Tax</td>
                                        <td>Amount</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody id="add-products">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <a href="{{ route('purchase.return.index') }}" class="btn btn-danger">Cancel</a>
                        <button type="button" id="save-purchasereturn-button" class="btn btn-primary ms-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script nonce="{{ csp_nonce() }}">
            $(document).ready(function() {
                $('#vendor_id, #requistion').select2();
            });
            $(document).ready(function() {
                $('#vendor_id').change(function() {
                    var vendorId = $(this).val();
                    if (vendorId) {
                        $.ajax({
                            url: '/purchase/get/product/' + vendorId,
                            type: 'get',
                            success: function(response) {
                                console.log(response);
                                if (response.products.length > 0) {
                                    $('#product').html(`
                                        <option value="" selected disabled>Select Product</option>
                                    `);
                                    $.map(response.products, function(product) {
                                        $('#product_id').append(`
                                            <option value="${product.id}">
                                                ${product.product_name}
                                            </option>
                                        `);
                                    });
                                    
                                } else {
                                    $('#requistion').append(
                                        '<option value="" class="text-danger">No requisition found!</option>'
                                    );
                                }
                            }
                        });
                    } else {
                        $('#requistion').empty().append(
                            '<option value="" selected disabled>Select Vendor first</option>');
                    }
                });
            });
            $("#add-btn").click(function(e) {
                e.preventDefault();
                addProduct();
            });

            function addProduct(type) {
                var productId = $("#product_id").val();
                if (productId) {
                    $.ajax({
                        type: "get",
                        url: "/purchase/requistions/product/" + productId,
                        success: function(response) {
                            var items = $("tbody tr").length;
                            $("#add-products").append(`
                                <tr id="${response.product.id}">
                                    <input type="hidden" name="products[${items}][id]" value="${response.product.id}">
                                    <td>
                                        <input type="text" class="form-control" value="${response.product.product_name}" readonly>
                                    </td>
                                    
                                    <td>
                                        <input type="text" name="products[${items}][packing]" class="form-control" value="${response.deliver_qty}" readonly>
                                    </td>
                                    <td>
                                        <input type="text"  placeholder="Piece" readonly  min="1" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="text" name="products[${items}][quantity]"  min="1" value="1" id="minusquantity${items}" max="${response.good_receive_note.deliver_qt}" name="quantity[${items}]" onchange="changeQuantity(${response.product.id},${items})" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="number"  value="${response.good_receive_note.deliver_qt}" id="leftedquantity${items}"  class="form-control" readonly>    
                                    </td>
                                    <td>
                                        <input type="number" name="products[${items}][purchase_rate]" id="${items}" value="${parseFloat(response.product.trade_price)/parseInt(response.product.packing)}" class="form-control" readonly>    
                                    </td>
                                    <td>
                                        <input type="number" name="products[${items}][sale_tax]" value="${response.product.sale_tax}" class="form-control" readonly>    
                                    </td>
                                    <td>
                                        <input type="number" id="totalprice${items}" name="products[${items}][price]" value="${parseInt(response.product.cost_price)/parseInt(response.product.pieces_per_pack)}" class="form-control" readonly>    
                                    </td>
                                    <td>
                                        <i onclick="removeRaw(${response.product.id})" class="text-danger fa fa-trash"></i>
                                    </td>
                                    <input type="hidden" id="discountamount${items}" value="${(response.product.disctradeprice * response.product.cost_price)/100 }">
                                    <input type="hidden" id="tradeprice${items}" value="${response.product.tradeprice/response.product.pieces_per_pack}">
                                    <input type="hidden" id="totalquantity${items}" value="${response.product.pieces_per_pack}">
                                    <input type="hidden" id="leftedprice${items}" value="" name="leftedprice${items}">
                                </tr>
                            `); 
                                           
                        }
                    });
                    disableadd();  
                    
                }
            }

            function removeRaw(id) {
                $("#" + id).remove();
                enableadd();
            }

            function changeQuantity(id,items) {
                var minusquantity = $('#minusquantity'+items).val();
                var totalquanitity = $('#totalquantity'+items).val();
                var price = $('#totalprice'+items).val();
                var tradeprice = $('#tradeprice'+items).val();
                $("#leftedquantity"+items).val(parseInt(totalquanitity) - parseInt(minusquantity));
                $('#totalprice'+items).val((price)*(minusquantity));
                var minusprice = $("#totalprice"+items).val()
                $('#leftedprice'+items).val(parseInt(minusprice) - parseInt(price))
            }

            function disableadd(){
                $('#add-btn').attr('disabled','True');
            }

            function enableadd(){
                $('#add-btn').removeAttr('disabled');
            }

            $('#save-purchasereturn-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#save-purchasereturn-form').submit();
            });
        </script>
    @endpush
</x-layouts.app>
