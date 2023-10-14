@extends('layouts.app')
@section('title')
    Item Report
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            {{-- <th>Pos ID</th> --}}
                            <th>Product Name</th>
                            <th>Product QTY</th>
                            {{-- <th>Product Total Price</th> --}}
                            <th>Return QTY</th>
                            {{-- <th>Return Amount</th> --}}
                            {{-- <th class="text-center">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($poses as $posProduct)
                            <tr>
                                <td>{{ $posProduct->productName }}</td>
                                <td>{{ $posProduct->productQty }}</td>
                                <td>
                                    @php
                                        $found = false; // Flag to track if a match is found
                                    @endphp
                    
                                    @foreach ($posReturnQuantity as $returnProduct)
                                        @if ($returnProduct->productName == $posProduct->productName)
                                            {{ $returnProduct->totalquantity }}
                                            @php $found = true; @endphp
                                        @endif
                                    @endforeach
                    
                                    @if (!$found)
                                        0
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                     
                </table>
                <div>
                    {{-- {{ $poses->links() }} --}}
                </div>
            </div>
        </div>
    </div>
@endsection
