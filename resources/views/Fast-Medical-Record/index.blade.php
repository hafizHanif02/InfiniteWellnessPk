@extends('layouts.app')
@section('title')
    F.A.S.T Medical Record
@endsection
@section('content') 
<div class="container-fluid">
    <div class="d-flex flex-column">
        @include('flash::message')
        @role('Admin|Nurse|Receptionist')
        <div class="col-md-12 mb-5 text-end">
            <a href="{{ route('fast-medical-record.create') }}" target="_blank"><button class="btn btn-primary"><i class="fa fa-plus"></i> New</button></a>
        </div>
        @endrole
        <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID.</th>
                            <th>Patient Name.</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fast_medical_records as $fastrecord)
                            <tr>
                                <td>{{ $fastrecord->id }}</td>
                                <td>{{ $fastrecord->patient_name }}</td>
                                <td class="d-flex justify-content-center gap-5">
                                    <a href="/fast-medical-record/{{$fastrecord->id}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>

                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5" class="text-danger">No Record Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{-- {{ $fast_medical_records->links() }} --}}
                </div>
            </div>
        </div>
    </div>
@endsection
