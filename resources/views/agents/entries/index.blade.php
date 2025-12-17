@extends('layouts.agent')
@section('title', 'Today\'s Collection')
@section('content')

<div class="py-8 flex oskasdadiaa rounded-xl bg-white dark:bg-gray-900">
    @include('agents.includes.filters.entries_filter')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg entries-data">
        <div class="table-data">
            <!-- <table id="datatable" style="text-align: left;" class="table table-hover table-bordered table-nowrap table-align-middle card-table"> -->
            <table class="table-sorter w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-2">SR#</th>
                        <th class="px-6 py-2">Customer Name</th>
                        <th class="px-6 py-2">Taken BY</th>
                        <th class="px-6 py-2">Amount</th>
                        <th class="px-6 py-2">Recevied Time</th>
                        <th class="px-6 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($entries->count() > 0)
                    @foreach ($entries as $entry)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $entry->RmDetail->name ?? '' }}</td>
                        <td>{{ $entry->agent->username }}</td>
                        <td>{{ $entry->amount }}</td>
                        <td>{{ date('M d, Y',strtotime($entry->entry_date)) }} {{ date('h:i A',strtotime($entry->created_at)) }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="text-center">
                        <td colspan="10">No Entries Found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @if($entries->count() > 0)
        {{ $entries->links('agents.pagination.default') }}
        @endif
    </div>
</div>
<div class="col-md-4">
    <div class="card">
        <div class="card-body">
            <div class="customers-list p-3 mb-3 ps ps--active-y">
                @foreach ($entries as $entry)
                <div class="customers-list-item d-flex align-items-center border-bottom p-2 cursor-pointer">
                    <div class="ms-2">
                        <h6 class="mb-1 font-14">{{ $entry->RmDetail->name ?? '' }}</h6>
                        <p class="mb-0 font-13 text-secondary">{{ date('M d, Y',strtotime($entry->entry_date)) }} {{ date('h:i A',strtotime($entry->created_at)) }}</p>
                    </div>
                    <div>
                        <span>{{ amountFormat($entry->amount) }}</span>
                    </div>
                    <div class="list-inline d-flex customers-contacts ms-auto"> <a href="javascript:;" class="list-inline-item"><i class="bx bxs-envelope"></i></a>
                        <a href="javascript:;" class="list-inline-item"><i class="bx bxs-microphone"></i></a>
                        <a href="javascript:;" class="list-inline-item"><i class="bx bx-dots-vertical-rounded"></i></a>
                    </div>
                </div>
                @endforeach
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                </div>
                <div class="ps__rail-y" style="top: 0px; height: 450px; right: 0px;">
                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 305px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('customjs')
<script>
    var timer;
    $(document).ready(function() {
        getData();
    });
    $(document).on('input', '.search', function() {
        clearInterval(timer);
        timer = setTimeout(() => {
            getData();
        }, 1000);
    });
    $(document).on('click', '.member-item', function() {
        $('.member-item').removeClass('active');
        $(this).addClass('active');
        $('.agent_name').text($(this).text());
        getData();
    });
    $(document).on('change', '.amount_type', function() {
        getData();
    });
    $(document).on('change', '.entry_date', function() {
        $('.amount_type').val('');
        getData();
    });

    function getData(url = '') {
        //$('.customer_list').html('<tr><td colspan="10"><img src="{{ asset('agent_panel/images/icons/loading.gif') }}" /></td></tr>');
        let filter = `search=${$('.search').val()}&date=${$('.entry_date').val()}&agent=${$('.member-item.active').data('key')}&amount_type=${$('.amount_type').val()}`;
        let response;
        if (!url) {
            response = ajaxCall(`{{ route('agent.entries') }}?${filter}`, '', '', 'GET');
        } else {
            response = ajaxCall(`${url}&${filter}`, '', '', 'GET');
        }
        response = JSON.parse(response);
        $('.entries-data').html(response.data);
        $('.pagination .page-link').each(function(e, v) {
            $(this).attr('href-key', $(this).attr('href'));
            $(this).attr('href', 'javascript:void(0)');

        });
    }
    $(document).on('click', '.page-link', function() {
        let href = $(this).attr('href-key');
        getData(href);
    })
    //$(document).ajaxStart(function() { alert('sd'); Pace.start(); });
</script>
@endpush