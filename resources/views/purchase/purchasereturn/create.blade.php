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
                                        <td>Batch</td>
                                        <td>Purchase Qty</td>
                                        <td>Limit</td>
                                        <td>Qty</td>
                                        <td>Available Qty</td>
                                        <td>Pur Rate</td>
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
            $('form').on('keypress', 'input', function(e) {
                if (e.which === 13) { 
                e.preventDefault(); 
                }
            });
        });
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
                console.log('goodReceiveNoteId '+goodReceiveNoteId);
                if (goodReceiveNoteId) {
                    $.ajax({
                        type: "get",
                        url: "/purchase/purchase-return/"+goodReceiveNoteId+"/product-list",
                        success: function(response) {
                            var items = $("tbody tr").length;
                            // console.log('TR LEN '+items);
                            
                            $.each(response.products, function(index, value) {
                                items += 1; // Increment items by 1 to count rows correctly
                                // console.log(items);
                                $("#add-products").append(`
                                    <tr id="${value.product.id}">
                                        <input type="hidden" name="products[${items}][id]" value="${value.product.id}">
                                        <td>
                                            <input type="text" class="form-control" value="${value.product.product_name}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="products[${items}][batch]"  class="form-control" value="${(value.batch)?value.batch.batch_no: ''}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="products[${items}][remaining_quantity]" id="remaining_quantity${value.product.id}" class="form-control" value="${value.deliver_qty}" readonly>
                                        </td>
                                        <td>
                                            <input type="text"  placeholder="Piece" readonly  min="1" class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="number" name="products[${items}][quantity]"  min="1" value="1" id="minusquantity${value.product.id}" max="${value.deliver_qty}" value="${value.good_receive_note.deliver_qty}" name="quantity[${items}]" oninput="changeQuantity(${value.product.id},${items})" class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="number"  value="${(value.batch)?value.batch.remaining_qty:0}" id="leftedquantity${value.product.id}"  class="form-control" readonly> 
                                            <input type="hidden"  value="${(value.batch)?value.batch.remaining_qty:0}" id="leftedquantity2${value.product.id}"  class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="products[${items}][purchase_rate]" id="purchase_rate${value.product.id}" value="${(value.product.cost_price)}" class="form-control" readonly>    
                                        </td>
                                        <td>
                                            <input type="number" id="totalprice${value.product.id}" name="products[${items}][price]" value="${value.item_amount/value.deliver_qty}" class="form-control" readonly>    
                                            <input type="hidden" id="totalprice2${value.product.id}" name="products[${items}][price]" value="${value.item_amount/value.deliver_qty}" class="form-control" readonly>    

                                        </td>
                                        <td>
                                            <i onclick="removeRaw(${value.product.id})" class="text-danger fa fa-trash"></i>
                                        </td>
                                        <input type="hidden" id="discountamount${value.product.id}" value="${(value.product.disctradeprice * value.product.cost_price)/100 }">
                                        <input type="hidden" id="tradeprice${value.product.id}" value="${value.product.tradeprice/value.product.pieces_per_pack}">
                                        <input type="hidden" id="totalquantity${value.product.id}" value="${value.deliver_qty}">
                                        <input type="hidden" id="leftedprice${value.product.id}" value="" name="leftedprice${value.product.id}">
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
                var minusquantity = $('#minusquantity' + id).val();
                var totalquanitity = $('#totalquantity' + id).val();
                var price = $('#totalprice2' + id).val();
                var tradeprice = $('#tradeprice' + id).val();
                $("#leftedquantity" + id).val($("#leftedquantity2" + id).val() - parseInt(minusquantity));
                $('#totalprice' + id).val((price) * (minusquantity));
                var minusprice = $("#totalprice" + id).val()
                $('#leftedprice' + id).val(parseInt(minusprice) - parseInt(price))
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
