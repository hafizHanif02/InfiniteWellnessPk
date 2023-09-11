@extends('layouts.app')
@section('title')
    {{ __('messages.bill.pos') }}
@endsection
@section('content')
    {{-- {{dd($prescriptions) }} --}}
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <div class="col-md-12 mb-5 text-end">
                <a href="{{ route('pos.index') }}"><button class="btn btn-secondary">Back</button></a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Point Of Sales</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('pos.store') }}" method="post">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="prescription_id">Prescription</label>
                                <select name="prescription_id" id="prescription_id" class="form-control">
                                    <option value="" selected disabled>Select prescription</option>
                                    @foreach ($prescriptions as $prescription)
                                        <option value="{{ $prescription['id'] }}"
                                            data-patient="{{ $prescription['patient']['user']['first_name'].' '.$prescription['patient']['user']['last_name']  }}"  data-doctor ="{{$prescription['doctor']['user']['first_name'].' '.$prescription['doctor']['user']['last_name']}}"  data-medicines="{{ json_encode($prescription->getMedicine) }}">
                                            {{ $prescription['doctor']['user']['first_name'] }} To Patient
                                            ({{ $prescription['patient']['user']['first_name'] }}) At
                                            ({{ $prescription['created_at'] }})
                                        </option>
                                    @endforeach
                                        </select>
                                @error('prescription_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="patient_name">Patient Name<sup class="text-danger">*</sup></label>
                                <input type="text" name="patient_name" id="patient_name" class="form-control"
                                    placeholder="Enter Patient Name">
                                @error('patient_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="doctor_name">Doctor Name</label>
                                <input type="text" name="doctor_name" id="doctor_name" class="form-control"
                                    placeholder="Enter Doctor Name">
                                @error('doctor_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="pos_date" class="form-label">POS Date <sup
                                        class="text-danger">*</sup></label>
                                <input type="date" readonly name="pos_date" id="pos_date" class="form-control" value="{{ old('pos_date', date('Y-m-d')) }}" title="Supply date"> 
                                @error('pos_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <table class="table table-bodered">
                                <thead>
                                    <h4>Prescription Items</h4>
                                    <tr class="d-flex gap-10">
                                        <th>Product</th>
                                        <th>Dosage</th>
                                        <th>Comment</th>
                                        <th>Time</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody class="" id="medicine-table-body">
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-9 mb-9 row">
                            <div class="col-md-4">
                                <label for="total_amount">Advance Cost</label>
                                <input type="number" class="form-control" onkeyup="updateTotalPrice()" id="advance_cost" placeholder="Any Other Charges">
                            </div>
                            <div class="col-md-8">
                                <label for="total_amount">Total Cost</label>
                                <input type="number" class="form-control" id="total_amount" name="total_amount" readonly value="0" placeholder="Total Price">
                                <input type="hidden" id="total_amount2">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-primary">Proceed To Pay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>

    $(document).ready(function() {
        $("#prescription_id").change(function() {
            var selectedOption = $(this).find(":selected");
            var selectedMedicinesAttr = selectedOption.data("medicines");

            $("#medicine-table-body").empty(); // Clear existing rows

            var total = 0;

            selectedMedicinesAttr.forEach(function(medicine) {
                var row = `
                    <tr class="d-flex gap-5">
                        <td><input type="text" class="form-control" readonly value="${medicine.medicine.name}" placeholder="item name"></td>
                        <td><input type="text" class="form-control" readonly value="${medicine.dosage}" placeholder="dosage"></td>
                        <td><input type="text" class="form-control" readonly value="${medicine.comment}" placeholder="Comment"></td>
                        <td><input type="text" class="form-control" readonly value="${medicine.time == 0 ? 'Before Meal' : 'After Meal'}" placeholder="Before/After Meal"></td>
                        <td><input type="text" class="form-control" id="prescription_item_price${medicine.id}" readonly value="${(medicine.medicine.selling_price/medicine.medicine.quantity)*medicine.dosage}" placeholder="selling_price"></td>
                    </tr>`;
                $("#medicine-table-body").append(row);

                total += ((medicine.medicine.selling_price / medicine.medicine.quantity) * medicine.dosage);
            });

            $("#total_amount").val(total.toFixed(2));
            $("#total_amount2").val(total.toFixed(2));
        });
    });


        const prescriptionSelect = document.getElementById('prescription_id');
        const patientInput = document.getElementById('patient_name');
        const doctorInput = document.getElementById('doctor_name');

        prescriptionSelect.addEventListener('change', function() {
            const selectedOption = prescriptionSelect.options[prescriptionSelect.selectedIndex];
            const patientName = selectedOption.getAttribute('data-patient');
            const doctorName = selectedOption.getAttribute('data-doctor');

            patientInput.value = patientName;
            doctorInput.value = doctorName;
            patientInput.readonly = true;
            doctorInput.readonly = true;

        }); 
        function updateTotalPrice() {
        var total_amount = parseFloat($("#total_amount2").val()) || 0;
        var advance_cost = parseFloat($("#advance_cost").val()) || 0;

        var grandTotal = total_amount + advance_cost;

        $("#total_amount").val(grandTotal.toFixed(2));
    }
    </script>
@endsection
