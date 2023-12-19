<x-layouts.app title="Product History">
    @push('styles')
        <link nonce="{{ csp_nonce() }}" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
            rel="stylesheet" />
    @endpush
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Product History</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered text-center table-hover mb-5">
                    <thead>
                        <tr>
                            <th>
                                Product Name
                            </th>
                            <td>
                                {{ $product->product_name }} ({{ $product->generic->formula }})
                            </td>
                        </tr>
                    </thead>
                </table>
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>SR</th>
                            <th>Type</th>
                            <th>#</th>
                            <th>Qty</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        @php
                            $key = 0;

                            // Combine purchases and transfers into a single array
                            $combinedData = array_merge(
                                array_map(function ($item) {
                                    $item['type'] = 'Purchase';
                                    return $item;
                                }, $goodReceives->toArray()),
                                array_map(function ($item) {
                                    $item['type'] = 'Transfer';
                                    return $item;
                                }, $transfers->toArray()),
                            );

                            // Sort the combined data by date in ascending order (FILO)
                            usort($combinedData, function ($a, $b) {
                                return strtotime($a['created_at']) - strtotime($b['created_at']);
                            });
                        @endphp

                        @foreach ($combinedData as $data)
                            <tr class="{{ strtolower($data['type']) }}-row">
                                <td>{{ ++$key }}</td>
                                <td><span
                                        class="badge badge-{{ strtolower($data['type']) == 'purchase' ? 'success' : 'danger' }}">{{ $data['type'] }}</span>
                                </td>
                                <td>{{ $data['id'] }}</td>
                                <td>{{ $data['type'] == 'Purchase' ? $data['deliver_qty'] + $data['bonus'] : $data['total_piece'] }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($data['created_at'])->timezone('Asia/Karachi')->format('Y-m-d h:i:s A') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


                <div class="row">
                    <div class="col-md-12 text-center mt-3">
                        <span style="font-weight: bold">Current Quantity:
                            {{ $goodReceives->sum('deliver_qty') + $goodReceives->sum('bonus') - $transfers->sum('total_piece') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-layouts.app>

<style>
    .purchase-row {
       background-color: #ecedec !important; /* Light green for purchases */
   }
   .transfer-row {
       background-color: #fdfbcf !important; /* Light red for transfers */
   }
   </style>
