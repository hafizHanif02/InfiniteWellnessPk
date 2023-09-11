@extends('layouts.app')
@section('title')
    Transfer Report Detail
@endsection
@section('content')
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Transfer Report Detail</h3>
                    <div>
                        @if ($stockReport->count() > 0)
                            <a href="{{ route('new-stocks.report') }}" class="btn btn-primary me-5">Print</a>
                        @endif
                        <a href="{{ route('new-stocks.report') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Issue Date</th>
                            <td>{{ $stockReport->supply_date }}</td>
                        </tr>
                        <tr>
                            <th>Code</th>
                            <td>{{ $stockReport->id }}</td>
                        </tr>
                        <tr>
                            <th>Total Price Amount</th>
                            <td>{{ $stockReport->total_price_amount }}</td>
                        </tr>
                        <tr>
                            <th>Total Supply Quantity</th>
                            <td>{{ $stockReport->total_supply_quantity }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center h1">Products</td>
                        </tr>
                        @forelse ($stockReport->transferProducts as $transferProduct)
                            <tr>
                                <th>Code:</th>
                                <td>{{ $transferProduct->product->code }}</td>
                            </tr>
                            <tr>
                                <th>Name:</th>
                                <td>{{ $transferProduct->product->product_name }}</td>
                            </tr>
                            <tr>
                                <th>Group:</th>
                                <td>{{ $transferProduct->product->group->name }}</td>
                            </tr>
                            <tr>
                                <th>Generic Formula:</th>
                                <td>{{ $transferProduct->product->generic->formula }}</td>
                            </tr>
                            <tr>
                                <th>Package Detail:</th>
                                <td>{{ $transferProduct->product->package_detail ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>transferProduct Category:</th>
                                <td>{{ $transferProduct->product->productCategory->name }}</td>
                            </tr>
                            <tr>
                                <th>Manufacturer:</th>
                                <td>{{ $transferProduct->product->manufacturer->company_name }}</td>
                            </tr>
                            <tr>
                                <th>Vendor:</th>
                                <td>{{ $transferProduct->product->vendor->account_title }}</td>
                            </tr>
                            <tr>
                                <th>Least Unit:</th>
                                <td>{{ $transferProduct->product->least_unit == 1 ? 'Packet' : 'Pcs' }}</td>
                            </tr>
                            <tr>
                                <th>Manufacturer Retail Price:</th>
                                <td>{{ $transferProduct->product->manufacturer_retail_price }}</td>
                            </tr>
                            <tr>
                                <th>Trade Price %:</th>
                                <td>{{ $transferProduct->product->trade_price_percentage }}%</td>
                            </tr>
                            <tr>
                                <th>Trade Price:</th>
                                <td>{{ $transferProduct->product->trade_price }}</td>
                            </tr>
                            <tr>
                                <th>Discount % On Trade Price:</th>
                                <td>{{ $transferProduct->product->discount_trade_price }}%</td>
                            </tr>
                            <tr>
                                <th>Pieces Per Pack:</th>
                                <td>{{ $transferProduct->product->pieces_per_pack }} Pack</td>
                            </tr>
                            <tr>
                                <th>Unit Retail:</th>
                                <td>{{ $transferProduct->product->unit_retail }}</td>
                            </tr>
                            <tr>
                                <th>Unit Trade</th>
                                <td>{{ $transferProduct->product->unit_trade }}</td>
                            </tr>
                            <tr>
                                <th>Cost Price:</th>
                                <td>{{ $transferProduct->product->cost_price }}</td>
                            </tr>
                            <tr>
                                <th>Packing</th>
                                <td>{{ $transferProduct->product->packing }}</td>
                            </tr>
                            <tr>
                                <th>Fixed Discount:</th>
                                <td>{{ $transferProduct->product->fixed_discount ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Sales Tax:</th>
                                <td>{{ $transferProduct->product->sale_tax ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Barcode:</th>
                                <td>{{ $transferProduct->product->barcode ?? '-' }}</td>
                            </tr>
                        @empty
                            <td></td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
