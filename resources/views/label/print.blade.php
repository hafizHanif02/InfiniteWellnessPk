<table class="table table-bordered">
    <tbody>
        <tr>
            <th class="text-end">Medicine:</th>
            <td>{{$label->name }}</td>
        </tr>
        <tr>
            <th class="text-end">Brand</th> 
            <td>{{$label->brand_name }}</td>
        </tr>
        <tr>
            <th class="text-end">Quantity</th>
            <td>{{$label->quantity }}</td>

        </tr>
        <tr>
            <th class="text-end">Patient</th>
            <td>{{$label->patient_name }}</td>

        </tr>
        <tr>
            <th class="text-end">Direction Use</th>
            <td>{{$label->direction_use }}</td>

        </tr>
        <tr>
            <th class="text-end">Common Side Effect</th>
            <td>{{$label->common_side_effect }}</td>

        </tr>
        <tr>
            <th class="text-end">Date Of Sale</th>
            <td>{{$label->created_at }}</td>
        </tr>
    </tbody>
</table>

<script>
    window.print();
</script>
<style>
    .table-bordered {
        border: 2px solid black;
        border-collapse: collapse; /* Collapse border spacing */
    }
    .table-bordered th, .table-bordered td {
        border: 2px solid black; /* Add border to table cells */
        padding: 5px; /* Add padding for better appearance */
    }
</style>