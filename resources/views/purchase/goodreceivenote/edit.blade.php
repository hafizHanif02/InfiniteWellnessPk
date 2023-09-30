<x-layouts.app title="Edit Good Receive Note">
    @push('styles')
        <link nonce="{{ csp_nonce() }}" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
            rel="stylesheet" />
    @endpush
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Edit Good Receive Note</h3>
                <a href="{{ route('purchase.good_receive_note.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form id="save-goodreceivenote-form"
                    action="{{ route('purchase.good_receive_note.update', $goodReceiveNote->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label for="invoice_number" class="form-label">Invoice Number <sup class="text-danger">*</sup></label>
                            <input type="text" name="invoice_number" value="{{ old('invoice_number', $goodReceiveNote->invoice_number) }}" id="invoice_number"
                                class="form-control">
                            @error('invoice_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label for="grn_no" class="form-label">Code <sup class="text-danger ">*</sup></label>
                            <input type="number" readonly name="grn_no"
                                value="{{ $goodReceiveNote->id }}"
                                id="grn_no" class="form-control">
                            @error('grn_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="vendor_id" class="form-label">Vendor<sup class="text-danger">*</sup></label>
                            <select name="vendor_id" id="vendor_id" class="form-control" value="{{ old('vendor_id') }}">
                                <option value="" selected disabled>Select Vendor</option>
                                @forelse ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}"
                                        {{ $vendor->id == old('vendor_id', $goodReceiveNote->vendor_id) ? 'selected' : '' }}>
                                        {{ $vendor->account_title }}</option>
                                @empty
                                    <option value="" class="text-danger" disabled>No vendor found!</option>
                                @endforelse
                            </select>
                            @error('vendor_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <input type="text" name="remark" id="remarks" class="form-control"
                                value="{{ old('remark', $goodReceiveNote->remark) }}" placeholder="Enter Your remark">
                            @error('remark')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date <sup class="text-danger">*</sup></label>
                            <input type="date" name="date" id="date" class="form-control"
                                value="{{ old('date', $goodReceiveNote->date) }}">
                            @error('date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="requistion_id" class="form-label">Requistion <sup
                                class="text-danger">*</sup></label>
                        <div class="row">
                            <div class="col-md-9">
                                <select name="requistion_id" id="requistion_id" class="form-control">
                                    <option value="" selected>Select vendor first</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="requistion-btn" class="btn btn-primary">
                                    <i class="fa fa-plus"></i>
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-dark">
                                    <tr class="text-white">
                                        <td style="min-width: 100px"></td>
                                        <td style="min-width: 200px">Product</td>
                                        <td style="min-width: 200px">Description</td>
                                        <td style="min-width: 200px">Packing</td>
                                        <td style="min-width: 200px">Limit</td>
                                        <td style="min-width: 150px">Qty</td>
                                        <td style="min-width: 150px">Dis%</td>
                                        <td style="min-width: 150px">Dis Amt</td>
                                        <td style="min-width: 150px">Bonus</td>
                                        <td style="min-width: 150px">Pcs Qty</td>
                                        <td style="min-width: 150px">Pur Rate</td>
                                        <td style="min-width: 150px">S Tax</td>
                                        <td style="min-width: 150px">Amount</td>
                                    </tr>
                                </thead>
                                <tbody id="add-products">
                                    @forelse ($goodReceiveNote->goodReceiveProducts as $goodReceiveProduct)
                                        <tr id="{{ $goodReceiveProduct->product_id }}">
                                            <td>
                                                <input type="checkbox" name='product_id[]'
                                                    value="{{ $goodReceiveProduct->product_id }}"
                                                    class="form-check-input" id="product{{ $goodReceiveProduct->id }}"
                                                    checked>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ $goodReceiveProduct->product->product_name }}"
                                                    id="product_name{{ $goodReceiveProduct->id }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ $goodReceiveProduct->product->package_detail }}"
                                                    id="package_detail{{ $goodReceiveProduct->id }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ $goodReceiveProduct->product->pieces_per_pack }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ $goodReceiveProduct->product->type == '0' ? 'piece' : 'pack' }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                <input type="number" value="{{$goodReceiveProduct->deliver_qty}}" min="1"
                                                    onchange="changeQuantity({{ $goodReceiveProduct->product_id }})"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ $goodReceiveProduct->discount }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ (($goodReceiveProduct->deliver_qty * $goodReceiveProduct->item_amount) / 100) *$goodReceiveProduct->discount }}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" name="bonus" value="0" min="0"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" value="{{ $goodReceiveProduct->pcs_qty }}"
                                                    class="form-control" readonly>
                                            </td>
                                            <td>
                                                <input type="number"
                                                    value="{{ $goodReceiveProduct->purchase_rate }}"
                                                    class="form-control" readonly>
                                            </td>
                                            <td>
                                                <input type="number" value="{{ $goodReceiveProduct->sale_tax }}"
                                                    class="form-control" readonly>
                                            </td>
                                            <td>
                                                <input type="number" value="{{ $goodReceiveProduct->total_amount }}"
                                                    class="form-control" readonly>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="13" class="text-danger">No product found!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <a href="{{ route('purchase.good_receive_note.index') }}" class="btn btn-danger">Cancel</a>
                        <button type="button" id="save-goodreceivenote-button"
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
                $('#vendor_id, #requistion').select2();
            });
            $(document).ready(function() {
                $('#vendor_id').change(function() {
                    var vendorId = $(this).val();
                    if (vendorId) {
                        $.ajax({
                            url: '/purchase/get/requisitions/' + vendorId,
                            type: 'get',
                            success: function(response) {
                                if (response.requistions.length > 0) {
                                    $('#requistion').html(`
                                    <option value="" selected disabled>Select requistion</option>
                                `);
                                    $.map(response.requistions, function(requisition) {
                                        $('#requistion').append(`
                                        <option value="${requisition.id}">
                                            ${requisition.po_number} ${requisition.delivery_date}
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
                            '<option value="" selected disabled>Select vendor first</option>');
                    }
                });

                $("#requistion-btn").click(function() {
                    var value = $("#requistion").val();
                    if (value) {
                        $.ajax({
                            type: "get",
                            url: "/purchase/get/requistion-products/" + value,
                            success: function(response) {
                                $.map(response.requistionProducts, function(requistionProduct,
                                    index) {
                                    if ($("#add-products tr#" + requistionProduct
                                            .product_id).length == 0) {
                                        $('#add-products').append(`
                                        <tr id="${requistionProduct.product_id}">
                                            <td>
                                                <input type="checkbox"  name='products[${requistionProduct.id}][id]' value="${requistionProduct.product_id}" class="form-check-input">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="${requistionProduct.product.product_name}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="${requistionProduct.product.package_detail}" readonly>
                                            </td>
                                            <td>
                                                <input type="text"  class="form-control" value="${requistionProduct.product.pieces_per_pack}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="${requistionProduct.product.least_unit == 1 ? 1 : 0}" readonly>
                                            </td>
                                            <td>
                                                ${requistionProduct.product.least_unit == 1 ? `<input type="number" id="totalquantity${requistionProduct.id}"  value="${requistionProduct.qty}" class="form-control" readonly>` : `<input type="number" id="totalquantity${requistionProduct.id}"  value="${requistionProduct.qty*requistionProduct.packing}" class="form-control" readonly>`  }
                                            </td>
                                            <td>
                                                <input type="number" min="0" name="products[${requistionProduct.id}][qty]"  id="minusquantity${requistionProduct.id}"  max="${requistionProduct.product.least_unit == 1 ? `${requistionProduct.qty}` : `${requistionProduct.qty*requistionProduct.packing}` }" onchange ="changeQuantity(${requistionProduct.id})"   class="form-control" >
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="${requistionProduct.disc}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" value="${requistionProduct.disc_amount }" readonly>
                                            </td>
                                            <td>
                                                <input type="number" name="products[${requistionProduct.id}][item_bonus]" value="0" min="0" class="form-control" >
                                            </td>
                                            <td>
                                                <input type="number" id="totalprice${requistionProduct.id}"  value="${requistionProduct.product.trade_price}" class="form-control" readonly>
                                            </td>
                                            <td>
                                                <input type="number" value="${requistionProduct.sale_tax}" class="form-control" readonly>
                                            </td>
                                            <td>
                                                <input type="number" id="totalprice2${requistionProduct.id}" name="products[${requistionProduct.id}][totalprice2]" value="${requistionProduct.total_amount/requistionProduct.qty}" class="form-control" readonly>
                                            </td>
                                        </tr>

                                    `);
                                    }
                                });
                            }
                        });
                    }
                });
            });

            function changeQuantity(id) {
                console.log(id);
                var quantity = $("#minusquantity" + id).val();
                var totalquantity = $("#totalquantity" + id).val();
                var amount = $("#totalprice2" + id).val();
                $('#totalprice2' + id).val((amount) * (quantity));
                $('#totalquantity' + id).val(totalquantity - (quantity));
                calculateTotalAmount();
            }

            function advanceTax() {
                var advanceTax = parseFloat($("#advance_tax").val());
                var initialTotalAmount = parseFloat($("#total_amountcost").val());
                var TaxAmount = (initialTotalAmount) * (advanceTax / 100)
                $('#advance_taxamount').val(TaxAmount);
                var newTotalAmount = initialTotalAmount + (initialTotalAmount * ((advanceTax) / 100));
                $("#total_amountcost").val(newTotalAmount);
            }

            function calculateTotalAmount() {
                var totalAmount = 0;
                $("input[id^='totalprice2']").each(function() {
                    totalAmount += parseFloat($(this).val());

                });
                $("#total_amountcost").val(totalAmount);
            }
            $('#save-goodreceivenote-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#save-goodreceivenote-form').submit();
            });
        </script>
    @endpush
</x-layouts.app>
