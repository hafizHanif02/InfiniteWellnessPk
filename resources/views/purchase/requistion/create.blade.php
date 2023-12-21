<x-layouts.app title="Add New Requistion">
    @push('styles')
        <link nonce="{{ csp_nonce() }}" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
            rel="stylesheet" />
    @endpush
    <style>
        .select2-container{
            width: 100% !important;
        }
    </style>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Add Purchase Requistion</h3>
                <a href="{{ route('purchase.requistions.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('purchase.requistions.store') }}" method="POST" id="save-requistion-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-5">
                        <div class="col-md-4">
                            <label for="requistion_id" class="form-label">Product Order # <sup
                                    class="text-danger">*</sup></label>
                            <input type="text" name="requistion_id" value="{{ ($requistion_id ? $requistion_id : 95000) + 1 }}"
                                id="requistion_id" class="form-control" readonly title="Product order number">
                            @error('remarks')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="manufacturer_id" class="form-label">Manufacturers <sup class="text-danger">*</sup></label>
                            <select name="manufacturer_id" id="manufacturer_id" class="form-control" title="Manufactuter">
                                <option value="" selected disabled>Select Manufacturer</option>
                                @forelse ($manufactuters as $manufactuter)
                                    <option value="{{ $manufactuter->id }}">{{ $manufactuter->company_name }}</option>
                                @empty
                                    <option value="" class="text-danger">No vendor found!</option>
                                @endforelse
                            </select>
                            @error('manufacturer_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="vendor_id" class="form-label">Vendor <sup class="text-danger">*</sup></label>
                            <select name="vendor_id" id="vendor_id" class="form-control" title="Vendor">
                                <option value="" selected disabled>Select Vendor</option>
                                @forelse ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->account_title }}</option>
                                @empty
                                    <option value="" class="text-danger">No vendor found!</option>
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
                            <input type="text" name="remarks" id="remarks" class="form-control"
                                value="{{ old('remarks') }}" placeholder="Enter your remarks" title="Remarks">
                            @error('remarks')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="delivery_date" class="form-label">Delivery Date</label>
                            <input type="date" name="delivery_date" readonly id="delivery_date" class="form-control"
                                value="{{ old('delivery_date', date('Y-m-d')) }}" placeholder="Enter Delivery Date"
                                title="Delivery date">
                            @error('delivery_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="document" class="form-label">Import Products</label>
                        <input type="file" name="document" id="document" class="form-control"
                            title="Import products">
                        @error('document')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="product_id" class="form-label">(Generic Formula) Product <sup class="text-danger">*</sup></label>
                        <div class="row">
                            <div class="col-md-10">
                                <select name="product_id[]" id="product_id" class="form-control" multiple>
                                    <option value="" selected disabled>Select Product</option>
                                    @foreach ($products as $product)
                                    <option value="{{$product->id }}">({{$product->generic->formula}}) {{$product->product_name }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="add-btn" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr class="text-white">
                                    <td style="min-width: 200px">Product</td>
                                    <td style="min-width: 120px">Total Stock</td>
                                    <td style="min-width: 200px">Limit</td>
                                    <td style="min-width: 150px">Price Per Unit</td>
                                    <td style="min-width: 150px">Total Peice</td>
                                    <td style="min-width: 150px">Previous Price</td>
                                    <td style="min-width: 150px">Total Packet</td>
                                    <td style="min-width: 150px">Discount Percentage</td>
                                    <td style="min-width: 200px">Amount</td>
                                    <td style="min-width: 50px"></td>
                                </tr>
                            </thead>
                            <tbody id="add-products">
                            </tbody>
                        </table>
                    </div>
                        <input type="hidden" readonly id="discount_amount" placeholder="Total Amount"
                            name="discount_amount" class="form-control" value="0">
                    <div class="d-flex justify-content-center mt-5">
                        <a href="{{ route('purchase.requistions.index') }}" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-primary ms-3">Save</button>
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
                $('#manufacturer_id, #product_id').select2();
            $('form').on('keypress', 'input', function(e) {
                if (e.which === 13) {
                e.preventDefault();
                }
            });
            });
            $("#add-btn").click(function(e) {
                e.preventDefault();
                addProduct();
                // $("#product_id").empty();
            });
            // $('#manufacturer_id').change(function() {
            //     $("#add-products").empty();
            //     $.ajax({
            //         type: "get",
            //         url: "/purchase/requistions/products/list",
            //         data: {
            //             manufacturer_id: $(this).val()
            //         },
            //         dataType: "json",
            //         success: function(response) {
            //             console.log(response);
            //             $("#product_id").empty();
            //             if (response.data.length != 0) {
            //                 $.each(response.data, function(index, value) {
            //                     $("#product_id").append(`
            //                         <option value="${value.id}">${value.product_name}</option>
            //                     `);
            //                 });
            //             } else {
            //                 $("#product_id").html(`
            //                     <option value="" class="text-danger" selected disabled>No product found!</option>
            //                 `);
            //             }
            //         }
            //     });
            // });
  
            function addProduct(type, callback) {
                var productId = $("#product_id").val();         
                if (productId && $('tbody tr#' + productId).length == 0) {
                    $.ajax({
                        type: "post",
                        url: "/purchase/requistions/product/",
                        data: {
                            _token: "{{ csrf_token() }}",
                            product_id: productId
                        },
                        success: function(response) {
                            $("#product_id option:selected").remove();
                            $("#product_id option[value='"+productId+"']").remove();
                            var items = $("tbody tr").length;                        
                            $.each(response.product, function(index, value) {
                                $("#add-products").append(`
                                    <tr id="${value.id}">
                                        <input type="hidden" name="products[${index}][id]" value="${value.id}">
                                        <td>
                                            <input type="text" class="form-control" value="${value.product_name}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="products[${index}][total_quantity]" class="form-control" value="${value.total_quantity}" readonly>
                                        </td>
                                        <td>
                                            <select id="selectLimit${index}" onchange="changeType(${value.id},${index})" name="products[${index}][limit]" class="form-control" required>
                                                <option value="1" selected >Unit Qty</option>
                                                <option value="0">Box Qty</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="hidden" step="any" id="price_per_unit${index}" name="products[${index}][price_per_unit]" value="" oninput="changeQuantityPerUnit(${value.id},${index})" class="form-control">
                                            <input type="number" step="any" id="price_per_unit${index}2" name="products[${index}][price_per_unit2]" value="${value.unit_trade}" oninput="changeQuantityPerUnit(${value.id},${index})" class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" value="1" min="1" name="products[${index}][total_piece]" oninput="changeQuantityPerUnit(${value.id},${index})" class="form-control">
                                        </td>
                                        <td>

                                            <input type="number" id="previouse_price${value.id}"  value="${value.unit_trade}" class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="products[${index}][total_pack]"  class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input type="number" step="any" name="products[${index}][discount_percentage]" oninput="discountPerc(${value.id})"  id="discount_percentage${value.id}" value="0" class="form-control" >
                                            <input type="hidden" id="discount_amount2${value.id}">
                                        </td>
                                        <td>
                                            <input type="number" name="products[${index}][total_amount]" value="${value.unit_trade}" id="total_amount${value.id}" class="form-control" readonly>
                                            <input type="hidden" name="products[${index}][total_amounts2]" value="${value.cost_price}" id="total_amounts2${value.id}" class="form-control" readonly>
                                        </td>
                                        <td>
                                            <i onclick="removeRaw(${value.id})" class="text-danger fa fa-trash"></i>
                                            <input type="hidden" id="cost_price${value.id}" value="${value.cost_price}">
                                            <input type="hidden" id="unit_trade${value.id}" value="${value.unit_trade}">
                                        </td>
                                        <input type="hidden" id="discountamount${value.id}" name="products[${index}][pieces_per_pack]" value="${value.pieces_per_pack }">
                                        <input type="hidden" id="pieces_per_pack${value.id}" name="pieces_per_pack" value="${value.pieces_per_pack }">
                                        <input type="hidden" id="previouse_pricess${value.id}" value="${value.cost_price}">
                                        <input type="hidden" id="cost_price${value.id}" value="${value.cost_price}">
                                        <input type="hidden" id="unit_trade${value.id}" value="${value.unit_trade}">
                                        <input type="hidden" id="discountamount${value.id}" name="products[${index}][disc_amount]" value="${(value.discount_trade_price * value.cost_price)/100 }">
                                        <input type="hidden" id="tradeprice${index}" value="${value.trade_price}">
                                        <input type="hidden" id="total_peice_per_pack${index}" name="products[${index}][total_peice_per_pack]" value="${value.pieces_per_pack}">
                                        <input type="hidden" id="mainqunatityvalue${index}" name="products[${index}][mainqunatityvalue]" >
                                    </tr>
                                    
                                `);
                            });
                        }
                    });
                }
            }

            function removeRaw(id) {
                $("#" + id).remove();
            }

            function changeType(id, items) {
                var previouse_price = $("#previouse_pricess" + id).val();
                var costPrice = $('#cost_price'+id).val();
                var unitPrice = $('#unit_trade'+id).val();
                console.log('COST PRICE'+costPrice+ ' UNIT PRICE'+unitPrice)
                var pieces_per_pack = $("#pieces_per_pack" + id).val();
                var limit = $("#selectLimit" + items).val();
                var amount = $("#" + id + " input[name='products[" + items + "][total_amount]']").val();
                var TotalPeice = $("#" + id + " input[name='products[" + items + "][total_quantity]']").val();
                var price_per_unitet = $("#" + id + " input[name='products[" + items + "][total_peice_per_pack]']").val();
                var TotalPack = $("#" + id + " input[name='products[" + items + "][total_pack]']").val();
                if (limit == 1) {
                    // UNIT
                    $('#price_per_unit'+items).val(unitPrice);
                    $('#price_per_unit'+items+'2').val(unitPrice);
                    $("#previouse_price"+id).val(unitPrice);
                    // $("#" + id + " input[name='products[" + items + "][price_per_unit2]']").val((amount / TotalPeice).toFixed(2));
                    $("#" + id + " input[name='products[" + items + "][total_piece]']").removeAttr('readonly').attr('oninput',
                        'changeQuantityPerUnit(' + id + ',' + items + ')').val(1);
                    $("#" + id + " input[name='products[" + items + "][total_pack]']").attr('readonly', 'true');
                    $("#" + id + " input[name='products[" + items + "][total_amount]']").val(unitPrice)
                } else if (limit == 0) {
                    // BOX
                    $('#price_per_unit'+items).val(costPrice);
                    $("#previouse_price"+id).val(costPrice);
                    // var pprice = pieces_per_pack * previouse_price;
                    // console.log(pprice);
                    $("#" + id + " input[name='products[" + items + "][total_amount]']").val(costPrice)
                    $("#" + id + " input[name='products[" + items + "][price_per_unit]']").val(costPrice);
                    $("#" + id + " input[name='products[" + items + "][price_per_unit2]']").attr('oninput',
                        'changeQuantityPerPack(' + id + ',' + items + ')').val(costPrice);

                    $("#" + id + " input[name='products[" + items + "][total_pack]']").removeAttr('readonly').attr('oninput',
                        'changeQuantityPerPack(' + id + ',' + items + ')');
                    $("#" + id + " input[name='products[" + items + "][total_piece]']").attr('readonly', 'true').val(price_per_unitet *
                        TotalPack);
                    // $("#" + id + " input[name='products[" + items + "][price_per_unit]2']").val((amount / TotalPack).toFixed(2));
                    $("#" + id + " input[name='products[" + items + "][mainqunatityvalue]']").val(price_per_unitet);
                }
            }
            function changeQuantityPerUnit(id, items, limit = null) {
                var quantity = $("#" + id + " input[name='products[" + items + "][total_piece]']").val();
                var priceperpeice = $("#" + id + " input[name='products[" + items + "][price_per_unit2]']").val();
                $("#" + id + " input[name='products[" + items + "][price_per_unit]']").val(priceperpeice);
                let piece_per_pack = $("#" + id + " input[name='products[" + items + "][pieces_per_pack]']").val();

                if(quantity >= piece_per_pack){
                    $("#" + id + " input[name='products[" + items + "][total_pack]']").val((Math.floor(quantity/piece_per_pack)));
                }
                else if (quantity < piece_per_pack) {
                    $("#" + id + " input[name='products[" + items + "][total_pack]']").val(0);
                }
                $("#" + id + " input[name='products[" + items + "][total_amount]']").val((quantity * (priceperpeice)));
                $("#" + id + " input[name='products[" + items + "][total_amounts2]']").val((quantity * (priceperpeice)));

            }

            function changeQuantityPerPack(id, items, limit = null) {
                var total_pack = $("#" + id + " input[name='products[" + items + "][total_pack]']").val();
                var priceperpeice = $("#" + id + " input[name='products[" + items + "][price_per_unit2]']").val();
                var peice_per_pack = $("#" + id + " input[name='products[" + items + "][total_peice_per_pack]']").val();
                console.log(peice_per_pack);
                $("#" + id + " input[name='products[" + items + "][price_per_unit]']").val(priceperpeice / peice_per_pack );
                var mainqunatityvalue = $("#" + id + " input[name='products[" + items + "][mainqunatityvalue]']").val();
                $("#" + id + " input[name='products[" + items + "][total_amount]']").val((total_pack * (priceperpeice)));
                $("#" + id + " input[name='products[" + items + "][total_amounts2]']").val((total_pack * (priceperpeice)));
                $("#" + id + " input[name='products[" + items + "][total_piece]']").val(total_pack * mainqunatityvalue);
            }
            function discountPerc(id) {
                var discountPer = $('#discount_percentage'+id).val();
                var total_cost_per_product = $('#total_amounts2'+id).val();
                var discount_amount = ((discountPer/100) * total_cost_per_product);
                $('#discount_amount').val(discount_amount)
                $('#discount_amount2'+id).val(discount_amount);
                $('#total_amount'+id).val(total_cost_per_product-discount_amount);
                discountTotal();
            }

            function discountTotal() {
                var discount = 0;
                $("input[id^='discount_amount2']").each(function() {
                    if($(this).val() != ''){
                        discount += parseFloat($(this).val());
                    }
                });
                $('#discount_amount').val(discount);
            }

            $("#document").change(function() {
                var file = $("#document")[0].files[0];
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('document', file);

                $.ajax({
                    type: "POST",
                    url: "/purchase/requistions/document/import",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(response) {
                        if ($("#add-products #" + response.product.id).length == 0) {
                            var items = $("tbody tr").length;
                            $.each(response.product, function(index, value) {
                                // $.each(value1, function(index, value) {
                                console.log(value);
                                $("#add-products").append(`
                                    <tr id="${value.id}">
                                            <input type="hidden" name="products[${items}][id]" value="${value.product.id}">
                                            <td>
                                                <input type="text" class="form-control" value="${value.product.product_name}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="products[${items}][total_quantity]" class="form-control" value="${value.product.total_quantity}" readonly>
                                            </td>
                                            <td>
                                                <select id="selectLimit${items}" onchange="changeType(${value.id},${items})" name="products[${items}][limit]" class="form-control" required>
                                                    <option value="${value.limit == 'unit_quantity'? 1 : ''}" ${value.limit == 'unit_quantity' ? 'selected' : '' } >Unit Qty</option>
                                                    <option value="${value.limit == 'box_quantity'? 0 : ''}" ${value.limit == 'box_quantity' ? 'selected' : '' }>Box Qty</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="hidden" step="any" id="price_per_unit${items}" name="products[${items}][price_per_unit]" value="" oninput="changeQuantityPerUnit(${value.id},${items})" class="form-control">
                                                <input type="number" step="any" id="price_per_unit${items}2" name="products[${items}][price_per_unit2]" value="" oninput="changeQuantityPerUnit(${value.id},${items})" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" value="1" min="1" name="products[${items}][total_piece]" oninput="changeQuantityPerUnit(${value.id},${items})" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number"  value="${value.product.cost_price}" class="form-control" readonly>
                                            </td>
                                            <td>
                                                <input type="number" name="products[${items}][total_pack]"  class="form-control" readonly>
                                            </td>
                                            <td>
                                            <input type="number" step="any"  name="products[${items}][discount_percentage]" oninput="discountPerc(${value.id})"  id="discount_percentage${value.id}" value="0" class="form-control" >
                                            <input type="hidden" id="discount_amount2${value.id}">
                                            </td>
                                            <td>
                                                <input type="number" name="products[${items}][total_amount]" value="${value.product.cost_price}" class="form-control" readonly>
                                            </td>
                                            <td>
                                                <i onclick="removeRaw(${value.id})" class="text-danger fa fa-trash"></i>
                                            </td>

                                            <input type="hidden" id="discountamount${value.id}" name="products[${items}][pieces_per_pack]" value="${value.product.pieces_per_pack }">
                                            <input type="hidden" id="discountamount${value.id}" name="products[${items}][disc_amount]" value="${(value.product.discount_trade_price * value.product.cost_price)/100 }">
                                            <input type="hidden" id="tradeprice${items}" value="${value.product.trade_price}">
                                            <input type="hidden" id="total_peice_per_pack${items}" name="products[${items}][total_peice_per_pack]" value="${value.product.pieces_per_pack}">
                                            <input type="hidden" id="mainqunatityvalue${items}" name="products[${items}][mainqunatityvalue]" >
                                        </tr>
                                `);
                                // });
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
        
            $(document).ready(function() {
    $('#save-requistion-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Perform your AJAX request here
        $.ajax({
            url: '/purchase/validate-requistions',
            type: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                console.log('Response:', response);
                if (response.valid) { 
                    console.log('Before form submission');
                    $('#save-requistion-form')[0].submit();
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
