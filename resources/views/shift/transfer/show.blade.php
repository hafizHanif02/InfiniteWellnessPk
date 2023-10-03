<x-layouts.app title="Transfer Detail">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Transfer Detail</h3>
                <a href="{{ route('shift.transfers.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered text-start">
                    <tr>
                        <th>Code:</th>
                        <td>{{ $transfer->id }}</td>
                    </tr>
                    <tr>
                        <th>Supply Date:</th>
                        <td>{{ $transfer->supply_date }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>{{ $transfer->status == null ? 'Pending' : (1 ? 'Approved' : 'Rejected') }}</td>
                    </tr>
                </table>
            </div>
        </div>


        <div class="card">
            <div class="card-header d-flex justify-content-center">
                <h3>PRODUCTS</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Product</th>
                            <th>Total Piece</th>
                            <th>Price Per Unit</th>
                            <th>Unit of Measurement</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transfer->transferProducts as $transferProduct)
                            <tr>
                                <td>{{ $transferProduct->product->product_name }}</td>
                                <td>{{ $transferProduct->total_piece }}</td>
                                <td>{{ number_format($transferProduct->price_per_unit , 2, '.', '')}}</td>
                                <td>{{ $transferProduct->unit_of_measurement == 1 ? 'Unit' : 'Box' }}</td>
                                <td>{{ number_format($transferProduct->amount, 2, '.', '') }}</td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td class="text-danger" colspan="2">No product found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
