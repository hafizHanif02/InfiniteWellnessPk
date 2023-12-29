@extends('layouts.app')
@section('title')
    Finance Report
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
            </div>
            @include('flash::message')
            {{-- <div class="col-md-12 mb-5 text-end">
                <a href="{{ route('grn-payments') }}"><button class="btn btn-secondary">Back</button></a>
            </div> --}}
            <div class="card">
                <div class="card-header">
                    <h3>Finance Report</h3>
                </div>
                <div class="card-body">
                    <div class="row d-flex justify-content-center align-items-center">

                        <div class="col-md-4">
                            <div
                                class="bg-secondary shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-center my-sm-3 my-2">
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-700 text-white">Vendor Ledger Report</h2>
                                    <a href="{{ route('purchase.grnExport') }}" target="_blank"
                                        class="text-decoration-none d-flex justify-content-center">
                                        <button class="btn btn-primary mt-4">Export</button>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div
                                class="bg-secondary shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-center my-sm-3 my-2">
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-700 text-white">Point Of Sale Report</h2>
                                    <a href="{{ route('posreport.export') }}" target="_blank"
                                        class="text-decoration-none d-flex justify-content-center">
                                        <button class="btn btn-primary mt-4">Export</button>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div
                                class="bg-secondary shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-center my-sm-3 my-2">
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-700 text-white">Profit & Loss Report</h2>
                                    <a href="{{ route('profitLossPOS') }}" target="_blank"
                                        class="text-decoration-none d-flex justify-content-center">
                                        <button class="btn btn-primary mt-4">Export</button>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div
                                class="bg-secondary shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-center my-sm-3 my-2">
                                <div class="text-end text-white d-flex justify-content-center align-items-center flex-column">
                                    <h2 class="fs-1-xxl fw-700 text-white mb-5">Day Wise Inventory</h2>
                                    <form action="/inventory/export-report" method="GET" id="export-form"
                                        class="align-items-center d-flex flex-column justify-content-center align-items-center">
                                        <div class="d-flex">
                                            <div class="mb-3 d-flex justify-content-center align-items-start flex-column">
                                                <label for="date_from" class="form-label">Date From</label>
                                                <input type="date" value="{{ request('date_from', date('Y-m-d')) }}"
                                                    class="form-control" name="date_from" id="date_from">
                                            </div>
                                            <div class="mb-3 d-flex justify-content-center align-items-start flex-column ms-2">
                                                <label for="date_to" class="form-label">Date To</label>
                                                <input type="date" value="{{ request('date_to', date('Y-m-d')) }}"
                                                    class="form-control" name="date_to" id="date_to">
                                            </div>
                                        </div>
                                        <div class="d-flex mt-md-0 mt-3">
                                            <button type="button" onclick="exportReport()" class="btn btn-primary ms-5"
                                                style="margin: 13px;">
                                                Export Report
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <script>
        function exportReport() {
            $('#export-form').submit();
        }
    </script>
@endsection
