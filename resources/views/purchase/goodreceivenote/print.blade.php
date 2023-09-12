<x-layouts.print>
    <div class="container-fluid">
        <table class="table-bordered">
            <thead class="">
                <tr>
                    <th colspan="9" class="no-bottom-border">
                        <div class="text-start">
                            <img width="200px" class="img-fluid"
                                src="https://infinitewellnesspk.com/wp-content/uploads/2023/05/1.png" alt="">
                        </div>
                        <div class="text-center">
                            GOOD RECEIVING NOTES <br> INFINITE PHARMACY SERVICES
                        </div>
                    </th>
                    <th colspan="4">
                        <table style="margin: 0; padding: 0" class="no-border no-bottom-border">
                            <tbody>
                                {{-- <tr class="no-border">
                                    <th>INV#</th>
                                    <td class="no-border">{{ $goodReceiveNote->grn_number }}</td>
                                </tr> --}}
                                <tr class="no-border">
                                    <th>SUPPLY DATE:</th>
                                    <td class="no-border">{{ $goodReceiveNote->date }}</td>
                                </tr class="no-border">
                                <tr class="no-bottom-border">
                                    <th>GRN#</th>
                                    <td class="no-border no-bottom-border">{{ $goodReceiveNote->id }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </th>
                </tr>
                <tr>
                    <th class="no-border">PO DATE</th>
                    <th class="text-start no-border" colspan="8">{{( $goodReceiveNote->requistion === null)?'-': $goodReceiveNote->requistion->delivery_date}}
                    </th>
                    <th colspan="4" rowspan="2"></th>
                </tr>
                <tr>
                    <th class="no-border">PO #</th>
                    <th class="text-start no-border" colspan="11">{{ $goodReceiveNote->requistion->id }}</th>
                </tr>
                <tr>
                    <th class="no-border">SUPPLIER</th>
                    <th class="text-start no-border" colspan="2">
                        {{ $goodReceiveNote->requistion->vendor->account_title }}</th>
                    <th class="text-start no-border" colspan="6">{{ $goodReceiveNote->requistion->vendor->address }}
                        <br>
                        {{ $goodReceiveNote->requistion->vendor->area }}
                    </th>
                    <th class="text-start" colspan="4" rowspan="2">Ship to: STORE 1 PHARMACY</th>
                </tr>

                <tr>
                    <th class="text-start no-border">MANUFACTURER:</th>
                    <th class="text-start no-border" colspan="11">
                        @foreach ($goodReceiveNote->requistion->requistionProducts as $requistionProduct)
                            {{ $requistionProduct->product->manufacturer->company_name }}
                        @endforeach
                    </th>
                </tr>
                <tr>
                    <th>S. No</th>
                    <th>Description</th>
                    <th>PACK SIZE</th>
                    <th>EXP Date</th>
                    <th>BATCH #</th>
                    <th>PRICE</th>
                    <th>RECIVED OTY</th>
                    <th>UNIT PRICE</th>
                    <th>SALE TAX %</th>
                    <th>DIS ON TP</th>
                    <th>ADV TAX %</th>
                    <th>AMOUNT</th>
                    <th>NET COST UNIT</th>
                </tr>
            </thead>
            <tbody class="table-bordered text-center-data">
                @foreach ($goodReceiveNote->goodReceiveProducts as $grnproduct)
                    <tr>
                        <td scope="row">{{ $loop->iteration }}</td>
                        <td>{{ $grnproduct->product->product_name }}</td>
                        <td >{{ $grnproduct->product->pieces_per_pack }}</td>
                        <td >{{ $grnproduct->expiry_date }}</td>
                        <td >{{ $grnproduct->batch_number }}</td>
                        <td>{{ $grnproduct->product->cost_price }}</td>
                        <td>{{ ($grnproduct->deliver_qty == null)?'Wait For Approval': $grnproduct->deliver_qty}}</td>
                        <td>
                            {{ $grnproduct->item_amount}}</td>
                        <td>{{ $goodReceiveNote->sale_tax_percentage }} %</td>
                        <td>{{ $grnproduct->product->discount_trade_price }}.00 %</td>
                        <td>{{ $goodReceiveNote->advance_tax_percentage }}%</td>
                        <td>{{ $grnproduct->item_amount }}</td>
                        <td>{{ $grnproduct->item_amount }}.00</td>
                    </tr>
                @endforeach
                <tr class="text-start">
                    <td scope="row"rowspan="5" colspan="9"></td>
                    <th>TOTAL</th>
                    <th></th>
                    <th></th>
                    <th class="text-center">{{ $goodReceiveNote->total_amount }}</th>
                </tr>
                <tr>
                    <th>DIS AMOUNT</th>
                    <th></th>
                    <th></th>
                    <th class="text-center">{{$goodReceiveNote->total_discount_amount }}</th>
                </tr>
                <tr>
                    <th>ADV TAX</th>
                    <th></th>
                    <th></th>
                    <th class="text-center">{{ ($goodReceiveNote->advance_tax_percentage*$goodReceiveNote->total_amount)/100 }}</th>

                </tr>
                <tr>
                    <th>SALES TAX</th>
                    <th></th>
                    <th></th>
                    <th class="text-center">{{ ($goodReceiveNote->sale_tax_percentage*$goodReceiveNote->total_amount)/100 }}</th>

                </tr>
                <tr>
                    <th>GRAND TOTAL</th>
                    <th></th>
                    <th></th>
                    <th class="text-center">{{ $goodReceiveNote->net_total_amount }}</th>
                </tr>

                <tr>
                    <th class="text-center" style="padding: 20px;" colspan="7">Prepared By:</th>
                    <th class="text-center" style="padding: 20px;" colspan="4">Cheked By:</th>
                    <th class="text-center" style="padding: 20px;" colspan="2">Approved By:</th>
                </tr>

                <tr>
                    <th class="text-center" style="padding: 20px;" colspan="7">ASSISTANT MANAGER SUPPLY CHAIN</th>
                    <th class="text-center" style="padding: 20px;" colspan="4">FINANCE</th>
                    <th class="text-center" style="padding: 20px;" colspan="2">DIRECTOR OPERATION</th>
                </tr>
            </tbody>
        </table>
    </div>
    <script nonce="{{ csp_nonce() }}">
        window.print();
    </script>
</x-layouts.print>
