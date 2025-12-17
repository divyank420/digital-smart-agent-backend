<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-4 col-xl-4">
                <h5 class="mb-0">Collection Entries  ({{date('M, Y')}})</h5>
            </div>
            <div class="col-lg-8 col-xl-8">
                <form class="float-lg-end">
                    <div class="row row-cols-lg-2 row-cols-xl-auto g-2">
                        <div class="col">
                            <div class="position-relative">
                                <input type="text" class="form-control ps-5  search" placeholder="Search Customer..."> <span class="position-absolute top-50 search-icon translate-middle-y"><i class="bx bx-search"></i></span>
                            </div>
                        </div>
                        @php
                            $members = session()->get('members');
                            if(is_null($members)){
                                $members = getAgentList(Auth::user());
                            }
                        @endphp
                        @if (count($members) > 0)
                            <div class="col">
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <button type="button" class="btn btn-white agent_name">All Agent</button>
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-white dropdown-toggle dropdown-toggle-nocaret px-1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-chevron-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <li><a class="dropdown-item member-item active" data-key = '' href="#">All Agent</a></li>
                                            @foreach ($members as $key => $member)
                                                <li><a class="dropdown-item member-item" data-key = '{{ $key }}' href="#">{{ $member }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col">
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <input type="date" class="form-control entry_date" value="{{date('Y-m-d')  }}">
                              </div>
                        </div>
                        <div class="col">
                            <select class="form-select amount_type">
                                <option value="">All</option>
                                <option value="cash">Cash</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>