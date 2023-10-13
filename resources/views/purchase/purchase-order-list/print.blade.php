<x-layouts.print>
    <table border="1" class="table table-bordered">
        <thead class="table-dark text-dark">
            <tr class="text-center">
                <th colspan="12" class="no-bottom-border">
                    <div class="text-start">
                        <img nonce="{{ csp_nonce() }}" width="200px" class="img-fluid"
                            src="https://infinitewellnesspk.com/wp-content/uploads/2023/05/1.png" alt="">
                    </div>
                    <div class="text-center">
                        PURCHASE ORDER <br> INFINITE PHARMACY SERVICES
                    </div>
                </th>
            </tr>
            <tr>
                <th class="top-border">PO DATE:</th>
                <th class="text-start top-border" colspan="11">{{ $requistion->delivery_date }}</th>
            </tr>
            <tr>
                <th class="no-border">PO #:</th>
                <th class="text-start no-border" colspan="11">{{ $requistion->id }}</th>
            </tr>
            <tr>
                <th class="no-border">SUPPLIER:</th>
                <th class="text-start no-border" colspan="4">{{ $requistion->vendor->account_title }}</th>
                <th class="text-start no-border" colspan="5">{{ $requistion->vendor->address }} <br>
                    {{ $requistion->vendor->area }}</th>
                <th class="text-start" colspan="2" rowspan="2">Ship to: STORE 1 PHARMACY</th>
            </tr>
            <tr>
                <th class="no-border">MANUFACTURER:</th>
                <th class="text-start no-border" colspan="9">
                    {{-- @foreach ($requistion->requistionProducts as $requistionProduct)
                        {{ $requistionProduct->product->manufacturer->company_name }}
                    @endforeach --}} 
                    @if (isset($requistion->manufacturer->company_name))
                    {{ $requistion->manufacturer->company_name }}
                    @else
                    -
                    @endif

                </th>
            </tr>
            <tr>
                <th class="text-center">S. No</th>
                <th class="text-center">Description</th>
                <th class="text-center" >QTY</th>
                <th class="text-center">PRICE</th>
                <th class="text-center">PACK SIZE</th>
                <th class="text-center">LEAST UNIT</th>
                <th class="text-center">TP WITH S.T</th>
                <th class="text-center">GROSS AMT</th>
                <th class="text-center">DIS ON TP</th>
                <th class="text-center">SALE TAX %</th>
                <th class="text-center">AMOUNT</th>
                <th class="text-center">NET COST UNIT</th>
            </tr>
        </thead>
        <tbody class="table-bordered text-dark" style="border: 2px solid black">
            @foreach ($requistion->requistionProducts as $requistionproduct)
                <tr>
                    <td class="text-center"  scope="row">{{ $loop->iteration }}</td>
                    <td class="text-center" >{{ $requistionproduct->product->product_name }}</td>
                    <td class="text-center">{{ number_format($requistionproduct->total_piece/$requistionproduct->product->pieces_per_pack, 2, '.', '') }}</td>
                    <td class="text-center">{{ $requistionproduct->product->unit_retail }} </td>
                    <td class="text-center">{{$requistionproduct->product->pieces_per_pack}}
                    <td class="text-center">{{ ($requistionproduct->limit == 0)?'Pack':'Piece' }}</td>
                    <td class="text-center">{{ $requistionproduct->price_per_unit }}</td>
                    <td class="text-center">{{ $requistionproduct->total_amount}}</td>
                    {{-- {{dd($requistionproduct)}} --}}
                    <td class="text-center">{{ number_format($requistionproduct->discount_percentage, 2, '.', '') }} %</td>
                    <td class="text-center">{{ ($requistionproduct->product->sale_tax != null)?$requistionproduct->product->sale_tax.'%':'-' }} </td>
                    <td class="text-center" class="text-center">{{ $requistionproduct->total_amount }}</td>
                    <td class="text-center">{{ number_format($requistionproduct->total_amount, 2, '.', '') }}</td>
                </tr>
            @endforeach
            <tr>
                <td scope="row" rowspan="3" colspan="9"></td>
                <th>Total</th>
                <th>{{ number_format($requistion->requistionProducts->sum('total_amount'), 2, '.', '') }}</th>
                <th>{{ number_format($requistion->requistionProducts->sum('total_amount'), 2, '.', '') }}</th>
            </tr>
            <tr>
                <th>Dis Amount</th>
                
                <th>{{ number_format($requistion->discount_amount, 2, '.', '')}}</th>
                <th>{{ number_format($requistion->discount_amount, 2, '.', '')}}</th>
            </tr>
            <tr>
                <th>Grand Total</th>
                <th>{{ number_format($totalcost - $requistion->discount_amount, 2, '.', '') }}</th>
                <th>{{ number_format($totalcost - $requistion->discount_amount, 2, '.', '') }}</th>
            </tr>
            <tr rowspan="2">
                <th style="padding: 20px;" class="text-center" colspan="6">Prepared By:</th>
                <th style="padding: 20px;" class="text-center" colspan="4">Checked By:</th>
                <th style="padding: 20px;" class="text-center" colspan="2">Approved By:</th>
            </tr>

            <tr rowspan="2">
                <th style="padding: 20px;" class="text-center" colspan="6">ASSISTANT MANAGER SUPPLY CHAIN</th>
                <th style="padding: 20px;" class="text-center" colspan="4">FINANCE</th>
                <th style="padding: 20px;" class="text-center" colspan="2">DIRECTOR OPERATION</th>
            </tr>
        </tbody>
    </table>
    <script nonce="{{ csp_nonce() }}">
        window.print();
    </script>
    <style>
        .text-center{
            text-align: center;
        }
    </style>
</x-layouts.print>
