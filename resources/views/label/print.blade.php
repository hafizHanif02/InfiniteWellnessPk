<div class="container">
    <table class="table-bordered ">
        <tbody>
            <tr class="text-start">
                <th>
                    <p>{{$label->quantity}}  {{$label->name }} </p>
                </th>
            </tr>
            <tr class="text-start">
                <th><h2>{{$label->direction_use }}</h2></th>
            </tr>
            <tr class="text-start">
                <th><h3>{{$label->common_side_effect }}</h3></th>
            </tr>
            <tr class="text-start">
                <td>Take With OR After Meal</td>
            </tr>
            <tr>
                <td>Take Regularly and Complete the Course</td>
            </tr>
            <tr class="text-start">
                <th>Mr/Ms. {{$label->patient_name }}</th>
                <th>{{$label->created_at }}</th>
            </tr>
        </tbody>
    </table>
</div>

<script>
    window.print();
</script>
<style>
    .container{
        padding: 20px;
    }
    .table-bordered {
        border-radius: 14px;
        border: 2px solid black;
}
    .table-bordered th, .table-bordered td {
        padding: 5px; 
    }
    .table-bordered tr{
        border: 0px;
    }
    .table-bordered tr td{
        border: 0px;
    }
    .table-bordered tr th{
        border: 0px;
    }
    .text-start{
        padding-left: 20px; 
        text-align: left;
    }
</style>