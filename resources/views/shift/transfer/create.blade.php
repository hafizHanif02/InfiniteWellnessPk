<x-layouts.app title="Shift Transfer Inventory Create">
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Shift Transfer Inventory</h3>
                <a href="{{ route('purchase.return.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="alert-container" style="display:none;">
                <div class="alert alert-danger">
                    <div>
                        <div class="d-flex">
                            <i class="fas fa-frown me-2 my-custom-icon"
                                style="font-size: 40px;padding-right:2px;color:orange;"></i>
                            <span class="validation-container"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form id="save-transfer-form" action="{{ route('shift.transfers.store') }}" method="POST">
                    @csrf
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label for="transfer_id" class="form-label">Code <sup class="text-danger">*</sup></label>
                            <input type="number" name="id" id="code"
                                class="form-control @error('code') is-invalid @enderror"
                                value="{{ ($transfer_id ? $transfer_id : 1010) + 1 }}" title="Unique Code" readonly>
                            @error('id')
                                <small class="text-danger">{{ $transfer_id }}</small>
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
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <label for="import-product" class="font-label mt-5 mb-2">Import Product</label>
                            <input type="file" id="import-product" name="import-product" class="form-control mb-5" placeholder="Import Product">
                        </div>
                    </div> --}}
                    {{-- <form id="csv-form" action="{{route('shift.import-excel') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <label for="import-product" class="font-label mt-5 mb-2">Import Product</label>
                    <input type="file" id="import-product" name="import-product" class="form-control mb-5" placeholder="Import Product">
                    <button type="submit" class="btn btn-secondary float-end mr-5 mb-3"
                        style="display: none;">button</button>
                    </form> --}}
                    <label for="import-product" class="font-label mt-5 mb-2">Import Product</label>
                    <input type="file" id="upload" class="form-control" />
                    <div class="row mb-5 mt-5">
                        <div class="col-md-12">
                            <label for="re_transfer_id" class="form-label">Re Transfer</label>
                            <select name="re_transfer_id" id="re_transfer_id" class="form-control">
                                <option value="" selected disabled>If You Want To Re-Transfer Any Same Request
                                </option>
                                @forelse ($transfers as $transfer)
                                    <option value="{{ $transfer->id }}">{{ $transfer->id }}
                                        ({{ $transfer->supply_date }})
                                    </option>
                                @empty
                                    <option value="" class="text-danger">no product found!</option>
                                @endforelse
                            </select>
                            @error('product_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    {{-- @foreach ($products as $product)
                    @if ($product->id == 2407)
                    {{dd($product->batch[0]) }}
                    @endif
                    @endforeach --}}
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
                                        <td style="min-width: 50px">#</td>
                                        <td style="min-width: 200px">Product</td>
                                        <td style="min-width: 200px">Batch</td>
                                        <td style="min-width: 200px">Total Stock</td>
                                        <td style="min-width: 200px">Unit of Measurement</td>
                                        <td style="min-width: 200px">Price Per Unit</td>
                                        <td style="min-width: 200px">Expiry Date</td>
                                        <td style="min-width: 200px">Total Piece</td>
                                        <td style="min-width: 200px">Total Pack</td>
                                        <td style="min-width: 200px">Amount</td>
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
                        <button type="button" id="save-transfer-button" class="btn btn-primary ms-3"
                            disabled>Save</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Excel to JSON Conversion</title>
    </head>

    <body>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
        <script>
            document.getElementById('upload').addEventListener('change', handleFile, false);

            function handleFile(e) {
                const files = e.target.files;
                if (!files || files.length === 0) return;

                const file = files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, {
                        type: 'array'
                    });
                    const sheetName = workbook.SheetNames[0];
                    const sheet = workbook.Sheets[sheetName];


                    const json = XLSX.utils.sheet_to_json(sheet);


                    var products = `<?php echo json_encode($products); ?>`;

                    products = JSON.parse(products);


                    var BreakException = {};

                    var isValid = true;

                    $(json).each(function(e, key) {
                        // console.log(key.code);
                        for (var i = 0; i < products.length; i++) {
                            // if(key.code == products[i].id){
                            //     console.log(key.code + ' == ' + products[i].id + ' => ' + products[i].total_quantity);
                            // }

                            if (products[i].id == key.code) {
                                if (key.quantity > 0) {
                                    var items = $("tbody tr").length;
                                    $("#add-products").append(`
                                    <tr id="${products[i].id}">
                                        <input type="hidden" name="products[${i}][id]" value="${products[i].id}">
                                        <td>${e}</td>
                                        <td>
                                            <input type="text" class="form-control" value="${products[i].product_name}" readonly>
                                        </td>
                                        <td>
                                            <select onchange="batchChange(${i},${products[i].id})" id="batch${i}" name="products[${i}][batch_no]" class="form-control batch1">
                                            ${products[i].batch.length != 0  ?
                                                `<option value="" selected disabled>Select Batch</option>
                                                                        ${products[i].batch.map(batch => {
                                                                            return `<option value="${batch.id}" class="highlight" 
                                                                data-batch-id="${batch.id}" 
                                                                data-quantity="${batch.quantity}" 
                                                                data-remaining_qty="${batch.remaining_qty}" 
                                                                data-expiry-date="${batch.expiry_date}"
                                                                data-unit_retail="${batch.unit_retail}"
                                                                data-unit_trade="${batch.unit_trade}">
                                                            ${batch.batch_no}
                                                            </option>`;
                                                                        }).join('')}` :
                                                `<option value="">Not Any Batch Found</option>`
                                            }
                                        </select>
                                        </td>
                                        <td>
                                            <input type="text" name="products[${i}][total_quantity]" id="totalquantity${i}" class="form-control" value="${products[i].total_quantity}" readonly>
                                        </td>
                                        <td>
                                            <select id="selectunit_of_measurement${i}" onchange="changeType(${products[i].id},${i})" name="products[${i}][unit_of_measurement]" class="form-control" required>
                                                <option value="1" selected >Unit Qty</option>
                                                <option value="0">Box Qty</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step="any" id="price_per_unit${i}" name="products[${i}][price_per_unit]" value="${products[i].unit_retail}" readonly  class="form-control">
                                            <input type="hidden" step="any" id="price_per_unit2${i}" name="products[${i}][price_per_unit2]" value="${products[i].unit_retail}" readonly  class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="products[${i}][expiry_date]" class="form-control" id="expiry_date${i}"  readonly>
                                        <td>
                                            <input type="number" value="1" id="totalpeice${i}" min="1" name="products[${i}][total_piece]" oninput="changeQuantityPerUnit(${products[i].id},${i})" class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" name="products[${i}][total_pack]" value="${products[i].number_of_pack}"  class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="products[${i}][amount]" id="importamount${i}" value="${products[i].unit_retail}" class="form-control" readonly>
                                        </td>
                                        <td>
                                            <i onclick="removeRaw(${products[i].id})" class="text-danger fa fa-trash"></i>
                                        </td>

                                        <input type="hidden" id="discountamount${products[i].id}" name="products[${i}][pieces_per_pack]" value="${products[i].pieces_per_pack }">
                                        <input type="hidden" id="discountamount${products[i].id}" name="products[${i}][price_per_unit_unitonly]" value="${products[i].unit_retail }">
                                        <input type="hidden" id="forimportunitprice${i}"  value="${products[i].unit_retail }">
                                        <input type="hidden" id="discountamount${products[i].id}" name="products[${i}][disc_amount]" value="${(products[i].discount_trade_price * products[i].cost_price)/100 }">
                                        <input type="hidden" id="tradeprice${products[i].id}" value="${products[i].trade_price}">
                                        <input type="hidden" id="total_peice_per_pack${i}" name="products[${i}][total_peice_per_pack]" value="${products[i].pieces_per_pack}">
                                        <input type="hidden" id="mainqunatityvalue${i}" name="products[${i}][mainqunatityvalue]" >
                                `);
                                    calculation(i);
                                    break;
                                } else {
                                    alert(`The following Item Code (${key.code}) has quantity is zero or less`);
                                }



                            } else {
                                if (i == (products.length - 1)) {
                                    isValid = false;
                                }

                            }
                        }
                    });

                    if (!isValid) {
                        alert('Not A Valid Excel Action');
                    }
                };

                reader.readAsArrayBuffer(file);
            }

            function calculation(i) {
                var totalPeice = $('#totalpeice' + i).val();
                var unitprice = $('#forimportunitprice' + i).val();
                $('#importamount' + i).val(totalPeice * unitprice);
            }

            //     $(document).ready(function() {
            //     $('#submit').prop('disabled', true);
            //     $('form input, form select, form textarea').on('input change', function() {
            //         console.log("first");
            //         if (                  
            //             $('id="batch{$id}"').val() !== '' &&                
            //         ) {
            //             $('#save-transfer-button').prop('disabled', false);
            //             console.log('if condition');
            //         } else {
            //             $('#save-transfer-button').prop('disabled', true);
            //             console.log('else condition');
            //         }
            //     });
            // });
        </script>
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#product_id, #requistion, #re_transfer_id').select2();
                });
                $("#add-btn").click(function(e) {
                    e.preventDefault();
                    addProduct();
                    $('.batch1').trigger('change');
                });

                function addProduct(type) {
                    $('.batch1').trigger('change');
                    var productId = $("#product_id").val();
                    if (productId != null && ($('#add-products tr#' + productId).length == 0)) {
                        $.ajax({
                            type: "get",
                            url: "/shift/transfer-products/" + productId,
                            success: function(response) {
                                console.log(response.product.batch);
                                var items = $("tbody tr").length;
                                $("#add-products").append(`
                                    <tr id="${response.product.id}">
                                        <input type="hidden" name="products[${items}][id]" value="${response.product.id}">
                                        <td>
                                            
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="${response.product.product_name}" readonly>
                                        </td>
                                        <td>
                                            <select onchange="batchChange(${items},${response.product.id})" id="batch${items}" name="products[${items}][batch_no]" class="form-control batch1">
                                            ${response.product.batch.length != 0  ?
                                                `<option value="" selected>Select Batch</option>
                                                                                    ${response.product.batch.map(batch => {
                                                                                        return `<option value="${batch.id}" 
                                                                data-batch-id="${batch.id}" 
                                                                data-quantity="${batch.quantity}" 
                                                                data-remaining_qty="${batch.remaining_qty}" 
                                                                data-expiry-date="${batch.expiry_date}"
                                                                data-unit_retail="${batch.unit_retail}"
                                                                data-unit_trade="${batch.unit_trade}">
                                                            ${batch.batch_no}
                                                            </option>`;
                                                                                    }).join('')}` :
                                                `<option value="">Not Any Batch Found</option>`
                                            }
                                        </select>
                                        </td>
                                        <td>
                                            <input type="text" name="products[${items}][total_quantity]" id="totalquantity${items}" class="form-control" value="${response.product.total_quantity}" readonly>
                                        </td>
                                        <td>
                                            <select id="selectunit_of_measurement${items}" onchange="changeType(${response.product.id},${items})" name="products[${items}][unit_of_measurement]" class="form-control" required>
                                                <option value="1" selected >Unit Qty</option>
                                                <option value="0">Box Qty</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step="any" id="price_per_unit${items}" name="products[${items}][price_per_unit]" value="${response.product.unit_retail}" readonly  class="form-control">
                                            <input type="hidden" step="any" id="price_per_unit2${items}" name="products[${items}][price_per_unit2]" value="${response.product.unit_retail}" readonly  class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="products[${items}][expiry_date]" class="form-control" id="expiry_date${items}"  readonly>
                                        <td>
                                            <input type="number" value="1" min="1" name="products[${items}][total_piece]" oninput="changeQuantityPerUnit(${response.product.id},${items})" class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" name="products[${items}][total_pack]" value="${response.product.number_of_pack}"  class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="products[${items}][amount]" value="${response.product.unit_retail}" id="importamount${items}" class="form-control" readonly>
                                        </td>
                                        <td>
                                            <i onclick="removeRaw(${response.product.id})" class="text-danger fa fa-trash"></i>
                                        </td>

                                        <input type="hidden" id="discountamount${response.product.id}" name="products[${items}][pieces_per_pack]" value="${response.product.pieces_per_pack }">
                                        <input type="hidden" id="discountamount${response.product.id}" class="price_per_unit_unitonly${items}" name="products[${items}][price_per_unit_unitonly]" value="${response.product.unit_retail }">
                                        <input type="hidden" id="discountamount${response.product.id}" name="products[${items}][disc_amount]" value="${(response.product.discount_trade_price * response.product.cost_price)/100 }">
                                        <input type="hidden" id="tradeprice${response.product.id}" value="${response.product.trade_price}">
                                        <input type="hidden" id="total_peice_per_pack${items}" name="products[${items}][total_peice_per_pack]" value="${response.product.pieces_per_pack}">
                                        <input type="hidden" id="mainqunatityvalue${items}" name="products[${items}][mainqunatityvalue]" >
                                `);
                                $('.batch1').trigger('change');
                            }
                        });
                    }
                }

                function removeRaw(id) {
                    $("#" + id).remove();
                    $('.batch1').trigger('change');
                }

                function removeRaw(id) {
                    $("#" + id).remove();
                    $('.batch1').trigger('change');
                }

                function batchChange(items, id) {

                    const select = document.getElementById(`batch${items}`);
                    const selectedOption = select.options[select.selectedIndex];


                    const batchId = selectedOption.getAttribute('data-batch-id');
                    const quantity = selectedOption.getAttribute('data-quantity');
                    const remaining_qty = selectedOption.getAttribute('data-remaining_qty');
                    const expiryDate = selectedOption.getAttribute('data-expiry-date');
                    const unitTrade = selectedOption.getAttribute('data-unit_trade');
                    const unitRetail = selectedOption.getAttribute('data-unit_retail');

                    // console.log('Unit Retail '+unitRetail);

                    $(`#price_per_unit${items}`).val(unitRetail);
                    $(`#price_per_unit2${items}`).val(unitRetail);
                    $(`#discountamount${id}`).val(unitRetail);
                    $(`#importamount${items}`).val(unitRetail);
                    $('.price_per_unit_unitonly' + items).val(unitRetail);
                    // console.log($('.price_per_unit_unitonly'+items).val());
                    $(`#totalquantity${items}`).val(remaining_qty);
                    $(`#expiry_date${items}`).val(expiryDate);
                    // Perform actions with the additional data
                    console.log(
                        `Selected Batch ID: ${batchId}, Quantity: ${quantity}, Remaining Quantity: ${remaining_qty}, Expiry Date: ${expiryDate}, unitTrade: ${unitTrade}, unitRetail: ${unitRetail}`
                    );

                }

                function changeType(id, items) {
                    var unit_of_measurement = $("#selectunit_of_measurement" + items).val();
                    var amount = $("#" + id + " input[name='products[" + items + "][amount]']").val();
                    var tradeprice = $("#tradeprice" + id).val();
                    console.log(tradeprice);
                    var TotalPeice = $("#" + id + " input[name='products[" + items + "][total_quantity]']").val();
                    var price_per_unitet = $("#" + id + " input[name='products[" + items + "][total_peice_per_pack]']").val();
                    var price_per_unit_unitonly = $("#" + id + " input[name='products[" + items + "][price_per_unit_unitonly]']")
                        .val();
                    var TotalPack = $("#" + id + " input[name='products[" + items + "][total_pack]']").val();
                    var pieces_per_pack = $("#" + id + " input[name='products[" + items + "][pieces_per_pack]']").val();
                    if (unit_of_measurement == 1) {
                        // UNIT
                        $("#" + id + " input[name='products[" + items + "][price_per_unit2]']").val((price_per_unit_unitonly));
                        $("#" + id + " input[name='products[" + items + "][price_per_unit]']").val((price_per_unit_unitonly));
                        $("#" + id + " input[name='products[" + items + "][total_piece]']").removeAttr('readonly').attr('oninput',
                            'changeQuantityPerUnit(' + id + ',' + items + ')').val(1);
                        $("#" + id + " input[name='products[" + items + "][total_pack]']").attr('readonly', 'true');
                    } else if (unit_of_measurement == 0) {
                        // BOX
                        $("#" + id + " input[name='products[" + items + "][price_per_unit]']").val(tradeprice);
                        $("#" + id + " input[name='products[" + items + "][price_per_unit2]']").attr('oninput',
                            'changeQuantityPerPack(' + id + ',' + items + ')').val(tradeprice);
                        $("#" + id + " input[name='products[" + items + "][total_pack]']").removeAttr('readonly').attr('oninput',
                            'changeQuantityPerPack(' + id + ',' + items + ')');
                        $("#" + id + " input[name='products[" + items + "][total_piece]']").attr('readonly', 'true').val(
                            price_per_unitet *
                            pieces_per_pack);
                        $("#" + id + " input[name='products[" + items + "][price_per_unit]']").val(tradeprice);
                        $("#" + id + " input[name='products[" + items + "][mainqunatityvalue]']").val(price_per_unitet);
                    }
                }

                function changeQuantityPerUnit(id, items, unit_of_measurement = null) {
                    var pieces_per_pack = $("#" + id + " input[name='products[" + items + "][pieces_per_pack]']").val();
                    var quantity = $("#" + id + " input[name='products[" + items + "][total_piece]']").val();
                    var priceperpeice = $("#" + id + " input[name='products[" + items + "][price_per_unit2]']").val();
                    console.log(priceperpeice);
                    $("#" + id + " input[name='products[" + items + "][price_per_unit]']").val(priceperpeice);
                    let piece_per_pack = $("#" + id + " input[name='products[" + items + "][pieces_per_pack]']").val();

                    if (quantity >= piece_per_pack) {
                        $("#" + id + " input[name='products[" + items + "][total_pack]']").val((Math.floor(quantity /
                            pieces_per_pack)));
                    } else if (quantity < piece_per_pack) {
                        $("#" + id + " input[name='products[" + items + "][total_pack]']").val(0);
                    }
                    $("#" + id + " input[name='products[" + items + "][amount]']").val((quantity * (priceperpeice)));

                    // BATCH SELECTION WORKING

                    var transferQty = $("#" + id + " input[name='products[" + items + "][total_piece]']").val();
                    var batchQty = $("#" + id + " input[name='products[" + items + "][total_quantity]']").val();
                    transferQty = parseInt(transferQty);
                    batchQty = parseInt(batchQty);

                    if (transferQty > batchQty) {
                        var batch_id = $("#" + id + " select[name='products[" + items + "][batch_no]']").val();
                        console.log("Batch_id: " + batch_id);

                        $.ajax({
                            type: "GET",
                            url: "/shift/get-batch/" + batch_id,
                            success: function(data) {
                                console.log(data.productBatch);

                                for (var i = 0; i < data.productBatch.length; i++) {
                                    var remainingQty = data.productBatch[i].remaining_qty;
                                    remainingQty = parseInt(remainingQty);
                                    if (remainingQty >= transferQty) {
                                        console.log("Found batch with enough remaining_qty: ", data.productBatch[i]);
                                        $("#" + id + " select[name='products[" + items + "][batch_no]']").val(data
                                            .productBatch[i].id).trigger('change');
                                        break;
                                    } else {
                                        console.log("Not Match");
                                    }
                                }
                            }
                        });
                    }

                //    else if (transferQty < batchQty) {
                //         var batch_id = $("#" + id + " select[name='products[" + items + "][batch_no]']").val();
                //         console.log("Batch_id: " + batch_id);
                //         $.ajax({
                //             type: "GET",
                //             url: "/shift/get-batch/" + batch_id,
                //             success: function(data) {
                //                 console.log(data.productBatch);

                //                 for (var i = 0; i < data.productBatch.length; i++) {
                //                     var remainingQty = data.productBatch[i].remaining_qty;

                //                     if (remainingQty <= transferQty) {
                //                         console.log("Found batch with enough remaining_qty: ", data.productBatch[i]);
                //                         $("#" + id + " select[name='products[" + items + "][batch_no]']").val(data
                //                             .productBatch[i].id).trigger('change');
                //                         break;
                //                     } else {
                //                         console.log("Not Match");
                //                     }
                //                 }
                //             }
                //         });
                //     }

                }
// hello world
                function changeQuantityPerPack(id, items, unit_of_measurement = null) {
                    var total_pack = $("#" + id + " input[name='products[" + items + "][total_pack]']").val();
                    var priceperpeice = $("#" + id + " input[name='products[" + items + "][price_per_unit2]']").val();
                    var peice_per_pack = $("#" + id + " input[name='products[" + items + "][total_peice_per_pack]']").val();
                    console.log(peice_per_pack);
                    $("#" + id + " input[name='products[" + items + "][price_per_unit]']").val(priceperpeice);
                    var mainqunatityvalue = $("#" + id + " input[name='products[" + items + "][mainqunatityvalue]']").val();
                    $("#" + id + " input[name='products[" + items + "][amount]']").val((total_pack * (priceperpeice)));
                    $("#" + id + " input[name='products[" + items + "][total_piece]']").val(total_pack * mainqunatityvalue);
                    $("#" + id + " input[name='products[" + items + "][price_per_unit]']").val(priceperpeice);
                }

                $('#save-transfer-button').on('click', function() {
                    // $(this).prop('disabled', true);
                    $('#save-transfer-form').submit();
                });

                $('#re_transfer_id').on('change', function() {
                    var selectedTransferId = $(this).val();

                    // Make an AJAX request to fetch products for the selected transfer
                    $.get('/retransfer/' + selectedTransferId, function(data) {
                        // Clear the table
                        $('#add-products').empty();

                        // Loop through the fetched data and add rows to the table
                        $.each(data, function(items, response) {
                            console.log(response);
                            var newRow = `
                <tr id="${response.product.id}">
                                        <input type="hidden" name="products[${items}][id]" value="${response.product_id}">
                                        <td>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="${response.product.product_name}" readonly>
                                        </td>
                                        <td>
                                            <select onchange="batchChange(${items},${response.product.id})" id="batch${items}" name="products[${items}][batch_no]" class="form-control batch1">
                                            ${response.product.batch.length != 0  ?
                                                `<option value="" selected disabled>Select Batch</option>
                                                                                    ${response.product.batch.map(batch => {
                                                                                        return `<option value="${batch.id}" 
                                                                data-batch-id="${batch.id}" 
                                                                data-quantity="${batch.quantity}" 
                                                                data-remaining_qty="${batch.remaining_qty}" 
                                                                data-expiry-date="${batch.expiry_date}"
                                                                data-unit_retail="${batch.unit_retail}"
                                                                data-unit_trade="${batch.unit_trade}">
                                                            ${batch.batch_no}
                                                            </option>`;
                                                                                    }).join('')}` :
                                                `<option value="">Not Any Batch Found</option>`
                                            }
                                        </select>
                                        </td>
                                        <td>
                                            <input type="text" name="products[${items}][total_quantity]" id="totalquantity${items}" class="form-control" value="${response.product.total_quantity}" readonly>
                                        </td>
                                        <td>
                                            <select id="selectunit_of_measurement${items}" onchange="changeType(${response.product.id},${items})" name="products[${items}][unit_of_measurement]" class="form-control" required>
                                                <option value="1" selected >Unit Qty</option>
                                                <option value="0">Box Qty</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step="any" id="price_per_unit${items}" name="products[${items}][price_per_unit]" value="${response.product.unit_trade}" readonly  class="form-control">
                                            <input type="hidden" step="any" id="price_per_unit2${items}" name="products[${items}][price_per_unit2]" value="${response.product.unit_trade}" readonly  class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="products[${items}][expiry_date]" class="form-control" id="expiry_date${items}" readonly="">
                                        </td>
                                        <td>
                                            <input type="number" value="${response.total_piece}"  name="products[${items}][total_piece]" oninput="changeQuantityPerUnit(${response.product.id},${items})" class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" name="products[${items}][total_pack]" value="${response.total_pack}"  class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="products[${items}][amount]" value="${response.amount}" class="form-control" readonly>
                                        </td>
                                        <td>
                                            <i onclick="removeRaw(${response.product.id})" class="text-danger fa fa-trash"></i>
                                        </td>

                                        <input type="hidden" id="discountamount${response.product.id}" name="products[${items}][pieces_per_pack]" value="${response.product.pieces_per_pack }">
                                        <input type="hidden" id="discountamount${response.product.id}" name="products[${items}][price_per_unit_unitonly]" value="${response.product.unit_trade }">
                                        <input type="hidden" id="discountamount${response.product.id}" name="products[${items}][disc_amount]" value="${(response.product.discount_trade_price * response.product.cost_price)/100 }">
                                        <input type="hidden" id="tradeprice${response.product.id}" value="${response.product.trade_price}">
                                        <input type="hidden" id="total_peice_per_pack${items}" name="products[${items}][total_peice_per_pack]" value="${response.product.pieces_per_pack}">
                                        <input type="hidden" id="mainqunatityvalue${items}" name="products[${items}][mainqunatityvalue]" >
                `;

                            $('#add-products').append(newRow);
                            $('#re_transfer_id').prop('disabled', true);


                        });
                    });
                });
                $('input[name="import-product"]').change(function() {
                    console.log('asdfsdf');
                    $('#csv-form').submit();
                });

                $(document).ready(function() {

                    // $(document).on('change', '.batch1', function() {
                    //     let selectedOption = $(this).find(':selected');

                    //     if (selectedOption.val() !== '') {
                    //         $('#save-transfer-button').prop('disabled', false);
                    //     } else {
                    //         $('#save-transfer-button').prop('disabled', true);
                    //     }
                    // });

                    $(document).on('change', '.batch1', function() {
                        let allSelected = true;

                        $('.batch1').each(function() {
                            let selectedOption = $(this).find(':selected');

                            if (selectedOption.val() === '') {
                                allSelected = false;
                                return false;
                            }
                        });

                        $('#save-transfer-button').prop('disabled', !allSelected);
                    });

                    $('#save-transfer-form').on('submit', function(e) {
                        e.preventDefault();

                        $.ajax({
                            url: '/shift/validate-transfer',
                            type: 'post',
                            data: $(this).serialize(),
                            dataType: 'json',
                            success: function(response) {
                                console.log('Response:', response);
                                if (response.valid) {
                                    console.log('Before form submission');
                                    $('#save-transfer-form')[0].submit();
                                    console.log('After form submission');
                                } else {
                                    // Show the alert and validation message
                                    $('.alert-container').css('display', 'block');
                                    $('.validation-container').show();
                                    $('.validation-container').text(response.message);

                                    // Scroll to the validation message
                                    $('html, body').animate({
                                        scrollTop: $('.validation-container').offset().top
                                    }, 1000);

                                    // Automatically hide the alert after 5 seconds
                                    setTimeout(function() {
                                        $('.alert-container').css('display', 'none');
                                    }, 5000);
                                }
                            },
                            error: function(xhr, status, error) {
                                // Show the validation message
                                $('.validation-container').text(xhr.responseJSON.message);
                                $('.validation-container').show();

                                // Scroll to the validation message
                                $('html, body').animate({
                                    scrollTop: $('.validation-container').offset().top
                                }, 1000);

                                // Automatically hide the alert after 5 seconds
                                setTimeout(function() {
                                    $('.alert-container').css('display', 'none');
                                }, 5000);
                            }
                        });
                    });
                });
            </script>
        @endpush
        <style>
            .alert {
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

            .validationError {
                font-weight: 900;
                color: #2f2f2f;
                letter-spacing: 2px;
            }
        </style>
</x-layouts.app>
