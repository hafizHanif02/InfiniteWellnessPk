<x-layouts.app title="Good Receive Status Detail">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Good Receive Status Detail</h3>
                    <div class="d-flex gap-5">
                        <a href="{{ route('purchase.good_receive_note.print', $goodReceiveNote->id) }}"
                            class="btn btn-primary float-end mr-5 mb-3">Print</a>
                        <a href="{{ route('purchase.good-receive-statuses.index') }}"
                            class="btn btn-secondary float-end mr-5 mb-3">Back</a>
                        </div>
                </div>
                <table class="table table-bordered table-hover text-start">
                    <tbody>
                        <tr>
                            <th>Code</th>
                            <td>{{ $goodReceiveNote->id }}</td>
                        </tr>
                        <tr>
                            <th>Vendor</th>
                            <td>{{ $goodReceiveNote->requistion->vendor->account_title }}</td>
                        </tr>
                        <tr>
                            <th>Remarks</th>
                            <td>{{ $goodReceiveNote->remark ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $goodReceiveNote->date ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td>{{$goodReceiveNote->total_amount }}</td>
                        </tr>
                        <tr>
                            <th>Advance Tax Percentage</th>
                            <td>{{$goodReceiveNote->advance_tax_percentage.'%' ?? '-' }} </td>
                        </tr>
                        <tr>
                            <th>Sale Tax Percentage</th>
                            <td>{{$goodReceiveNote->sale_tax_percentage.'%' ?? '-'  }}</td>
                        </tr>
                        <tr>
                            <th>Net Total Amount</th>
                            <td>{{ $goodReceiveNote->net_total_amount }}</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center h1">Products</th>
                        </tr>

                        @foreach ($goodReceiveNote->goodReceiveProducts as $goodReceiveNoteProduct)
                            <tr>
                                <td class="py-5" colspan="2"></td>
                            </tr>
                            <tr>
                                <th>Product Name</th>
                                <td>{{ $goodReceiveNoteProduct->product->product_name }}</td>
                            </tr>
                            <tr>
                                <th>Product Description</th>
                                <td>{{ $goodReceiveNoteProduct->product->package_detail }}</td>
                            </tr>
                            <tr>
                                <th>Total Stock</th>
                                <td>{{ $goodReceiveNoteProduct->product->total_quantity }}</td>
                            </tr>
                            <tr>
                                <th>Unit Of Measurement</th>
                                <td>{{ $goodReceiveNoteProduct->product->limit == 0 ? 'Unit' : 'Box' }}</td>
                            </tr>
                            <tr>
                                <th>Deliver Quantity</th>
                                <td>{{ $goodReceiveNoteProduct->deliver_qty }}</td>
                            </tr>
                            <tr>
                                <th>Bonus</th>
                                <td>{{ ($goodReceiveNoteProduct->bonus)?? 0}}</td>
                            </tr>
                            <tr>
                                <th>Piece Quantity</th>
                                <td>{{ $goodReceiveNoteProduct->deliver_qty }}</td>
                            </tr>
                            <tr>
                                <th>Manufacture Purchase Rate</th>
                                <td>{{ $goodReceiveNoteProduct->product->manufacturer_retail_price }}</td>
                            </tr>
                            <tr>

                                <th>Sale Tax</th>
                                <td>{{ $goodReceiveNoteProduct->goodReceiveNote->sale_tax_percentage ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Total Amount</th>
                                <td>{{ $goodReceiveNoteProduct->item_amount }}</td>
                            </tr>
                            <tr>
                                <th>Expiry Date</th>
                                <td>{{ $goodReceiveNoteProduct->expiry_date }}</td>
                            </tr>
                            <tr>
                                <th>Batch #</th>
                                <td>{{ $goodReceiveNoteProduct->batch_number }}</td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
