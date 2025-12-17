@extends('layouts.agent')
@section('content')
    <div>
        @include('agents.includes.filters.denomination_filter')
        <div class="card">
            <div class="card-body">
                <hr class="mb-0"/>
                <div class="table-data">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Online</th>
                                    <th>500</th>
                                    <th>200</th>
                                    <th>100</th>
                                    <th>50</th>
                                    <th>20</th>
                                    <th>10</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($denomination->count() > 0)
                                    @foreach ($denomination as $value)
                                    @php
                                        $total = 0;
                                        $total += $value->online;
                                        $total += $value->n_2000*2000;
                                        $total += $value->n_500*500;
                                        $total += $value->n_200*200;
                                        $total += $value->n_100*100;
                                        $total += $value->n_50*50;
                                        $total += $value->n_20*20;
                                        $total += $value->n_10*10;
                                    @endphp
                                    <tr>
                                        <td>{{ date('d-M-Y',strtotime($value->denomination_date)) }}</td>
                                        <td>{{ $value->online }}</td>
                                        <td>{{ $value->n_500*500 }}</td>
                                        <td>{{ $value->n_200*200 }}</td>
                                        <td>{{ $value->n_100*100 }}</td>
                                        <td>{{ $value->n_50*50 }}</td>
                                        <td>{{ $value->n_20*20 }}</td>
                                        <td>{{ $value->n_10*10 }}</td>
                                        <td><b>{{ amountFormat($total) }}</b></td>
                                    </tr>        
                                    @endforeach
                                    
                                @else
                                    <tr class="text-center"><td colspan="10">No Record Found</td></tr>
                                @endif
                            </tbody>
                        </table>
                        @if($denomination->count() > 0)
                            {{ $denomination->links('agents.pagination.default') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('customjs')
<script>
    $(document).on('click','.member-item',function(){
        $('.member-item').removeClass('active');
        $(this).addClass('active');
        $('.agent_name').text($(this).text());
        getData();
    });
    function changeMonthYear(type =''){
        let month = $('.month option:selected').text();
        let year = $('.deno_year option:selected').text();
        $('#month_text').text(month);
        $('.year_text').text(year);
        getData();
    }
    const getData = (url = '') => {
        let filter = `agent=${$('.member-item.active').data('key')}&month=${$('.month').val()}&year=${$('.deno_year').val()}`;
        if(!url){
            response = ajaxCall(`{{ route('agent.denomination') }}?${filter}`,'','','GET');
        }else{
            response = ajaxCall(`${url}&${filter}`,'','','GET');
        }
        response = JSON.parse(response);
        console.log(response.data);
        $('.table-data').html(response.data);
        $('.pagination .page-link').each(function(e,v){
            $(this).attr('href-key',$(this).attr('href'));
            $(this).attr('href','javascript:void(0)');
        });
    }
    $(document).on('click','.page-link',function(){
        let href = $(this).attr('href-key');
        getData(href);
    })
</script>    
@endpush