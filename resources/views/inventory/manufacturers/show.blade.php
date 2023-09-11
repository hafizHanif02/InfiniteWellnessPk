<x-layouts.app title="Manufacturer Detail">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Manufacturer Detail</h3>
                <a href="{{ route('inventory.manufacturers.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered text-start">
                    <tr>
                        <th>Code:</th>
                        <td>{{$manufacturer->id }}</td>
                    </tr>
                    <tr>
                        <th>Company:</th>
                        <td>{{$manufacturer->company_name }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
