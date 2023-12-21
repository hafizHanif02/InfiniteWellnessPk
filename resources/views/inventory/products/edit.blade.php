<x-layouts.app title="Edit Product">
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Edit Product</h3>
                <a href="{{ route('inventory.products.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form id="save-product-form" action="{{ route('inventory.products.update', $product->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-5">
                                <label for="code" class="form-label">Code <sup class="text-danger">*</sup></label>
                                <input type="number" name="code" id="code" required class="form-control"
                                    value="{{ $product->id }}" readonly title="Unique Code">
                                @error('code')
                                    <div class="text-danger">{{ $code }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="mb-5">
                                <label for="product_category_id" class="form-label">Product Category<sup
                                        class="text-danger">*</sup></label>
                                <select type="text" name="product_category_id" id="product_category_id" required
                                    class="form-control @error('product_category_id') is-invalid @enderror">
                                    <option value="" selected disabled>Select category</option>
                                    @forelse ($productCategories as $productCategory)
                                        <option value="{{ $productCategory->id }}"
                                            {{ old('product_category_id', $productCategory->id) == $product->product_category_id ? 'selected' : '' }}>
                                            {{ $productCategory->name }}
                                        </option>
                                    @empty
                                        <option value="" id="no-product-category-found" class="text-danger"
                                            disabled>No product category
                                            found!</option>
                                    @endforelse
                                </select>
                                @error('product_category_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-1 mt-5">
                            <div class="mt-3"></div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#groupCreateModal">Add</button>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="product_name" class="form-label">Product Name <sup
                                class="text-danger">*</sup></label>
                        <input type="text" name="product_name" id="product_name" class="form-control"
                            value="{{ old('product_name', $product->product_name) }}" title="Product name">
                        @error('product_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="dricetion_of_use" class="form-label">Dricetion Of Use <sup
                                class="text-danger">*</sup></label>
                        <input type="text" name="dricetion_of_use" id="dricetion_of_use" class="form-control"
                            value="{{ old('dricetion_of_use', $product->dricetion_of_use) }}" title="dricetion_of_use">
                        @error('dricetion_of_use')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="common_side_effect" class="form-label">Common Side Effect <sup
                                class="text-danger">*</sup></label>
                        <input type="text" name="common_side_effect" id="common_side_effect" class="form-control"
                            value="{{ old('common_side_effect', $product->common_side_effect) }}"
                            title="common_side_effect">
                        @error('common_side_effect')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="generic_id" class="form-label">Generic <sup class="text-danger">*</sup></label>
                        <div class="row">
                            <div class="col-md-11">
                                <select name="generic_id" id="generic_id" required
                                    class="form-control @error('generic_id') is-invalid @enderror">
                                    <option value="" selected disabled>Select Generic</option>
                                    @forelse ($generics as $generic)
                                        <option value="{{ $generic->id }}"
                                            {{ old('generic_id', $product->generic_id) == $generic->id ? 'selected' : '' }}>
                                            {{ $generic->formula }}</option>
                                    @empty
                                        <option value="" id="no-formula-found" class="text-danger" disabled>No
                                            formula found!</option>
                                    @endforelse
                                </select>
                                @error('generic_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#genericCreateModal">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="package_detail" class="form-label">Package Detail </label>
                        <textarea type="text" name="package_detail" id="package_detail" class="form-control" title="Package detail">{{ old('package_detail', $product->package_detail) }}</textarea>
                        @error('package_detail')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="dosage_id" class="form-label">Dosage <sup class="text-danger">*</sup></label>
                        <div class="row">
                            <div class="col-md-11">
                                <select type="text" name="dosage_id" id="dosage_id"
                                    class="form-control @error('dosage_id') is-invalid @enderror">
                                    <option value="" selected disabled>Select Dosage </option>
                                    @forelse ($dosages as $dosage)
                                        <option value="{{ $dosage->id }}"
                                            {{ old('dosage_id', $dosage->id) == $product->dosage_id ? 'selected' : '' }}>
                                            {{ $dosage->name }}</option>
                                    @empty
                                        <option value="" id="no-dosage-found" class="text-danger" disabled>No
                                            Dosage found!</option>
                                    @endforelse
                                </select>
                                @error('dosage_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#categoryCreateModal">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="manufacturer_id" class="form-label">Manufacturer <sup
                                class="text-danger">*</sup></label>
                        <div class="row">
                            <div class="col-md-11">
                                <select name="manufacturer_id" id="manufacturer_id" class="form-control"
                                    title="Manufacturer">
                                    <option value="" selected disabled>Select manufacturer</option>
                                    @forelse ($manufacturers as $manufacturer)
                                        <option value="{{ $manufacturer->id }}"
                                            {{ old('manufacturer_id', $product->manufacturer_id) == $manufacturer->id ? 'selected' : '' }}>
                                            {{ $manufacturer->company_name }}</option>
                                    @empty
                                        <option value="" id="no-manufacturer-found" class="text-danger"
                                            disabled>No manufacturer found!
                                        </option>
                                    @endforelse
                                </select>
                                @error('manufacturer')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#manufacturerCreateModal">Add</button>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="mb-5">
                        <label for="vendor_id" class="form-label">Vendor <sup class="text-danger">*</sup></label>
                        <div class="row">
                            <div class="col-md-11">
                                <select name="vendor_id" required id="vendor_id" class="form-control" title="Vendor">
                                    <option value="" selected disabled>Select vendor</option>
                                    @forelse ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}"
                                            {{ old('vendor_id', $product->vendor_id) == $vendor->id ? 'selected' : '' }}>
                                            {{ $vendor->contact_person }}</option>
                                    @empty
                                        <option value="" id="no-vendor-found" class="text-danger" disabled>No
                                            manufacturer found!
                                        </option>
                                    @endforelse
                                </select>
                                @error('manufacturer')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#vendorCreateModal">Add</button>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="row">
                        <div class="col-md-9">
                            <div class="mb-5">
                                <label for="unit_of_measurement" class="form-label">Unit Of Measurement <sup
                                        class="text-danger">*</sup></label>
                                <select type="text" name="unit_of_measurement" id="unit_of_measurement" class="form-control"
                                    title="Least unit">
                                    <option value="" selected disabled>Select Unit</option>
                                    <option value="1"
                                        {{ old('unit_of_measurement', $product->unit_of_measurement) == 1 ? 'selected' : '' }}>
                                        Unit</option>
                                    <option value="0"
                                        {{ old('unit_of_measurement', $product->unit_of_measurement) == 0 ? 'selected' : '' }}>
                                        Box</option>
                                </select>
                                @error('unit_of_measurement')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="number_of_pack" class="form-label">Number of Pack<sup
                                    class="text-danger">*</sup></label>
                            <input type="text"  name="number_of_pack" id="number_of_pack"
                                class="form-control" onkeyup="calculation()" value="{{ old('number_of_pack', $product->number_of_pack) }}"
                                title="Number of packet">
                            @error('number_of_pack')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
                    <input type="hidden" value="1" name="unit_of_measurement" id="unit_of_measurement"
                        class="form-control" title="Least unit">
                    <input type="hidden" name="number_of_pack" id="number_of_pack" class="form-control"
                        value="1" title="Number of packet">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="manufacturer_retail_price" class="form-label">Manufacturer Retail Price
                                    <sup class="text-danger">*</sup></label>
                                <input type="number" oninput="calculation()" step="any"
                                    name="manufacturer_retail_price" id="manufacturer_retail_price" required
                                    class="form-control"
                                    value="{{ old('manufacturer_retail_price', $product->manufacturer_retail_price) }}"
                                    title="Retail Price">
                                @error('manufacturer_retail_price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="pieces_per_pack" class="form-label">Pieces Per Pack <sup
                                        class="text-danger">*</sup></label>
                                <input type="number" oninput="calculation()" name="pieces_per_pack"
                                    id="pieces_per_pack" class="form-control"
                                    value="{{ old('pieces_per_pack', $product->pieces_per_pack) }}"
                                    title="Pieces per pack">
                                @error('pieces_per_pack')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="total_quantity" class="form-label"></label>
                                <input type="hidden" oninput="calculation()" name="total_quantity"
                                    id="total_quantity" class="form-control" readonly
                                    value="{{ old('total_quantity', $product->total_quantity) }}" title="Paking">
                                @error('total_quantity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="trade_price_percentage" class="form-label">Trade Price % <sup
                                        class="text-danger">*</sup></label>
                                <input type="number" oninput="calculation()" name="trade_price_percentage"
                                    id="trade_price_percentage" class="form-control"
                                    value="{{ old('trade_price_percentage', $product->trade_price_percentage) }}"
                                    title="Trade price percentage">
                                @error('trade_price_percentage')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="unit_retail" class="form-label">Unit Retail <sup
                                        class="text-danger">*</sup></label>
                                <input type="number" name="unit_retail" id="unit_retail" class="form-control"
                                    value="{{ old('unit_retail', $product->unit_retail) }}" readonly>
                                @error('unit_retail')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-5">
                                <label for="fixed_discount" class="form-label">Fixed Discount</label>
                                <input type="number" name="fixed_discount" id="fixed_discount" class="form-control"
                                    value="{{ old('fixed_discount', $product->fixed_discount) }}"
                                    placeholder="Enter fix discount" title="Fixed discount">
                                @error('fixed_discount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-5">
                                <label for="fixed_discount" class="form-label">Discount Amount</label>
                                <input type="number" min="1" name="discount_amount" id="discount_amount"
                                    class="form-control @error('fixed_discount') is-invalid @enderror"
                                    value="{{ old('discount_amount', ($product->fixed_discount / 100) * $product->cost_price) }}"
                                    title="Discount Amount" readonly>
                                @error('fixed_discount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="trade_price" class="form-label">Trade Price <sup
                                        class="text-danger">*</sup></label>
                                <input type="number" oninput="calculation()" name="trade_price" id="trade_price"
                                    class="form-control" readonly
                                    value="{{ old('trade_price', $product->trade_price) }}" title="Trade price">
                                @error('trade_price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="unit_trade" class="form-label">Unit Trade <sup
                                        class="text-danger">*</sup></label>
                                <input type="number" name="unit_trade" id="unit_trade" class="form-control"
                                    readonly value="{{ old('unit_trade', $product->unit_trade) }}"
                                    placeholder="Unit trade" title="Unit trade">
                                @error('unit_trade')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="sale_tax_percentage" class="form-label">Sale Tax Percentage</label>
                                <input type="number" name="sale_tax_percentage" id="sale_tax_percentage"
                                    class="form-control" placeholder="Enter Sales Tax"
                                    value="{{ old('sale_tax_percentage', $product->sale_tax_percentage) }}"
                                    title="Sales tax">
                                @error('sale_tax_percentage')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="discount_trade_price" class="form-label">Discount % On Trade Price</label>
                                <input type="number" name="discount_trade_price" id="discount_trade_price"
                                    class="form-control" oninput="calculation()"
                                    placeholder="Enter discount percentage on trade price"
                                    value="{{ old('discount_trade_price', $product->discount_trade_price) }}"
                                    placeholder="Enter discount percentage on trade price"
                                    title="Discount percentage on trade price">
                                @error('discount_trade_price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="cost_price" class="form-label">Cost Price <sup
                                        class="text-danger">*</sup></label>
                                <input type="number" oninput="calculation()" name="cost_price" id="cost_price"
                                    class="form-control" readonly
                                    value="{{ old('cost_price', $product->cost_price) }}" placeholder="Cost price"
                                    title="Cost price">
                                @error('cost_price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="barcode" class="form-label">Barcode</label>
                                <input type="text" name="barcode" id="barcode" class="form-control"
                                    value="{{ old('barcode', $product->barcode) }}" placeholder="Enter barcode"
                                    title="Barcode">
                                @error('barcode')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <a href="{{ route('inventory.products.index') }}" class="btn btn-danger">Cancel</a>
                        <button type="button" id="save-product-button" class="btn btn-primary ms-3">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                calculation();
                $("#fixed_discount").on('keyup', function() {
                    var fixed_discount = $("#fixed_discount").val();
                    var cost_price = $("#cost_price").val();

                    var percentage = (fixed_discount / 100) * cost_price;
                    $("#discount_amount").val(percentage);
                });

                // Capture the key press event on all input fields within the form
                $('form').on('keypress', 'input', function(e) {
                    if (e.which === 13) { // 13 is the key code for "Enter"
                        e.preventDefault(); // Prevent the default form submission
                    }
                });


                $('#group_id, #product_category_id, #manufacturer_id, #vendor_id, #generic_id').select2();
            });
            // $("#trade_price_percentage").on('keyup change', function() {
            //     var retailPrice = parseFloat($("#manufacturer_retail_price").val());
            //     if ($("#manufacturer_retail_price").val() != '') {
            //         var tp = parseFloat($(this).val());
            //         var calc = parseFloat(retailPrice - (retailPrice * tp / 100));
            //         $("#trade_price").val(calc);
            //     }
            // });

            // $("#pieces_per_pack").on('keyup change', function() {

            //     var pcsperpack = parseInt($(this).val());
            //     var noofpack = parseInt($('#number_of_pack').val());

            //     var retailPrice = parseFloat($("#manufacturer_retail_price").val());
            //     totaltotal_quantity = parseInt(pcsperpack * noofpack);

            //     var retailpriceperunit = parseFloat(retailPrice / totaltotal_quantity);
            //     $("#unit_retail").val(retailpriceperunit);

            //     var tradeprice = parseFloat($("#trade_price").val());

            //     var tradepriceperunit = parseFloat(tradeprice / totaltotal_quantity);
            //     $("#unit_trade").val(tradepriceperunit);

            //     $("#total_quantity").val(noofpack * pcsperpack)
            // })

            // $("#discount_trade_price").on('keyup change', function() {

            //     var discperc = parseInt($(this).val());
            //     var tradeprice = parseFloat($("#trade_price").val());
            //     var calc = tradeprice - (tradeprice * discperc / 100);

            //     $("#cost_price").val(calc);

            // })

            // $('#unit_of_measurement').change(function() {
            //     if ($(this).val() === '0') {
            //         // Box
            //         $('#number_of_pack').prop('readonly', false);
            //     } else if ($(this).val() === '1') {
            //         // Unit
            //         $('#number_of_pack').prop('readonly', true);
            //         $("#number_of_pack").val(1);
            //     }
            // });


            // var unit_of_measurement = $('#unit_of_measurement').val();
            // if(unit_of_measurement == 0){
            //     $('#number_of_pack').prop('readonly', false);
            // }
            // else if(unit_of_measurement == 1){
            //     $('#number_of_pack').prop('readonly', true);
            // }

            $('#save-product-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#save-product-form').submit();
            });





            function calculation() {
                var retailPrice = parseFloat($("#manufacturer_retail_price").val());
                // if ($("#manufacturer_retail_price").val() != '') {
                    var tp = parseFloat($("#trade_price_percentage").val());
                    var calc = parseFloat(retailPrice - (retailPrice * tp / 100));
                    $("#trade_price").val(calc);
                    var pcsperpack = parseInt($("#pieces_per_pack").val());
                    var noofpack = parseInt($('#number_of_pack').val());
                    var retailPrice = parseFloat($("#manufacturer_retail_price").val());
                    totaltotal_quantity = parseInt(pcsperpack * noofpack);
                    var retailpriceperunit = parseFloat(retailPrice / totaltotal_quantity);
                    $("#unit_retail").val(retailpriceperunit);
                    var tradeprice = parseFloat($("#trade_price").val());
                    var tradepriceperunit = parseFloat(tradeprice / totaltotal_quantity);
                    tradepriceperunit = parseFloat(tradepriceperunit).toFixed(2);
                    $("#unit_trade").val(tradepriceperunit);
                    $("#trade_price").val(tradepriceperunit);
                    $("#total_quantity").val(noofpack * pcsperpack);

                    var discperc = $("#discount_trade_price").val();
                    var tradeprice = parseFloat($("#trade_price").val());
                    var calc = tradeprice - (tradeprice * discperc / 100);
                    calc = parseFloat(calc).toFixed(2);
                    $("#cost_price").val(calc);

                    if ($('#unit_of_measurement').val() === '0') {
                        // Box
                        $('#number_of_pack').prop('readonly', false);
                    } else if ($('#unit_of_measurement').val() === '1') {
                        // Unit
                        $('#number_of_pack').prop('readonly', true);
                        $("#number_of_pack").val(1);
                    }

                    // Fixed Discount Amount Set
                    var fixed_discount = $("#fixed_discount").val();
                    var cost_price = $("#cost_price").val();
                    var percentage = (fixed_discount / 100) * cost_price;
                    $("#discount_amount").val(percentage);
                    // Fixed Discount Amount Set

                // }
            }
        </script>
    @endpush

    @include('inventory.product-categories.model.create_modal')
    @include('inventory.products.generic_modal.create_modal')
    @include('inventory.dosages.model.create_modal')
    @include('inventory.manufacturers.model.create_modal')
    @include('inventory.vendor.modal.create_modal')
</x-layouts.app>
