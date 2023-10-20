<x-layouts.app title="Product Detail">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Product Detail</h3>
                <a href="{{ route('inventory.products.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered text-start">
                    <tr>
                        <th>Code:</th>
                        <td>{{$product->id }}</td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td>{{$product->product_name }}</td>
                    </tr>
                    <tr>
                        <th>Dricetion Of Use:</th>
                        <td>{{$product->dricetion_of_use }}</td>
                    </tr>
                    <tr>
                        <th>Common Side Effect:</th>
                        <td>{{$product->common_side_effect }}</td>
                    </tr>
                    <tr>
                        <th>Dosage Form:</th>
                        <td>{{$product->dosage->name }}</td>
                    </tr>
                    <tr>
                        <th>Generic Formula:</th>
                        <td>{{$product->generic->formula }}</td>
                    </tr>
                    <tr>
                        <th>Package Detail:</th>
                        <td>{{$product->package_detail ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Product Category:</th>
                        <td>{{$product->productCategory->name }}</td>
                    </tr>
                    <tr>
                        <th>Manufacturer:</th>
                        <td>{{$product->manufacturer->company_name }}</td>
                    </tr>
                   
                    <tr>
                        <th>Unit of Measurement:</th>
                        <td>{{($product->least_unit == 1)?'Packet':'Pcs' }}</td>
                    </tr>
                    <tr>
                        <th>Manufacturer Retail Price:</th>
                        <td>{{$product->manufacturer_retail_price }}</td>
                    </tr>
                    <tr>
                        <th>Trade Price %:</th>
                        <td>{{$product->trade_price_percentage }}%</td>
                    </tr>
                    <tr>
                        <th>Trade Price:</th>
                        <td>{{$product->trade_price }}</td>
                    </tr>
                    <tr>
                        <th>Discount % On Trade Price:</th>
                        <td>{{$product->discount_trade_price }}%</td>
                    </tr>
                    <tr>
                        <th>Pieces Per Pack:</th>
                        <td>{{$product->pieces_per_pack }} Peice</td>
                    </tr>
                    <tr>
                        <th>Total Packs</th>
                        <td>{{$product->number_of_pack }} Packs</td>
                    </tr>
                    <tr>
                        <th>Unit Retail:</th>
                        <td>{{$product->unit_retail }}</td>
                    </tr>
                    <tr>
                        <th>Unit Trade</th>
                        <td>{{$product->unit_trade}}</td>
                    </tr>
                    <tr>
                        <th>Cost Price:</th>
                        <td>{{$product->cost_price }}</td>
                    </tr>
                    <tr>
                        <th>Total Quantity</th>
                        <td>{{$product->total_quantity }} Peices</td>
                    </tr>
                    <tr>
                        <th>Fixed Discount:</th>
                        <td>{{$product->fixed_discount ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Sales Tax Percentage:</th>
                        <td>{{$product->sale_tax_percentage.'%' ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Barcode:</th>
                        <td>{{$product->barcode ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
