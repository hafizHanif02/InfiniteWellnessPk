<x-layouts.app title="Good Receive Note Create">
    @push('styles')
        <link nonce="{{ csp_nonce() }}" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
            rel="stylesheet" />
    @endpush
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Batch POS</h3>
                <a href="{{ route('inventory.products.batch-pos-report') }}" class="btn btn-secondary mb-3">Back</a>
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-start">
                            <th> Medicine Id </th>
                            <td>{{ $product->id }}</td>

                        </tr>
                        <tr>
                            <th class="text-start"> Medicine Name </th>
                            <td>{{ $product->name }}</td>

                        </tr>
                    </thead>
                    </tbody>

                </table>

            </div>
            <div class="card-body">

                <table class="table table-bordered">
                    <thead class="table-dark">
                        <th>Batch Id</th>
                        <th>Unit Trade</th>
                        <th>Unit Retail</th>
                        <th>Quantity</th>
                        <th>Sold Quantity</th>
                        <th>Remaining Qty</th>
                        <th>Expiry Date</th>
                    </thead>
                    <tbody class="table-light">
                        @foreach ($batches as $product)  
                        <tr>
                                <td>{{ $product->batch_id }}</td>
                                <td>{{ $product->unit_trade }}</td>
                                <td>{{ $product->unit_retail }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->sold_quantity }}</td>
                                <td>{{ $product->remaining_qty }}</td>
                                <td>{{ $product->expiry_date }}</td>

                        
                        </tr>
                        @endforeach
                        @if(count($batches) == 0)
                            <tr class="text-center text-danger"><td>No data found</td></tr>
                        @endif
                        
                    </tbody>
                </table>
            </div>
</x-layouts.app>
