<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{ asset('agent_panel/images/favicon.png') }}" type="image/png" />
	<!--plugins-->
	<link href="{{ asset('agent_panel/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('agent_panel/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('agent_panel/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('agent_panel/plugins/notification/lobibox.min.css') }}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{ asset('agent_panel/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('agent_panel/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('agent_panel/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('agent_panel/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{ asset('agent_panel/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('agent_panel/css/icons.css') }}" rel="stylesheet">
	<title>Agent Portal</title>
</head>

<body class="bg-login">
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('agent_panel/js/bootstrap.bundle.min.js') }}"></script>
	<!--plugins-->
	<script src="{{ asset('agent_panel/js/jquery.min.js') }}"></script>
	<script src="{{ asset('agent_panel/plugins/simplebar/js/simplebar.min.js') }}"></script>
	<script src="{{ asset('agent_panel/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('agent_panel/plugins/notification/notification.min.js') }}"></script>
	<script src="{{ asset('agent_panel/plugins/notification/notification-custom-script.js') }}"></script>
    <script>
        @if(Session::has('success'))  
            round_error_noti("{{ Session::get('success') }}");  
        @endif  
        @if(Session::has('warning'))  
            round_warning_noti("{{ Session::get('warning') }}");  
        @endif  
        @if(Session::has('error'))  
            round_error_noti("{{ Session::get('error') }}");  
        @endif  
    </script>
</body>

</html>
