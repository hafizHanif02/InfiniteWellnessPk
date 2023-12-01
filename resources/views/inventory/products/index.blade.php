<x-layouts.app title="Products List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Products</h3>
                    <div class="container">
                        
                        <form method="Get" role="search">
                            <div class="search-container">
                                  <input type="text" name="search_data" id="search_data" class="search_data form-control" value="{{$search_data}}" placeholder="Search by Name or ID ...">
                                  <button type="submit" class="search-button">
                                    <i class="fa fa-search"  style="font-size:48px;color:rgb(1, 7, 41);"></i>
                                  </button>
                                </div>
                        </form>
                </div>
                    <div class="d-flex col-auto gap-5">
                        <a href="{{route('inventory.export-to-excel') }}" target="_blank"><button class="btn btn-primary">Export All Product</button></a>
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
                        <form id="update-csv-form" action="{{ route('inventory.products.update-import-excel') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="update_product" id="update_product" style="display: none;">
                            <label for="update_product" class="btn btn-secondary float-end mr-5 mb-3">
                                Update Product Excel
                            </label>
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
                        @if (count($products) > 0) 
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
                        @endif
                    </tbody>
                </table>
                <div>
                    @if (count($products) > 0) 
                    {!! $products->render() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
            // Capture the key press event on all input fields within the form
            //   $('form').on('keypress', 'input', function(e) {
            //     if (e.which === 13) { // 13 is the key code for "Enter"
            //       e.preventDefault(); // Prevent the default form submission
            //     }
            //   }); 
        });
            $('input[name="products_csv"]').change(function() {
                $('#csv-form').submit();
            });

            $('input[name="update_product"]').change(function() {
                $('#update-csv-form').submit();
            });

            function deleteProduct(productId) {
                $(this).prop('disabled', true);
                $('#delete-product-form'+productId).submit();
            };
            
        </script>
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
                      .search-container{
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
                      .fa-search:before{
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
                      .search-input:focus + .search-button i{
                        color: #a10505;
                      }
</style>
