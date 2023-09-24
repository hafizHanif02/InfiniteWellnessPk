<x-layouts.app title="Purchase Order Detail">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Purchase Order Detail</h3>
                    <a href="{{ route('purchase.purchaseorder.index') }}"
                        class="btn btn-secondary float-end mr-5 mb-3">Back</a>
                </div>
                <table class="table table-bordered table-hover text-start">
                    <tbody>
                        <tr>
                            <th>Code</th>
                            <td>{{ $requistion->id }}</td>
                        </tr>
                        <tr>
                            <th>Vendor</th>
                            <td>{{ $requistion->vendor->account_title }}</td>
                        </tr>
                        <tr>
                            <th>Remarks</th>
                            <td>{{ $requistion->remarks ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Delivery Date</th>
                            <td>{{ $requistion->delivery_date ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center h1">Products</th>
                        </tr>
                        @foreach ($requistion->requistionProducts as $requistionProduct)
                            <tr>
                                <td class="py-5" colspan="2"></td>
                            </tr>
                            <tr>
                                <th>Product Name</th>
                                <td>{{ $requistionProduct->product->product_name }}</td>
                            </tr>
                            <tr>
                                <th>Product Description</th>
                                <td>{{ $requistionProduct->product->package_detail }}</td>
                            </tr>
                            <tr>
                                <th>Unit Of Measurement</th>
                                <td>{{ $requistionProduct->limit == 1 ? 'Unit' : 'Box' }}</td>
                            </tr>
                            <tr>
                                <th>Total Packs</th>
                                <td>{{$requistionProduct->total_piece/$requistionProduct->product->pieces_per_pack}} packs</td>
                            </tr>
                            <tr>
                                <th>Total Quantity</th>
                                <td>{{ $requistionProduct->total_piece }} Pieces</td>
                            </tr>
                            <tr>
                                <th>Total Amount</th>
                                <td>Rs {{ $requistionProduct->total_amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
