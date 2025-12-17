<!doctype html>
<html lang="en" class="semi-dark">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{ asset('agent_panel/images/favicon.png') }}" type="image/png" />
	<!--plugins-->
	<link href="{{ asset('agent_panel/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
	<link href="{{ asset('agent_panel/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('agent_panel/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('agent_panel/plugins/notification/lobibox.min.css') }}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{ asset('agent_panel/css/pace.min.css') }}" rel="stylesheet" />
	<script data-pace-options='{ "ajax": false }' src="{{ asset('agent_panel/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('agent_panel/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('agent_panel/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{ asset('agent_panel/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('agent_panel/css/icons.css') }}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{ asset('agent_panel/css/semi-dark.css') }}" />
	<link rel="stylesheet" href="{{ asset('agent_panel/css/agent-panel.css') }}" />
	<title>DSA AGENT PANEL</title>
</head>
<body>
    <div class="wrapper">
        @include('agents.includes.sidebar')
        @include('agents.includes.agent_header')
		@php
			$segments = Request::segments();
		@endphp
        <div class="page-wrapper">
			<div class="page-content">
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Agents</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">{{ ucwords($segments[1]) }}</li>
							</ol>
						</nav>
					</div>
				</div>
                @yield('content')
            </div>
        </div>
        <!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button-->
		  <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © {{ date('Y') }}. All right reserved.</p>
		</footer>
    </div>
    <script src="{{ asset('agent_panel/js/bootstrap.bundle.min.js') }}"></script>
	<!--plugins-->
	<script src="{{ asset('agent_panel/js/jquery.min.js') }}"></script>
	<script src="{{ asset('agent_panel/plugins/simplebar/js/simplebar.min.js') }}"></script>
	<script src="{{ asset('agent_panel/plugins/metismenu/js/metisMenu.min.js') }}"></script>
	<script src="{{ asset('agent_panel/plugins/chartjs/js/Chart.min.js') }}"></script>
	<script src="{{ asset('agent_panel/js/index.js') }}"></script>
	<script src="{{ asset('agent_panel/js/app.js') }}"></script>
	<script src="{{ asset('agent_panel/plugins/notification/notification.min.js') }}"></script>
	<script src="{{ asset('agent_panel/plugins/notification/notification-custom-script.js') }}"></script>
	<script src="{{ asset('agent_panel/js/developer.js') }}"></script>
    <script>
        @if(Session::has('success'))  
            round_success_noti("{{ Session::get('success') }}");  
        @elseif (Session::has('warning'))
            round_warning_noti("{{ Session::get('warning') }}");  
        @elseif (Session::has('error'))
            round_error_noti("{{ Session::get('error') }}");  
        @endif  
    </script>
    @stack('customjs')
</body>

</html>
