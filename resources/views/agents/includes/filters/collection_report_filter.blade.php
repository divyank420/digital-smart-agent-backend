<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-12 col-xl-12">
                <form class="float-lg-end">
                    <div class="row row-cols-lg-2 row-cols-xl-auto g-2">
                        <div class="col-auto">
                          <input type="date" class="form-control collection_date" value="{{ date('Y-m-d') }}"/>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group" role="group">
                                <a href="{{ route('api.collection_pdf_report').'?company_id='.auth()->user()->company_id.'&date='.date('Y-m-d') }}" data-url="{{ route('api.collection_pdf_report').'?company_id='.auth()->user()->company_id }}" target="_blank" class="btn btn-theme"><i class="bx bx-download"></i>Download Report</a>
                              </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>