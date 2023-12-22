@extends('layouts.app')
@section('title')
    F.A.S.T Medical Record
@endsection
@section('content')
    <div class="container-fluid mt-5">
        @if (session()->has('success'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                </div>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column">
                    @include('flash::message')
                    <div class="card-header d-flex justify-content-between">
                        <div class="col-md-6 mb-5 text-start">
                            <h1 class="mb-0 text-dark">F.A.S.T Medical Record</h1>
                        </div>
                        <div class="col-md-6 mb-5 text-end">
                            <a href="{{ route('fast-medical-record.create') }}" target="_blank"><button
                                    class="btn btn-primary me-3"><i class="fa fa-plus"></i> New</button></a>

                            <a href="{{ route('fast-medical-record.print') }}" target="_blank"><button
                                    class="btn btn-success"><i class="fa fa-print"></i> Print</button></a>

                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID.</th>
                                <th>Patient Name.</th>
                                <th>DOB </th>
                                <th>Contact No.</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($fast_medical_records as $fastrecord)
                                <tr>
                                    <td>{{ $fastrecord->id }}</td>
                                    <td>{{ $fastrecord->patient_name }}</td>
                                    <td>{{ $fastrecord->dob }}</td>
                                    <td>{{ $fastrecord->contact }}</td>
                                    <td class="d-flex justify-content-center gap-5">
                                        <a href="/fast-medical-record/view/{{ $fastrecord->id }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('fast-medical-record.edit', $fastrecord->id) }}" aria-label="Edit">
                                            <i class="fa fa-edit"></i></a>
                                            <a href="{{ route('fast-medical-record.prints', ['id' => $fastrecord->id]) }}" aria-label="Print">
                                                <i class="fa fa-print"></i>
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
                        {{ $fast_medical_records->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
