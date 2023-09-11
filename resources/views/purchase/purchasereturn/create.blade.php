<x-layouts.app title="Purchase Item Return Create">
    @push('styles')
        <link nonce="{{ csp_nonce() }}" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
            rel="stylesheet" />
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
                        <label for="remark" class="form-label">Remark</label>
                        <input type="text" name="remark" id="remark" class="form-control"
                            value="{{ old('remark') }}" placeholder="Enter your remark" title="Remark">
                        @error('remark')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="good_receive_note_id" class="form-label">Good Receive Note<sup
                                class="text-danger">*</sup></label>
                        <div class="row">
                            <div class="col-md-10">
                                <select name="good_receive_note_id" id="good_receive_note_id" class="form-control"
                                    value="{{ old('good_receive_note_id') }}">
                                    <option value="" selected disabled>Select Good Receive Note</option>
                                    @forelse ($goodReceiveNotes as $goodReceiveNote)
                                        <option value="{{ $goodReceiveNote->id }}">{{ $goodReceiveNote->id }}</option>
                                    @empty
                                        <option value="" class="text-danger">no good receive note found!</option>
                                    @endforelse
                                </select>
                                @error('good_receive_note_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary" id="add-btn" title="Add products">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5 mt-5">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <td>Product</td>
                                        <td>Purchase Qty</td>
                                        <td>Limit</td>
                                        <td>Qty</td>
                                        <td>Available Qty</td>
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
                        <button type="button" id="save-purchasereturn-button"
                            class="btn btn-primary ms-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js">
        </script>
        <script nonce="{{ csp_nonce() }}">
            $(document).ready(function() {
                $('#good_receive_note_id').select2();
            });
            $("#add-btn").click(function(e) {
                e.preventDefault();
                console.log("pass");
                addProduct();
            });

            function addProduct() {
                console.log("pass2");
                var goodReceiveNoteId = $("#good_receive_note_id").val();
                console.log(goodReceiveNoteId);
                if (goodReceiveNoteId) {
                    $.ajax({
                        type: "get",
                        url: "/purchase/purchase-return/"+goodReceiveNoteId+"/product-list",
                        success: function(response) {
                            console.log(response);
                            var items = $("tbody tr").length;
                            $.each(response.products, function(index, value) {
                                console.log(value);
                                $("#add-products").append(`
                                    <tr id="${value.product.id}">
                                        <input type="hidden" name="products[${items}][id]" value="${value.product.id}">
                                        <td>
                                            <input type="text" class="form-control" value="${value.product.product_name}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="products[${items}][remaining_quantity]" id="remaining_quantity${items}" class="form-control" value="${value.deliver_qty}" readonly>
                                        </td>
                                        <td>
                                            <input type="text"  placeholder="Piece" readonly  min="1" class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="text" name="products[${items}][quantity]"  min="1" value="1" id="minusquantity${items}" max="${value.deliver_qty}" value="${value.good_receive_note.deliver_qty}" name="quantity[${items}]" onkeyup="changeQuantity(${value.product.id},${items})" class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="number"  value="${value.product.total_quantity}" id="leftedquantity${items}"  class="form-control" readonly> 
                                            <input type="hidden"  value="${value.product.total_quantity}" id="leftedquantity2${items}"  class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="products[${items}][purchase_rate]" id="${items}" value="${(value.product.cost_price)}" class="form-control" readonly>    
                                        </td>
                                        <td>
                                            <input type="number" name="products[${items}][sale_tax]" value="${value.good_receive_note.sale_tax_percentage}" class="form-control" readonly>    
                                        </td>
                                        <td>
                                            <input type="number" id="totalprice${items}" name="products[${items}][price]" value="${value.item_amount/value.deliver_qty}" class="form-control" readonly>    
                                            <input type="hidden" id="totalprice2${items}" name="products[${items}][price]" value="${value.item_amount/value.deliver_qty}" class="form-control" readonly>    

                                        </td>
                                        <td>
                                            <i onclick="removeRaw(${value.product.id})" class="text-danger fa fa-trash"></i>
                                        </td>
                                        <input type="hidden" id="discountamount${items}" value="${(value.product.disctradeprice * value.product.cost_price)/100 }">
                                        <input type="hidden" id="tradeprice${items}" value="${value.product.tradeprice/value.product.pieces_per_pack}">
                                        <input type="hidden" id="totalquantity${items}" value="${value.deliver_qty}">
                                        <input type="hidden" id="leftedprice${items}" value="" name="leftedprice${items}">
                                    </tr>
                                `);
                            });
                        }
                    });
                    disableadd();
                }
            }

            function removeRaw(id) {
                $("#" + id).remove();
                enableadd();
            }

            function changeQuantity(id, items) {
                var minusquantity = $('#minusquantity' + items).val();
                var totalquanitity = $('#totalquantity' + items).val();
                var price = $('#totalprice2' + items).val();
                var tradeprice = $('#tradeprice' + items).val();
                $("#leftedquantity" + items).val($("#leftedquantity2" + items).val() - parseInt(minusquantity));
                $('#totalprice' + items).val((price) * (minusquantity));
                var minusprice = $("#totalprice" + items).val()
                $('#leftedprice' + items).val(parseInt(minusprice) - parseInt(price))
                $('#remaining_quantity'+items).val(parseInt(totalquanitity) - parseInt(minusquantity))
            }

            function disableadd() {
                $('#add-btn').attr('disabled', 'True');
            }

            function enableadd() {
                $('#add-btn').removeAttr('disabled');
            }

            $('#save-purchasereturn-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#save-purchasereturn-form').submit();
            });
        </script>
    @endpush
</x-layouts.app>
