<table id="tbl_exporttable_to_xls" border="1">
    <thead>
        <tr>
            <th>GRN #</th>
            <th>Invoice #</th>
            <th>Invoice Date</th>
            <th>Distributor</th>
            <th>Net Total Amount</th>
            <th>Paid/Unpaid</th>
            <th>Unpaid Amount</th>
            <th>Paid Amount</th>
            <th>Last Paid Date</th>
            <th>Comments</th>
        </tr>
    </thead>
    {{-- @dd($grn[278]) --}}
    <tbody>
        @foreach ($grn as $grn)
            {{-- @dd($grn) --}}
            <tr>
                <td>{{ $grn->id }}</td>
                <td>{{ $grn->invoice_number }}</td>
                <td>{{ $grn->invoice_date }}</td>
                <td>{{ $grn->requistion->vendor->account_title }}</td>
                <td>{{ $grn->net_total_amount }}</td>
                <td>{{ $grn->grnPayments->sum('paid_amount') == 0 ? 'Unpaid' : 'Paid' }}</td>
                <td>{{ $grn->grnPayments->sum('paid_amount') == 0 ? $grn->net_total_amount : $grn->net_total_amount - $grn->grnPayments->sum('paid_amount') }}</td>
                <td>{{ $grn->grnPayments->sum('paid_amount') }}</td>
                <td>{{ $grn->grnPayments->sum('paid_amount') == 0 ? '-' : $grn->grnPayments->sortByDesc('id')->first()->paid_date }}</td>
                @if ( count($grn->grnPayments) > 0)
                {{-- @dd() --}}
                <td>{{ 
                    $grn->grnPayments->where('comments', '!=', null)->sortByDesc('id')->first() 
                    ? $grn->grnPayments->where('comments', '!=', null)->sortByDesc('id')->first()->comments 
                    : '-' 
                }}</td>
                @else
                <td>-</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.6/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        ExportToExcel('xlsx');

        function ExportToExcel(type) {
            var elt = document.getElementById('tbl_exporttable_to_xls');
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "sheet1"
            });
            var currentDate = new Date();
            var day = currentDate.getDate().toString().padStart(2, '0');
            var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            var year = currentDate.getFullYear();
            var formattedDate = day + '-' + month + '-' + year;
            var fileName = 'Vendor Ledger (' + formattedDate + ').xlsx';
            XLSX.writeFile(wb, fileName);
            window.close();
        }
    });
</script>
