<x-layouts.app title="Batch Report">
    @push('styles')
        <link nonce="{{ csp_nonce() }}" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
            rel="stylesheet" />
            
    @endpush
    <div class="container-fluid">
        <div class="card">
            {{-- <div class="card-header d-flex justify-content-between">
                <h3>Batch Report</h3>
                <div class="container">
                    <div class="d-flex">
                        <form action="/inventory/export-report" method="GET" id="export-form">
                            <div class="d-flex justify-content-center gap-5 mb-5">
                                <div class="d-flex gap-5" style="margin-top: -20px; padding-right: 10px;">
                                    <div>
                                        <label for="date_from" class="form-label">Date From</label>
                                        <input type="date" value="{{ request('date_from', date('Y-m-d')) }}"
                                            class="form-control" name="date_from" id="date_from">
                                    </div>
                                    <div>
                                        <label for="date_to" class="form-label">Date To</label>
                                        <input type="date" value="{{ request('date_to', date('Y-m-d')) }}"
                                            class="form-control" name="date_to" id="date_to">
                                    </div>
                                    <div class="d-flex gap-5 mt-5">
                                        <button type="button" onclick="exportReport()" class="btn btn-primary mt-3">
                                            Export Report
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <script>
                            function exportReport() {
                                $('#export-form').submit();
                            }
                        </script>

                        <form method="Get" role="search">
                            <div class="search-container mt-2" >
                                <input type="text" name="search_data" id="search_data" class="search_data form-control"
                                    value="{{ $search_data }}" placeholder="Search by Name or ID ...">
                                <button type="submit" class="search-button">
                                    <i class="fa fa-search" style="font-size:48px;color:rgb(1, 7, 41);"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}



            <div class="card-header d-flex justify-content-between">
                <h3>Batch Report</h3>
                <div class="container">
                    <div class="d-flex flex-column flex-md-row">
                        <form action="/inventory/export-report" method="GET" id="export-form"
                            class="d-flex flex-column flex-md-row align-items-md-center">
                            <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                                <div class="mb-3">
                                    <label for="date_from" class="form-label">Date From</label>
                                    <input type="date" value="{{ request('date_from', date('Y-m-d')) }}" class="form-control"
                                        name="date_from" id="date_from">
                                </div>
                                <div class="mb-3">
                                    <label for="date_to" class="form-label">Date To</label>
                                    <input type="date" value="{{ request('date_to', date('Y-m-d')) }}" class="form-control"
                                        name="date_to" id="date_to">
                                </div>
                                <div class="d-flex mt-md-0 mt-3">
                                    <button type="button" onclick="exportReport()" class="btn btn-primary ms-5" style="margin: 13px;">
                                        Export Report
                                    </button>
                                </div>
                            </div>
                        </form>
            
                        <script>
                            function exportReport() {
                                $('#export-form').submit();
                            }
                        </script>
            
                        <form method="Get" role="search" class="d-flex flex-column flex-md-row align-items-md-center">
                            <div class="search-container mt-2 me-md-2">
                                <input type="text" name="search_data" id="search_data" style="margin: 20px;" class="search_data form-control ms-3"
                                    value="{{ $search_data }}" placeholder="Search by Name or ID ...">
                                <button type="submit" class="search-button">
                                    <i class="fa fa-search" style="font-size:24px;color:rgb(1, 7, 41);"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            




            <div class="card-body">
                <div class="card-body">
                    @if($batches->isEmpty())
                    <tr class="text-center text-danger" >
                        <td >No data found</td>
                    </tr>
                @else
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Id</th>
                            <th>Product Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        @foreach ($batches as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>
                                    <a href="{{ route('inventory.products.batch-pos-report.print', ['id' => $product->id]) }}"
                                        class="btn btn-primary btn-sm">View batch
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $batches->links() }}
                @endif
            </div>
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
    }

    .search-button i {
        color: #d60b0b;
        font-size: 20px;

    }

    .search-input:focus+.search-button i {
        color: #a10505;
    }
</style>