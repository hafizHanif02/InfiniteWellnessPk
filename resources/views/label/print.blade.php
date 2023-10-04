<div class="container">
    <table class="table-bordered " style="">
        <tbody>
            <tr>
                <td colspan="1">
                    <img src="/images/8.png" width="100px" height="45px" alt="logo">
                </td>
                <td colspan="11">
                    <h3>Infinite Pharmacy Services</h3>
                </td>
            </tr>
            <tr>
                <td><br /></td>
                <td><br /></td>
            </tr>
            <tr>
                <td>Bill No:</td>
                <td colspan="5">{!! $bill_no_barcode !!}</td>
            </tr>
            <tr>
                <td>Name:</td>
                <td colspan="5">{{ $label->patient_name }}</td>
            </tr>
            <tr>
                <td>Drug:</td>
                <td colspan="5">{{ $label->name }}</td>
                <td>Qty:</td>
                <td>{{ $label->quantity }}</td>
            </tr>
            <tr>
                <td>Directions:</td>
                <td colspan="5">{{ $label->direction_use }}</td>
            </tr>
            <tr>
                <td>Side Effects/Precautions:</td>
                <td colspan="5">{{ $label->common_side_effect }}</td>
            </tr>
            <tr>
                <td>Date:</td>
                <td colspan="5">{{ $label->created_at }}</td>

                <td>User:</td>
                <td>{{ $user_name }}</td>
            </tr>
        </tbody>
    </table>





    {{-- <table class="table-bordered " style="width: 368px;">
        <tbody>
            <tr>
                <td style="width: 100px;">
                    <img src="/images/8.png" width="100px" alt="">
                </td>
                <td colspan="6">
                    <h3>Infinite Pharmacy Services</h3>
                </td>
            </tr>
            <tr class="text-start">
                <td>
                    {{ $label->created_at }}
                </td>
            </tr>
            <tr class="text-start">
                <td>
                    <b>{{ $label->quantity }} {{ $label->name }} </b>
                </td>
            </tr>
            <tr class="text-start">
                <td>{{ $label->direction_use }}</td>
            </tr>
            <tr class="text-start" style="font-size: 12px;">
                <td>{{ $label->common_side_effect }}</td>
            </tr>
            <tr class="text-start">
                <td>Take With OR After Meal</td>
            </tr>
            <tr>
                <td>Take Regularly and Complete the Course</td>
            </tr>
            <tr class="text-start">
                <td>Mr/Ms. {{ $label->patient_name }}</td>

            </tr>
        </tbody>
    </table> --}}
</div>

<script>
    window.print();
</script>
<style>
    * {
        font-family: arial;
        margin: 2px;
        padding: 2px;
    }

    .table-bordered {
        border-radius: 8px;
        border: 2px solid black;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 3px;
        width: 600px;
    }

    .table-bordered th,
    .table-bordered td {}

    .table-bordered tr {
        border: 0px;
    }

    .table-bordered tr td {
        border: 0px;
        margin: 10px;
    }

    .table-bordered tr th {
        border: 0px;
    }

    .text-start {

        text-align: left;
    }
</style>
