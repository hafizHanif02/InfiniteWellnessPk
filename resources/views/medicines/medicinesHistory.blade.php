@extends('layouts.app')
@section('title')
Medicine History
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Medicine History</h3>
                <a href="{{ route('medicines.index') }}" class="btn btn-secondary">Back</a>
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
                    <thead class="table-border">
                        <tr>
                            <th class="text-dark">SR</th>
                            <th class="text-dark">Type</th>
                            <th class="text-dark">#</th>
                            <th class="text-dark">Qty</th>
                            <th class="text-dark">Date</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        @php
                            $key = 0;
                            $combinedData = array_merge(
                                array_map(function ($item) {
                                    $item['type'] = 'Pos';
                                    return $item;
                                }, $posProduct->toArray()),
                                array_map(function ($item) {
                                    $item['type'] = 'Transfer';
                                    return $item;
                                }, $transfer->toArray()),
                                array_map(function ($item) {
                                    $item['type'] = 'Pos Return';
                                    return $item;
                                }, $posProductReturn->toArray()),
                            );
                            usort($combinedData, function ($a, $b) {
                                return strtotime($a['created_at']) - strtotime($b['created_at']);
                            });
                        @endphp

                        @foreach ($combinedData as $data)
                            <tr class="{{ strtolower(str_replace(' ', '', $data['type'])) }}-row">
                                <td >{{ ++$key }}</td>
                                <td><span  class="badge {{ strtolower($data['type']) === 'pos' ? 'badge-pos' : (strtolower($data['type']) === 'transfer' ? 'badge-transfer' : 'badge-posreturn') }}">
                                {{ $data['type'] }}</span>
                                </td>
                                <td>
                                    @if($data['type'] == 'Pos')
                                    {{ $data['pos_id'] }}
                                    @elseif (($data['type'] == 'Transfer') )
                                    {{ $data['transfer_id'] }}
                                    @elseif (($data['type'] == 'Pos Return') )
                                    {{ $data['pos_return_id'] }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    @if($data['type'] == 'Pos')
                                        {{ $data['product_quantity'] }}
                                    @elseif(($data['type'] == 'Transfer') )
                                        {{ $data['total_piece'] }}
                                        @elseif(($data['type'] == 'Pos Return') )
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

@endsection
<style>
    /* Badge for 'Pos' */
.badge-pos {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 3px;
    color: #000000 !important;
    background-color: lightgreen;
}

/* Badge for 'Transfer' */
.badge-transfer {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 3px;
    color: #000000 !important;
    background-color: lightsalmon;
}

/* Badge for 'Pos Return' */
.badge-posreturn {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 3px;
    color: #000000 !important;
    background-color: lightblue;
}

</style>
