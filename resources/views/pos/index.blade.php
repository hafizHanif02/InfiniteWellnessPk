@extends('layouts.app')
@section('title')
    {{ __('messages.bill.pos') }}
@endsection
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column">
        @include('flash::message')
        <div class="col-md-12 mb-5 text-end">
            <a href="{{ route('pos.create') }}" target="_blank"><button class="btn btn-primary">Add New POS</button></a>
            <a href="{{ route('posinv.index') }}" target="_blank"><button class="btn btn-secondary">See In Filter</button></a>
            @role('Admin|PharmacistAdmin')
            <a href="{{route('posreport.export') }}" target="_blank"><button class="btn btn-danger">POS Report</button></a>
            <a href="{{route('profitLossPOS') }}" target="_blank"><button class="btn btn-warning">P&L Report</button></a>
            @endrole
        </div>
        <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>POS No.</th>
                            <th>Paitent</th>
                            <th>Charges</th>
                            <th>Paid</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($poses as $pos)
                            <tr>
                                <td>{{ $pos->id }}</td>
                                <td>{{ $pos->patient_name }}</td>
                                <td>{{ $pos->total_amount }}</td>
                                <td>
                                    @if ($pos->is_paid == 1)
                                    <span class="badge bg-success">Paid</span>
                                    @else
                                    <span class="badge bg-danger">Unpaid</span>
                                    @endif
                                </td>
                                <td class="d-flex justify-content-center gap-5">
                                    <a href="{{ route('pos.show', $pos->id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @role('Admin|PharmacistAdmin')
                                    <form action="{{ route('pos.destroy',$pos->id) }}" class="d-inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-transparent border-0 text-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                    @endrole
                                </td>
                                
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5" class="text-danger">No pos stock</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $poses->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
