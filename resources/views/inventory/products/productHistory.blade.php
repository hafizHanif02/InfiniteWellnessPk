<x-layouts.app title="Product History">
    @push('styles')
        <link nonce="{{ csp_nonce() }}" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
            rel="stylesheet" />
            
    @endpush
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Product History</h3>
                <div class="container">              
                </div>
            </div>
            {{-- {{dd($product)}} --}}
            <div class="card-body">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>SR</th>
                                <th>Purchase #</th>
                                <th>Transfer #</th>
                                <th>Purchase Qty</th>
                                <th>Transfer Qty</th>
                                <th>Purchase Date</th>
                                <th>Transfer Date</th>
                            </tr>
                        </thead>
                        <tbody class="table-light">
                            @foreach ($goodReceives as $key => $goodReceive)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $goodReceive->id }}</td>
                                    <td>-</td> 
                                    <td>{{ $goodReceive->deliver_qty }}</td>
                                    <td>-</td>
                                    <td>{{ $goodReceive->created_at }}</td>
                                    <td>-</td> 
                                </tr>
                            @endforeach
                    
                            @foreach ($transfers as $transfer)
                                <tr>
                                    <td>-</td> 
                                    <td>-</td> 
                                    <td>{{ $transfer->id }}</td>
                                    <td>-</td> >
                                    <td>{{ $transfer->total_piece }}</td>
                                    <td>-</td> 
                                    <td>{{ $transfer->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
               

            </div>
</x-layouts.app>