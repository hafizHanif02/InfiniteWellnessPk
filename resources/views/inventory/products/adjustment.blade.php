<x-layouts.app title="Products List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5">
                    <h3>Adjustment Products</h3>
                    <a href="{{ route('inventory.products.adjustment.create') }}" class="btn btn-primary">Add Adjustment</a>
                </div>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td scope="col">Adjustment #</td>
                            <td scope="col" >Product Name</td>
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
                    {{-- @if (count($products) > 0)
                        {!! $products->render() !!}
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script></script>
    @endpush
</x-layouts.app>
<style>
    .search-input {
        padding: 10px;
        border: 2px solid #ccc;
        border-radius: 25px;
        outline: none;
        width: 200px;
        transition: width 0.4s ease-in-out;
        font-size: 16px;
    }

    .search-container {
        display: flex;

    }

    /* Style for the search button */
    .search-button {


        background-color: transparent;
        font-size: 30px;
        border: none;
        outline: none;
        cursor: pointer;
        z-index: 10;
    }

    .fa-search:before {
        font-size: 30px;
        /* position: relative;
                          left:10px ;
                          bottom:40px */
    }

    /* Style for the search icon */
    .search-button i {
        color: #d60b0b;
        font-size: 20px;

    }


    /* Transition effect for the search icon color */
    .search-input:focus+.search-button i {
        color: #a10505;
    }
</style>
