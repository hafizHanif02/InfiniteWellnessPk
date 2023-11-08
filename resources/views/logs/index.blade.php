<x-layouts.app title="Logs">
    

    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <div class="mb-5 d-flex justify-content-between">
                    <h3>Logs</h3>
                    <form action="{{ route('logs.index') }}" method="get" class="d-flex gap-5">
                        <div>
                            <label for="date_from" class="form-label">From</label>
                            <input type="date" name="date_from" value="{{ request()->date_from }}" id="date_from" class="form-control">
                        </div>
                        <div>
                            <label for="date_to" class="form-label">To</label>
                            <input type="date" name="date_to" value="{{ request()->date_to }}" id="date_to" class="form-control">
                        </div>
                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary mt-3">Apply</button>
                        </div>
                    </form>
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
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>