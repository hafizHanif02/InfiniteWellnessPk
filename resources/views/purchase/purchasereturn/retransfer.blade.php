{{dd($return) }}
<x-layouts.app title="Purchase Item Return Retransfer">
    @push('styles')
        <link nonce="{{ csp_nonce() }}" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
            rel="stylesheet" />
    @endpush
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Purchase Item Return Retransfer</h3>
                <a href="{{ route('purchase.return.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form id="save-purchasereturn-form" action="{{ route('purchase.return.store') }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label for="remark" class="form-label">Remark</label>
                        <input type="text" name="remark" id="remark" class="form-control"
                            value="{{$return->remark}}" readonly placeholder="Enter your remark" title="Remark">
                        @error('remark')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="good_receive_note_id" class="form-label">Good Receive Note<sup
                                class="text-danger">*</sup></label>
                        <div class="row">
                            <div class="col-md-10">
                                <input name="good_receive_note_id" id="good_receive_note_id" class="form-control"
                                   readonly value="{{$return->good_receive_note_id }}">
                                @error('good_receive_note_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary" id="add-btn" title="Add products">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5 mt-5">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <td>Product</td>
                                        <td>Purchase Qty</td>
                                        <td>Limit</td>
                                        <td>Qty</td>
                                        <td>Available Qty</td>
                                        <td>Pur Rate</td>
                                        <td>Amount</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody id="add-products">
                                    <tr id="{{$return->product->id}}">
                                        <input type="hidden" name="products[{{$return->id }}][id]" value="{{$return->product->id}}">
                                        <td>
                                            <input type="text" class="form-control" value="{{$return->product->product_name}}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="products[{{$return->id }}][remaining_quantity]" id="remaining_quantity{{$return->product->id}}" class="form-control" value="{{$return->deliver_qty}}" readonly>
                                        </td>
                                        <td>
                                            <input type="text"  placeholder="Piece" readonly  min="1" class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="text" name="products[{{$return->id }}][quantity]"  min="1"id="minusquantity{{$return->product->id}}" max="{{$return->deliver_qty}}" value="{{$return->good_receive_note->deliver_qty}}" name="quantity[{{$return->id }}]" onkeyup="changeQuantity($return->product->id,$return->id)" class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="number"  value="{{$return->product->total_quantity}}" id="leftedquantity{{$return->product->id}}"  class="form-control" readonly> 
                                            <input type="hidden"  value="{{$return->product->total_quantity}}" id="leftedquantity2{{$return->product->id}}"  class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="products[{{$return->id }}][purchase_rate]" id="purchase_rate{{$return->product->id}}" value="{{$return->product->cost_price}}" class="form-control" readonly>    
                                        </td>
                                        <td>
                                            <input type="number" id="totalprice{{$return->product->id}}" name="products[{{$return->id }}][price]" value="{{$return->item_amount/$return->deliver_qty}}" class="form-control" readonly>    
                                            <input type="hidden" id="totalprice2{{$return->product->id}}" name="products[{{$return->id }}][price]" value="{{$return->item_amount/$return->deliver_qty}}" class="form-control" readonly>    

                                        </td>
                                        {{-- <td>
                                            <i onclick="removeRaw($return->product->id)" class="text-danger fa fa-trash"></i>
                                        </td> --}}
                                        {{-- <input type="hidden" id="discountamount{{$return->product->id}}" value="${($return->product->disctradeprice * $request->product->cost_price)/100 }}">
                                        <input type="hidden" id="tradeprice{{$return->product->id}}" value="{{$return->product->tradeprice/$request->product.pieces_per_pack}}">
                                        <input type="hidden" id="totalquantity{{$return->product->id}}" value="{{$request->deliver_qty}}">
                                        <input type="hidden" id="leftedprice{{$return->product->id}}" value="" name="leftedprice{{$return->product->id}}"> --}}
                                    </tr>
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <a  class="btn btn-danger">Cancel</a>
                        <button type="button" id="save-purchasereturn-button"
                            class="btn btn-primary ms-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>