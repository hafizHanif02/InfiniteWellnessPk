<x-layouts.app title="Products List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <h3>Products Report</h3>

                <div class="d-flex justify-content-center gap-5 mb-5">
                    <div class="d-flex gap-5">
                        <div>
                            <label for="date_from" class="form-label">Date From</label>
                            <input type="date" value="{{ request('date_from', date('Y-m-d')) }}" class="form-control"
                                name="date_from" id="date_from" onchange="updateQueryString('date_from', this.value)">
                        </div>
                        <div>
                            <label for="date_to" class="form-label">Date To</label>
                            <input type="date" value="{{ request('date_to', date('Y-m-d')) }}" class="form-control"
                                name="date_to" id="date_to" onchange="updateQueryString('date_to', this.value)">
                        </div>
                    </div>
                    <div class="d-flex gap-5 mt-5">
                        <a href="{{ route('inventory.products.products_report') }}"
                            class="btn btn-secondary mt-3">Reset</a>
                        <button class="btn btn-primary mt-3" style="" onclick="ExportToExcel('xlsx')">Export to
                            Excel</button>
                        <a href="{{ route('products_report.print', ['date_from' => request('date_from'), 'date_to' => request('date_to')]) }}"
                            target="_blank" class="btn btn-primary mt-3">Print</a>

                    </div>
                </div>


                <div class="table-wrap d-flex justify-content-between">
                    <table class="sortable table table-bordered" id="tbl_exporttable_to_xls">
                        <thead class="table-dark">
                            <tr>
                                <th>
                                    <button class="button">
                                        #
                                        <span aria-hidden="true"></span>
                                    </button>
                                </th>
                                <th>
                                    <button class="button">
                                        Name
                                        <span aria-hidden="true"></span>
                                    </button>
                                </th>
                                <th>
                                    <button class="button">
                                        Open Qty
                                        <span aria-hidden="true"></span>
                                    </button>
                                </th>
                                <th>
                                    <button class="button">
                                        Current Qty
                                        <span aria-hidden="true"></span>
                                    </button>
                                </th>
                                <th>
                                    <button class="button">
                                        StockIn
                                        <span aria-hidden="true"></span>
                                    </button>
                                </th>
                                <th>
                                    <button class="button">
                                        StockOut
                                        <span aria-hidden="true"></span>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                {{-- {{ dd($product) }} --}}
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->product_name }}
                                        {{ $product->generic->formula != null ? '(' . $product->generic->formula . ')' : '-' }}
                                    </td>
                                    <td>{{ $product->open_quantity }}</td>
                                    <td>{{ $product->stock_current }}</td>
                                    {{-- <td>{{ $product->total_quantity }}</td> --}}
                                    <td>{{ $product->stock_in }}</td>
                                    <td>{{ $product->stock_out }}</td>
                                </tr>
                            @endforeach
                            @if ($products->count() == 0)
                                <tr class="text-center">
                                    <td colspan="5" class="text-danger">No products found!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <script>
            $(document).ready(function() {
                if (!localStorage.getItem('reloaded')) {
                localStorage.setItem('reloaded', 'true');
                location.reload(true);
            }
            });

            function updateQueryString(key, value) {
                var searchParams = new URLSearchParams(window.location.search);

                if (searchParams.has(key)) {
                    searchParams.set(key, value);
                } else {
                    searchParams.append(key, value);
                }

                var newUrl = window.location.pathname + '?' + searchParams.toString();
                history.pushState({}, '', newUrl);

                window.location.reload();
            }


            'use strict';

            class SortableTable {
                constructor(tableNode) {
                    this.tableNode = tableNode;

                    this.columnHeaders = tableNode.querySelectorAll('thead th');

                    this.sortColumns = [];

                    for (var i = 0; i < this.columnHeaders.length; i++) {
                        var ch = this.columnHeaders[i];
                        var buttonNode = ch.querySelector('button');
                        if (buttonNode) {
                            this.sortColumns.push(i);
                            buttonNode.setAttribute('data-column-index', i);
                            buttonNode.addEventListener('click', this.handleClick.bind(this));
                        }
                    }

                    this.optionCheckbox = document.querySelector(
                        'input[type="checkbox"][value="show-unsorted-icon"]'
                    );

                    if (this.optionCheckbox) {
                        this.optionCheckbox.addEventListener(
                            'change',
                            this.handleOptionChange.bind(this)
                        );
                        if (this.optionCheckbox.checked) {
                            this.tableNode.classList.add('show-unsorted-icon');
                        }
                    }
                }

                setColumnHeaderSort(columnIndex) {
                    if (typeof columnIndex === 'string') {
                        columnIndex = parseInt(columnIndex);
                    }

                    for (var i = 0; i < this.columnHeaders.length; i++) {
                        var ch = this.columnHeaders[i];
                        var buttonNode = ch.querySelector('button');
                        if (i === columnIndex) {
                            var value = ch.getAttribute('aria-sort');
                            if (value === 'descending') {
                                ch.setAttribute('aria-sort', 'ascending');
                                this.sortColumn(
                                    columnIndex,
                                    'ascending',
                                    ch.classList.contains('num')
                                );
                            } else {
                                ch.setAttribute('aria-sort', 'descending');
                                this.sortColumn(
                                    columnIndex,
                                    'descending',
                                    ch.classList.contains('num')
                                );
                            }
                        } else {
                            if (ch.hasAttribute('aria-sort') && buttonNode) {
                                ch.removeAttribute('aria-sort');
                            }
                        }
                    }
                }

                sortColumn(columnIndex, sortValue, isNumber) {
                    function compareValues(a, b) {
                        if (sortValue === 'ascending') {
                            if (a.value === b.value) {
                                return 0;
                            } else {
                                if (isNumber) {
                                    return a.value - b.value;
                                } else {
                                    return a.value < b.value ? -1 : 1;
                                }
                            }
                        } else {
                            if (a.value === b.value) {
                                return 0;
                            } else {
                                if (isNumber) {
                                    return b.value - a.value;
                                } else {
                                    return a.value > b.value ? -1 : 1;
                                }
                            }
                        }
                    }

                    if (typeof isNumber !== 'boolean') {
                        isNumber = false;
                    }

                    var tbodyNode = this.tableNode.querySelector('tbody');
                    var rowNodes = [];
                    var dataCells = [];

                    var rowNode = tbodyNode.firstElementChild;

                    var index = 0;
                    while (rowNode) {
                        rowNodes.push(rowNode);
                        var rowCells = rowNode.querySelectorAll('th, td');
                        var dataCell = rowCells[columnIndex];

                        var data = {};
                        data.index = index;
                        data.value = dataCell.textContent.toLowerCase().trim();
                        if (isNumber) {
                            data.value = parseFloat(data.value);
                        }
                        dataCells.push(data);
                        rowNode = rowNode.nextElementSibling;
                        index += 1;
                    }

                    dataCells.sort(compareValues);

                    // remove rows
                    while (tbodyNode.firstChild) {
                        tbodyNode.removeChild(tbodyNode.lastChild);
                    }

                    // add sorted rows
                    for (var i = 0; i < dataCells.length; i += 1) {
                        tbodyNode.appendChild(rowNodes[dataCells[i].index]);
                    }
                }

                /* EVENT HANDLERS */

                handleClick(event) {
                    var tgt = event.currentTarget;
                    this.setColumnHeaderSort(tgt.getAttribute('data-column-index'));
                }

                handleOptionChange(event) {
                    var tgt = event.currentTarget;

                    if (tgt.checked) {
                        this.tableNode.classList.add('show-unsorted-icon');
                    } else {
                        this.tableNode.classList.remove('show-unsorted-icon');
                    }
                }
            }

            // Initialize sortable table buttons
            window.addEventListener('load', function() {
                var sortableTables = document.querySelectorAll('table.sortable');
                for (var i = 0; i < sortableTables.length; i++) {
                    new SortableTable(sortableTables[i]);
                }
            });


            function ExportToExcel(type, fn, dl) {
                var elt = document.getElementById('tbl_exporttable_to_xls');
                var wb = XLSX.utils.table_to_book(elt, {
                    sheet: "sheet1"
                });
                var currentDate = new Date();
                var day = currentDate.getDate().toString().padStart(2, '0');
                var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
                var year = currentDate.getFullYear();
                var formattedDate = day + '-' + month + '-' + year;
                var fileName = 'POS-Report (' + formattedDate + ').xlsx';

                return dl ?
                    XLSX.write(wb, {
                        bookType: type,
                        bookSST: true,
                        type: 'base64'
                    }) :
                    XLSX.writeFile(wb, fn || fileName);
            }
        </script>
</x-layouts.app>
<style>
    .button {
        border: none !important;
        outline: none !important;
        background: transparent !important;
        color: white !important;
        content: "Sort" !important;
        cursor: pointer !important;
    }
</style>

