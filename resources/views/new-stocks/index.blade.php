@extends('layouts.app')
@section('title')
    {{ __('messages.transfer_request') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Issue Date</th>
                            <th>Code</th>
                            {{-- <th>Total Price Amount</th>
                            <th>Total Supply Quantity</th> --}}
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($newStocks as $newStock)
                            <tr>
                                <td>{{ $newStock->supply_date }}</td>
                                <td>{{ $newStock->id }}</td>
                                {{-- <td>{{ $newStock->total_price_amount }}</td>
                                <td>{{ $newStock->total_supply_quantity }}</td> --}}
                                <td class="d-flex justify-content-center">
                                    <a style="display: flex;align-items: center;" target="_blank" href="{{ route('new-stocks.report.show',$newStock->id) }}"><i class="fa fa-eye"></i></a>
                                    @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('PharmacistAdmin') || auth()->user()->hasRole('Pharmacist'))
                                    <form action="{{ route('new-stocks.update-status', $newStock->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="1">
                                        <button class="btn border-0 bg-transparent text-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn border-0 bg-transparent text-danger"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    @else
                                    <div class="btn disabled btn-warning btn-sm ms-2">Only Admin Can Approve</div>
                                @endif

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h1 class="text-center text-danger">Do You Want to Reject This Request !
                                                    </h1>
                                            <form action="{{ route('new-stocks.update-status', $newStock->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="0">
                                                </div>
                                                <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">No</button>
                                                        <button type="submit" class="btn btn-primary">Yes</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5" class="text-danger">No new stock</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $newStocks->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
