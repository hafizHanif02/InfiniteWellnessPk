@extends('layouts.app')
@section('title')
    Medicines Recalculations
@endsection
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>Recalculation</h3>
            <button class="btn btn-primary" id="recalculate">Recaculate <i
                    class="fas fa-angle-double-down"></i></button>
        </div>
        <div class="card-body">
            <table id="table" style="display: none" class="table table-bordered text-center table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Total Qty</th>
                    </tr>
                </thead>
                <tbody id="ajax-data"></tbody>
            </table>
            <div id="loading"
                style="display: none; justify-content: center; align-items: center margin-bottom: 50px">
                <center>
                    <p>Recalculating... Please do'nt close this page</p>
                    <img src="https://i.gifer.com/ZKZg.gif" width="20px" alt="">
                </center>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#recalculate').on('click', function() {
            $('#recalculate').text('Recalculating...');
            $('#recalculate').attr('disabled', 'disabled');
            $('#ajax-data').empty();
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "{{ route('medicines.recalculate') }}",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    // $('#table').show();
                    $('#success').show();
                    $('#loading').hide();
                    $('#recalculate').text('Recalculate');
                    $('#recalculate').removeAttr('disabled');
                    console.log(data);
                    // $.each(data.medicine, function(index, value) {
                    //     $('#ajax-data').append(`
                    //     <tr>
                    //         <td>${value.id}</td>
                    //         <td>${value.name}</td>
                    //         <td>${value.total_quantity}</td>
                    //     </tr>
                    // `);
                    // });
                }
            });
        });
    });
</script>
@endsection
    
