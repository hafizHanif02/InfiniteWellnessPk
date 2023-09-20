@extends('layouts.app')
@section('title')
    POS Return
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <div class="col-md-12 mb-5 text-end">
                <a href="{{ route('pos-return.create') }}" target="_blank"><button class="btn btn-primary">Add POS Return</button></a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>POS No.</th>
                            <th>Total Quantity</th>
                            <th>Charges</th>
                            {{-- <th>Paid</th> --}}
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pos_retrun as $pos)
                            <tr>
                                <td>{{ $pos->id }}</td>
                                <td>{{ $pos->patient_name }}</td>
                                <td>{{ $pos->total_amount }}</td>
                                {{-- <td>
                                    @if ($pos->is_paid == 1)
                                    <span class="badge bg-success">Paid</span>
                                    @else
                                    <span class="badge bg-danger">Unpaid</span>
                                    @endif --}}
                                </td>
                                <td class="d-flex justify-content-center gap-5">
                                    <a href="{{ route('pos.show', $pos->id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <form action="{{ route('pos.destroy',$pos->id) }}" class="d-inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-transparent border-0 text-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                                
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5" class="text-danger">No pos return stock</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{-- {{ $pos_retrun->links() }} --}}
                </div>
            </div>
        </div>
    </div>
@endsection
