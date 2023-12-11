@extends('layouts.app')
@section('title')
    Nursing From List
@endsection
@section('content') 
<div class="container-fluid">
    <div class="d-flex flex-column">
        @include('flash::message')
        @role('Admin|Nurse|Receptionist')
        <div class="col-md-12 mb-5 text-end">
            <a href="{{ route('nursing-form.create') }}" target="_blank"><button class="btn btn-primary">Add New Nursing Form</button></a>
        </div>
        @endrole
        <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Form No.</th>
                            <th>Paitent MR No.</th>
                            <th>Patient Name</th>
                            <th>OPD ID</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($nursing_froms as $nursing_from)
                            <tr>
                                <td>{{ $nursing_from->id }}</td>
                                <td>{{ $nursing_from->patient_mr_number }}</td>
                                <td>{{ $nursing_from->patient->user->first_name }} {{ $nursing_from->patient->user->last_name }}</td>
                                <td>{{ $nursing_from->opd_id }}</td>
                                <td class="d-flex justify-content-center gap-5">
                                    <a href="/nursing-form/{{$nursing_from->id}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    {{-- <form action="{{ route('nursing-form.destroy',$nursing_from->id) }}" class="d-inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-transparent border-0 text-danger"><i class="fa fa-trash"></i></button>
                                    </form> --}}
                                </td>

                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5" class="text-danger">No Nursing form stock</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $nursing_froms->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
