@extends('layouts.app')
@section('title')
    Payment Page
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <div class="col-md-12 mb-5 text-end">
                <a href="{{ route('pos.index') }}"><button class="btn btn-primary">Back</button></a>
            </div>
            <div class="">
                
            </div>
        </div>
    </div>
@endsection
