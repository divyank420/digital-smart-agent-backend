@extends('layouts.agent')
@section('content')
<div class="row">
    <div class="col-xl-12 col-md-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="fm-search">
                    <div class="mb-0">
                        <div class="input-group input-group-lg"> <span class="input-group-text bg-transparent"><i class="bx bx-search"></i></span>
                            <input type="text" class="form-control search" placeholder="Search customer">
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Customer Name</th>
                                <th>Rm Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th title="Monthly Amount">M.A</th>
                                <th title="Installment Amount">I.A.</th>
                                <th>Last Modified</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="customer_list">
                            <tr class="text-center">
                                <td colspan="10"><img src="{{ asset('agent_panel/images/icons/loading.gif') }}" /> Loading ...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="pagination-div mt-2 mb-0">

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
        $(document).on('input', '.search', function() {
            clearInterval(timer);
            timer = setTimeout(() => {
                getData();
            }, 1000);
        });
    });

    function getData(url = '') {
        //$('.customer_list').html('<tr><td colspan="10"><img src="{{ asset('agent_panel/images/icons/loading.gif') }}" /></td></tr>');
        let response;
        let filter = `search=${$('.search').val()}`;
        if (!url) {
            response = ajaxCall(`{{ route('agent.getCustomersData') }}?${filter}`, '', '', 'GET');
        } else {
            response = ajaxCall(`${url}&${filter}`, '', '', 'GET');
        }
        response = JSON.parse(response);
        $('.customer_list').html(response.data.list);
        $('.pagination-div').html(response.data.pagination);

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