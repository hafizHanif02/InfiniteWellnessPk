@extends('layouts.app')
@section('title')
    Pos Return
@endsection
@section('content')
    @if ($errors->any())
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
                    <form action="{{ route('pos-return.store') }}" method="post">
                        @csrf
                        <div class="row mb-5 mt-5">
                            <div class="col-md-6">
                                <label for="pos_id">Select POS</label>
                                <select class="form-control" name="pos_id" id="pos_id">
                                    <option value="" selected disabled>Select Pos fro Return</option>
                                    @foreach ($poses as $pos)
                                        <option value="{{$pos->id }}"
                                             data-pos_date="{{$pos->pos_date }}" 
                                             data-patient="{{$pos->patient_name }}"
                                             data-product="{{$pos->PosProduct}}"
                                             
                                             >{{$pos->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="patient_name">Patient Name<sup class="text-danger">*</sup></label>
                                <input type="text" readonly name="patient_name"  id="patient_name" class="form-control"
                                    placeholder="Select POS">
                                @error('patient_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                      
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="pos_date" class="form-label">POS Date <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" placeholder="Select POS First" readonly name="pos_date" id="pos_date" >
                                @error('pos_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-10">
                            <div class="row mb-5 ">
                                <div class="col-md-8">
                                    <h4>Pos Items</h4>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bodered table-medicine" id="able-medicine">
                                    <thead class="bg-dark">
                                        <th class="col" >Product</th>
                                        <th class="col" >Generic Formula</th>
                                        <th class="col" >Dosage</th>
                                        <th class="col" >MRP Per Unit</th>
                                        <th class="col" >Return Quantity</th>
                                        <th class="col" >Price</th>
                                        <th></th>
                                    </thead>
                                    <tbody class="" id="medicine-table-body">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mb-5 mt-5">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>
 
<script>
    $(document).ready(function() {
            $('#pos_id').select2();
            $("#pos_id").change(function() {
                var selectedOption = $(this).find(":selected");
                var selectedPosProductAttr = selectedOption.data("product");
                console.log(selectedPosProductAttr);
                var selectedPatientAttr = selectedOption.data("patient");
                var selectedPosDateAttr = selectedOption.data("pos_date");
                $('#patient_name').val(selectedPatientAttr);
                $('#pos_date').val(selectedPosDateAttr);
                
                $("#medicine-table-body").empty();
                selectedPosProductAttr.forEach(function(medicine, items) {
                    var row = `
                <tr scope="row" id="medicine-row${items}">
                    <td><input class="form-control" value="${medicine.medicine.name}" readonly ></td>
                    <td><input class="form-control" value="${medicine.medicine.generic_formula}" readonly ></td>
                    <td><input class="form-control" value="${medicine.product_quantity}" readonly ></td>
                    <td><input class="form-control" value="${medicine.medicine.selling_price}" id="mrp_perunit${items}" readonly ></td>
                    <td><input class="form-control" value="${medicine.product_quantity}" ></td>
                    <td><input class="form-control" value="${medicine.product_total_price}" id="total_price${items}" readonly ></td>
                </tr>`;
                    $("#medicine-table-body").append(row);

                    // total += ((medicine.medicine.selling_price) * medicine.dosage);
                });

                // $("#total_amount").val(total.toFixed(2));
                // $("#total_amount2").val(total.toFixed(2));
            });
        });


        // const prescriptionSelect123 = document.getElementById('prescription_id');
        // const patientInput123 = document.getElementById('patient_name');
        // const doctorInput123 = document.getElementById('doctor_name');

        // prescriptionSelect123.addEventListener('change', function() {
        //     const selectedOption = prescriptionSelect123.options[prescriptionSelect123.selectedIndex];
        //     const patientName = selectedOption.getAttribute('data-patient');
        //     const doctorName = selectedOption.getAttribute('data-doctor');

        //     patientInput123.value = patientName;
        //     doctorInput123.value = doctorName;
        //     patientInput123.readonly = true;
        //     doctorInput123.readonly = true;

        // });

       

      
        
    </script>
@endsection
