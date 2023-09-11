<x-layouts.app title="Edit Purchase Order List">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Edit Purchase Order List</h3>
                <a href="{{ route('purchase.purchaseorderlist.index') }}" class="btn btn-secondary">Back</a>
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
                            <input type="text" name="manufacturer" class="form-control" value="{{ $requistion->vendor->manufacturer->company_name }}" id="manufacturer" disabled
                                title="Manufacturer">
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
                            <label for="delivery_date" class="form-label">Delivery Date</label>
                            <input type="date" name="delivery_date" id="delivery_date" class="form-control"
                                value="{{ old('delivery_date', $requistion->delivery_date) }}"
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
                                    <td>Product</td>
                                    <td>Total Piece</td>
                                    <td>Limit</td>
                                    <td>Price Per Unit</td>
                                    <td>Total Peice</td>
                                    <td>Sale Tax</td>
                                    <td>Total Packet</td>
                                    <td>Amount</td>
                                </tr>
                            </thead>
                            <tbody id="add-products">
                                @foreach ($requistion->requistionProducts as $requistionProduct)
                                <tr id="{{ $loop->index }}">
                                    <input type="hidden" name="products[{{ $loop->index  }}][id]" value="{{ $requistionProduct->product_id }}">
                                    <td>
                                        <input type="text" class="form-control" value="{{ $requistionProduct->product->product_name }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="products[{{ $loop->index  }}][total_quantity]" class="form-control" value="{{ $requistionProduct->product->total_quantity }}" readonly>
                                    </td>
                                    <td>
                                        <select id="selectLimit{{ $loop->index  }}" onchange="changeType({{ $requistionProduct->product_id }},{{ $loop->index  }})" name="products[{{ $loop->index  }}][limit]" class="form-control" readonly>
                                            <option valu="" selected disabled>Select Least Quantity</option>
                                            <option value="1" {{ $requistionProduct->limit === 1 ? 'selected' : '' }}>Unit Qty</option>
                                            <option value="0" {{ $requistionProduct->limit === 0 ? 'selected' : '' }}>Box Qty</option>
                                        </select>
                                    </td>
                                    <td>
                                        @if ($requistionProduct->limit === 1 )
                                        <input type="hidden" step="any" id="price_per_unit{{ $loop->index  }}" value="{{ $requistionProduct->price_per_unit }}" name="products[{{ $loop->index  }}][price_per_unit]" onkeyup="changeQuantityPerUnit({{$requistionProduct->id}},{{$loop->index}})"  class="form-control">   
                                        <input type="number" step="any" id="price_per_unit{{ $loop->index  }}2" value="{{ $requistionProduct->price_per_unit }}" name="products[{{ $loop->index  }}][price_per_unit2]" onkeyup="changeQuantityPerUnit({{$requistionProduct->id}},{{$loop->index}})"  class="form-control">    
                                        @else
                                        <input type="hidden" step="any" id="price_per_unit{{ $loop->index  }}" value="{{ $requistionProduct->price_per_unit }}" name="products[{{ $loop->index  }}][price_per_unit]" onkeyup="changeQuantityPerPack({{$requistionProduct->id}},{{$loop->index}})"  class="form-control">   
                                        <input type="number" step="any" id="price_per_unit{{ $loop->index  }}2" value="{{ $requistionProduct->price_per_unit * $requistionProduct->product->pieces_per_pack }}" name="products[{{ $loop->index  }}][price_per_unit2]" onkeyup="changeQuantityPerPack({{$requistionProduct->id}},{{$loop->index}})"  class="form-control">    
                                        @endif
                                    </td>
                                    <td>
                                        <input type="text" value="{{ $requistionProduct->total_piece }}" min="1" name="products[{{ $loop->index  }}][total_piece]" onkeyup="changeQuantityPerUnit({{ $requistionProduct->product_id  }},{{ $loop->index  }})" class="form-control" {{ $requistionProduct->limit === 0 ? 'readonly' : '' }}>
                                    </td>
                                    <td>
                                        <input type="number"  value="{{ $requistionProduct->total_amount - $requistionProduct->dis_amount  }}" class="form-control" readonly>    
                                    </td>
                                    <td>
                                        <input type="number" name="products[{{ $loop->index  }}][total_pack]" value="{{ $requistionProduct->total_piece / $requistionProduct->product->pieces_per_pack }}" onkeyup="changeQuantityPerPack({{$requistionProduct->id}},{{$loop->index}})" class="form-control" {{ $requistionProduct->limit === 1 ? 'readonly' : '' }}>    
                                    </td>
                                    <td>
                                        <input type="number" name="products[{{ $loop->index  }}][total_amount]" value="{{ $requistionProduct->total_amount }}" class="form-control" readonly>    
                                    </td>
                                    <td>
                                        <i onclick="removeRaw({{ $loop->index  }})" class="text-danger fa fa-trash"></i>
                                    </td>
                                    <input type="hidden" id="discountamount{{ $loop->index  }}" name="products[{{ $loop->index  }}][disc_amount]" value="{{ ($requistionProduct->discount_trade_price * $requistionProduct->cost_price) / 100 }}">
                                    <input type="hidden" id="tradeprice{{ $loop->index  }}" value="{{ $requistionProduct->trade_price }}">
                                    <input type="hidden" id="total_peice_per_pack{{ $loop->index  }}" name="products[{{ $loop->index  }}][total_peice_per_pack]" value="{{ $requistionProduct->product->pieces_per_pack }}">
                                    <input type="hidden" id="mainqunatityvalue{{ $loop->index  }}" name="products[{{ $loop->index  }}][mainqunatityvalue]" >
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
                $("input[name='products[" + items + "][total_piece]']").removeAttr('readonly').attr('onkeyup',
                    'changeQuantityPerUnit(' + id + ',' + items + ')').val(1);
                $("input[name='products[" + items + "][total_pack]']").attr('readonly', 'true');
            } else if (limit == 0) {
                // BOX
                $("input[name='products[" + items + "][price_per_unit]']").val(0);
                $("input[name='products[" + items + "][price_per_unit2]']").attr('onkeyup',
                    'changeQuantityPerPack(' + id + ',' + items + ')').val(0);

                $("input[name='products[" + items + "][total_pack]']").removeAttr('readonly').attr('onkeyup',
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
    </script>
    @endpush
</x-layouts.app>
