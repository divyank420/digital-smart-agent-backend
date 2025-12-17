<!DOCTYPE html>
<html lang="en">

    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
   
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
 
     <!-- Site Metas -->
    <title>Digital Smart Agent</title>  
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta property="og:title" content="Digital Smart Agent">
    <meta property="og:description" content="The Digital Smart Agent is an innovative platform designed to streamline and optimize various aspects of your daily collection transactions, customer management, Monthly Posting Reports.">
    <meta property="og:image" content="{{ asset('SEO/images/favicon.png') }}">
    <meta property="og:url" content="https://www.digitalsmartagent.com">
    <meta property="og:type" content="website">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="{{ asset('SEO/images/favicon.png') }}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{ asset('SEO/images/favicon.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('SEO/css/bootstrap.min.css') }}">
    <!-- Site CSS -->
    <link rel="stylesheet" href="{{ asset('SEO/css/style.css') }}">
    <!-- Colors CSS -->
    <link rel="stylesheet" href="{{ asset('SEO/css/colors.css') }}">
    <!-- ALL VERSION CSS -->
    <link rel="stylesheet" href="{{ asset('SEO/css/versions.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('SEO/css/responsive.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('SEO/css/custom.css') }}">
    <style>
        .btn-theme {
            background: #001d41;
            color:#fff;
        }
        .mt-3{
            margin-top:25px;
        }
        .navbar-default .navbar-toggle{
            background-color: #001d41;
            border-color: #001d41;
        }
    </style>
</head>
<body class="seo_version">
    <!-- LOADER -->
	<div id="preloader">
		<div id="cupcake" class="box">
			<span class="letter">L</span>
			<div class="cupcakeCircle box">
				<div class="cupcakeInner box">
					<div class="cupcakeCore box"></div>
				</div>
			</div>
			<span class="letter box">A</span>
			<span class="letter box">D</span>
			<span class="letter box">I</span>
			<span class="letter box">N</span>
			<span class="letter box">G</span>
		</div>
	</div>
    <header class="header header_style_01">
        <nav class="megamenu navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="d-flex">
                        <a href="{{ route('agent.login') }}" target="_blank" class="btn btn-theme hidden-lg mt-3" style="margin-top:25px"><i class="fa fa-user-secret"></i> Agent Portal</a>
                        <a class="navbar-brand mt-3" href="index.html"><img src="{{ asset('SEO/images/logo-icon.png') }}" class="header-logo" alt="image" style="height: 30px;width:50px"></a>
                    </div>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right hidden-md hidden-sm hidden-xs">
                        <li><a class="btn-light btn-radius btn-brd top-btn" href="{{ route('agent.login') }}"><i class="fa fa-angle-double-right"></i>Agent Portal</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right menu-top">
                        <li><a class="active" href="index.html">Home</a></li>
                        <li><a href="about.html">About Us </a></li>
                        <li><a href="services.html">Services</a></li>
                        <li><a href="case-study.html">Case Study</a></li>
                        <li><a href="pricing.html">Pricing</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    @yield('content')
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="widget clearfix">
                        <div class="widget-title">
                            <img src="{{ asset('images/logo.png') }}" alt="" height="80">
                        </div>
                        <p> SEO Mauris pharetra quam ut commodo malesuada. Sed a ornare purus, nec cursus tortor. Integer vehicula felis nec nunc pulvinar efficitur. In et semper odio. Sed laoreet ullamcorper augue, ut mattis metus mattis quis.</p>
                        <p>Sed fermentum est vitae rhoncus molestie. Cum sociis natoque penatibus et magnis dis montes.</p>
                    </div><!-- end clearfix -->
                </div><!-- end col -->

                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="widget clearfix">
                        <div class="widget-title">
                            <h3>Contact Details</h3>
                        </div>

                        <ul class="footer-links">
                            <li><a href="mailto:#">info@yoursite.com</a></li>
                            <li><a href="#">www.yoursite.com</a></li>
                            <li>PO Box 16122 Collins Street West Victoria 8007 Australia</li>
                            <li>+61 3 8376 6284</li>
                        </ul><!-- end links -->
                    </div><!-- end clearfix -->
                </div><!-- end col -->

                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="widget clearfix">
                        <div class="widget-title">
                            <h3>Information</h3>
                        </div>

                        <ul class="footer-links">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Pricing</a></li>
							<li><a href="#">About</a></li>
							<li><a href="#">Faq</a></li>
							<li><a href="#">Contact</a></li>
                        </ul><!-- end links -->
                    </div><!-- end clearfix -->
                </div><!-- end col -->

                <div class="col-md-2 col-sm-2 col-xs-12">
                    <div class="widget clearfix">
                        <div class="widget-title">
                            <h3>Social</h3>
                        </div>
                        <ul class="footer-links social-md">
                            <li><a class="fb" href="#"><i class="fa fa-facebook"></i> Facebook</a></li>
                            <li><a class="gi" href="#"><i class="fa fa-github"></i> Github</a></li>
                            <li><a class="tw" href="#"><i class="fa fa-twitter"></i> Twitter</a></li>
                            <li><a class="dr" href="#"><i class="fa fa-dribbble"></i> Dribbble</a></li>
                            <li><a class="pi" href="#"><i class="fa fa-pinterest"></i> Pinterest</a></li>
                        </ul><!-- end links -->
                    </div><!-- end clearfix -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </footer><!-- end footer -->
	
    <div class="copyrights">
        <div class="container">
            <div class="footer-distributed">
                <div class="footer-left">
                    <p class="footer-company-name">All Rights Reserved. &copy; {{ date('Y') }} Design By <a href="https://html.design/">html design</a> Distributed By <a href="https://themewagon.com/">ThemeWagon</a></p>
                </div>

                <div class="footer-right">
                    <form method="get" action="#">
                        <input placeholder="Subscribe our newsletter.." name="search">
                        <i class="fa fa-envelope-o"></i>
                    </form>
                </div>
            </div>
        </div><!-- end container -->
    </div><!-- end copyrights -->

    <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

    <!-- ALL JS FILES -->
    <script src="{{ asset('SEO/js/all.js') }}"></script>
    <!-- ALL PLUGINS -->
    <script src="{{ asset('SEO/js/custom.js') }}"></script>

</body>
</html>