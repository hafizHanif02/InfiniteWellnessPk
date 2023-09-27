<div class="container" >
    <table class="table-bordered " style="width: 368px;">
        <tbody>
            <tr class="text-start">
                <td>
                    {{$label->created_at }}
            </td>
            </tr>
            <tr class="text-start">
                <td>
                    <b>{{$label->quantity}}  {{$label->name }} </b>
            </td>
            </tr>
            <tr class="text-start">
                <td>{{$label->direction_use }}</td>
            </tr>
            <tr class="text-start" style="font-size: 12px;">
                <td>{{$label->common_side_effect }}</td>
            </tr>
            <tr class="text-start">
                <td>Take With OR After Meal</td>
            </tr>
            <tr>
                <td>Take Regularly and Complete the Course</td>
            </tr>
            <tr class="text-start">
                <td>Mr/Ms. {{$label->patient_name }}</td>

            </tr>
        </tbody>
    </table>
</div>

<script>
    window.print();
</script>
<style>

    .table-bordered {
        border-radius: 14px;
        border: 2px solid black;
}
    .table-bordered th, .table-bordered td {

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

        text-align: left;
    }
</style>
