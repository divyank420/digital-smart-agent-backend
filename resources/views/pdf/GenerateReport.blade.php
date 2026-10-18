<!doctype html>
    <html class="no-js" lang="zxx">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>Collection Report</title>
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      
      <style>
        @page { margin: 0px; }
        body{
            margin: 5px 30px 0px 50px;
        }
        .bg-danger{
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
        .receipt-main::after {
            background: #414143;
            content: "";
            height: 5px;
            left: 0;
            position: absolute;
            right: 0;
            top: -13px;
        }
        .receipt-main thead {
            background: #cadef7 none repeat scroll 0 0;
        }
        .receipt-main thead th {
            color:#001d41;
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
            margin: 14px 0 0;
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
        .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
            border-bottom-width: 2px;
            justify-content: center;
            align-items: center;
        }
        .table>tbody>tr>td{
            line-height: 0.7;
            vertical-align: top;
            border-top: 1px solid #ddd;
            justify-content:center;
            align-items: center;
        }
        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
            border: 1px solid #ddd;
            text-align: left;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
        }
        .receipt-main-header{
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
            opacity: 0.3;
            font-size: 14px;
        }
        .watermark_1 {
            top: 10%;
            left: 50%;
        }
        .watermark_2 {
            top: 50%;
            left: 50%;
            opacity: 0.2;
        }
        .watermark_3 {
            top: 80%;
            left: 50%;
            opacity: 0.1;
        }
        .text-danger {
            color: #df4759;
        }
        main{
            padding: 0px 2px 30px 2px;
        }
    </style>
</head>
<body>
    <div class="watermark watermark_1">Digital Smart Agent <br><small style="font-size: 10px;">Contact Us: +91-7665629201</small></div>
    <div class="watermark watermark_2">Digital Smart Agent <br><small style="font-size: 10px;">Contact Us: +91-7665629201</small></div>
    <div class="watermark watermark_3">Digital Smart Agent <br><small style="font-size: 10px;">Contact Us: +91-7665629201</small></div>
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
                            <h3 style="font-weight: 500;font-size:16px;">COLLECTION REPORT - {{$report_date}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
            <div class="row">
                <div class="receipt-header receipt-header-mid">
                    <div class="col-xs-8 col-sm-8 col-md-8 text-left" style="display: inline-block;">
                        <div class="receipt-right">
                            <h5>{{$company->company_name}}</h5>
                            <p><b>Agent :</b> {{$company->owner_name}}</p>
                            <p><b>Email :</b> {{$company->email ?? ''}}</p>
                            <p><b>Mobile :</b> 9352244561</p>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4" style="display: inline-block;float: right;">
                        <div class="receipt-right">
                            <h5>Digital Smart Agent</h5>
                            <p>9588279416</p>
                            <p>work.divyank@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:5%">Sr</th>
                            <th>Customer</th>
                            <th>Payment Via</th>
                            <th style="width: 25%;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($entries->count() > 0)
                        @php

                        $sr = 1;
                        $totalCollection = 0;
                        @endphp
                        @foreach($entries as $value)
                        @php
                        $totalCollection = $totalCollection+ (int)$value['amount'];
                        @endphp 

                        <tr class="{{$value['entry_type']=='penalty'?bg-danger:''}}">
                            <td>{{$sr++}}</td>
                            <td>{{$value['name']}}</td>
                            <td>{{$value['amount_type']}}</td>
                            <td>{{number_format($value['amount'])}}/-</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" style="text-align: right;"><h2><strong>Total: </strong></h2></td>
                            <td class="text-left text-danger"><h2><strong><i class="fa fa-inr"></i> {{number_format($totalCollection)}}/-</strong></h2></td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="10" style="text-align: center;"><h2><strong>No Entries Found</strong></h2></td>
                        </tr>
                        @endif

                    </tbody>
                </table>
                @php
                    $sr = 1;
                    $totalExpenses = 0;
                @endphp
                @if($expenses->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:5%">Sr</th>
                            <th>Reason</th>
                            <th>Payment Via</th>
                            <th style="width: 25%;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $value)
                        @php
                            $totalExpenses = $totalExpenses + (int)$value['amount'];
                        @endphp 
                        <tr class="{{$value['entry_type']=='penalty'?bg-danger:''}}">
                            <td>{{$sr++}}</td>
                            <td>{{$value['reason']}}</td>
                            <td>{{$value['amount_type']}}</td>
                            <td>{{number_format($value['amount'])}}/-</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" style="text-align: right;"><h2><strong>Total </strong></h2></td>
                            <td class="text-left text-danger"><h2><strong><i class="fa fa-inr"></i> {{number_format($totalExpenses)}}/-</strong></h2></td>
                        </tr>
                    </tbody>
                </table>
                @endif

                <table class="table table-bordered" style="width:35%;justify-content:right;">
                    <thead>
                        <tr>
                            <th colspan="2" style="text-align: center">Note Denomination</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: left;margin-left: 30px;">
                                @if($denomination->online != 0)
                                <p><strong>online:</strong></p>
                                @endif
                                @if($denomination->n_2000 != 0)
                                <p><strong>2000 * {{$denomination->n_2000}}:</strong></p>
                                @endif
                                @if($denomination->n_500 != 0)
                                <p><strong>500 * {{$denomination->n_500}}:</strong></p>
                                @endif
                                @if($denomination->n_200 != 0)
                                <p><strong>200 * {{$denomination->n_200}}:</strong></p>
                                @endif
                                @if($denomination->n_100 != 0)
                                <p><strong>100 * {{$denomination->n_100}}:</strong></p>
                                @endif
                                @if($denomination->n_50 != 0)
                                <p><strong>50 * {{$denomination->n_50}}:</strong></p>
                                @endif
                                @if($denomination->n_10 != 0)
                                <p><strong>10 * {{$denomination->n_10}}:</strong></p>
                                @endif
                            </td>
                            <td>
                                @if($denomination->online != 0)
                                <p><strong>{{number_format($denomination->online)}}</strong></p>
                                @endif
                                @if($denomination->n_2000 != 0)
                                <p><strong>{{number_format($denomination->n_2000_value)}}/-</strong></p>
                                @endif
                                @if($denomination->n_500 != 0)
                                <p><strong>{{number_format($denomination->n_500_value)}}/-</strong></p>
                                @endif
                                @if($denomination->n_200 != 0)
                                <p><strong>{{number_format($denomination->n_200_value)}}/-</strong></p>
                                @endif
                                @if($denomination->n_100 != 0)
                                <p><strong>{{number_format($denomination->n_100_value)}}/-</strong></p>
                                @endif
                                @if($denomination->n_50 != 0)
                                <p><strong>{{number_format($denomination->n_50_value)}}/-</strong></p>
                                @endif
                                @if($denomination->n_10 != 0)
                                <p><strong>{{number_format($denomination->n_10_value)}}/-</strong></p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left;margin-left: 30px;"><h2><strong>Total </strong></h2></td>
                            <td class="text-left text-danger">
                                <h2>
                                    <strong>
                                        @php
                                            $totalDenomination = $denomination->online+$denomination->n_2000_value+$denomination->n_500_value+$denomination->n_200_value+$denomination->n_100_value+$denomination->n_50_value+$denomination->n_10_value;
                                        @endphp
                                        {{ number_format($totalDenomination);}}
                                    </strong>
                                </h2>
                            </td>
                        </tr>
                    </tbody>
                </table>
                @if($totalDenomination + $totalExpenses !=  $totalCollection)
                    <div>
                        <h4 class="text-danger">Note: Your Collection Amount or Denomination Amount not matched </h4>
                    </div>
                @endif
            </div>
        </div>
    </main>
    <footer>
        <div style="margin-top: 8px !important">Thank you for using DSA. This is a system-generated report. Contact us : +91-7665629201 </div>
    </footer>
</body>
</html>