<x-layouts.app title="Good Receive Note Detail">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Good Receive Note Detail</h3>
                    <div class="d-flex gap-5">
                        <a href="{{ route('purchase.good_receive_note.print', $goodReceiveNote->id) }}"
                            class="btn btn-primary float-end mr-5 mb-3">Print</a>
                        <a href="{{ route('purchase.good_receive_note.index') }}"
                            class="btn btn-secondary float-end mr-5 mb-3">Back</a>
                            @role('Admin|PharmacistAdmin')
                                <button  class="btn btn-danger float-end mr-5 mb-3" onclick="ExportToExcel('xlsx')">Export to Excel</button>
                            @endrole
                            </div>
                </div>
                <table class="table table-bordered table-hover text-start" >
                    <tbody >
                        <tr>
                            <th>Invoice #</th>
                            <td>{{ $goodReceiveNote->invoice_number }}</td>
                        </tr>
                        <tr>
                            <th>Invoice Date</th>
                            @if($goodReceiveNote->invoice_date == null)
                                <td>-</td>
                            @endif
                            <td>{{ $goodReceiveNote->invoice_date  }}</td>
                        </tr>
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
                                <td>{{ $goodReceiveNoteProduct->manufacturer_retail_price }}</td>
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
        <table class="table table-bordered table-hover text-start" id="add-products" style="display: none;">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Invoice Date</th>
                    <th>Distributor Name</th>
                    <th>item Name </th>                
                    {{-- <th>Pack Size</th>           --}}
                    {{-- <th>Rate</th>         --}}
                    <th>Qty</th>    
                    <th>Unit</th>
                   <th>Per Unit Trade Price</th>          
                    <th>Total Trade price </th>
                    <th>Discount on Trade Price %</th>
                    {{-- <th>Discount on TP %</th> --}}
                    <th>Sales Tax %</th>
                    <th>Sale Tax Amount</th>
                    {{-- <th>Inclusive of Sale Tax Final-Cost</th> --}}
                    <th>Final Per Unit Cost</th>
                    <th>Advance Tax (%)</th>
                    <th>Net Total Amount </th>
                    {{-- <th>Mrp Rate in Box </th> --}}
                   {{-- <th>Mrp Rate</th>   --}}
                   <th>Mrp Per Unit </th>  
                   {{-- <th>Profit Margin </th>               
                    <th> Profit</th> --}}
                    <th>Expiry </th>
                </tr>
            </thead>
            <tbody>
                    @foreach($GrnProducts as $product)
                    <tr>
                        <td>{{ $product->goodReceiveNote->invoice_number }}</td>
                        <td>{{ $product->goodReceiveNote->invoice_date }}</td>
                        <td>{{ $product->requistionProduct->requistion->vendor->account_title }}</td>
                        <td>{{ $product->product->product_name }}</td>
                        <td>{{ $product->deliver_qty }}</td>
                        <td>{{ $product->product->unit_of_measurement ? 'Pcs' : 'Unit' }}</td>
                        <td>{{ $product->product->trade_price }}</td>
                        <td>{{ $product->product->trade_price * $product->deliver_qty }}</td>
                        <td>{{ $product->product->discount_trade_price }}</td>
                        <td>{{ $product->saletax_percentage }}</td>
                        <td>{{ $product->saletax_amount }}</td>
                        <td>{{ $product->item_amount }}</td>
                        <td>{{ $product->goodReceiveNote->advance_tax_percentage }}</td>
                        <td>{{ $product->goodReceiveNote->net_total_amount }}</td>
                        <td>{{ $product->manufacturer_retail_price }}</td>
                        <td>{{ $product->expiry_date }}</td>
                    </tr>
                    @endforeach


                {{-- <td>{{ $goodReceiveNote->invoice_number }}</td>
                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $goodReceiveNote->invoice_date)->format('d-m-Y') }}</td>
                <td>{{ $goodReceiveNote->requistion->vendor->account_title }}</td>
                @foreach ($goodReceiveNote->goodReceiveProducts as $goodReceiveNoteProduct)
                <td>{{ $goodReceiveNoteProduct->product->product_name }}</td>
                <td>{{ $goodReceiveNoteProduct->deliver_qty  }}</td>
                <td>{{ $goodReceiveNoteProduct->product->limit == 0 ? 'Unit' : 'Box' }}</td>
                <td>{{ $goodReceiveNoteProduct->product->trade_price  }}</td>
                <td>{{ $goodReceiveNoteProduct->product->discount_trade_price  }}</td>
                <td>{{ $goodReceiveNoteProduct->product->trade_price_percentage  }}</td>
                <td>{{ $goodReceiveNoteProduct->sale_tax_percentage  }}</td>
                <td>{{ $goodReceiveNoteProduct->saletax_amount  }}</td>               
                <td>{{ $goodReceiveNoteProduct->item_amount  }}</td>
                @endforeach
                <td>{{ $goodReceiveNote->advance_tax_percentage  }}</td>
                <td>{{ $goodReceiveNote->net_total_amount  }}</td>
                @foreach($goodReceiveNote->goodReceiveProducts as $goodReceiveNoteProduct)
                <td>{{ $goodReceiveNoteProduct->manufacturer_retail_price }}</td>
                <td>{{ $goodReceiveNoteProduct->expiry_date }}</td>
                @endforeach  --}}
            </tbody>
        </table>
    </div>
</x-layouts.app>
<script type="text/javascript" src=" https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js "></script>
<script>
      function ExportToExcel(type, fn, dl) {

                var elt = document.getElementById('add-products');
                var wb = XLSX.utils.table_to_book(elt, {
                    sheet: "sheet1"
                });
                var currentDate = new Date();
                var day = currentDate.getDate().toString().padStart(2, '0');
                var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
                var year = currentDate.getFullYear();
                var formattedDate = day + '-' + month + '-' + year;
                var fileName = 'GRN Product (' + formattedDate + ').xlsx';

                return dl ?
                    XLSX.write(wb, {
                        bookType: type,
                        bookSST: true,
                        type: 'base64'
                    }) :
                    XLSX.writeFile(wb, fn || fileName);
            }
</script>
