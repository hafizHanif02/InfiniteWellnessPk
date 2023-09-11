<x-layouts.app title="Purchase Return Detail">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Purchase Return Detail</h3>
                    <a href="{{ route('purchase.return.index') }}"
                        class="btn btn-secondary float-end mr-5 mb-3">Back</a>
                </div>
                <table class="table table-bordered table-hover text-start">
                    <tbody>
                        <tr>
                            <th>Return Code</th>
                            <td>{{ $purchasereturn->id }}</td>
                        </tr>
                        <tr>
                            <th>Good Receive Note #</th>
                            <td>{{ $purchasereturn->goodReceiveNote->id }}</td>
                        </tr>
                        <tr>
                            <th>Remark</th>
                            <td>{{ $purchasereturn->remark ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-5" colspan="2"></td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center h1">Product</th>
                        </tr>
                        <tr>
                            <th>Product Code</th>
                            <td>{{ $purchasereturn->product->id }}</td>
                        </tr>
                            <tr>
                                <th>Product Name</th>
                                <td>{{ $purchasereturn->product->product_name }}</td>
                            </tr>
                            <tr>
                                <th>Quantity Return</th>
                                <td>{{ $purchasereturn->quantity }}</td>
                            </tr>
                            <tr>
                                <th>Amount Return</th>
                                <td>{{ $purchasereturn->price }}</td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
