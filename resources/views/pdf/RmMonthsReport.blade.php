<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Collection Report</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <style>
        @page {
            margin: 0px;
        }

        body {
            margin: 5px 30px 0px 50px;
        }

        .bg-danger {
            background-color: #f8d7da;
            color: #df4759;

        }

        .text-danger strong {
            color: #9f181c;
        }

        .receipt-main {
            background: #ffffff none repeat scroll 0 0;
            margin-top: 0px;
            margin-bottom: 10px;
            padding: 10px 20px !important;
            position: relative;
            color: #001d41;
            font-family: open sans;
            margin: auto;
        }

        .receipt-main p {
            color: #333333;
            font-family: open sans;
            line-height: 1.42857;
        }

        .receipt-footer h1 {
            font-size: 15px;
            font-weight: 400 !important;
            margin: 0 !important;
        }

        .receipt-main thead {
            background: #cadef7 none repeat scroll 0 0;
        }

        .receipt-main thead th {
            color: #001d41;
        }

        .receipt-right h5 {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 7px 0;
        }

        .receipt-right p {
            font-size: 12px;
            margin: 0px;
        }

        .receipt-right p i {
            text-align: center;
            width: 18px;
        }

        .receipt-main td {
            padding: 9px 20px !important;
        }

        .receipt-main th {
            padding: 5px 20px !important;
        }

        .receipt-main td {
            font-size: 13px;
            font-weight: initial !important;
        }

        .receipt-main td p:last-child {
            margin: 0;
            padding: 0;
        }

        .receipt-main td h2 {
            font-size: 16px;
            font-weight: 900;
            margin: 0px;
            text-transform: uppercase;
        }

        .receipt-header-mid .receipt-left h1 {
            font-weight: 100;
            margin: 10px 0 0;
            text-align: right;
            text-transform: uppercase;
        }

        .receipt-header-mid {
            margin: 14px 0;
            overflow: hidden;
        }

        #container {
            background-color: #dcdcdc;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 10px;
        }

        .table-bordered>thead>tr>td,
        .table-bordered>thead>tr>th {
            border-bottom-width: 2px;
            justify-content: center;
            align-items: center;
        }

        .table>tbody>tr>td {
            line-height: 0.7;
            vertical-align: top;
            border-top: 1px solid #ddd;
            justify-content: center;
            align-items: center;
        }

        .table-bordered>tbody>tr>td,
        .table-bordered>tbody>tr>th,
        .table-bordered>tfoot>tr>td,
        .table-bordered>tfoot>tr>th,
        .table-bordered>thead>tr>td,
        .table-bordered>thead>tr>th {
            border: 1px solid #ddd;
            text-align: left;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        .receipt-main-header {
            margin: 5px 30px 0px 10px;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            font-size: 12px;
            color: #001d41;
            background-color: #cadef7;
            text-align: center;
            line-height: 12px;
        }

        .watermark {
            position: fixed;
            transform: translate(-50%, -50%);
            font-size: 30px;
            opacity: 0.1;
            font-size: 14px;
        }

        .watermark_1 {
            top: 10%;
            left: 50%;
        }

        .watermark_2 {
            top: 50%;
            left: 30%;
            opacity: 0.2;
        }

        .watermark_3 {
            top: 80%;
            left: 70%;
            opacity: 0.1;
        }

        .text-danger {
            color: #df4759;
        }

        main {
            padding: 0px 2px 30px 2px;
        }

        .month-box {
            border: 1px solid #999;
            margin-bottom: 12px;
            border-radius: 4px;
        }

        .month-header {
            background: #cadef7;
            padding: 6px;
            font-weight: bold;
        }

        .report-period {
            background-color: #cadef7;
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="watermark watermark_1">
        <img src="{{ public_path() . '/images/logo.png' }}" alt="Digital Smart Agent"
            style="width: 150px; height: 40px; border-radius: 43px;">
    </div>
    <div class="watermark watermark_2">
        <img src="{{ public_path() . '/images/logo.png' }}" alt="Digital Smart Agent"
            style="width: 150px; height: 40px; border-radius: 43px;">
    </div>
    <div class="watermark watermark_3">
        <img src="{{ public_path() . '/images/logo.png' }}" alt="Digital Smart Agent"
            style="width: 150px; height: 40px; border-radius: 43px;">
    </div>
    <header>
        <table style="width: 100%; border-collapse: collapse; margin-top: 5px;">
            <tr>
                <td style="width: 50%;">
                    <img src="{{ public_path() . '/images/logo.png' }}" alt="Digital Smart Agent"
                        style="width: 150px; height: 40px; border-radius: 43px;">
                </td>
                <td style="width: 50%; text-align: right; vertical-align: middle;">
                    <h3 style="margin: 0; font-weight: 500; font-size: 14px;">PAYMENT DEPOSIT REPORT</h3>
                    <p style="margin: 2px 0 0; font-size: 12px; font-weight: 600;">
                        {{ $report_period }}
                    </p>
                </td>
            </tr>
        </table>
    </header>
    <main>
        <div class="receipt-main">
            <div class="receipt-header receipt-header-mid" style="width:100%">
                <div class=" text-left" style="display: inline-block;">
                    <div class="receipt-right">
                        <h5>{{ $company->firm_name }}</h5>
                        <p><b>Agent :</b> {{ $company->agent_name }}</p>
                        <p><b>Email :</b> {{ $company->email }}</p>
                        <p><b>Mobile :</b> {{ $company->mobile }} </p>
                    </div>
                </div>
                <div style="display: inline-block; float: right;">
                    <div class="receipt-right">
                        <h5>Digital Smart Agent</h5>
                        <p>Divyank Kabra</p>
                        <p>9588279416</p>
                        <p>work.divyank@gmail.com</p>
                    </div>
                </div>
            </div>
            @foreach ($groupedEntries as $month => $monthEntries)
                <div style="margin-bottom: 15px; border: 1px solid #ccc;">

                    <!-- Month Title -->
                    <h4 style="margin: 0 0 5px 0; background: #cadef7; padding: 5px; text-align:center">
                        {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}
                    </h4>

                    <!-- Table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:10%">Sr</th>
                                <th>Agent Name</th>
                                <th>Entry Date</th>
                                <th>Payment Mode</th>
                                <th style="width:30%">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sr = 1;
                                $monthlyTotal = 0;
                            @endphp
                            {{-- @if ($monthEntries->isEmpty())
                                <tr>
                                    <td colspan="3" style="text-align:center;">No Entries</td>
                                </tr>
                            @endif --}}
                            @foreach ($monthEntries as $entry)
                                @php $monthlyTotal += (int)$entry['amount']; @endphp

                                <tr>
                                    <td>{{ $sr++ }}</td>
                                    <td>{{ $entry['agent']['name'] }}</td>
                                    <td>{{ date('d-M-Y', strtotime($entry['entry_date'])) }}</td>
                                    <td>{{ $entry['amount_type'] }}</td>
                                    <td>{{ number_format($entry['amount']) }}/-</td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <!-- Monthly Total -->
                            <tr>
                                <td colspan="4" style="text-align: right;"><strong>Total</strong></td>
                                <td><strong>{{ number_format($monthlyTotal) }}/-</strong></td>
                            </tr>

                        </tfoot>
                    </table>

                </div>
            @endforeach
        </div>
    </main>
    <footer>
        <div style="margin-top: 8px !important">Thank you for using DSA. This is a system-generated report. Contact us :
            +91-7665629201 </div>
    </footer>
</body>

</html>
