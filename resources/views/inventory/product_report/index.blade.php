<x-layouts.app title="Products List">
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <h3>Products Report</h3>

                <div class="d-flex justify-content-center gap-5 mb-5">
                    <div class="d-flex gap-5">
                        <div>
                            <label for="date_from" class="form-label">Date From</label>
                            <input type="date" value="{{ request('date_from') }}" class="form-control" name="date_from"
                                id="date_from" onchange="updateQueryString('date_from',this.value)">
                        </div>
                        <div>
                            <label for="date_to" class="form-label">Date To</label>
                            <input type="date" value="{{ request('date_to') }}" class="form-control" name="date_to"
                                id="date_to" onchange="updateQueryString('date_to',this.value)">
                        </div>
                    </div>
                    <div class="mt-5">
                        <a href="{{ route('inventory.products.products_report') }}"
                            class="btn btn-secondary mt-3">Reset</a>
                    </div>
                </div>


                {{-- <div class="d-flex justify-content-between">
                    <table class="table table-bordered text-center table-hover">
                        <thead class="table-dark">
                            <tr>
                                <td scope="col" id="serial_number">#</td>
                                <td scope="col" id="name">Name</td>
                                <td scope="col" id="name">Open Qty</td>
                                <td scope="col" id="name">Current Qty</td>
                                <td scope="col" id="name">StockIn</td>
                                <td scope="col" id="name">StockOut</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td scope="row" headers="serial_number">{{ $product->id }}</td>
                                    <td headers="name">{{ $product->product_name }}</td>
                                    <td headers="name">{{ $product->open_quantity }}</td>
                                    <td headers="name">{{ $product->stock_current }}</td>
                                    <td headers="name">{{ $product->stock_in }}</td>
                                    <td headers="name">{{ $product->stock_out }}</td>
                                </tr>
                            @endforeach
                            @if ($products->count() == 0)
                                <tr class="text-center">
                                    <td colspan="5" class="text-danger">No products found!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div> --}}


                <div class="table-wrap d-flex justify-content-between">
                    <table class="sortable table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>
                                    <button>
                                        #
                                        <span aria-hidden="true"></span>
                                    </button>
                                </th>
                                <th>
                                    <button>
                                        Name
                                        <span aria-hidden="true"></span>
                                    </button>
                                </th>
                                <th>
                                    <button>
                                        Open Qty
                                        <span aria-hidden="true"></span>
                                    </button>
                                </th>
                                <th>
                                    <button>
                                        Current Qty
                                        <span aria-hidden="true"></span>
                                    </button>
                                </th>
                                <th>
                                    <button>
                                        StockIn
                                        <span aria-hidden="true"></span>
                                    </button>
                                </th>
                                <th>
                                    <button>
                                        StockOut
                                        <span aria-hidden="true"></span>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->open_quantity }}</td>
                                    <td>{{ $product->stock_current }}</td>
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
        <script>
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


            /*
             *   This content is licensed according to the W3C Software License at
             *   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
             *
             *   File:   sortable-table.js
             *
             *   Desc:   Adds sorting to a HTML data table that implements ARIA Authoring Practices
             */

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
        </script>
</x-layouts.app>

<style>
    button {
        border: none !important;
        outline: none !important;
        background: transparent !important;
        color: white !important;
        content: "Sort" !important;
        cursor: pointer !important;
    }
</style>