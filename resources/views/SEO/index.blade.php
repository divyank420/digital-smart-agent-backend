@extends('layouts.seo')
@section('content')

    <div id="home" class="parallax first-section" data-stellar-background-ratio="0.4" style="background-image:url('{{ asset('SEO/uploads/parallax_12.jpg') }}');">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <div class="big-tagline">
                        <h2>Increase Your Ranking<br> on Search Engines</h2>
                        <p class="lead">Digital Smart Agent, with its excellent SEO services, turns your SEO goals into reality. We thoroughly understand your needs and create a powerful SEO plan. Our focus is on bringing in valuable leads to help you grow your business.!</p>
                        <a href="#support" class="btn btn-light btn-radius btn-brd ban-btn">Free SEO Analysis</a>
                    </div>
                </div>

                <div class="app_iphone_02 wow slideInUp hidden-xs hidden-sm" data-wow-duration="1s" data-wow-delay="0.5s">
                    <img src="{{ asset('SEO/uploads/cloud.png') }}" alt="" class="img-responsive">
                </div>
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->

    <svg id="clouds" class="hidden-xs" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 85 100" preserveAspectRatio="none">
        <path d="M-5 100 Q 0 20 5 100 Z
            M0 100 Q 5 0 10 100
            M5 100 Q 10 30 15 100
            M10 100 Q 15 10 20 100
            M15 100 Q 20 30 25 100
            M20 100 Q 25 -10 30 100
            M25 100 Q 30 10 35 100
            M30 100 Q 35 30 40 100
            M35 100 Q 40 10 45 100
            M40 100 Q 45 50 50 100
            M45 100 Q 50 20 55 100
            M50 100 Q 55 40 60 100
            M55 100 Q 60 60 65 100
            M60 100 Q 65 50 70 100
            M65 100 Q 70 20 75 100
            M70 100 Q 75 45 80 100
            M75 100 Q 80 30 85 100
            M80 100 Q 85 20 90 100
            M85 100 Q 90 50 95 100
            M90 100 Q 95 25 100 100
            M95 100 Q 100 15 105 100 Z">
        </path>
    </svg>

    <div id="about" class="section wb nopadtop">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="post-media wow fadeIn">
                        <img src="{{ asset('SEO/uploads/about_01.jpg') }}" alt="" class="img-responsive img-rounded">
                        <a href="http://www.youtube.com/watch?v=nrJtHemSPW4" data-rel="prettyPhoto[gal]" class="playbutton"><i class="flaticon-play-button"></i></a>
                    </div><!-- end media -->
                </div><!-- end col -->

                <div class="col-md-6 m40">
                    <div class="message-box">
                        <h4>Awards Winning SEO Company</h4>
                        <h2>We Are FlaxSeo</h2>
                        <p class="lead">Quisque eget nisl id nulla sagittis auctor quis id. Aliquam quis vehicula enim, non aliquam risus. Sed a tellus quis mi rhoncus dignissim.</p>

                        <div class="skills">
                            <div class="skills-wrapper">
                                <h3>Search Engine Optimization</h3>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success color6 wow slideInLeft" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%">
                                    </div>
                                </div>
                            </div><!-- end skills-wrapper -->

                            <div class="skills-wrapper">
                                <h3>Conversion Rate Optimization</h3>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success color2 wow slideInLeft" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                    </div>
                                </div>
                            </div><!-- end skills-wrapper -->

                            <div class="skills-wrapper">
                                <h3>Online Reputation Management</h3>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success color3 wow slideInLeft" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                    </div>
                                </div>
                            </div><!-- end skills-wrapper -->

                            <div class="skills-wrapper">
                                <h3>Google AdWords</h3>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success color5 wow slideInLeft" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                    </div>
                                </div>
                            </div><!-- end skills-wrapper -->
                        </div><!-- end skills -->
                    </div><!-- end messagebox -->
                </div><!-- end col -->
            </div><!-- end row -->
			
			<hr class="hr1">
			
			<div class="section-title text-center">
                <small>The Landigoo SEO Market</small>
                <h3>Who We Are</h3>
                <p class="lead">We offer unlimited solutions to all your business needs. in the installation package we prepare search engine optimization, social media support, we provide corporate identity and graphic design services.</p>
            </div><!-- end title -->
			
			<div class="seo-services row clearfix">
                <div class="col-md-3 col-sm-6 col-xs-12">
					<div class="who">
						<img src="{{ asset('SEO/images/seo-icons/growth.svg') }}" alt="icon" class="wow fadeInUp">
						<h4>Useful Dashboard</h4>
						<p class="lead">Falaningo Ipsum dolroin gravida nibh vel velit aliquet. Aenean lorem quis dashboard..</p>
					</div>
                </div><!-- end col -->

                <div class="col-md-3 col-sm-6 col-xs-12">
					<div class="who">
						<img src="{{ asset('SEO/images/seo-icons/research.svg') }}" alt="icon" class="wow fadeInUp">
						<h4>Research Optimization</h4>
						<p class="lead">Research Ipsum dolroin gravida nibh vel velit aliquet. Aenean lorem quis optimization..</p>
					</div>
                </div><!-- end col -->

                <div class="col-md-3 col-sm-6 col-xs-12">
					<div class="who">
						<img src="{{ asset('SEO/images/seo-icons/stopwatch.svg') }}" alt="icon" class="wow fadeInUp">
						<h4>Save Time + Money</h4>
						<p class="lead">Save Ipsum dolroin gravida nibh vel velit aliquet. Aenean sollicitudin lorem quis money..</p>
					</div>
                </div><!-- end col -->  

                <div class="col-md-3 col-sm-6 col-xs-12">
					<div class="who">
						<img src="{{ asset('SEO/images/seo-icons/development.svg') }}" alt="icon" class="wow fadeInUp">
						<h4>Ranking Monitoring</h4>
						<p class="lead">Monitoring Ipsum dolroin gravida nibh vel velit aliquet. Aenean sollicitudin ranking..</p>
					</div>
                </div><!-- end col -->  
            </div><!-- end how-its-work -->
        </div><!-- end container -->
    </div><!-- end section -->

    <section class="section nopad cac text-center">
        <a href="#"><h3>Interesting our awesome web design services? Just drop an email to us and get quote for free!</h3></a>
    </section>

    <div id="services" class="section lb">
        <div class="container">
            <div class="section-title text-center">
                <small>OnePage SEO - Validation - BACKLINKS</small>
                <h3>SEO Services</h3>
                <p class="lead">We offer unlimited solutions to all your business needs. in the installation package we prepare search engine optimization, social media support, we provide corporate identity and graphic design services.</p>
            </div><!-- end title -->
            <div class="row text-center">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="service-widget">
                        <div class="post-media wow fadeIn">
                            <img src="{{ asset('SEO/uploads/seo_01.png') }}" alt="" class="img-responsive img-rounded">
                        </div>
                        <h3>SEO Optimization</h3>
                        <p>Aliquam sagittis ligula et sem lacinia, ut facilisis enim sollicitudin. Proin nisi est, convallis nec purus vitae, iaculis posuere sapien. Cum sociis natoque.</p>
                    </div><!-- end service -->
                </div><!-- end col -->

                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="service-widget">
                        <div class="post-media wow fadeIn">
                            <img src="{{ asset('SEO/uploads/seo_02.png') }}" alt="" class="img-responsive img-rounded">
                        </div>
                        <h3>Backlink Management</h3>
                        <p>Duis at tellus at dui tincidunt scelerisque nec sed felis. Suspendisse id dolor sed leo rutrum euismod. Nullam vestibulum fermentum erat. It nam auctor. </p>
                    </div><!-- end service -->
                </div><!-- end col -->

                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="service-widget">
                        <div class="post-media wow fadeIn">
                            <img src="{{ asset('SEO/uploads/seo_03.png') }}" alt="" class="img-responsive img-rounded">
                        </div>
                        <h3>Pay Per Click</h3>
                        <p>Etiam materials ut mollis tellus, vel posuere nulla. Etiam sit amet lacus vitae massa sodales aliquam at eget quam. Integer ultricies et magna quis accumsan.</p>
                    </div><!-- end service -->
                </div><!-- end col -->
            </div><!-- end row -->

            <hr class="invis">

            <div class="row text-center">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="service-widget">
                        <div class="post-media wow fadeIn">
                            <img src="{{ asset('SEO/uploads/seo_04.png') }}" alt="" class="img-responsive img-rounded">
                        </div>
                        <h3>Dashboard Statics</h3>
                        <p>Aliquam sagittis ligula et sem lacinia, ut facilisis enim sollicitudin. Proin nisi est, convallis nec purus vitae, iaculis posuere sapien. Cum sociis natoque.</p>
                    </div><!-- end service -->
                </div><!-- end col -->

                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="service-widget">
                        <div class="post-media wow fadeIn">
                            <img src="{{ asset('SEO/uploads/seo_05.png') }}" alt="" class="img-responsive img-rounded">
                        </div>
                        <h3>Onepage SEO</h3>
                        <p>Duis at tellus at dui tincidunt scelerisque nec sed felis. Suspendisse id dolor sed leo rutrum euismod. Nullam vestibulum fermentum erat. It nam auctor. </p>
                    </div><!-- end service -->
                </div><!-- end col -->

                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="service-widget">
                        <div class="post-media wow fadeIn">
                            <img src="{{ asset('SEO/uploads/seo_06.png') }}" alt="" class="img-responsive img-rounded">
                        </div>
                        <h3>Black Hat SEO</h3>
                        <p>Etiam materials ut mollis tellus, vel posuere nulla. Etiam sit amet lacus vitae massa sodales aliquam at eget quam. Integer ultricies et magna quis accumsan.</p>
                    </div><!-- end service -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->

    <div class="parallax section lb">
        <div class="container">
            <div class="row text-center stat-wrap">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <span data-scroll class="global-radius icon_wrap effect-1"><i class="flaticon-briefcase"></i></span>
                    <p class="stat_count">1200</p>
                    <h3>Complated Projects</h3>
                </div><!-- end col -->

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <span data-scroll class="global-radius icon_wrap effect-1"><i class="flaticon-happy"></i></span>
                    <p class="stat_count">3210</p>
                    <h3>Happy Clients</h3>
                </div><!-- end col -->

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <span data-scroll class="global-radius icon_wrap effect-1"><i class="flaticon-idea"></i></span>
                    <p class="stat_count">3781</p>
                    <h3>Customer Services</h3>
                </div><!-- end col -->

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <span data-scroll class="global-radius icon_wrap effect-1"><i class="flaticon-customer-service"></i></span>
                    <p class="stat_count">4300</p>
                    <h3>Answered Questions</h3>
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->

    <div id="pricing" class="section pricing-bg">
        <div class="container">
            <div class="section-title text-center">
                <h3>Ready to get started?</h3>
                <p class="lead">Get the red carpet treatment just $39 per month! It is estimated that 3.5 million established by personal blogs.<br> From each other, we share paid WordPress themes WP Service...</p>
            </div><!-- end title -->

            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active fade in" id="tab1">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="pricing-table pricing-table-highlighted">
                                        <div class="pricing-table-header grd1">
                                            <h2>Free SEO Analysis</h2>
                                            <h3>$15/month</h3>
                                        </div>
                                        <div class="pricing-table-space"></div>
										<div class="pricing-table-text">
                                            <p>This is a perfect choice for small businesses and startups.</p>
                                        </div>
                                        <div class="pricing-table-features">
                                            <p><i class="fa fa-envelope-o"></i> <strong>250</strong> Email Addresses</p>
                                            <p><i class="fa fa-rocket"></i> <strong>125GB</strong> of Storage</p>
                                            <p><i class="fa fa-database"></i> <strong>140</strong> Databases</p>
                                            <p><i class="fa fa-link"></i> <strong>60</strong> Domains</p>
                                            <p><i class="fa fa-life-ring"></i> <strong>24/7 Unlimited</strong> Support</p>
                                        </div>
                                        <div class="pricing-table-sign-up">
                                            <a href="#" class="btn btn-light btn-radius btn-brd grd1 effect-1">Order Now</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="pricing-table pricing-table-highlighted">
                                        <div class="pricing-table-header grd1">
                                            <h2>4 Month SEO</h2>
                                            <h3>$59/One-Time</h3>
                                        </div>
                                        <div class="pricing-table-space"></div>
                                        <div class="pricing-table-text">
                                            <p>This is a perfect choice for small businesses and startups.</p>
                                        </div>
                                        <div class="pricing-table-features">
                                            <p><i class="fa fa-envelope-o"></i> <strong>150</strong> Email Addresses</p>
                                            <p><i class="fa fa-rocket"></i> <strong>65GB</strong> of Storage</p>
                                            <p><i class="fa fa-database"></i> <strong>60</strong> Databases</p>
                                            <p><i class="fa fa-link"></i> <strong>30</strong> Domains</p>
                                            <p><i class="fa fa-life-ring"></i> <strong>24/7 Unlimited</strong> Support</p>
                                        </div>
                                        <div class="pricing-table-sign-up">
                                            <a href="#" class="btn btn-light btn-radius btn-brd grd1 effect-1">Learn More</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="pricing-table pricing-table-highlighted">
                                        <div class="pricing-table-header grd1">
                                            <h2>Ultimate SEO</h2>
                                            <h3>$85/one-time</h3>
                                        </div>
                                        <div class="pricing-table-space"></div>
										<div class="pricing-table-text">
                                            <p>This is a perfect choice for small businesses and startups.</p>
                                        </div>
                                        <div class="pricing-table-features">
                                            <p><i class="fa fa-envelope-o"></i> <strong>250</strong> Email Addresses</p>
                                            <p><i class="fa fa-rocket"></i> <strong>125GB</strong> of Storage</p>
                                            <p><i class="fa fa-database"></i> <strong>140</strong> Databases</p>
                                            <p><i class="fa fa-link"></i> <strong>60</strong> Domains</p>
                                            <p><i class="fa fa-life-ring"></i> <strong>24/7 Unlimited</strong> Support</p>
                                        </div>
                                        <div class="pricing-table-sign-up">
                                            <a href="#" class="btn btn-light btn-radius btn-brd grd1 effect-1">Order Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end row -->
                        </div><!-- end pane -->
                    </div><!-- end content -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->

    <div id="testimonials" class="section wb">
        <div class="container">
            <div class="section-title text-center">
                <h3>Happy Clients</h3>
                <p class="lead">We thanks for all our awesome testimonials! There are hundreds of our happy customers! <br>Let's see what others say about Landigoo website template!</p>
            </div><!-- end title -->

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="testi-carousel owl-carousel owl-theme">
                        <div class="testimonial clearfix">
                            <div class="desc">
                                <h3><i class="fa fa-quote-left"></i> Wonderful Support!</h3>
                                <p class="lead">They have got my project on time with the competition with a sed highly skilled, and experienced & professional team.</p>
                            </div>
                            <div class="testi-meta">
                                <img src="{{ asset('SEO/uploads/testi_01.png') }}" alt="" class="img-responsive alignleft">
                                <h4>James Fernando <small>- Manager of Racer</small></h4>
                            </div>
                            <!-- end testi-meta -->
                        </div>
                        <!-- end testimonial -->

                        <div class="testimonial clearfix">
                            <div class="desc">
                                <h3><i class="fa fa-quote-left"></i> Awesome Services!</h3>
                                <p class="lead">Explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you completed.</p>
                            </div>
                            <div class="testi-meta">
                                <img src="{{ asset('SEO/uploads/testi_02.png') }}" alt="" class="img-responsive alignleft">
                                <h4>Jacques Philips <small>- Designer</small></h4>
                            </div>
                            <!-- end testi-meta -->
                        </div>
                        <!-- end testimonial -->

                        <div class="testimonial clearfix">
                            <div class="desc">
                                <h3><i class="fa fa-quote-left"></i> Great & Talented Team!</h3>
                                <p class="lead">The master-builder of human happines no one rejects, dislikes avoids pleasure itself, because it is very pursue pleasure. </p>
                            </div>
                            <div class="testi-meta">
                                <img src="{{ asset('SEO/uploads/testi_03.png') }}" alt="" class="img-responsive alignleft">
                                <h4>Venanda Mercy <small>- Newyork City</small></h4>
                            </div>
                            <!-- end testi-meta -->
                        </div>
                        <!-- end testimonial -->
                        <div class="testimonial clearfix">
                            <div class="desc">
                                <h3><i class="fa fa-quote-left"></i> Wonderful Support!</h3>
                                <p class="lead">They have got my project on time with the competition with a sed highly skilled, and experienced & professional team.</p>
                            </div>
                            <div class="testi-meta">
                                <img src="{{ asset('SEO/uploads/testi_01.png') }}" alt="" class="img-responsive alignleft">
                                <h4>James Fernando <small>- Manager of Racer</small></h4>
                            </div>
                            <!-- end testi-meta -->
                        </div>
                        <!-- end testimonial -->

                        <div class="testimonial clearfix">
                            <div class="desc">
                                <h3><i class="fa fa-quote-left"></i> Awesome Services!</h3>
                                <p class="lead">Explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you completed.</p>
                            </div>
                            <div class="testi-meta">
                                <img src="{{ asset('SEO/uploads/testi_02.png') }}" alt="" class="img-responsive alignleft">
                                <h4>Jacques Philips <small>- Designer</small></h4>
                            </div>
                            <!-- end testi-meta -->
                        </div>
                        <!-- end testimonial -->

                        <div class="testimonial clearfix">
                            <div class="desc">
                                <h3><i class="fa fa-quote-left"></i> Great & Talented Team!</h3>
                                <p class="lead">The master-builder of human happines no one rejects, dislikes avoids pleasure itself, because it is very pursue pleasure. </p>
                            </div>
                            <div class="testi-meta">
                                <img src="{{ asset('SEO/uploads/testi_03.png') }}" alt="" class="img-responsive alignleft">
                                <h4>Venanda Mercy <small>- Newyork City</small></h4>
                            </div>
                            <!-- end testi-meta -->
                        </div><!-- end testimonial -->
                    </div><!-- end carousel -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->

    <div id="support" class="section db">
        <div class="container">
            <div class="section-title text-center">
                <h3>Clients Logo</h3>
            </div><!-- end title -->

            <div class="row">
                <div id="logo-carousel" class="owl-carousel">
					<div> <img src="{{ asset('SEO/uploads/logo_01.png') }}" alt=""> </div>
					<div> <img src="{{ asset('SEO/uploads/logo_02.png') }}" alt=""> </div>
					<div> <img src="{{ asset('SEO/uploads/logo_03.png') }}" alt=""> </div>
					<div> <img src="{{ asset('SEO/uploads/logo_04.png') }}" alt=""> </div>
					<div> <img src="{{ asset('SEO/uploads/logo_05.png') }}" alt=""> </div>
					<div> <img src="{{ asset('SEO/uploads/logo_06.png') }}" alt=""> </div>
					<div> <img src="{{ asset('SEO/uploads/logo_01.png') }}" alt=""> </div>
					<div> <img src="{{ asset('SEO/uploads/logo_02.png') }}" alt=""> </div>
				</div>
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->

    <svg id="clouds1" class="hidden-xs" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 85 100" preserveAspectRatio="none">
        <path d="M-5 100 Q 0 20 5 100 Z
            M0 100 Q 5 0 10 100
            M5 100 Q 10 30 15 100
            M10 100 Q 15 10 20 100
            M15 100 Q 20 30 25 100
            M20 100 Q 25 -10 30 100
            M25 100 Q 30 10 35 100
            M30 100 Q 35 30 40 100
            M35 100 Q 40 10 45 100
            M40 100 Q 45 50 50 100
            M45 100 Q 50 20 55 100
            M50 100 Q 55 40 60 100
            M55 100 Q 60 60 65 100
            M60 100 Q 65 50 70 100
            M65 100 Q 70 20 75 100
            M70 100 Q 75 45 80 100
            M75 100 Q 80 30 85 100
            M80 100 Q 85 20 90 100
            M85 100 Q 90 50 95 100
            M90 100 Q 95 25 100 100
            M95 100 Q 100 15 105 100 Z">
        </path>
    </svg>
@endsection
