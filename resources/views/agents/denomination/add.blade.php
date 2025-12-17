@extends('layouts.agent')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-title mb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="mb-0">Add New Denomination</h4>
                    <a href="{{ route('agent.denomination') }}" class="btn btn-theme btn-sm"><i class="bx bx-plus"></i>All Denomination</a>
                </div>

            </div>
        </div>
    </div>
    <form action="{{ route('agent.new_denomination') }}" method="POST">
        @csrf

        <div class="col-xxl-5 col-md-6 col-sm-12 col-12 m-auto">
            <div class="border denomination-form-outer-shadow border-3 p-4 rounded">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="inputPrice" class="form-label">Denomination Date</label>
                        <input type="date" class="form-control" name="denomination_date" onload="getDate()" placeholder="dd-mm-yyyy"
                            value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-1">
                            <span class="input-group-text">Online</span>
                            <input type="text" class="form-control text-center note_total text-right pr-3" name="online" onblur="calculateTotalAmount()" placeholder="Enter Online Amount" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-1">
                            <span class="input-group-text">500</span>
                            <span class="input-group-text">*</span>
                            <input type="text" class="form-control text-center note_count" data-key="500" name="n_500" placeholder="500 note" value="">
                            <span class="input-group-text">=</span>
                            <input type="text" class="form-control text-center note_total" readonly placeholder="500 Total" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-1">
                            <span class="input-group-text">200</span>
                            <span class="input-group-text">*</span>
                            <input type="text" class="form-control text-center note_count" name="n_200" data-key="200" placeholder="200 note" value="">
                            <span class="input-group-text">=</span>
                            <input type="text" class="form-control text-center note_total" readonly placeholder="200 Total" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-1">
                            <span class="input-group-text">100</span>
                            <span class="input-group-text">*</span>
                            <input type="text" class="form-control text-center note_count" name="n_100" data-key="100" placeholder="100 note" value="">
                            <span class="input-group-text">=</span>
                            <input type="text" class="form-control text-center note_total" readonly placeholder="100 Total" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-1">
                            <span class="input-group-text">50</span>
                            <span class="input-group-text">*</span>
                            <input type="text" class="form-control text-center note_count" name="n_50" data-key="50" placeholder="50 note" value="">
                            <span class="input-group-text">=</span>
                            <input type="text" class="form-control text-center note_total" readonly placeholder="50 Total" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-1">
                            <span class="input-group-text">20</span>
                            <span class="input-group-text">*</span>
                            <input type="text" class="form-control text-center note_count" name="n_20" data-key="20" placeholder="20 note" value="">
                            <span class="input-group-text">=</span>
                            <input type="text" class="form-control text-center note_total" readonly placeholder="20 Total" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-1">
                            <span class="input-group-text">10</span>
                            <span class="input-group-text">*</span>
                            <input type="text" class="form-control text-center note_count" name="n_10" data-key="10" placeholder="10 note" value="">
                            <span class="input-group-text">=</span>
                            <input type="text" class="form-control text-center note_total" readonly placeholder="10 Total" value="">
                        </div>
                    </div>
                    <hr /> 
                    <div class="col-md-12 mt-0">
                        <div class="row">
                            <div class="col-md-6 col-sm-8 col-6"><b>Total</b></div>
                            <div class="col-md-6 col-sm-4 col-6 text-center"><b class="grand_total">0/-</b></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-theme">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('customjs')
    <script>
        $(document).on('input','.note_count',function(){
            let key = $(this).data('key');
            let total = $(this).val()*key;
            $(this).parents('.col-md-12').find('.note_total').val(total);
            calculateTotalAmount()
        });
        function calculateTotalAmount(){
            let total = 0;
            $('.note_total').each((e,v)=>{
                value = (v.value != '')?v.value:0;
                console.log(value);
                total += parseInt(value);
            });
            $('.grand_total').text(total);
        }
    </script>
@endpush
