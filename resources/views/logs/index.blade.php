<x-layouts.app title="Logs">


    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="mb-5 d-flex justify-content-between">
                    <h3>Logs</h3>
                    <form action="{{ route('logs.index') }}" method="get" class="d-flex gap-5">
                        <div>
                            <label for="date_from" class="form-label">From</label>
                            <input type="date" name="date_from" value="{{ request()->date_from }}" id="date_from"
                                class="form-control">
                        </div>
                        <div>
                            <label for="date_to" class="form-label">To</label>
                            <input type="date" name="date_to" value="{{ request()->date_to }}" id="date_to"
                                class="form-control">
                        </div>
                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary mt-3">Apply</button>
                        </div>
                    </form>
                </div>

                <div class="mb-5 d-flex justify-content-between">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <form method="Get" role="search">
                            <div class="search-container">
                                <input type="text" name="search_data" id="search_data"
                                    class="search_data form-control" value="{{ $search_data }}"
                                    placeholder="Search by Name or ID ...">
                                <button type="submit" class="search-button">
                                    <i class="fa fa-search" style="font-size:48px;color:rgb(1, 7, 41);"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4"></div>
                </div>


                <table class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td>#</td>
                            <td>Action</td>
                            <td>User</td>
                            <td>User Code</td>
                            <td>Date/Time</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                {{-- <td>{{ $log->id }}</td> --}}
                                <td>{{ $log->action }}</td>
                                <td>{{ $log->actionByUser->first_name . $log->actionByUser->last_name }}</td>
                                <td>{{ $log->action_by_user_id }}</td>
                                <td>{{ $log->created_at->format('d M Y h:i A') }}</td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="4" class="text-danger">No log found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    @if ($search_data == '')
                        {{ $logs->links() }}
                    @endif
                </div>
            </div>
        </div>
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
