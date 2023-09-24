<x-layouts.app title="Vendor Details">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Vendor Details</h3>
                <a href="{{ route('inventory.vendors.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Code:</th>
                        <td>{{$vendor->id }}</td>
                    </tr>
                    <tr>
                        <th>Manufacturer:</th>
                        <td>{{$vendor->manufacturer->company_name }}</td>
                    </tr>
                    <tr>
                        <th>Contact Person:</th>
                        <td>{{$vendor->account_title }}</td>
                    </tr>
                    <tr>
                        <th>Account Title:</th>
                        <td>{{$vendor->account_title }}</td>
                    </tr>
                    <tr>
                        <th>Phone:</th>
                        <td>{{$vendor->phone }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{$vendor->email }}</td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>{{$vendor->address }}</td>
                    </tr>
                    <tr>
                        <th>National Tax Number (NTN):</th>
                        <td>{{$vendor->ntn }}</td>
                    </tr>
                    <tr>
                        <th>Sales Tax Registration Number (STRN) :</th>
                        <td>{{$vendor->sales_tax_reg }}</td>
                    </tr>
                    <tr>
                        <th>Active:</th>
                        <td>{{ $vendor->active == 1 ? 'Yes' : 'No' }}</td>
                    </tr>

                    <tr>
                        <th>Area:</th>
                        <td>{{$vendor->area }}</td>
                    </tr>
                    <tr>
                        <th>City:</th>
                        <td>{{$vendor->city }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
