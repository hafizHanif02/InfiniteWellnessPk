<x-layouts.app title="Good Receive Note Create">
    @push('styles')
        <link nonce="{{ csp_nonce() }}" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
            rel="stylesheet" />
    @endpush
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Add Good Receive Note</h3>
                <a href="{{ route('purchase.good_receive_note.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form id="save-goodreceivenote-form" action="{{ route('purchase.good_receive_note.store') }}"
                    method="POST">
                    @csrf
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label for="grn_no" class="form-label">Code <sup class="text-danger ">*</sup></label>
                            <input type="number" readonly name="grn_no" value="{{ ($id ? $id : 6160) + 1 }}"
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
                                    <option value="{{ $vendor->id }}">{{ $vendor->account_title }}</option>
                                @empty
                                    <option value="" disabled class="text-danger">No vendor found!</option>
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
                                value="{{ old('remark') }}" placeholder="Enter Your remark">
                            @error('remark')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date <sup class="text-danger">*</sup></label>
                            <input type="text" name="date" id="date" readonly value="{{ date('j-M-Y') }}"
                                class="form-control">
                            @error('date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="requistion" class="form-label">Requistion<sup class="text-danger">*</sup></label>
                        <div class="row">
                            <div class="col-md-9">
                                <select name="requistion_id" id="requistion" class="form-control">
                                    <option value="" selected>Select vendor first</option>
                                </select>
                                @error('requistion_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="requistion-btn" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <td></td>
                                        <td>Product</td>
                                        <td>Demand Total Piece</td>
                                        <td>Reamining Total Piece</td>
                                        <td>Deliver Total Piece (Pcs)</td>
                                        <td>Discount %</td>
                                        <td>Bonus</td>
                                        <td>Exp Date</td>
                                        <td>Batch No.</td>
                                        <td>Price Per Unit</td>
                                        <td>Amount</td>

                                    </tr>
                                </thead>
                                <tbody id="add-products">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row mb-3 mt-3">
                        <div class="col-md-7">
                            <label for="totalcostwithtax" class="form-label">Total Amount</label>
                            <input type="number" readonly id="totalcostwithtax" placeholder="Total Amount"
                                name="total_amount" class="form-control">
                            @error('totalcostwithtax')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label for="total_discount_amount" class="form-label">Total Discount Amount</label>
                            <input type="number" readonly id="total_discount_amount" placeholder="Total Amount"
                                name="total_discount_amount" class="form-control" value="0">
                            @error('total_discount_amount')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        </div>
                    </div>
                    <div class="row d-flex flex-column justify-content-end">
                        <div class="row mb-3 mt-3">
                            <div class="col-md-7">
                                <label for="advance_tax_percentage" class="form-label">Advanced Tax %</label>
                                <input type="number" min="0" max="100" id="advance_tax_percentage"
                                    onkeyup="advanceTax()" placeholder="Advance Tax Percentage"
                                    name="advance_tax_percentage" class="form-control" value="0">
                                @error('advance_tax_percentage')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <label for="advance_tax_percentage_amount" class="form-label">Advanced Tax
                                    Amount</label>
                                <input type="number" id="advance_tax_percentage_amount"
                                    placeholder="Advance Tax Amount" readonly name="advance_tax_percentage_amount"
                                    class="form-control" value="0">
                                @error('advance_tax_percentage_amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3 mt-3">
                            <div class="col-md-7">
                                <label for="sale_tax_percentage" class="form-label">Sale Tax %</label>
                                <input type="number" min="0" value="0" id="sale_tax_percentage"
                                    name="sale_tax_percentage" onkeyup="advanceTax()" class="form-control">
                                @error('sale_tax_percentage')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <label for="sales_taxamount" class="form-label">Sales Tax Amount</label>
                                <input type="number" id="sales_taxamount" placeholder="Sales Tax Amount"
                                    name="sales_taxamount" readonly class="form-control" value="0">
                                @error('sales_taxamount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="net_total_amountcost" class="form-label">Net Total Amount <sup
                                    class="text-danger">*</sup></label>
                            <input type="number" id="net_total_amountcost" placeholder="Net Total Amount"
                                name="net_total_amount" readonly class="form-control">
                            <input type="hidden" id="net_total_amountcost2">
                            
                            @error('net_total_amountcost')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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
                                                ${requisition.id} - ${requisition.delivery_date}
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
                                        var items = $("tbody tr").length;
                                        $('#add-products').append(`
                                            <tr id="${requistionProduct.product_id}">
                                                <td>
                                                    <input type="checkbox"  name='products[${items}][id]' value="${requistionProduct.product_id}" class="form-check-input">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" value="${requistionProduct.product.product_name}" readonly>
                                                </td>
                                                
                                                <td>
                                                    <input type="number"  class="form-control"  id="totalquantity${requistionProduct.id}" value="${requistionProduct.total_piece}" readonly>
                                                </td>
                                                <td>
                                                    ${requistionProduct.product.least_unit == 1 ? `<input type="number" id="changequantity${requistionProduct.id}"  value="${requistionProduct.total_piece}" class="form-control" readonly>` : `<input type="number" id="changequantity${requistionProduct.id}"  value="${requistionProduct.total_piece}" class="form-control" readonly>`  }
                                                </td>
                                                <td>
                                                    <input type="number" min="0" name="products[${items}][deliver_qty]"  id="minusquantity${requistionProduct.id}"  max="${requistionProduct.product.least_unit == 1 ? `${requistionProduct.total_piece}` : `${requistionProduct.total_piece}` }" onkeyup="changeQuantity(${requistionProduct.id})"   class="form-control" >
                                                </td>
                                                <td>
                                                    <input type="number" min="0" name="products[${items}][discount]" onkeyup="discountPerc(${requistionProduct.id})"  id="discount${requistionProduct.id}" value="0" class="form-control" >
                                                    <input type="hidden" readonly  name="products[${items}][discount_amount]"   id="discount_amount${requistionProduct.id}" class="form-control" >
                                                </td>
                                                <td>
                                                    <input type="number" name="products[${items}][item_bonus]" value="0" min="0" class="form-control" >
                                                </td>
                                                <td>
                                                    <input type="date" name="products[${items}][expiry_date]"  class="form-control" >
                                                </td>
                                                <td>
                                                    <input type="number" name="products[${items}][batch_no]" class="form-control" >
                                                </td>
                                                <td>
                                                    <input type="number" id="price_per_unit${requistionProduct.id}" name="products[${items}][totalprice2]" value="${requistionProduct.price_per_unit}" class="form-control" readonly>  
                                                </td>
                                               
                                                <td>
                                                    <input type="number" id="totalprice2${requistionProduct.id}" name="products[${items}][totalprice]" value="${requistionProduct.total_amount/requistionProduct.total_piece}" class="form-control" readonly>    
                                                    <input type="hidden" id="totalpricefordiscount${requistionProduct.id}" name="products[${items}][totalpricefordiscount]" value="${requistionProduct.total_amount/requistionProduct.total_piece}" class="form-control" readonly>    
                                                </td>
                                            </tr>
                                           
                                                    <input type="hidden" class="form-control" value="${requistionProduct.disc}" readonly>
                                                    <input type="number" value="${requistionProduct.sale_tax_percentage}" class="form-control" readonly>    
                                                    <input type="hidden" class="form-control" value="${requistionProduct.disc_amount }" readonly>    
                                                    <input type="hidden" id="price_per_unit${requistionProduct.id}" value="${requistionProduct.price_per_unit}"
                                                
                                                               
                                        `);
                                    }
                                });
                            }
                        });
                    }
                });
            });

            function changeQuantity(id) {
                var quantity = $("#minusquantity" + id).val();
                var totalquantity = $("#totalquantity" + id).val();
                var amount = $("#price_per_unit" + id).val();
                $('#totalprice2' + id).val((amount) * (quantity));
                $('#totalpricefordiscount' + id).val((amount) * (quantity));
                $('#changequantity' + id).val(totalquantity - (quantity));
                calculateTotalAmount();
            }

            function calculateTotalAmount() {
                var totalAmount = 0;
                $("input[id^='totalprice2']").each(function() {
                    totalAmount += parseFloat($(this).val());

                });
                $("#total_amountcost").val(totalAmount);
                $('#net_total_amountcost').val(totalAmount);
                $("#totalcostwithtax").val(totalAmount);
                $('#net_total_amountcost3').val(totalAmount);


                discountTotal();
            }

            $('#save-goodreceivenote-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#save-goodreceivenote-form').submit();
            });



            function advanceTax() {
                console.log("adv tax start");
                var advancetaxperc = parseFloat($('#advance_tax_percentage').val());
                var totalcostwithouttax = parseFloat($('#net_total_amountcost2').val());
                var SaleTaxPercPerc = $('#sale_tax_percentage').val();

                var advanceTaxAmount = (parseFloat((advancetaxperc * totalcostwithouttax) / 100)).toFixed(2);
                $('#advance_tax_percentage_amount').val(advanceTaxAmount);

                var salesTaxAmount = (parseFloat((SaleTaxPercPerc * totalcostwithouttax) / 100)).toFixed(2);
                $('#sales_taxamount').val(salesTaxAmount);

                var amountwithtax = (parseFloat(totalcostwithouttax) + parseFloat(advanceTaxAmount) + parseFloat(salesTaxAmount));
                $('#net_total_amountcost').val(amountwithtax);
                console.log("adv tax end");
            }


            function saleTax() {
                // var SaleTaxPercPerc = $('#sale_tax_percentage').val();
                // var NetTotalAmountWithAdvTax = $('#net_total_amountcost2').val();
                
                // var peramountsales = (parseFloat((SaleTaxPercPerc * totalcostwithtax) / 100)).toFixed(2);
                // $('#sales_taxamount').val(peramountsales);
                // var amountwithtaxsale = (parseFloat(NetTotalAmountWithAdvTax) + parseFloat(peramountsales));
                // var amountwithtaxsaleTwoDigit = amountwithtaxsale.toFixed(2);
                // $('#net_total_amountcost').val(amountwithtaxsaleTwoDigit);
            };

            function discountPerc(id) {
                var discountPer = $('#discount' + id).val();
                var total_cost_per_product = $('#totalprice2' + id).val();
                var discount_amount = (discountPer * total_cost_per_product) / 100;
                console.log(discountPer, total_cost_per_product);
                $('#discount_amount' + id).val(discount_amount)
                discountTotal();
            }

            function discountTotal() {
                var discount = 0;
                $("input[id^='discount_amount']").each(function() {
                    if($(this).val() != ''){
                        discount += parseFloat($(this).val());
                    }
                });
                
                $('#total_discount_amount').val(discount);
                var total_amount = $('#totalcostwithtax').val();
                console.log("discount "+ discount, total_amount);
                $('#net_total_amountcost2').val(total_amount-discount);
                //$('#net_total_amountcost').val(total_amount-discount); 
                advanceTax();
            }
        </script>
    @endpush
</x-layouts.app>
