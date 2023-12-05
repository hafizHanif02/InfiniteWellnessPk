<x-layouts.app title="Products List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5">
                    <h3>Adjustment Products</h3>
                    <a href="{{ route('inventory.products.adjustment.create') }}" class="btn btn-primary">Add
                        Adjustment</a>
                </div>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td scope="col">Adjustment #</td>
                            <td scope="col">Product Name</td>
                            <td scope="col">Batch #</td>
                            <td scope="col">Current Quantity</td>
                            <td scope="col">Adjustment Quantity</td>
                            <td scope="col">Difference Quantity</td>
                            <td scope="col">Adjustment Date</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adjustment as $product)
                            <tr>
                                <td scope="row">{{ $product->id }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->batch->batch_no }}</td>
                                <td>{{ $product->current_qty }}</td>
                                <td>{{ $product->adjustment_qty }}</td>
                                <td>{{ $product->different_qty }}</td>
                                <td>{{ $product->created_at }}</td>
                            </tr>
                        @endforeach
                        @if (count($adjustment) == 0)
                            <tr class="text-center">
                                <td colspan="5" class="text-danger">No product found!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{ $adjustment->links() }}
                <div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
