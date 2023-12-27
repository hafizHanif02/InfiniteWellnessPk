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
                            <label for="invoice_number" class="form-label">Invoice Number <sup
                                    class="text-danger">*</sup></label>
                            <input type="text" name="invoice_number"
                                value="{{ old('invoice_number', $goodReceiveNote->invoice_number) }}"
                                id="invoice_number" class="form-control" required>
                            @error('invoice_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="form-label">Invoice Date <sup
                                class="text-danger">*</sup></label>
                        <input type="date" name="invoice_date" id="date" required class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label for="grn_no" class="form-label">Code <sup class="text-danger ">*</sup></label>
                            <input type="number" readonly name="grn_no" value="{{ $goodReceiveNote->id }}"
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
                                    <option value="{{ $goodReceiveNote->requistion_id }}" selected>
                                        {{ $goodReceiveNote->requistion->id }}</option>
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
                                    <tr>
                                        <td style="min-width: 100px"></td>
                                        <td style="min-width: 200px">Product</td>
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
                                    {{-- {{ dd($goodReceiveNote) }} --}}


                                    @forelse ($goodReceiveNote->goodReceiveProducts as $goodReceiveProduct)
                                        {{-- {{ dd($goodReceiveProduct) }} --}}
                                        <tr id="{{ $goodReceiveProduct->product_id }}">
                                            <td>
                                                <input type="checkbox" name="products[{{ $loop->iteration }}][id]"
                                                    value="{{ $goodReceiveProduct->product_id }}"
                                                    class="form-check-input" checked>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    title="{{ $goodReceiveProduct->product->product_name }}"
                                                    value="{{ $goodReceiveProduct->product->product_name }}" readonly>
                                            </td>

                                            <td>
                                                <input type="number" class="form-control"
                                                    id="totalquantity{{ $loop->iteration }}"
                                                    value="{{ $goodReceiveProduct->requistionProduct->total_piece }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                {{-- ${requistionProduct.product.least_unit == 1 ? `<input type="number" id="changequantity${requistionProduct.id}"  value="${(requistionProduct.total_piece)-1}" class="form-control" readonly>` : `<input type="number" id="changequantity${requistionProduct.id}"  value="${(requistionProduct.total_piece)-1}" class="form-control" readonly>`  } --}}
                                                @if ($goodReceiveProduct->product->least_unit == 1)
                                                    <input type="number" id="changequantity{{ $loop->iteration }}"
                                                        value="{{ $goodReceiveProduct->requistionProduct->total_piece - $goodReceiveProduct->deliver_qty }}"
                                                        class="form-control" readonly>
                                                @else
                                                    <input type="number" id="changequantity{{ $loop->iteration }}"
                                                        value="{{ $goodReceiveProduct->requistionProduct->total_piece - $goodReceiveProduct->deliver_qty }}"
                                                        class="form-control" readonly>
                                                @endif

                                            </td>
                                            <td>
                                                <input type="number" min="0"
                                                    name="products[{{ $loop->iteration }}][deliver_qty]"
                                                    value={{ $goodReceiveProduct->deliver_qty }}
                                                    id="minusquantity{{ $loop->iteration }}"
                                                    oninput="changeQuantity({{ $loop->iteration }})"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" min="0"
                                                    name="products[{{ $loop->iteration }}][discount]"
                                                    oninput="discountPerc({{ $loop->iteration }})"
                                                    id="discount{{ $loop->iteration }}"
                                                    value="{{ $goodReceiveProduct->discount }}" class="form-control">
                                                <input type="hidden" readonly
                                                    name="products[{{ $loop->iteration }}][discount_amount]"
                                                    id="discount_amount{{ $loop->iteration }}"
                                                    value="{{ $goodReceiveProduct->discount }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" min="0"
                                                    name="products[{{ $loop->iteration }}][saletax_percentage]"
                                                    oninput="saletaxPerc({{ $loop->iteration }})"
                                                    id="saletax{{ $loop->iteration }}"
                                                    value="{{ $goodReceiveProduct->saletax_percentage }}"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" readonly
                                                    name="products[{{ $loop->iteration }}][saletax_amount]"
                                                    id="saletax_amount{{ $loop->iteration }}"
                                                    value="{{ $goodReceiveProduct->saletax_amount }}"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" name="products[{{ $loop->iteration }}][bonus]"
                                                    value="{{ $goodReceiveProduct->bonus }}" min="0"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <input type="date"
                                                    name="products[{{ $loop->iteration }}][expiry_date]"
                                                    value="{{ $goodReceiveProduct->expiry_date }}"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <input type="text"
                                                    name="products[{{ $loop->iteration }}][batch_no]"
                                                    value="{{ $goodReceiveProduct->batch_number }}"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" id="price_per_unit{{ $loop->iteration }}"
                                                    name="products[{{ $loop->iteration }}][totalprice2]"
                                                    value="{{ $goodReceiveProduct->requistionProduct->price_per_unit }}"
                                                    class="form-control" readonly>
                                            </td>
                                            <td>
                                                <input type="number" id="manufacturer_retail_price{{ $loop->iteration }}"
                                                    name="products[{{ $loop->iteration }}][manufacturer_retail_price]"
                                                    value="{{ $goodReceiveProduct->manufacturer_retail_price }}"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" id="totalprice2{{ $loop->iteration }}"
                                                    name="products[{{ $loop->iteration }}][totalprice]"
                                                    value="{{ $goodReceiveProduct->requistionProduct->total_amount / $goodReceiveProduct->requistionProduct->total_piece }}"
                                                    class="form-control" readonly>
                                                <input type="hidden"
                                                    id="totalpricefordiscount{{ $loop->iteration }}"
                                                    name="products[{{ $loop->iteration }}][totalpricefordiscount]"
                                                    value="{{ $goodReceiveProduct->requistionProduct->total_amount / $goodReceiveProduct->requistionProduct->total_piece }}"
                                                    class="form-control" readonly>
                                            </td>
                                        </tr>

                                        <input type="hidden" class="form-control"
                                            value="{{ $goodReceiveProduct->requistionProduct->disc }}" readonly>
                                        <input type="hidden"
                                            value="{{ $goodReceiveProduct->requistionProduct->sale_tax_percentage }}"
                                            class="form-control" readonly>
                                        <input type="hidden" class="form-control"
                                            value="{{ $goodReceiveProduct->requistionProduct->disc_amount }}"
                                            readonly>
                                        <input type="hidden" id="price_per_unit{{ $loop->iteration }}"
                                            value="{{ $goodReceiveProduct->requistionProduct->price_per_unit }}">
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="13" class="text-danger">No product found!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row mb-3 mt-3">
                            <div class="col-md-7">
                                <label for="totalcostwithtax" class="form-label">Total Amount</label>
                                <input type="number" readonly id="totalcostwithtax"
                                    value="{{ $goodReceiveNote->total_amount }}" placeholder="Total Amount"
                                    name="total_amount" class="form-control">
                                @error('totalcostwithtax')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <label for="total_discount_amount" class="form-label">Total Discount Amount</label>
                                <input type="number" readonly id="total_discount_amount" placeholder="Total Amount"
                                    name="total_discount_amount" class="form-control"
                                    value="{{ $goodReceiveNote->total_discount_amount }}">
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
                                    oninput="advanceTax()" placeholder="Advance Tax Percentage"
                                    name="advance_tax_percentage" class="form-control"
                                    value="{{ $goodReceiveNote->advance_tax_percentage }}">
                                @error('advance_tax_percentage')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <label for="advance_tax_percentage_amount" class="form-label">Advanced Tax
                                    Amount</label>
                                <input type="number" id="advance_tax_percentage_amount" name="advance_tax_amount"
                                    placeholder="Advance Tax Amount" readonly name="advance_tax_amount"
                                    class="form-control" value="{{ $goodReceiveNote->advance_tax_amount }}">
                                @error('advance_tax_amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="net_total_amountcost" class="form-label">Net Total Amount <sup
                                    class="text-danger">*</sup></label>
                            <input type="number" id="net_total_amountcosts2"
                                value="{{ $goodReceiveNote->net_total_amount }}" placeholder="Net Total Amount"
                                name="net_total_amount" readonly class="form-control">
                            <input type="hidden" id="net_total_amountcosts2">
                            <input type="hidden" id="net_total_amountcosts3">

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
            function changeQuantity(id) {
                var quantity = $("#minusquantity" + id).val();
                var totalquantity = $("#totalquantity" + id).val();
                var amount = $("#price_per_unit" + id).val();
                $('#totalprice2' + id).val(((amount) * (quantity)).toFixed(2));
                $('#totalpricefordiscount' + id).val((amount) * (quantity));
                $('#changequantity' + id).val(totalquantity - (quantity));
                calculateTotalAmount();
            }


            function saletaxPerc(id) {
                var Saletax_percentage = $('#saletax' + id).val();
                var total_cost_per_product = $('#totalprice2' + id).val();
                var Saletax_amount = (Saletax_percentage * total_cost_per_product) / 100;
                console.log('TOTAL DATA', id, Saletax_amount, total_cost_per_product);
                $('#saletax_amount' + id).val(Saletax_amount.toFixed(2));


                var amount = $('#totalpricefordiscount' + id).val();

                var amountwithtax = (parseFloat(amount) + parseFloat(Saletax_amount));
                $('#totalprice2' + id).val((parseFloat(amount) + parseFloat(Saletax_amount)).toFixed(2));
                calculateTotalAmount();
            }

            function calculateTotalAmount() {
                var totalAmount = 0;
                $("input[id^='totalprice2']").each(function() {

                    totalAmount += parseFloat($(this).val());

                });
                $("#total_amountcost").val(totalAmount);
                $('#net_total_amountcost').val(totalAmount);
                $("#totalcostwithtax").val(totalAmount.toFixed(2));

                // console.log(totalAmount);

                discountTotal();
            }

            $('#save-goodreceivenote-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#save-goodreceivenote-form').submit();
            });







            function advanceTax() {
                var totalAmount = parseFloat($('#totalcostwithtax').val());
                var totaldiscountamount = parseFloat($('#total_discount_amount').val());
                var advancetaxperc = parseFloat($('#advance_tax_percentage').val());
                // var totalcostwithouttax = parseFloat($('#net_total_amountcosts3').val());

                var totalamountwithdiscount = (totalAmount - totaldiscountamount).toFixed(2);
                var advanceTaxAmount = (parseFloat((advancetaxperc * totalamountwithdiscount) / 100)).toFixed(2);

                var totalAdvancewithTaxAmount = parseFloat(totalamountwithdiscount) + parseFloat(advanceTaxAmount);


                $('#advance_tax_percentage_amount').val(advanceTaxAmount);

                // var salesTaxAmount = (parseFloat((SaleTaxPercPerc * totalcostwithouttax) / 100)).toFixed(2);
                // $('#sales_taxamount').val(salesTaxAmount);

                var amountwithtax = (parseFloat(totalAmount) + parseFloat(advanceTaxAmount));
                $('#net_total_amountcosts2').val(totalAdvancewithTaxAmount.toFixed(2));
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

                var minusquantity = $('#minusquantity' + id).val();
                var amount = $("#price_per_unit" + id).val();
                var totalPrice = minusquantity * amount;
                var discountPer = $('#discount' + id).val();
                var numdiscountPer = Number(discountPer);
                // var total_cost_per_product = $('#totalprice2' + id).val();
                var discount_amount = (numdiscountPer * totalPrice) / 100;
                $('#discount_amount' + id).val(discount_amount)
                var amountwithdiscount = totalPrice - discount_amount;
                $('#totalprice2' + id).val(amountwithdiscount.toFixed(2));
                discountTotal();
                advanceTax();
            }

            function discountTotal() {
                var discount = 0;
                var discountnum = Number(discount);
                $("input[id^='discount_amount']").each(function() {
                    if ($(this).val() != '') {
                        discountnum += parseFloat($(this).val());
                    }
                });
                $('#total_discount_amount').val(discountnum.toFixed(2));
                var total_amount = $('#totalcostwithtax').val();
                var testNum = Number(total_amount);
                var amountwithdisc = Number(testNum - discountnum);
                var Totalamountwithdisc = amountwithdisc.toFixed(2).toString();
                console.log(amountwithdisc);


                $('#net_total_amountcost').val(Totalamountwithdisc);
                $('#net_total_amountcosts2').val(Totalamountwithdisc);
                $('#net_total_amountcosts3').val(Totalamountwithdisc);
                advanceTax();
            }
        </script>
    @endpush
</x-layouts.app>
