<x-layouts.app title="Edit Shift Transfer">
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Edit Shift Transfer Inventory</h3>
                <a href="{{ route('purchase.return.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form id="save-transfer-form" action="{{ route('shift.transfers.update', $transfer->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label for="code" class="form-label">Code <sup class="text-danger">*</sup></label>
                            <input type="number" name="code" id="code"
                                class="form-control @error('code') is-invalid @enderror"
                                value="{{ ($code ? $code : 1010) + 1 }}" title="Unique Code" readonly>
                            @error('code')
                                <small class="text-danger">{{ $code }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="supply_date" class="form-label">Supply Date<sup
                                    class="text-danger">*</sup></label>
                            <input type="date" name="supply_date" id="supply_date" class="form-control"
                                value="{{ old('supply_date', date('Y-m-d')) }}" placeholder="Enter Supply Date"
                                title="Supply date">
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-10">
                            <label for="product_id" class="form-label">Products<sup class="text-danger">*</sup></label>
                            <select name="product_id" id="product_id" class="form-control"
                                value="{{ old('product_id') }}">
                                <option value="" selected disabled>Select Product</option>
                                @forelse ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @empty
                                    <option value="" class="text-danger">no product found!</option>
                                @endforelse
                            </select>
                            @error('product_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <div class="mt-2"></div>
                            <button type="button" id="add-btn" class="btn btn-primary mt-5">Add</button>
                        </div>
                    </div>
                    <div class="mb-5">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr class="text-white">
                                        <td>Product</td>
                                        <td>Total Stock (Pcs)</td>
                                        <td>Limit</td>
                                        <td>Supply Qty</td>
                                        <td>Rmaining Qty</td>
                                        <td>No. Of Pack</td>
                                        <td>Peice Per Pack</td>
                                        <td>Price Per Unit</td>
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
                        <a href="{{ route('shift.transfers.index') }}" class="btn btn-danger">Cancel</a>
                        <button type="button" id="save-transfer-button" class="btn btn-primary ms-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#product_id, #requistion').select2();
            });
            $("#add-btn").click(function(e) {
                e.preventDefault();
                addProduct();
            });

            function addProduct(type) {
                var productId = $("#product_id").val();
                if (productId != null && ($('#add-products tr#' + productId).length == 0)) {
                    $.ajax({
                        type: "get",
                        url: "/shift/transfer-products/" + productId,
                        success: function(response) {
                            var items = $("tbody tr").length;
                            $("#add-products").append(`
                                    <tr id="${response.product.id}">
                                        <input type="hidden" name="products[${items}][product_id]" value="${response.product.id}">
                                        <td>
                                            <input type="text" class="form-control" value="${response.product.product_name}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" id="packing${items}" name="products[${items}][packing]" class="form-control" value="${response.product.packing}" readonly>
                                        </td>
                                        <td>
                                            <select id="selectLimit${items}" onchange="changeType(${response.product.id},${items})" name="products[${items}][least_unit]" class="form-control" required>
                                                <option value="" selected disable>Select Least Quantity</option>
                                                <option value="1">Piece</option>
                                                <option value="0">Pack</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="products[${items}][total_supply_quantity]"  min="1" value="1" id="minusquantity${items}"  max="${response.product.packing}" name="quantity[${items}]" onkeyup="changeQuantity(${response.product.id},${items})"  class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="number"  value="${response.product.packing - 1}" name="products[${items}][leftedquantity]" id="leftedquantity${items}"  class="form-control" readonly>    
                                        </td>
                                        <td>
                                            <input type="number" name="products[${items}][number_of_pack]" id="number_of_pack${items}" value="${(response.product.number_of_pack)}" class="form-control" readonly>    
                                        </td>
                                        <td>
                                            <input type="number" name="products[${items}][pieces_per_pack]" id="pieces_per_pack${items}" value="${response.product.pieces_per_pack}" class="form-control" readonly>    
                                        </td>
                                        <td>
                                            <input type="number" id="price_per_unit${items}" name="products[${items}][price_per_unit]" value="${parseInt(response.product.cost_price)/parseInt(response.product.packing)}" class="form-control" readonly>    
                                        </td>
                                        <td>
                                            <input type="number" id="totalprice${items}" name="products[${items}][total_price_amount]" value="${response.product.cost_price}" class="form-control" readonly>    
                                        </td>
                                        <td>
                                            <i onclick="removeRaw(${response.product.id})" class="text-danger fa fa-trash"></i>
                                        </td>
                                    </tr>
                                        <input type="hidden" id="perunitprice${items}" value=${response.product.cost_price/response.product.packing}> 
                                        <input type="hidden" id="discountamount${items}" value="${(response.product.disctradeprice * response.product.cost_price)/100 }">
                                        <input type="hidden" id="tradeprice${items}" value="${response.product.tradeprice/response.product.pieces_per_pack}">
                                        <input type="hidden" id="totalquantity${items}"  value="${response.product.packing}">
                                        <input type="hidden" id="totalquantitypacket${items}"  value="${(parseInt(response.product.number_of_pack)/parseInt(response.product.packing))}">
                                        <input type="hidden" id="leftedprice${items}" value="" name="leftedprice${items}">  
                                        <input type="hidden" id="hiddenleftquantity${items}" >  
                                        <input type="hidden" id="AmountWithoutDiscount${items}" name="products[${items}][amount_without_discount]" value="${response.product.manufacturer_retail_price/response.product.packing}">
                                        <input type="hidden" id="UnitTrade${items}" name="products[${items}][unit_trade]" value="${response.product.unit_trade}">
                                `);
                        }
                    });

                }
            }

            function removeRaw(id) {
                $("#" + id).remove();
            }

            function changeType(id, items) {
                var limit = $("#selectLimit" + items).val();
                var totalPeice = $('#totalquantity' + items).val();
                var totalPack = $('#number_of_pack' + items).val();

                var amount = $("#totalprice" + items).val();
                if (limit == 1) {
                    $("#" + id + " input[name='products[" + items + "][total_price_amount]']").val((amount / totalPeice)
                        .toFixed(2));
                    $("#" + id + " input[name='products[" + items + "][price_per_unit]']").val((amount / totalPeice).toFixed(
                        2));
                    $('#leftedquantity' + items).val(totalPeice);
                    $('#hiddenleftquantity' + items).val(totalPeice);

                } else if (limit == 0) {
                    $("#" + id + " input[name='products[" + items + "][total_price_amount]']").val((amount / totalPack).toFixed(
                        2));
                    $("#" + id + " input[name='products[" + items + "][price_per_unit]']").val((amount / totalPack).toFixed(2));
                    $('#leftedquantity' + items).val(totalPack);
                    $('#hiddenleftquantity' + items).val(totalPack);
                }
            }


            function changeQuantity(id, items) {
                var minusquantity = $('#minusquantity' + items).val();
                var PricePerUnit = $('#price_per_unit' + items).val();
                var totalquanitity = $('#hiddenleftquantity' + items).val();
                $("#leftedquantity" + items).val(totalquanitity - minusquantity);
                $('#totalprice' + items).val(PricePerUnit * minusquantity);
            }

            $('#save-transfer-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#save-transfer-form').submit();
            });
        </script>
    @endpush
</x-layouts.app>
