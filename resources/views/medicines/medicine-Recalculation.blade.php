@extends('layouts.app')
@section('title')
    Medicines Recalculations
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Recalculation</h3>
                <button class="btn btn-primary" id="recalculate">Recaculate <i class="fas fa-angle-double-down"></i></button>
            </div>
            <div class="card-body">
                <table id="table" style="display: none;" class="table table-bordered text-center table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Total Qty</th>
                        </tr>
                    </thead>
                    <tbody id="ajax-data"></tbody>
                </table>
                <div id="loading" style="display: none; justify-content: center; align-items: center margin-bottom: 50px">
                    <center>
                        <p>Recalculating... Please don't close this page</p>
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

                fetch("{{ route('medicines.recalculate') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({}),
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        $('#success').show();
                        $('#loading').hide();
                        $('#table').show();
                        $('#recalculate').text('Recalculate');
                        $('#recalculate').removeAttr('disabled');
                        $('#ajax-data').show();
                        console.log(data.medicines);
                        data.medicines.forEach(function(value) {
                            $('#ajax-data').append(`
                        <tr>
                          <td>${value.id}</td>
                          <td>${value.name}</td>
                          <td>${value.total_quantity}</td>
                        </tr>
                      `);
                        });
                    })
                    .catch(error => {
                        console.error("Error:", error);
                    });
            });
        });
    </script>
@endsection
