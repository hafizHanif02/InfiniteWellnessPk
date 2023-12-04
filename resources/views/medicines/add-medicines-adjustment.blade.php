@extends('layouts.app')
@section('title')
    Add Medicines Adjustment
@endsection
@section('content')
        
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Medicines Adjustment</h3>
                <a href="{{ route('medicines.adjustment.show') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('medicines.adjustment.store') }}" method="POST" id="save-adjustment-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <label for="adjustment_id" class="form-label">Adjustment # <sup
                                    class="text-danger">*</sup></label>
                            <input type="text" name="id"
                                value="{{ ($adjustment_id ? $adjustment_id : 75000) + 1 }}" id="adjustment_id"
                                class="form-control" readonly title="Product order number">
                            @error('remarks')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-12 mt-5">
                            <label for="medicine_id" class="form-label">(Generic Formula) Medicine <sup
                                    class="text-danger">*</sup></label>
                            <select name="medicine_id[]" id="medicine_id" class="form-control p-0" multiple>
                                <option value="" selected disabled>Select Medicine</option>
                                @foreach ($medicines as $medicine)
                                    <option value="{{ $medicine->id }}">({{ $medicine->generic_formula }})
                                        {{ $medicine->name }}</option>
                                @endforeach
                            </select>
                            @error('medicine_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-2 mt-5">
                            <button type="button" id="add-btn" class="btn btn-primary">Add</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr class="text-white">
                                    <td style="min-width: 200px">Medicine</td>
                                    <td style="min-width: 200px">Batch</td>
                                    <td style="min-width: 120px">Current Qty</td>
                                    <td style="min-width: 200px">Adjustment Qty</td>
                                    <td style="min-width: 150px">Difference Qty</td>
                                    <td style="min-width: 50px">Action</td>
                                </tr>
                            </thead>
                            <tbody id="add-products">
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('medicines.adjustment.show') }}" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary ms-3">Save</button>
            </div>
            </form>
        </div>
    </div>
        <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js">
        </script>
        <script nonce="{{ csp_nonce() }}">
            $(document).ready(function() {
                $('#manufacturer_id, #medicine_id').select2();
                $('form').on('keypress', 'input', function(e) {
                    if (e.which === 13) {
                        e.preventDefault();
                    }
                });
            });
            $("#add-btn").click(function(e) {
                e.preventDefault();
                addProduct();
                $("#medicine_id").empty();
            });

            function addProduct(type, callback) {
                var medicine_id = $("#medicine_id").val();
                if (medicine_id && $('tbody tr#' + medicine_id).length == 0) {
                    $.ajax({
                        type: "post",
                        url: "/get-medicines",
                        data: {
                            _token: "{{ csrf_token() }}",
                            medicine_id: medicine_id
                        },
                        success: function(response) {
                            $("#medicine_id option[value='" + medicine_id + "']").remove();
                            var items = $("tbody tr").length;
                            // console.log(response.medicine[0].all_batch_p_o_s);
                            $.each(response.medicine, function(index, value) {
                                $("#add-products").append(`
                                    <tr id="${value.id}">
                                        <input type="hidden" name="medicines[${index}][medicine_id]" value="${value.id}">
                                        <td>
                                            <input type="text" id="product_name" name="medicines[${index}][medicine_name]" class="form-control" value="${value.name}" readonly>
                                        </td>
                                        <td>
                                            <select name="medicines[${index}][batch_id]" id="batch_pos${index}" onchange="ChangeBatch(${index})" class="batch_pos form-control">
                                                ${response.medicine[index].all_batch_p_o_s.length !== 0 ?
                                                `<option value="" selected disabled>Select Batch</option>
                                                    ${response.medicine[index].all_batch_p_o_s.map(batch => {
                                                        return `<option  value="${batch.id}"
                                                                    data-batch-id="${batch.id}"
                                                                    data-remaining_qty="${batch.remaining_qty}">
                                                                    ${batch.batch.batch_no}
                                                                </option>`
                                                            
                                                    }).join('')}`
                                                    : `<option value="">Not Any Batch Found</option>`
                                                }
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" id="current_qty${index}" name="medicines[${index}][current_qty]" class="form-control" value="" readonly>
                                        </td>
                                        <td>
                                            <input type="number" id="adjustment_qty${index}" name="medicines[${index}][adjustment_qty]" class="form-control" onkeyup="calculate(${index})" value="">
                                        </td>
                                        <td>
                                            <input type="number" id="different_qty${index}" name="medicines[${index}][different_qty]" class="form-control" value="" readonly>
                                        </td>
                                        <td>
                                            <i onclick="removeRaw(${value.id})" class="text-danger fa fa-trash"></i>
                                        </td>
                                    </tr>
                                    
                                `);
                            });
                        }
                    });
                }
            }

            function removeRaw(id) {
                $("#" + id).remove();
            }

            function ChangeBatch(id){
                const selectBatch = document.getElementById('batch_pos' + id);

                const selectedOption = selectBatch.options[selectBatch.selectedIndex];

                const RemainingQty = selectedOption.getAttribute('data-remaining_qty');
                $("#current_qty" + id).val(RemainingQty);
                calculate(id);
            }

            function calculate(index) {
                var current_qty = $("#current_qty" + index).val();
                var adjustment_qty = $("#adjustment_qty" + index).val();
                current_qty = parseInt(current_qty);
                adjustment_qty = parseInt(adjustment_qty);
                // current_qty = Math.abs(current_qty);
                var different_qty = parseInt(current_qty)*(-1)+parseInt(adjustment_qty);

                // var different_qty = current_qty - adjustment_qty;
                $("#different_qty" + index).val(different_qty);
                console.log(current_qty, adjustment_qty, different_qty);
            }
        </script>
@endsection
    
