<x-layouts.app title="Medicine History">
    @push('styles')
        <link nonce="{{ csp_nonce() }}" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
            rel="stylesheet" />
    @endpush
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Medicine History</h3>
                {{-- {{dd($posProduct[0]->product_quantity)}} --}}
            </div>
            <div class="card-body">
                <table class="table table-bordered text-center table-hover mb-5">
                    <thead>
                        <tr>
                            <th>
                                Medicine Name
                            </th>
                            <td>
                                {{ $product->name }} ({{ $product->generic_formula }})
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
                            $combinedData = array_merge(
                                array_map(function ($item) {
                                    $item['type'] = 'Purchase';
                                    return $item;
                                }, $posProduct->toArray()),
                                array_map(function ($item) {
                                    $item['type'] = 'Transfer';
                                    return $item;
                                }, $transfer->toArray()),
                                array_map(function ($item) {
                                    $item['type'] = 'Purchase Return';
                                    return $item;
                                }, $posProductReturn->toArray()),
                            );
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
                                <td>
                                    @if($data['type'] == 'Purchase')
                                        {{ $data['product_quantity'] }}
                                    @elseif(($data['type'] == 'Transfer') )
                                        {{ $data['total_piece'] }}
                                        @elseif(($data['type'] == 'Purchase Return') )
                                        {{ $data['product_quantity'] }}
                                    @else
                                        N/A
                                    @endif
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
                            {{  $transfer->sum('total_piece')  + $posProductReturn->sum('product_quantity') - $posProduct->sum('product_quantity') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-layouts.app>

<style>
    .purchase-row {
        background-color: #ecedec;
        /* Light green for purchases */
    }

    .transfer-row {
        background-color: #fdfbcf;
        /* Light red for transfers */
    }
</style>
