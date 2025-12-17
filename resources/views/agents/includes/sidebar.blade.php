<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('agent_panel/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">DSA</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    @php
        $segments = Request::segments();
    @endphp
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li class="{{ $segments['1'] == 'dashboard'?'mm-active':'' }}">
            <a href="{{ route('agent.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li class="{{ $segments['1'] == 'customer'?'mm-active':'' }}">
            <a href="{{ route('agent.customers') }}">
                <div class="parent-icon"><i class="bx bx-group"></i>
                </div>
                <div class="menu-title">Customer's</div>
            </a>
        </li>
        <li class="{{ $segments['1'] == 'denomination'?'mm-active':'' }}"> 
            <a href="{{ route('agent.denomination') }}">
                <div class="parent-icon"><i class="bx bx-coin-stack"></i></div>
                <div class="menu-title">Denomination's</div>
            </a>
        </li>
        <li class="{{ $segments['1'] == 'entries'?'mm-active':'' }}">
            <a href="{{ route('agent.entries') }}">
                <div class="parent-icon"><i class="bx bx-tone"></i></div>
                <div class="menu-title">Entries</div>
            </a>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-repeat"></i>
                </div>
                <div class="menu-title">Reports</div>
            </a>
            <ul>
                <li><a href="{{ route('agent.collection_report') }}"><i class="bx bx-radio-circle"></i>Collection Report</a></li>
                <li> <a href="{{ route('agent.monthly_report') }}"><i class="bx bx-radio-circle"></i>Monthly Report</a></li>
                <li><a href="content-text-utilities.html"><i class="bx bx-radio-circle"></i>Text Utilities</a></li>
            </ul>
        </li>
    </ul>
</div>