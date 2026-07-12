<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Collection Posting Report</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <style>
        @page {
            size: A4 landscape;
            margin: 0px;
        }

        body {
            margin: 0px;
            margin-top: 40px;
        }

        /* .receipt-main {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            padding: 0px;
            box-sizing: border-box;
        } */
        .receipt-main {
            background: #ffffff none repeat scroll 0 0;
            margin-top: 10px;
            margin-bottom: 10px;
            padding: 0px !important;
            color: #333333;
            font-family: open sans;
            margin: 0 auto;
        }

        .receipt-content {
            padding: 2px;
        }
        .receipt-main-header{
            margin: 5px 30px 0px 30px;
        }
        .receipt-header-mid .receipt-left h1 {
            font-weight: 100;
            margin: 14px 0 0;
            text-align: right;
            text-transform: uppercase;
        }
        .receipt-header-mid {
            margin: 14px 0;
            overflow: hidden;
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

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
        }

        .receipt-table th,
        .receipt-table td {
            border: 1px solid #ddd;
            padding: 3px;
            text-align: center;
            font-size: 12px;
        }

        .bg-dark {
            color: #1b1e21;
            background-color: #d6d8d9;
        }
        .bg-danger {
            color: #721c24;
            background-color: #f8d7da;
        }
        .bg-success {
            color: #155724;
            background-color: #d4edda;
        }
        .text-danger {
            color: #df4759;
        }
        .text-success {
            color: #3cf08d;
        }

        .receipt-table th {
            background-color: #414143;
            color: white;
        }
        .customer {
            text-align:left !important;
            padding-left:5px !important;
            font-size: 11px;
        }
        .total{
            font-size: 10px;
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
        main {
            padding: 0px 2px 30px 2px;
        }
        .blank{
            padding:2 !important;
        }
        .br-green{
            border:1px solid rgb(152, 153, 152) !important;
        }
    </style>
</head>

<body>
    <header>
        <div class="receipt-main-header">
            <div class="row">
                <div class="receipt-header">
                    <div class="col-xs-6 col-sm-6 col-md-6" style="display: inline-block;">
                        <div class="receipt-left">
                            <img class="img-responsive" alt="Digital Smart Agent" src="{{public_path().'/images/logo.png'}}" style="width: 150px;height: 50px; border-radius: 43px;">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 text-right" style="display: inline-block;float: right;text-align:right;">
                        <div class="receipt-left">
                            <h3 style="font-weight: 500;font-size:16px;">POSTING REPORT {{$posting_month}}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="receipt-header receipt-header-mid">
                    <div class="col-xs-8 col-sm-8 col-md-8 text-left" style="display: inline-block;">
                        <div class="receipt-right">
                            <h5>{{$company->company_name}}</h5>
                            <p><b>Agent :</b> {{$company->owner_name}}</p>
                            <p><b>Email :</b> {{$company->email ?? ''}}</p>
                            <p><b>Mobile :</b> {{ config('app.email') }}</p>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4" style="display: inline-block;float: right;">
                        <div class="receipt-right">
                            <h5>{{ config('app.name') }}</h5>
                            <p>{{ config('app.contact_no') }}</p>
                            <p>{{ config('app.email') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="receipt-main">
            <div class="receipt-content">
                <table class="receipt-table">
                    <thead>
                        <tr>
                            <th style="width: 3%;">Sr</th>
                            <th style="width: 9%;" class="customer">Customer</th>
                            @for ($i = 1; $i <= $dateData['endDate']; $i++)
                                <th style="width: {{ 60/($dateData['endDate']+1) }}%;">{{ $i }}</th>
                            @endfor
                            <th style="width:10%">Total</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        @if (count($rms) > 0)
                            @php
                                $sr = 1;
                                $totalCollection = 0;
                            @endphp
                            @foreach ($rms as $value)
                                <tr>
                                    <td>{{ $sr++ }}</td>
                                    <td class="customer">{{ $value['name'] }}</td>
                                    @foreach ($value['monthly_data'] as $day)
                                        @if ($day['amount'] > 0)
                                            <td class="br-green">{{ $day['amount'] }}</td>
                                        @else
                                            <td class="bg-dark blank">-</td>
                                        @endif
                                    @endforeach
                                    <td class="total bg-{{ $value['is_installment_complete'] }}">{{ $value['paid_installment_amount'] }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="{{ 31 + 3 }}">
                                    <h2>No Entries Found</h2>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <footer>
        <div style="margin-top: 8px !important">Thank you for using DSA. This is a system-generated report. Contact us : +91-7665629201</div>
    </footer>
</body>

</html>