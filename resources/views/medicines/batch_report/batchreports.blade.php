@extends('layouts.app')
@section('title')
    Batch POS Report
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Batch Report</h3>
                <div class="container">

                    <form method="Get" role="search">
                        <div class="search-container">
                            <input type="text" name="search_data" id="search_data" class="search_data form-control"
                                value="{{ $search_data }}" placeholder="Search by Name or ID ...">
                            <button type="submit" class="search-button">
                                <i class="fa fa-search" style="font-size:48px;color:rgb(1, 7, 41);"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
            <table class="table table-bordered">
                <thead class="text-dark">
                    <tr>
                        <th>Id</th>
                        <th>Medicine Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    @if($batches->isNotEmpty())
                    @foreach ($batches as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                <a href="{{ route('medicines.batch-pos-report.show', ['id' => $product->product_id]) }}"
                                    class="btn btn-primary btn-sm">View batch Pos</a>
                            </td>
                        </tr>
                    @endforeach
                    @else
                    <tr class="text-center text-danger" >
                        <td colspan="3">No data found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            {{ $batches->links() }}
        </div>

        </div>
    </div>
@endsection
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
