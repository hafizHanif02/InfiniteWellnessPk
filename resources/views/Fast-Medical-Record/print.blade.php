<style>
    * {
        margin: 3px !important;
        padding: 3px !important;
        box-sizing: border-box;
        text-transform: uppercase;
        /* font-size: 15px; */
        font-family: arial;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid black;
    }

    table tr th {
        border: 1px solid black !important;
    }
</style>
<center>
    <h1 style="border: 1px solid black;">Fast Medical Record</h1>
</center>
<table>
    <thead>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold">PRE-TEST
                CONSULTATION</td>
            <td colspan="3" style="border: 1px solid black; text-align: center; font-weight: bold">Blood collection
                appointment</td>
            <td></td>
            <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold">fast test report
            </td>
            <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold">report reviwe
                session</td>
            <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold">post test
                consultation</td>
            <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold">post post test
                consultation</td>
            <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold">re-test
                consultation</td>
        </tr>
        <tr>
            <th>S No.</th>
            <th>patient name</th>
            <th>referred by</th>
            <th>dob</th>
            <th>contact</th>
            <th>referrel date</th>
            <th>date</th>
            <th>status</th>
            <th>date</th>
            <th>amount</th>
            <th>status</th>
            <th>date of shipment</th>
            <th>date</th>
            <th>status</th>
            <th>date</th>
            <th>status</th>
            <th>date</th>
            <th>status</th>
            <th>date</th>
            <th>status</th>
            <th>date</th>
            <th>status</th>
            <th>dietitian</th>
            <th>comment</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($Fast_Medical_Record as $fastrecord)
            <tr>
                <td style="border: 1px solid black;">{{ $fastrecord->id }}</td>
                <td style="border: 1px solid black;">{{ $fastrecord->patient_name }}</td>
                <td style="border: 1px solid black;">{{ $fastrecord->referred_by }}</td>
                <td style="border: 1px solid black;">{{ $fastrecord->dob }}</td>
                <td style="border: 1px solid black;">{{ $fastrecord->contact }}</td>
                <td style="border: 1px solid black;">{{ $fastrecord->referrel_date }}</td>
                <td style="border: 1px solid black;">{{ $fastrecord->pre_test_date }}</td>
                @if ($fastrecord->pre_test_status == 1)
                <td style="border: 1px solid black;">Completed</td>
                @else
                <td style="border: 1px solid black;">In complete</td>
                @endif
                <td style="border: 1px solid black;">{{ $fastrecord->blood_collection_date }}</td>
                <td style="border: 1px solid black;">{{ $fastrecord->blood_collection_amount }}</td>
                @if ($fastrecord->blood_collection_status == 1)
                <td style="border: 1px solid black;">Completed</td>
                @else
                <td style="border: 1px solid black;">In complete</td>
                @endif
                <td style="border: 1px solid black;">{{ $fastrecord->date_of_shipment }}</td>
                <td style="border: 1px solid black;">{{ $fastrecord->fast_test_report_date }}</td>
                @if ($fastrecord->fast_test_report_status == 1)
                <td style="border: 1px solid black;">Provided</td>
                @else
                <td style="border: 1px solid black;">Not Provided</td>
                @endif
                <td style="border: 1px solid black;">{{ $fastrecord->report_session_date }}</td>
                @if ($fastrecord->report_session_status == 1)
                <td style="border: 1px solid black;">Provided</td>
                @else
                <td style="border: 1px solid black;">Not Provided</td>
                @endif
                <td style="border: 1px solid black;">{{ $fastrecord->post_test_consult_date }}</td>
                @if ($fastrecord->post_test_consult_status == 1)
                <td style="border: 1px solid black;">Completed</td>
                @else
                <td style="border: 1px solid black;">In Complete</td>
                @endif
                <td style="border: 1px solid black;">{{ $fastrecord->post_post_test_date }}</td>
                @if ($fastrecord->post_post_test_status == 1)
                <td style="border: 1px solid black;">Completed</td>
                @else
                <td style="border: 1px solid black;">In Complete</td>
                @endif
                <td style="border: 1px solid black;">{{ $fastrecord->retest_date }}</td>
                @if ($fastrecord->retest_date_status == 1)
                <td style="border: 1px solid black;">Completed</td>
                @else
                <td style="border: 1px solid black;">In Complete</td>
                @endif
                <td style="border: 1px solid black;">{{ $fastrecord->dietitian }}</td>
                <td style="border: 1px solid black;">{{ $fastrecord->comment }}</td>
        @endforeach
    </tbody>

</table>
