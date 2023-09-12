<x-layouts.print>
    <table class="table table-bordered">
        <thead class="table-dark text-dark">
            <tr class="text-center">
                <th colspan="15" class=" no-bottom-border">
                    <div class="text-start">
                        <img nonce="{{ csp_nonce() }}" width="250px" style="padding: 10px" class="img-fluid"
                            src="https://infinitewellnesspk.com/wp-content/uploads/2023/05/1.png" alt="">
                    </div>
                    <div class="text-center">
                        <h2>
                            PURCHASE REQUISTION FORM
                        </h2>
                    </div>
                </th>
            </tr>
            <tr class="bg-green padding-topbottom padding-row">
                <th colspan="1">SUPPLIER: {{ $requistion->vendor->contact_person }}</th>
                <th colspan="2">DEPARTMENT:PHARMACY</th>
                <th colspan="2">DATE</th>
                <th colspan="2">{{ $requistion->delivery_date }}</th>
                <th colspan="8"></th>
            </tr>
            <tr class="bg-green padding-topbottom padding-row">
                <th colspan="7">ORDER</th>
                <th colspan="4">LAST PURCHASE</th>
                <th colspan="4">STOCK MOVEMENT</th>
            </tr>
            <tr class="padding-row">
                <th>Item No.</th>
                <th>Description of items</th>
                <th>Request Quantity</th>
                <th>PRICE</th>
                <th>DIS%</th>
                <th>TAX%</th>
                <th>TOTAL AMOUNT</th>
                <th>DATE</th>
                <th>QTY</th>
                <th>PRICE</th>
                <th>DIS%</th>
                <th>OPENING</th>
                <th>CONSUM.</th>
                <th>CLOSING</th>
                <th>MONTH AVERAGE.</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requistionProducts as $requistionProduct)
                <tr class="text-center-data">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $requistionProduct->product->product_name }}</td>
                    <td>{{ $requistionProduct->total_piece }}</td>
                    <td>{{ $requistionProduct->total_amount / $requistionProduct->total_piece }}</td>
                    <td>{{ $requistionProduct->discount_percentage }}%</td>
                    <td>{{ ($requistionProduct->sale_tax == 0)?'-':$requistionProduct->sale_tax.'%' }}</td>
                    <td>{{ $requistionProduct->total_amount }}</td>
                    @if($last_purchase)
                    @foreach ($last_purchase->goodReceiveProducts as $goodReceiveProducts)
                    @if ($requistionProduct->product->id == $goodReceiveProducts->product_id)
                    <td>{{$last_purchase->date}}</td>
                    <td>{{$goodReceiveProducts->deliver_qty}}</td>
                    <td>{{$goodReceiveProducts->item_amount}}</td>
                    <td>{{$goodReceiveProducts->discount}}</td>
                    <td>{{$goodReceiveProducts->product->open_quantity }}</td>
                    <td>{{($requistionProduct->consume== 0)?'-':$requistionProduct->consume}}</td>
                    <td>{{$goodReceiveProducts->product->total_quantity}}</td>
                    <td>{{($requistionProduct->averageMonthly == 0)?'-':$requistionProduct->averageMonthly }}</td>
                    @endif
                    @endforeach
                    @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @endif
                </tr>
            @empty
                <tr>
                    <th colspan="15"><span class="text-danger">Not Any Product Found</span></th>
                </tr>
            @endforelse

            <tr class="padding-row">
                <th colspan="15"></th>
            </tr>
            <tr class="padding-row">
                <th colspan="1">Line Manager</th>
                <th colspan="2"></th>
                <th colspan="1">Project Manager</th>
                <th colspan="3"></th>
            </tr>
            <tr class="padding-row">
                <th colspan="1">Signature</th>
                <th colspan="2"></th>
                <th colspan="1">Signature</th>
                <th colspan="3"></th>
            </tr>
            <tr class="padding-row">
                <th colspan="1">Finance Dept:</th>
                <th colspan="2"></th>
                <th colspan="1">Purchase Dept.:</th>
                <th colspan="3"></th>
            </tr>
        </tbody>
    </table>

    <style nonce="{{ csp_nonce() }}">
        @media print {
            @page {
                size: landscape;
            }

            body {
                background-image: initial !important;
            }
        }
    </style>
    <script>
        window.print();
    </script>
</x-layouts.print>
