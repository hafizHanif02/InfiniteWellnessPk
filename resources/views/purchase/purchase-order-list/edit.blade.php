<x-layouts.app title="Edit Purchase Order List">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Edit Purchase Order List</h3>
                <a href="{{ url('/purchase/purchaseorderlist') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form id="save-purchaseorder-form" action="{{ route('purchase.purchaseorderlist.update', $requistion->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="url" value="{{ url()->previous() }}">
                    <div class="row mb-5">
                        <div class="col-md-4">
                            <label for="po_number" class="form-label">Product Order Number <sup class="text-danger">*</sup></label>
                            <input type="text" name="po_number"
                                value="{{ old('po_number', $requistion->id) }}" id="po_number"
                                class="form-control" readonly required>
                            @error('remarks')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="vendor_id" class="form-label">Vendor<sup class="text-danger">*</sup></label>
                            <input type="hidden" name="vendor_id" id="vendor_id" class="form-control" value="{{ $requistion->vendor_id }}" readonly>
                            <input type="text" id="vendor_id" class="form-control" value="{{ $requistion->vendor->account_title }}" readonly>
                            @error('vendor_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="manufacturer" class="form-label">Manufacturer</label>
                            @if (isset($requistion->manufacturer->company_name))
                            <input type="text" name="manufacturer" class="form-control" value="{{ $requistion->manufacturer->company_name }}" id="manufacturer" disabled
                            title="Manufacturer">
                            @else
                            <input type="text" name="manufacturer" class="form-control" value="" id="manufacturer" disabled
                            title="Manufacturer">
                            @endif
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <input type="text" name="remarks" id="remarks" class="form-control"
                                value="{{ old('remarks', $requistion->remarks) }}" placeholder="Enter Your Remarks">
                            @error('remarks')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="delivery_date"  class="form-label">Delivery Date</label>
                            <input type="date" readonly name="delivery_date" id="delivery_date" class="form-control"
                                value="{{$requistion->delivery_date}}"
                                placeholder="Enter Delivery Date">
                            @error('delivery_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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
                                @foreach ($requistion->requistionProducts as $requistionProduct)
                                <tr id="{{$requistionProduct->product->id}}">
                                    <input type="hidden" name="products[{{$loop->iteration}}][id]" value="{{$requistionProduct->product->id}}">
                                    <td>
                                        <input type="text" class="form-control" title="{{$requistionProduct->product->product_name}}" value="{{$requistionProduct->product->product_name}}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="products[{{$loop->iteration}}][total_quantity]" class="form-control" value="{{$requistionProduct->product->total_quantity}}" readonly>
                                    </td>
                                    <td>
                                        <select readonly id="selectLimit{{$loop->iteration}}" onchange="changeType({{$requistionProduct->product->id}},{{$loop->iteration}})" name="products[{{$loop->iteration}}][limit]" class="form-control" required>
                                            @if ($requistionProduct->limit == 1)
                                            <option value="1" selected >Unit Qty</option>
                                            <option value="0">Box Qty</option>
                                            @else
                                            <option value="1">Unit Qty</option>
                                            <option value="0" selected>Box Qty</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" step="any" id="price_per_unit{{$loop->iteration}}" name="products[{{$loop->iteration}}][price_per_unit]" value="{{$requistionProduct->price_per_unit }}" oninput="changeQuantityPerUnit({{$requistionProduct->product->id}},{{$loop->iteration}})" class="form-control">    
                                        <input type="number" step="any" id="price_per_unit{{$loop->iteration}}2" name="products[{{$loop->iteration}}][price_per_unit2]" value="{{$requistionProduct->price_per_unit }}" oninput="changeQuantityPerUnit({{$requistionProduct->product->id}},{{$loop->iteration}})" class="form-control">    
                                    </td>
                                    <td>
                                        <input type="number"  min="1" name="products[{{$loop->iteration}}][total_piece]" oninput="changeQuantityPerUnit({{$requistionProduct->product->id}},{{$loop->iteration}})" value="{{$requistionProduct->total_piece}}" class="form-control">
                                    </td>
                                    <td>
                                        
                                        <input type="number" id="previouse_price{{$requistionProduct->product->id}}"  value="{{$requistionProduct->product->cost_price}}" class="form-control" readonly>    
                                    </td>
                                    <td>
                                        <input type="number" name="products[{{$loop->iteration}}][total_pack]" value="{{$requistionProduct->total_piece /$requistionProduct->product->pieces_per_pack }}"  class="form-control" readonly>    
                                    </td>
                                    <td>
                                        <input type="number" step="any" name="products[{{$loop->iteration}}][discount_percentage]" oninput="discountPerc({{$requistionProduct->product->id}})"  id="discount_percentage{{$requistionProduct->product->id}}" value="{{$requistionProduct->discount_percentage}}" class="form-control" >
                                        <input type="hidden" id="discount_amount2{{$requistionProduct->product->id}}">
                                    </td>
                                    <td>
                                        <input type="number" name="products[{{$loop->iteration}}][total_amount]" value="{{$requistionProduct->total_amount}}" id="total_amount{{$requistionProduct->product->id}}" class="form-control" readonly>    
                                        <input type="hidden" name="products[{{$loop->iteration}}][total_amounts2]" value="{{$requistionProduct->price_per_unit*$requistionProduct->total_piece}}" id="total_amounts2{{$requistionProduct->product->id}}" class="form-control" readonly>    
                                    </td>
                                    <td>
                                        <i onclick="removeRaw({{$requistionProduct->product->id}})" class="text-danger fa fa-trash"></i>
                                    </td>
                                    
                                    <input type="hidden" id="discountamount{{$requistionProduct->product->id}}" name="products[{{$loop->iteration}}][pieces_per_pack]" value="{{$requistionProduct->product->pieces_per_pack }}">
                                    <input type="hidden" id="pieces_per_pack{{$requistionProduct->product->id}}" name="pieces_per_pack" value="{{$requistionProduct->product->pieces_per_pack }}">
                                    <input type="hidden" id="previouse_pricess{{$requistionProduct->product->id}}" value="{{$requistionProduct->product->cost_price}}">
                                    <input type="hidden" id="discountamount{{$requistionProduct->product->id}}" name="products[{{$loop->iteration}}][disc_amount]" value="${(value.discount_trade_price * value.cost_price)/100 }">
                                    <input type="hidden" id="tradeprice{{$loop->iteration}}" value="{{$requistionProduct->product->trade_price}}">
                                    <input type="hidden" id="total_peice_per_pack{{$loop->iteration}}" name="products[{{$loop->iteration}}][total_peice_per_pack]" value="{{$requistionProduct->product->pieces_per_pack}}">
                                    <input type="hidden" id="mainqunatityvalue{{$loop->iteration}}" name="products[{{$loop->iteration}}][mainqunatityvalue]" >
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <a href="{{ route('purchase.purchaseorderlist.index') }}" class="btn btn-danger">Cancel</a>
                        <button type="submit" id="save-purchaseorder-button" class="btn btn-primary ms-3">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script> 
    $(document).ready(function() {

        $('form').on('keypress', 'input', function(e) {
                    if (e.which === 13) { 
                    e.preventDefault(); 
                    }
                });
    });
        function removeRaw(id) {
            $("#" + id).remove();
        }

        function changeType(id, items) {
            var limit = $("#selectLimit" + items).val();
            var amount = $("input[name='products[" + items + "][total_amount]']").val();
            var TotalPeice = $("input[name='products[" + items + "][total_piece]']").val();
            var price_per_unitet = $(" input[name='products[" + items + "][total_peice_per_pack]']").val();
            var TotalPack = $(" input[name='products[" + items + "][total_pack]']").val();

            console.log(limit, amount, TotalPeice, price_per_unitet, TotalPack);


            if (limit == 1) {
                // UNIT
                $("input[name='products[" + items + "][price_per_unit2]']").val((amount / TotalPeice).toFixed(2));
                $("input[name='products[" + items + "][total_piece]']").removeAttr('readonly').attr('oninput',
                    'changeQuantityPerUnit(' + id + ',' + items + ')').val(1);
                $("input[name='products[" + items + "][total_pack]']").attr('readonly', 'true');
            } else if (limit == 0) {
                // BOX
                $("input[name='products[" + items + "][price_per_unit]']").val(0);
                $("input[name='products[" + items + "][price_per_unit2]']").attr('oninput',
                    'changeQuantityPerPack(' + id + ',' + items + ')').val(0);

                $("input[name='products[" + items + "][total_pack]']").removeAttr('readonly').attr('oninput',
                    'changeQuantityPerPack(' + id + ',' + items + ')');
                $("input[name='products[" + items + "][total_piece]']").attr('readonly', 'true').val(price_per_unitet *
                    TotalPack);
                // $("#" + id + " input[name='products[" + items + "][price_per_unit]2']").val((amount / TotalPack).toFixed(2));
                $("input[name='products[" + items + "][mainqunatityvalue]']").val(price_per_unitet);
            }
        }
        function changeQuantityPerUnit(id, items, limit = null) {

            var quantity = $("input[name='products[" + items + "][total_piece]']").val();
            var priceperpeice = $("input[name='products[" + items + "][price_per_unit2]']").val();
            $("input[name='products[" + items + "][price_per_unit]']").val(priceperpeice);
            let piece_per_pack = $("input[name='products[" + items + "][pieces_per_pack]']").val();
            
            if(quantity >= piece_per_pack){
                $("input[name='products[" + items + "][total_pack]']").val((Math.floor(quantity/piece_per_pack)));
            }
            else if (quantity < piece_per_pack) {
                $("input[name='products[" + items + "][total_pack]']").val(0);
            }
            $("input[name='products[" + items + "][total_amount]']").val((quantity * (priceperpeice)));
        
        }

        function changeQuantityPerPack(id, items, limit = null) {
            var total_pack = $("input[name='products[" + items + "][total_pack]']").val();
            var priceperpeice = $("input[name='products[" + items + "][price_per_unit2]']").val();
            var peice_per_pack = $("input[name='products[" + items + "][total_peice_per_pack]']").val();
            console.log(peice_per_pack);
            $("input[name='products[" + items + "][price_per_unit]']").val(priceperpeice / peice_per_pack );
            $("input[name='products[" + items + "][total_amount]']").val((total_pack * (priceperpeice)));
            $("input[name='products[" + items + "][total_piece]']").val(total_pack * peice_per_pack);
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

        


    </script>
    @endpush
</x-layouts.app>
