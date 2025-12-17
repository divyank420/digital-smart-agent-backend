@extends('layouts.agent')
@section('content')
    <style>
        .h-500 {
            height: 500px;
            overflow-y: scroll;
        }
    </style>
    @include('agents.includes.filters.collection_report_filter')
    <div class="row report-data">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Collection List</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative">
                                    <input type="text" class="form-control ps-5 search_customer_name" placeholder="Search Customer Name..."> <span class="position-absolute top-50 search-icon translate-middle-y"><i class="bx bx-search"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-0" />
                    <div class="h-500">
                        @php
                            $totalEntriesAmount = 0;
                        @endphp
                        @if(count($data['entries']) > 0)
                            @foreach ($data['entries'] as $entry)
                                <div class="d-flex align-items-center border-bottom p-2 cursor-pointer justify-content-between">
                                    <div class="ms-2">
                                        <h6 class="mb-1 font-14">{{ $entry['name'] ?? '' }}</h6>
                                        <p class="mb-0 font-13 text-secondary">
                                            {{ date('M d, Y', strtotime($entry['entry_date'])) }}
                                            {{ date('h:i A', strtotime($entry['created_at'])) }}</p>
                                    </div>
                                    <div class="">
                                        <span class="badge badge-{{ $entry['amount_type'] == 'cash'?'success':'primary' }} {{ $entry['amount_type']}}">{{ $entry['amount_type'] }}</span>
                                    </div>
                                    <div class="list-inline d-flex customers-contacts">
                                        <span>{{ amountFormat($entry['amount']) }}</span>
                                    </div>
                                </div>
                                @php
                                    $totalEntriesAmount += $entry['amount'];
                                @endphp
                            @endforeach
                        @else
                            <div class="text-center text-center align-items-center border-bottom p-2 cursor-pointer">
                                
                                <div class="list-inline customers-contacts ms-auto">
                                    <span>No Record Found</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if(count($data['entries']) > 0)
                    <div class="text-right px-3 pt-2" style="border-top:1px solid">
                        <h5><strong>{{amountFormat($totalEntriesAmount)}}</strong></h5>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h5>Note Denomination</h5>
                    </div>
                    <hr />
                    <div>
                        <table class="table table-bordered" style="justify-content:right;">
                            <tbody>
                                <tr>
                                    <td style="text-align: left;margin-left: 30px;">
                                        @if ($data['denomination']->online != 0)
                                            <p><strong>online</strong></p>
                                        @endif
                                        @if ($data['denomination']->n_2000 != 0)
                                            <p><strong>2000 * {{ $data['denomination']->n_2000 }}</strong></p>
                                        @endif
                                        @if ($data['denomination']->n_500 != 0)
                                            <p><strong>500 * {{ $data['denomination']->n_500 }}</strong></p>
                                        @endif
                                        @if ($data['denomination']->n_200 != 0)
                                            <p><strong>200 * {{ $data['denomination']->n_200 }}</strong></p>
                                        @endif
                                        @if ($data['denomination']->n_100 != 0)
                                            <p><strong>100 * {{ $data['denomination']->n_100 }}</strong></p>
                                        @endif
                                        @if ($data['denomination']->n_50 != 0)
                                            <p><strong>50 * {{ $data['denomination']->n_50 }}</strong></p>
                                        @endif
                                        @if ($data['denomination']->n_10 != 0)
                                            <p><strong>10 * {{ $data['denomination']->n_10 }}</strong></p>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data['denomination']->online != 0)
                                            <p><strong>{{ amountFormat($data['denomination']->online) }}</strong></p>
                                        @endif
                                        @if ($data['denomination']->n_2000 != 0)
                                            <p><strong>{{ amountFormat($data['denomination']->n_2000_value) }}/-</strong>
                                            </p>
                                        @endif
                                        @if ($data['denomination']->n_500 != 0)
                                            <p><strong>{{ amountFormat($data['denomination']->n_500_value) }}/-</strong>
                                            </p>
                                        @endif
                                        @if ($data['denomination']->n_200 != 0)
                                            <p><strong>{{ amountFormat($data['denomination']->n_200_value) }}/-</strong>
                                            </p>
                                        @endif
                                        @if ($data['denomination']->n_100 != 0)
                                            <p><strong>{{ amountFormat($data['denomination']->n_100_value) }}/-</strong>
                                            </p>
                                        @endif
                                        @if ($data['denomination']->n_50 != 0)
                                            <p><strong>{{ amountFormat($data['denomination']->n_50_value) }}/-</strong>
                                            </p>
                                        @endif
                                        @if ($data['denomination']->n_10 != 0)
                                            <p><strong>{{ amountFormat($data['denomination']->n_10_value) }}/-</strong>
                                            </p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;margin-left: 30px;">
                                        <h5><strong>Total </strong></h5>
                                    </td>
                                    <td class="text-left text-danger">
                                        <h4>
                                            <strong>
                                                @php
                                                    $totalDenomination =
                                                        $data['denomination']->online +
                                                        $data['denomination']->n_2000_value +
                                                        $data['denomination']->n_500_value +
                                                        $data['denomination']->n_200_value +
                                                        $data['denomination']->n_100_value +
                                                        $data['denomination']->n_50_value +
                                                        $data['denomination']->n_10_value;
                                                @endphp
                                                {{ amountFormat($totalDenomination) }}
                                            </strong>
                                        </h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if ($data['expenses']->count() > 0)
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h5>Expenses</h5>
                    </div>
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
                            @php
                                $sr = 1;$totalExpenses = 0;
                            @endphp
                            @foreach ($data['expenses'] as $value)
                                @php
                                    $totalExpenses = $totalExpenses + (int) $value['amount'];
                                @endphp
                                
                                <tr class="{{ $value['entry_type'] == 'penalty' ? bg - danger : '' }}">
                                    <td>{{ $sr++ }}</td>
                                    <td>{{ $value['reason'] }}</td>
                                    <td>{{ $value['amount_type'] }}</td>
                                    <td>{{ amountFormat($value['amount']) }}/-</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" style="text-align: right;">
                                    <h4><strong>Total </strong></h4>
                                </td>
                                <td class="text-left text-danger">
                                    <h4>
                                        <strong>
                                            <i class="fa fa-inr"></i>
                                            {{ amountFormat($totalExpenses) }}/-
                                        </strong>
                                    </h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
        
    </div>
@endsection
@push('customjs')
    <script>
        $('.collection_date').change(function(){
            getData();
        });
        $('.search_customer_name').input(function(){

        });

        function getData(){
            let date = $('.collection_date').val();
            let response = ajaxCall(`{{ route('agent.collection_report') }}?date=${date}`,'','','GET');
            response = JSON.parse(response);
            $('.report-data').html(response.data);
            console.log(response);
        }
        var $rows = $('#table tr');
        $('#search').keyup(function() {
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

            $rows.show().filter(function() {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();
        });
    </script>
@endpush
