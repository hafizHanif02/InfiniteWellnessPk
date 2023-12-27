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
                            <label for="invoice_number" class="form-label">Invoice Number</label>
                            <input type="text" name="invoice_number" placeholder="Enter Your Invoice Number"
                                id="invoice_number" class="form-control" required>
                            @error('invoice_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="form-label">Invoice Date <sup
                                    class="text-danger">*</sup></label>
                            <input type="date" name="invoice_date" id="date" required class="form-control">
                        </div>
                    </div>
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
                            <div class="col-md-1">
                                <button type="button" id="requistion-btn" class="btn btn-primary">Add</button>
                            </div>
                          
                                </div>
                            </div>
                            <div class="mb-5">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <td style="min-width: 100px"></td>
                                                <td style="min-width: 400px">Product</td>
                                                <td style="min-width: 200px">Demand Total Piece</td>
                                                <td style="min-width: 200px">Reamining Total Piece</td>
                                                <td style="min-width: 200px">Deliver Total Piece (Pcs)</td>
                                                <td style="min-width: 150px">Discount %</td>
                                                <td style="min-width: 150px">SaleTax %</td>
                                                <td style="min-width: 150px">SaleTax Amount</td>
                                                <td style="min-width: 150px">Bonus</td>
                                                <td style="min-width: 150px">Exp Date</td>
                                                <td style="min-width: 150px">Batch No.</td>
                                                <td style="min-width: 150px">Price Per Unit</td>
                                                <td style="min-width: 150px">MRP</td>
                                                <td style="min-width: 150px">Amount</td>
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
                                        <input type="number" readonly id="totalcostwithtax"
                                            placeholder="Total Amount" name="total_amount" class="form-control">
                                        @error('totalcostwithtax')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-5">
                                        <label for="total_discount_amount" class="form-label">Total Discount
                                            Amount</label>
                                        <input type="number" readonly id="total_discount_amount"
                                            placeholder="Total Amount" name="total_discount_amount"
                                            class="form-control" value="0">
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
                                        <input type="text" id="advance_tax_percentage" oninput="advanceTax()"
                                            placeholder="Advance Tax Percentage" name="advance_tax_percentage"
                                            class="form-control" value="0">
                                        @error('advance_tax_percentage')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-5">
                                        <label for="advance_tax_percentage_amount" class="form-label">Advanced Tax
                                            Amount</label>
                                        <input type="number" id="advance_tax_percentage_amount"
                                            placeholder="Advance Tax Amount" readonly name="advance_tax_amount"
                                            class="form-control" value="0">
                                        @error('advance_tax_amount')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="net_total_amountcost" class="form-label">Net Total Amount <sup
                                            class="text-danger">*</sup></label>
                                    <input type="number" id="net_total_amountcosts2" placeholder="Net Total Amount"
                                        name="net_total_amount" readonly class="form-control">
                                    <input type="hidden" id="net_total_amountcosts2">
                                    <input type="hidden" id="net_total_amountcosts3">

                                    @error('net_total_amountcost')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <a href="{{ route('purchase.good_receive_note.index') }}"
                                    class="btn btn-danger">Cancel</a>
                                {{-- <button type="button" id="save-goodreceivenote-button"
                            class="btn btn-primary ms-3">Save</button> --}}
                                <!-- Add this button and message div to your HTML form -->
                                {{-- <div class="row d-flex justify-content-end"> --}}
                                <button type="submit" id="save-goodreceivenote-button-check"
                                    class="btn btn-primary ms-3">Save</button>
                                {{-- <button type="button" id="save-goodreceivenote-button-check" class="btn btn-secondary ms-3">Check</button> --}}
                                {{-- </div> --}}

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
                    if (e.which === 13) { // 13 is the key code for "Enter"
                        e.preventDefault(); // Prevent the default form submission
                    }
                });
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
                                                    <input type="checkbox"  name='products[${items}][id]' value="${requistionProduct.product_id}" class="form-check-input" checked>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" title="${requistionProduct.product.product_name}" value="${requistionProduct.product.product_name}" readonly>
                                                </td>

                                                <td>
                                                    <input type="number"  class="form-control"  id="totalquantity${requistionProduct.id}" value="${requistionProduct.total_piece}" readonly>
                                                </td>
                                                <td>
                                                    ${requistionProduct.product.least_unit == 1 ? `<input type="number" id="changequantity${requistionProduct.id}"  value="${(requistionProduct.total_piece)-1}" class="form-control" readonly>` : `<input type="number" id="changequantity${requistionProduct.id}"  value="${(requistionProduct.total_piece)-1}" class="form-control" readonly>`  }
                                                </td>
                                                <td>
                                                    <input type="number" min="0" name="products[${items}][deliver_qty]" value=1 id="minusquantity${requistionProduct.id}"  max="${requistionProduct.product.least_unit == 1 ? `${requistionProduct.total_piece}` : `${requistionProduct.total_piece}` }" oninput="changeQuantity(${requistionProduct.id})"   class="form-control" >
                                                </td>
                                                <td>
                                                    <input type="number" name="products[${items}][discount]" oninput="discountPerc(${requistionProduct.id})"  id="discount${requistionProduct.id}" value="0" class="form-control" >
                                                    <input type="hidden" readonly  name="products[${items}][discount_amount]"   id="discount_amount${requistionProduct.id}" value="0" class="form-control" >
                                                </td>
                                                <td>
                                                    <input type="number"  name="products[${items}][saletax_percentage]" oninput="saletaxPerc(${requistionProduct.id})"  id="saletax${requistionProduct.id}" class="form-control" >
                                                </td>
                                                <td>
                                                    <input type="text" readonly  name="products[${items}][saletax_amount]"   id="saletax_amount${requistionProduct.id}" class="form-control" >
                                                </td>
                                                <td>
                                                    <input type="number" name="products[${items}][bonus]" value="0" min="0" class="form-control" >
                                                </td>
                                                <td>
                                                    <input type="date" name="products[${items}][expiry_date]"  class="form-control" >
                                                </td>
                                                <td>
                                                    <input type="text" name="products[${items}][batch_no]" class="form-control" >
                                                </td>
                                                <td>
                                                    <input type="number" id="price_per_unit${requistionProduct.id}" name="products[${items}][totalprice2]" value="${requistionProduct.price_per_unit}" class="form-control" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" id="manufacturer_retail_price${requistionProduct.id}" name="products[${items}][manufacturer_retail_price]" value="${requistionProduct.product.manufacturer_retail_price}" step="any"  class="form-control">
                                                </td>
                                                
                                                <td>
                                                    <input type="number" id="totalprices2${requistionProduct.id}" name="products[${items}][totalprice]" value="${requistionProduct.total_amount/requistionProduct.total_piece}" class="form-control" readonly>
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
                $('#totalprices2' + id).val(((amount) * (quantity)).toFixed(2));
                $('#totalpricefordiscount' + id).val((amount) * (quantity));
                $('#changequantity' + id).val(totalquantity - (quantity));
                calculateTotalAmount();
                saletaxPerc(id);
                discountPerc(id);
            }


            function saletaxPerc(id) {
                // Total Calculation
                var priceperunit = $('#price_per_unit' + id).val();
                var InputQty = $('#minusquantity' + id).val();

                var totalAmount = priceperunit * InputQty;

                console.log(totalAmount);

                // Discount Calculation
                var discountPerc = $('#discount' + id).val();
                var DiscountAmount = ((discountPerc * totalAmount) / 100);

                var AmountwithDiscount = totalAmount - DiscountAmount;

                // SaleTax Calculation
                var saleTaxpercentage = $('#saletax' + id).val();
                var SaleAmount = ((AmountwithDiscount * saleTaxpercentage) / 100);

                $('#saletax_amount' + id).val(SaleAmount.toFixed(2));

                var TotalAmountwithSaleForNet = SaleAmount + AmountwithDiscount;
                var TotalAmountwithSaleFortotal = totalAmount + SaleAmount;

                $('#totalprices2' + id).val(TotalAmountwithSaleForNet.toFixed(2));
                $('#totalpricefordiscount' + id).val(TotalAmountwithSaleFortotal.toFixed(2));

                calculateTotalAmount();
            }

            function calculateTotalAmount() {
                var totalAmountForNet = 0;
                var totalAmountForTaxOnly = 0;
                $("input[id^='totalprices2']").each(function() {

                    totalAmountForNet += parseFloat($(this).val());

                });
                $("input[id^='totalpricefordiscount']").each(function() {

                    totalAmountForTaxOnly += parseFloat($(this).val());

                });
                // $("#totalcostwithtax").val(totalAmountForTaxOnly.toFixed(2));
                $("#totalcostwithtax").val(totalAmountForNet.toFixed(2));
                $('#net_total_amountcosts2').val(totalAmountForNet.toFixed(2));
                // $("#totalcostwithtax").val(totalAmount.toFixed(2));

                // console.log(totalAmount);

                // discountTotal();
            }

            $('#save-goodreceivenote-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#save-goodreceivenote-form').submit();
            });



            // $('#save-goodreceivenote-button-check').on('click', function() {
            //     // console.log('Add');
            //     // $(this).prop('disabled', true);
            //     // $('#save-goodreceivenote-form').submit();



            // });










            // function advanceTax() {
            //     var advancetaxperc = parseFloat($('#advance_tax_percentage').val());
            //     var totalcostwithouttax = parseFloat($('#net_total_amountcosts3').val());
            //     var SaleTaxPercPerc = $('#sale_tax_percentage').val();

            //     var advanceTaxAmount = (parseFloat((advancetaxperc * totalcostwithouttax) / 100)).toFixed(2);
            //     $('#advance_tax_percentage_amount').val(advanceTaxAmount);

            //     // var salesTaxAmount = (parseFloat((SaleTaxPercPerc * totalcostwithouttax) / 100)).toFixed(2);
            //     // $('#sales_taxamount').val(salesTaxAmount);

            //     var amountwithtax = (parseFloat(totalcostwithouttax) + parseFloat(advanceTaxAmount));
            //     $('#net_total_amountcosts2').val(amountwithtax.toFixed(2));
            // }

            function advanceTax() {
                var advancetaxperc = parseFloat($('#advance_tax_percentage').val());
                var totalcostwithtax = parseFloat($('#totalcostwithtax').val());

                var SaleTaxPercPerc = $('#sale_tax_percentage').val();

                var advanceTaxAmount = (parseFloat((totalcostwithtax * advancetaxperc) / 100)).toFixed(2);
                $('#advance_tax_percentage_amount').val(advanceTaxAmount);

                var amountwithtax = (parseFloat(totalcostwithtax) + parseFloat(advanceTaxAmount));
                $('#net_total_amountcosts2').val(amountwithtax.toFixed(2));
            }





            // function saleTax() {
            //     var SaleTaxPercPerc = $('#sale_tax_percentage').val();
            //     var NetTotalAmountWithAdvTax = $('#net_total_amountcost2').val();

            //     var peramountsales = (parseFloat((SaleTaxPercPerc * totalcostwithtax) / 100)).toFixed(2);
            //     $('#sales_taxamount').val(peramountsales);
            //     var amountwithtaxsale = (parseFloat(NetTotalAmountWithAdvTax) + parseFloat(peramountsales));
            //     var amountwithtaxsaleTwoDigit = amountwithtaxsale.toFixed(2);
            //     $('#net_total_amountcost').val(amountwithtaxsaleTwoDigit);
            // };

            function discountPerc(id) {
                var minusquantity = $('#minusquantity' + id).val();
                var amount = $("#price_per_unit" + id).val();
                var totalPrice = minusquantity * amount;
                var discountPer = $('#discount' + id).val();
                var discount_amount = ((discountPer * totalPrice) / 100).toFixed(2);
                $('#discount_amount' + id).val(discount_amount)
                var amountwithdiscount = totalPrice - discount_amount;
                $('#totalprices2' + id).val(amountwithdiscount.toFixed(2));
                discountTotal();
                saletaxPerc(id);
            }

            function discountTotal() {
                var discount = 0;
                $("input[id^='discount_amount']").each(function() {
                    if ($(this).val() != '') {
                        discount += parseFloat($(this).val());
                    }
                });
                $('#total_discount_amount').val(discount.toFixed(2));
                var total_amount = $('#totalcostwithtax').val();
                var amountwithdisc = (total_amount - discount);
                var Totalamountwithdisc = amountwithdisc.toFixed(2);
                $('#net_total_amountcost').val(Totalamountwithdisc);
                $('#net_total_amountcosts2').val(Totalamountwithdisc);
                $('#net_total_amountcosts3').val(Totalamountwithdisc);
            }

            $(document).ready(function() {
                $('#save-goodreceivenote-form').on('submit', function(e) {
                    e.preventDefault(); // Prevent the default form submission

                    // Perform your AJAX request here
                    $.ajax({
                        url: '/purchase/validate-goodreceivenote',
                        type: 'post',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            console.log('Response:', response);
                            if (response.valid) {
                                console.log('Before form submission');
                                $('#save-goodreceivenote-form')[0].submit();
                                console.log('After form submission');
                            } else {
                                $('#validation-message').text(response.message);
                                $('#validation-message').show();
                            }

                        },
                        error: function(xhr, status, error) {
                            // $('#validation-message').html(xhr.responseJSON.message);

                            $('.wrapper').append(
                                ` <div class="alert alert-danger">
                        <div>
                            <div class="d-flex">
                                <i class="fas fa-frown me-2 my-custom-icon" style="font-size: 40px;padding-right:2px;color:orange;"></i>
                                <span class="mt-1 validationError">${xhr.responseJSON.message}</span>
                            </div>
                        </div>
                    </div>
                    <style>
                        .alert{
                            position: absolute;
                            background: white;
                            width: 290px;
                            padding: 40px;
                            box-shadow: 5px 5px 5px rgba(128, 128, 128, 0.5);
                            top: 10px;
                            right: 10px;
                        }
                        .icon-sm {
                            font-size: 106px !important;
                        }
                        .validationError{
                            font-weight:900;
                            color:#2f2f2f;
                            letter-spacing:2px;
                        }
                    </style>
                    `
                            );
                            $('.alert').delay(5000).slideUp(300)
                            $('.alert').delay(50000).slideUp(300, function() {
                                $('.alert').attr('style', 'display:none')
                            })
                        }
                    });
                });
            });

          
        </script>
    @endpush
</x-layouts.app>
