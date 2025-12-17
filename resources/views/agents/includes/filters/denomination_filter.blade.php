<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-4 col-xl-3 col-md-5 col-sm-12">
                <h5>Denomination of (<span id="month_text">{{date('F')}}</span>, <span class="year_text">{{date('Y')}}</span>)</h5>
            </div>
            <div class="col-lg-8 col-xl-9 col-md-7 col-sm-12">
                <form class="float-lg-end">
                    <div class="row row-cols-lg-2 row-cols-xl-auto g-2">
                        @php
                        $members = session()->get('members');
                        if(is_null($members)){
                            $members = getAgentList(Auth::user());
                        }
                        @endphp
                        @if (count($members) > 0)
                        <div class="col-auto">
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <button type="button" class="btn btn-white agent_name">All Agent</button>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-white dropdown-toggle dropdown-toggle-nocaret px-1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <li><a class="dropdown-item member-item active" data-key='' href="#">All Agent</a></li>
                                        @foreach ($members as $key => $member)
                                        <li><a class="dropdown-item member-item" data-key='{{ $key }}' href="#">{{ $member }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col">
                            <div class="btn-group" role="group">
                                <select class="form-select month" onchange="changeMonthYear()">
                                    @for($m=1; $m<=12; $m++)
                                        <option value="{{ $m }}" {{ $m == date('m')?'selected':'' }}>{{ date('F', mktime(0,0,0,$m, 1, date('Y'))) }}</option>
                                        @endfor
                                </select>
                                <select class="form-select deno_year" onchange="changeMonthYear()">
                                    @for ($i = date('Y');$i >= 2022;$i--)
                                    <option value="{{ $i }}" {{ $i == date('Y')?'selected':'' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="btn-group" role="group">
                                <a href="{{ route('agent.new_denomination') }}" class="btn btn-theme"><i class="bx bx-plus"></i>New Denomination</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>