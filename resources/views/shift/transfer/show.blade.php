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
                        <th>Supply Date</th>
                        <td>{{ $transfer->supply_date }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>{{ $transfer->status == null ? 'Pending' : (1 ? 'Approved' : 'Rejected') }}</td>
                    </tr>
                    <tr>
                        <th>Supply Date:</th>
                        <td>{{ $transfer->supply_date }}</td>
                    </tr>
                    <tr>
                        <th colspan="2" class="h2">PRODUCTS</th>
                    </tr>
                    @forelse ($transfer->transferProducts as $transferProduct)
                        <tr>
                            <th>Product</th>
                            <td>{{ $transferProduct->product->product_name }}</td>
                        </tr>
                        <tr>
                            <th>Total Piece</th>
                            <td>{{ $transferProduct->total_piece }}</td>
                        </tr>
                        <tr>
                            <th>Price Per Unit</th>
                            <td>{{ $transferProduct->price_per_unit }}</td>
                        </tr>
                        <tr>
                            <th>Unit of Measurement</th>
                            <td>{{ ($transferProduct->unit_of_measurement == 1)?'Unit':'Box' }}</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td>{{$transferProduct->amount}}</td>
                        </tr>
                        <tr>
                            <th colspan="2"></th>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td class="text-danger" colspan="2">No product found!</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
