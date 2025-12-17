@extends('layouts.agent')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-title mb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="mb-0">Denomination of  ({{date('M d, Y',strtotime($denomination->denomination_date))}})</h4>
                    <a href="{{ route('agent.denomination') }}" class="btn btn-theme btn-sm"><i class="bx bx-plus"></i>All Denomination</a>
                </div>

            </div>
        </div>
    </div>
    <form action="{{ route('agent.edit_denomination', ['id' => $id]) }}" method="POST">
        @csrf

        <div class="col-xl-4 col-md-6 col-sm-12 col-12 m-auto">
            <div class="border denomination-form-outer-shadow border-3 p-4 rounded">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="inputPrice" class="form-label">Denomination Date</label>
                        <input type="date" class="form-control" name="denomination_date" onload="getDate()" placeholder="dd-mm-yyyy"
                            value="{{ $denomination->denomination_date }}">
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-1">
                            <span class="input-group-text">Online</span>
                            <input type="text" class="form-control text-center note_total text-right pr-3" name="online" onblur="calculateTotalAmount()" placeholder="Enter Online Amount" value="{{ $denomination->online }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-1">
                            <span class="input-group-text">500</span>
                            <span class="input-group-text">*</span>
                            <input type="text" class="form-control text-center note_count" data-key="500" name="n_500" placeholder="500 note" value="{{ $denomination->n_500}}">
                            <span class="input-group-text">=</span>
                            <input type="text" class="form-control text-center note_total" placeholder="500 Total" value="{{ $denomination->n_500*500 }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-1">
                            <span class="input-group-text">200</span>
                            <span class="input-group-text">*</span>
                            <input type="text" class="form-control text-center note_count" name="n_200" data-key="200" placeholder="200 note" value="{{ $denomination->n_200}}">
                            <span class="input-group-text">=</span>
                            <input type="text" class="form-control text-center note_total" placeholder="200 Total" value="{{ $denomination->n_200*200 }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-1">
                            <span class="input-group-text">100</span>
                            <span class="input-group-text">*</span>
                            <input type="text" class="form-control text-center note_count" name="n_100" data-key="100" placeholder="100 note" value="{{ $denomination->n_100}}">
                            <span class="input-group-text">=</span>
                            <input type="text" class="form-control text-center note_total" placeholder="100 Total" value="{{ $denomination->n_100*100 }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-1">
                            <span class="input-group-text">50</span>
                            <span class="input-group-text">*</span>
                            <input type="text" class="form-control text-center note_count" name="n_50" data-key="50" placeholder="50 note" value="{{ $denomination->n_50}}">
                            <span class="input-group-text">=</span>
                            <input type="text" class="form-control text-center note_total" placeholder="50 Total" value="{{ $denomination->n_50*50 }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-1">
                            <span class="input-group-text">20</span>
                            <span class="input-group-text">*</span>
                            <input type="text" class="form-control text-center note_count" name="n_20" data-key="20" placeholder="20 note" value="{{ $denomination->n_20}}">
                            <span class="input-group-text">=</span>
                            <input type="text" class="form-control text-center note_total" placeholder="20 Total" value="{{ $denomination->n_20*20 }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-1">
                            <span class="input-group-text">10</span>
                            <span class="input-group-text">*</span>
                            <input type="text" class="form-control text-center note_count" name="n_10" data-key="10" placeholder="10 note" value="{{ $denomination->n_10}}">
                            <span class="input-group-text">=</span>
                            <input type="text" class="form-control text-center note_total" placeholder="10 Total" value="{{ $denomination->n_10*10 }}">
                        </div>
                    </div>
                    <hr /> 
                    <div class="col-md-12 mt-0">
                        <div class="row">
                            <div class="col-md-6 col-sm-8 col-6"><b>Total</b></div>
                            <div class="col-md-6 col-sm-4 col-6 text-center grand_total">{{ $denomination->total }} /-</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-theme">Update</button>
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
                console.log(v.value);
                total += parseInt(v.value);
            });
            $('.grand_total').text(total);
        }
    </script>
@endpush
