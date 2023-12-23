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
                            <th>Return #</th>
                            <th>POS No.</th>
                            <th>Charges</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- {{dd($pos_retrun) }} --}}
                        @forelse ($pos_retrun as $pos)
                            <tr>
                                <td>{{ $pos->id }}</td>
                                <td>{{ $pos->pos_id }}</td>
                                <td>{{ $pos->total_amount }}</td>
                                </td>
                                <td class="d-flex justify-content-center gap-5">
                                    <a href="{{ route('pos-return.show', $pos->id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @role('Admin|PharmacistAdmin')
                                    <form action="{{ route('pos-return.destroy',$pos->id) }}" class="d-inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-transparent border-0 text-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                    @endrole
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
