<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "//www.w3.org/TR/html4/strict.dtd">
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="icon" href="{{ asset('web/img/logo.jpg') }}" type="image/png">
    <title>Bill PDF</title>
    <link href="{{ asset('assets/css/bill-pdf.css') }}" rel="stylesheet" type="text/css" />
    @if (getCurrentCurrency() == 'inr')
        <style>
            body {
                font-family: DejaVu Sans, sans-serif !important;
            }

            /* .text-right{
                text-align: right !important;
            } */
        </style>
    @endif
</head>

<body>
    <table width="100%">
        <tr>
            <td class="header-left">
                <div class="main-heading">{{ __('messages.bill.bill') }}</div>
                <img src="https://app.infinitewellnesspk.com/logo.png" width="120px" alt="logo">
                <div class="invoice-number font-color-gray">Bill
                    #{{ $bill->patient_admission_id }}</div>
            </td>
            <td class="header-right">
                <div class="logo"><img width="100px" src="{{ $setting['app_logo'] }}" alt=""></div>
                <div class="hospital-name">{{ $setting['app_name'] }}</div>
                <div class="hospital-name font-color-gray">{{ $setting['hospital_address'] }}</div>
            </td>
        </tr>
        {{-- <tr> --}}
            <td style="position: relative!important; top: 10px !important; display: flex !important; justify-content: start !important; align-items: start !important;">
                <table>
                    <tr>
                        <td>
                            <span
                                class="font-weight-bold patient-detail-heading">{{ __('messages.bill.bill_id') }}:</span>
                            #{{ $bill->bill_id }}
                            <br>
                            <span
                                class="font-weight-bold patient-detail-heading">{{ __('messages.bill.bill_date') }}:</span>
                            {{ \Carbon\Carbon::parse($bill->bill_date)->format('jS M,Y g:i A') }}
                            <br>
                            <span
                                class="font-weight-bold patient-detail-heading">{{ __('messages.investigation_report.doctor') }}:</span>
                            {{ $bill->patientAdmission ? $bill->patientAdmission->doctor->doctorUser->full_name : $bill->doctor }}
                        </td>
                    </tr>
                </table>
                <table style="margin-left: 110px !important;">
                    <tr>
                        <td>
                    <tr>
                        <td colspan="2" class="font-weight-bold patient-detail-heading ">
                            {{ __('messages.patient.patient_details') }}</td>
                    </tr>

                    <tr>
                        <td class="font-weight-bold ">{{ __('messages.investigation_report.patient') }}:
                        </td>
                        <td class="">{{ $bill->patient->user->full_name }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold ">{{ __('messages.user.email') }}:</td>
                        <td class="">{{ $bill->patient->user->email }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold ">EMR #</td>
                        <td class="">
                            {{ $bill->patient->MR }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold ">{{ __('messages.bill.cell_no') }}:</td>
                        <td class="">
                            {{ !empty($bill->patient->user->phone) ? $bill->patient->user->phone : 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold ">{{ __('messages.user.gender') }}:</td>
                        <td class="">
                            {{ $bill->patient->user->gender == 0 ? __('messages.user.male') : __('messages.user.female') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold ">{{ __('messages.user.dob') }}:</td>
                        <td class="">
                            {{ !empty($bill->patient->user->dob) ? Datetime::createFromFormat('Y-m-d', $bill->patient->user->dob)->format('jS M, Y') : 'N/A' }}
                        </td>
                    </tr>
            </td>
        {{-- </tr> --}}
    </table>
    </td>
    </tr>

    <tr>
        <td colspan="2">
            <table class="items-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        {{-- <th class="number-align">{{ __('messages.bill.qty') }}</th> --}}
                        <th class="number-align">{{ __('messages.bill.price') }}
                            (<b>{{ getCurrencySymbol() }}</b>)
                        </th>
                        <th class="number-align">{{ __('messages.bill.amount') }}
                            (<b>{{ getCurrencySymbol() }}</b>)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($bill) && !empty($bill))
                        @foreach ($bill->billItems as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->item_name }}</td>
                                {{-- <td class="number-align">{{ $item->qty }}</td> --}}
                                <td class="number-align">
                                    {{ checkNumberFormat($item->price, strtoupper($bill['currency_symbol'] ?? getCurrentCurrency())) }}
                                </td>
                                <td class="number-align">
                                    {{ checkNumberFormat($item->amount, strtoupper($bill['currency_symbol'] ?? getCurrentCurrency())) }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <table class="bill-footer">
                <tr>
                    <td class="font-weight-bold">Amount:</td>
                    <td>{{ checkNumberFormat($bill->amount, strtoupper($bill['currency_symbol'] ?? getCurrentCurrency())) }}
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Discount:</td>
                    <td>{{ checkNumberFormat($bill->discount_amount, strtoupper($bill['currency_symbol'] ?? getCurrentCurrency())) }}
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Total Amount:</td>
                    <td>{{ checkNumberFormat($bill->total_amount, strtoupper($bill['currency_symbol'] ?? getCurrentCurrency())) }}
                    </td>
                </tr>

            </table>
        </td>
    </tr>
    </table>
</body>

</html>

<script>
    window.print();
</script>
