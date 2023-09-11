<x-layouts.app title="Total Inventory History">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Total Inventory History</h3>
                    <a href="{{ route('shift.stock-in.export') }}" class="btn btn-primary float-end mr-5 mb-3">Print</a>
                </div>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td>#</td>
                            <td>Code</td>
                            <td>Product Name</td>
                            <td>Date</td>
                            <td>Price</td>
                            <td>Quantity</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stockIns as $stockIn)
                            <tr class="data">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $stockIn->code }}</td>
                                <td>{{ $stockIn->product_name }}</td>
                                <td>{{ $stockIn->created_at->format('d M Y') }}</td>
                                <td>Rs{{ $stockIn->cost_price }}</td>
                                <td>{{ $stockIn->packing }} Pcs</td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5" class="text-danger">No Stock In found!</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="4">Total:</td>
                            <td id="total-price"></td>
                            <td id="total-quantity"></td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    {{ $stockIns->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                function updateTotals() {
                    let totalPrice = 0;
                    let totalQuantity = 0;

                    $('.data').each(function() {
                        const price = parseFloat($(this).find('td:eq(4)').text().replace('Rs', '').trim());
                        const quantity = parseInt($(this).find('td:eq(5)').text());

                        if (!isNaN(price)) {
                            totalPrice += price;
                        }

                        if (!isNaN(quantity)) {
                            totalQuantity += quantity;
                        }
                    });

                    $('#total-price').text('Rs' + totalPrice.toFixed(2));
                    $('#total-quantity').text(totalQuantity);
                }

                updateTotals();
            });
        </script>
    @endpush
</x-layouts.app>
