<x-layouts.app title="New Product">
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Add New Product</h3>
                <a href="{{ route('inventory.products.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form id="save-product-form" action="{{ route('inventory.products.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-5">
                                <label for="product_id" class="form-label">ID <sup class="text-danger">*</sup></label>
                                <input type="number" name="product_id" id="product_id" required
                                    class="form-control"
                                    value="{{ ($product_id ? $product_id : 1010) + 1 }}" title="Unique ID" readonly>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="mb-5">
                                <label for="product_category_id" class="form-label">Product Category<sup class="text-danger">*</sup></label>
                                <select type="text" name="product_category_id" id="product_category_id" required
                                    class="form-control @error('product_category_id') is-invalid @enderror">
                                    <option value="" selected disabled>Select category</option>
                                    @forelse ($productCategories as $productCategory)
                                        <option value="{{ $productCategory->id }}"
                                            {{ old('product_category_id') == $productCategory->id ? 'selected' : '' }}>{{ $productCategory->name }}
                                        </option>
                                    @empty
                                        <option value="" id="no-product-category-found" class="text-danger" disabled>No product category
                                            found!</option>
                                    @endforelse
                                </select>
                                @error('product_category_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-1 mt-5">
                            <div class="mt-2"></div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#ProductCategoriesCreateModal">Add</button>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="product_name" class="form-label">Product Name <sup
                                class="text-danger">*</sup></label>
                        <input type="text" name="product_name" id="product_name"
                            class="form-control @error('product_name') is-invalid @enderror"
                            placeholder="Enter product name" value="{{ old('product_name') }}" title="Product">
                        @error('product_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="generic_id" class="form-label">Generic Formula <sup class="text-danger">*</sup></label>
                        <div class="row">
                            <div class="col-md-11">
                                <select name="generic_id" id="generic_id" required
                                    class="form-control @error('generic_id') is-invalid @enderror">
                                    <option value="" selected disabled>Select Generic Formula</option>
                                    @forelse ($generics as $generic)
                                        <option value="{{ $generic->id }}"
                                            {{ old('generic_id') == $generic->id ? 'selected' : '' }}>
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
                        <textarea type="text" name="package_detail" id="package_detail"
                            class="form-control @error('package_detail') is-invalid @enderror" placeholder="Enter package detail"
                            title="Package details">{{ old('package_detail') }}</textarea>
                        @error('package_detail')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="dosage_id" class="form-label">Dosage Form <sup
                                class="text-danger">*</sup></label>
                        <div class="row">
                            <div class="col-md-11">
                                <select type="text" name="dosage_id" id="dosage_id"
                                    class="form-control @error('dosage_id') is-invalid @enderror">
                                    <option value="" selected disabled>Select Dosage Form </option>
                                    @forelse ($dosages as $dosage)
                                        <option value="{{ $dosage->id }}"
                                            {{ old('dosage_id') == $dosage->id ? 'selected' : '' }}>
                                            {{ $dosage->name }}</option>
                                    @empty
                                        <option value="" id="no-dosage-found" class="text-danger" disabled>No
                                            Dosage form found!</option>
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
                                <select name="manufacturer_id" id="manufacturer_id"
                                    class="form-control @error('manufacturer_id') is-invalid @enderror">
                                    <option value="" selected disabled>Select manufacturer</option>
                                    @forelse ($manufacturers as $manufacturer)
                                        <option value="{{ $manufacturer->id }}"
                                            {{ old('manufacturer_id') == $manufacturer->id ? 'selected' : '' }}>
                                            {{ $manufacturer->company_name }}</option>
                                    @empty
                                        <option value="" id="no-manufacturer-found" class="text-danger"
                                            disabled>No manufacturer found!
                                        </option>
                                    @endforelse
                                </select>
                                @error('manufacturer_id')
                                    <small class="text-danger">{{ $message }}</small>
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
                                <select name="vendor_id" id="vendor_id" required
                                    class="form-control @error('vendor_id') is-invalid @enderror">
                                    <option value="" selected disabled>Select Vendor</option>
                                    @forelse ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}"
                                            {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                            {{ $vendor->contact_person }}</option>
                                    @empty
                                        <option value="" id="no-vendor-found" class="text-danger" disabled>No
                                            vendor found!
                                        </option>
                                    @endforelse
                                </select>
                                @error('vendor_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#vendorCreateModal">Add</button>
                            </div>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-md-9">
                            <div class="mb-5">
                                <label for="unit_of_measurement" class="form-label">Unit Of Measurement <sup
                                        class="text-danger">*</sup></label>
                                <select type="text" onchange="unit_of_measurement()" name="unit_of_measurement" id="unit_of_measurement"
                                    class="form-control @error('unit_of_measurement') is-invalid @enderror" title="Unit of measurement">
                                    {{-- <option value="" selected disabled>Select Unit</option> --}}
                                    <option value="1" {{ old('unit_of_measurement') == '1' ? 'selected' : '' }}>Unit Qty
                                    </option>
                                    <option value="0" {{ old('unit_of_measurement') == '0' ? 'selected' : '' }}>Box Qty
                                    </option>
                                </select>
                                @error('unit_of_measurement')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="number_of_pack" class="form-label">Number of Pack<sup
                                    class="text-danger">*</sup></label>
                            <input type="number" readonly value="1" onkeyup="calculation()" name="number_of_pack" id="number_of_pack"
                                class="form-control @error('number_of_pack') is-invalid @enderror"
                                placeholder="Select Unit Of Measurement First" value="{{ old('number_of_pack') }}"
                                title="Number of packet">
                            @error('number_of_pack')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="manufacturer_retail_price" class="form-label">Manufacturer Retail Price
                                    <sup class="text-danger">*</sup></label>
                                <input type="number" step="any" min="1" name="manufacturer_retail_price" required
                                    id="manufacturer_retail_price" onkeyup="calculation()"
                                    class="form-control @error('manufacturer_retail_price') is-invalid @enderror"
                                    placeholder="Enter manufacture retail price"
                                    value="{{ old('manufacturer_retail_price') }}" title="Manufacturer retail price">
                                @error('manufacturer_retail_price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="pieces_per_pack" class="form-label">Pieces Per Pack <sup
                                        class="text-danger">*</sup></label>
                                <input type="number" min="1" onkeyup="calculation()" name="pieces_per_pack" onkeyup="pieces_per_pack()" id="pieces_per_pack"
                                    class="form-control @error('pieces_per_pack') is-invalid @enderror"
                                    placeholder="Enter pieces per packet" value="{{ old('pieces_per_pack') }}"
                                    title="Pieces per pack">
                                @error('pieces_per_pack')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4" >
                            <div class="mb-5">
                                <label for="total_quantity" class="form-label"></label>
                                <input type="hidden" name="total_quantity" id="total_quantity"
                                    class="form-control @error('total_quantity') is-invalid @enderror" readonly
                                    value="{{ old('total_quantity') }}" title="total_quantity">
                                @error('total_quantity')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="trade_price_percentage" class="form-label">Trade Price % <sup
                                        class="text-danger">*</sup></label>
                                <input type="number" min="1" name="trade_price_percentage"
                                    id="trade_price_percentage" onkeyup="calculation()"
                                    class="form-control @error('trade_price_percentage') is-invalid @enderror"
                                    placeholder="Enter trade price %" onkeyup="trade_price_percentage()" value="{{ old('trade_price_percentage') }}"
                                    title="Trade price percentage">
                                @error('trade_price_percentage')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="unit_retail" class="form-label">Unit Retail <sup
                                        class="text-danger">*</sup></label>
                                <input type="number" name="unit_retail" id="unit_retail"
                                    class="form-control @error('unit_retail') is-invalid @enderror"
                                    value="{{ old('unit_retail') }}" readonly title="Unit retail">
                                @error('unit_retail')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="fixed_discount" class="form-label">Fixed Discount</label>
                                <input type="number" min="1" name="fixed_discount" id="fixed_discount"
                                    class="form-control @error('fixed_discount') is-invalid @enderror"
                                    value="{{ old('fixed_discount') }}" placeholder="Enter fixed discount"
                                    title="Fixed discount">
                                @error('fixed_discount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="trade_price" class="form-label">Trade Price <sup
                                        class="text-danger">*</sup></label>
                                <input type="number" min="1" name="trade_price" id="trade_price"
                                    class="form-control @error('trade_price') is-invalid @enderror" readonly
                                    value="{{ old('trade_price') }}" title="Trade price">
                                @error('trade_price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="unit_trade" class="form-label">Unit Trade <sup
                                        class="text-danger">*</sup></label>
                                <input type="number" name="unit_trade" id="unit_trade"
                                    class="form-control @error('unit_trade') is-invalid @enderror" readonly
                                    value="{{ old('unit_trade') }}" title="Unit trade">
                                @error('unit_trade')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="sale_tax_percentage" class="form-label">Sales Tax Percentage</label>
                                <input type="number" min="1" name="sale_tax_percentage" id="sale_tax_percentage"
                                    class="form-control @error('sale_tax_percentage') is-invalid @enderror"
                                    placeholder="Enter Sales Tax in Percentage" value="{{ old('sale_tax_percentage') }}" title="Sales tax">
                                @error('sale_tax_percentage')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="discount_trade_price" class="form-label">Discount % On Trade Price</label>
                                <input type="number"  name="discount_trade_price"
                                    id="discount_trade_price" onkeyup="calculation()"
                                    class="form-control @error('discount_trade_price') is-invalid @enderror"
                                    placeholder="Enter discount percentage on trade price"
                                    value="{{ old('discount_trade_price') }}" title="Discount trade price">
                                @error('discount_trade_price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="cost_price" class="form-label">Cost Price <sup
                                        class="text-danger">*</sup></label>
                                <input type="number" name="cost_price" id="cost_price"
                                    class="form-control @error('cost_price') is-invalid @enderror" readonly
                                    value="{{ old('cost_price') }}" title="Cost price">
                                @error('cost_price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-5">
                                <label for="barcode" class="form-label">Barcode</label>
                                <input type="text" min="1" name="barcode" id="barcode"
                                    class="form-control @error('barcode') is-invalid @enderror"
                                    placeholder="Enter barcode" value="{{ old('barcode') }}" title="Barcode">
                                @error('barcode')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <a href="{{ route('inventory.products.index') }}" class="btn btn-danger">Cancel</a>
                        <button type="button" class="btn btn-primary ms-3" id="save-product-button">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {

            // Capture the key press event on all input fields within the form
              $('form').on('keypress', 'input', function(e) {
                if (e.which === 13) { // 13 is the key code for "Enter"
                  e.preventDefault(); // Prevent the default form submission
                }
              }); 


                $('#product_category_id, #dosage_id, #manufacturer_id, #vendor_id, #generic_id').select2();
            });



            $('#save-product-button').on('click', function() {
                $(this).prop('disabled', true);
                $('#save-product-form').submit();
            });



            function calculation(){
                var retailPrice = parseFloat($("#manufacturer_retail_price").val());
                if ($("#manufacturer_retail_price").val() != '') {
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
                $("#unit_trade").val(tradepriceperunit);
                $("#total_quantity").val(noofpack * pcsperpack);

                var discperc = parseInt($("#discount_trade_price").val());
                var tradeprice = parseFloat($("#trade_price").val());
                var calc = tradeprice - (tradeprice * discperc / 100);
                $("#cost_price").val(calc);

                 if ($('#unit_of_measurement').val() === '0') {
                    // Box
                    $('#number_of_pack').prop('readonly', false);
                } else if ($('#unit_of_measurement').val() === '1') {
                    // Unit
                    $('#number_of_pack').prop('readonly', true);
                    $("#number_of_pack").val(1);
                }

                }
            }

        </script>
    @endpush
    @include('inventory.product-categories.model.create_modal')
    @include('inventory.products.generic_modal.create_modal')
    @include('inventory.dosages.model.create_modal')
    @include('inventory.manufacturers.model.create_modal')
    @include('inventory.vendor.modal.create_modal')

</x-layouts.app>
