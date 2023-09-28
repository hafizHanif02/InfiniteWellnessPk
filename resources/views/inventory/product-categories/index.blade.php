<x-layouts.app title="Categories List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3>Categories</h3>
                    <div class="d-flex gap-5">
                        <div>
                            <a href="{{ asset('csv/Categories.xlsx') }}" class="btn btn-danger" download>Download sample</a>
                        </div>
                        <form id="csv-form" action="{{ route('inventory.product-categories.import-excel') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="product_categories_csv" id="product_categories_csv" style="display: none;">
                            <label for="product_categories_csv" class="btn btn-secondary float-end mr-5 mb-3">Import
                                Excel</label>
                            <button type="submit" class="btn btn-secondary float-end mr-5 mb-3"
                                style="display: none;">button</button>
                        </form>
                        <a href="{{ route('inventory.product-categories.create') }}"
                            class="btn btn-primary float-end mr-5 mb-3">Add
                            New</a>
                    </div>
                </div>
                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td scope="col" id="serial_numer">#</td>
                            <td scope="col" id="name">Name</td>
                            <td scope="col" id="actions">Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productCategories as $productCategory)
                            <tr>
                                <td scope="row" headers="serial_number">{{ $loop->iteration }}</td>
                                <td headers="name">{{ $productCategory->name }}</td>
                                <td headers="actions">
                                    <a href="{{ route('inventory.product-categories.edit', $productCategory->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form id="delete-category-form{{ $productCategory->id }}" action="{{ route('inventory.product-categories.destroy', $productCategory->id) }}"
                                        class="d-inline" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="deleteProductCategory({{ $productCategory->id }})" id="delete-category-button" class="bg-transparent border-0 text-danger ms-5">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="10" class="text-danger">No categories found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $productCategories->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
            // Capture the key press event on all input fields within the form
              $('form').on('keypress', 'input', function(e) {
                if (e.which === 13) { // 13 is the key code for "Enter"
                  e.preventDefault(); // Prevent the default form submission
                }
              }); 
        });
            $('input[name="product_categories_csv"]').change(function() {
                $('#csv-form').submit();
            });
            function deleteProductCategory(productCategoryId) {
                $(this).prop('disabled', true);
                $('#delete-category-form'+productCategoryId).submit();
            }
        </script>
    @endpush
</x-layouts.app>
