<x-layouts.app title="Products List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Products</h3>
                    <div class="d-flex gap-5">
                        <div>
                            <a href="{{ asset('csv/Products.xlsx') }}" class="btn btn-danger" download>Download
                                sample</a>
                        </div>
                        <form id="csv-form" action="{{ route('inventory.products.import-excel') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="products_csv" id="products_csv" style="display: none;">
                            <label for="products_csv" class="btn btn-secondary float-end mr-5 mb-3">Import
                                Excel</label>
                            <button type="submit" class="btn btn-secondary float-end mr-5 mb-3"
                                style="display: none;">button</button>
                        </form>
                        <a href="{{ route('inventory.products.create') }}"
                            class="btn btn-primary float-end mr-5 mb-3">Add
                            New</a>
                    </div>
                </div>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td scope="col" id="serial_number">#</td>
                            <td scope="col" id="name">Name</td>
                            <td scope="col" id="quantity">Total Quantity</td>
                            <td scope="col" id="last_insert">Last Purchase Date</td>
                            <td scope="col" id="actions">Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td scope="row" headers="serial_number">{{ $product->id }}</td>
                                <td headers="name">{{ $product->product_name }}</td>
                                <td headers="quantity">{{ $product->total_quantity  }}</td>
                                <td headers="last_insert">{{ $product->goodReceiveProducts()->orderBy('created_at', 'desc')->first()->updated_at ?? '-' }}</td>
                                <td headers="actions" class="d-flex justify-content-center gap-5">
                                    <a href="{{ route('inventory.products.edit', $product->id) }}" aria-label="Edit"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="{{ route('inventory.products.show', $product->id) }}"
                                        aria-label="Detail"><i class="fa fa-eye"></i></a>
                                    <form action="{{ route('inventory.products.destroy', $product->id) }}"
                                        method="POST" id="delete-product-form{{ $product->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="deleteProduct({{ $product->id }})" class="bg-transparent border-0 text-danger"
                                            aria-label="Delete Product" id="delete-product-button"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5" class="text-danger">No product found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $('input[name="products_csv"]').change(function() {
                $('#csv-form').submit();
            });
            function deleteProduct(productId) {
                $(this).prop('disabled', true);
                $('#delete-product-form'+productId).submit();
            };
        </script>
    @endpush
</x-layouts.app>
