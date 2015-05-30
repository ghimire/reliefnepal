
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>
        @section('title')
            Nepal Relief Efforts
        @show
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="author" content="Prak">
    <meta name="copyright" content="Nepal United" />
    <meta name="application-name" content="Nepal United" />
    <meta name="keywords" content="Nepal, Earthquake Nepal, Relief Effort in Nepal">

    <meta name="_token" content="{{ csrf_token() }}"/>

    @section('meta-social')
        <meta name="description" content="Nepal United is a central repository of organizations and their relief efforts in Nepal.">
    @show

    @section('head')
        <link href="{{ asset('/libs/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/libs/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/libs/bower_components/animate.css/animate.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/libs/bower_components/bootstrap-material-design/dist/css/ripples.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/libs/bower_components/bootstrap-material-design/dist/css/material.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/css/grid.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="{{ asset('/libs/bower_components/html5shiv/dist/html5shiv.js') }}"></script>
        <![endif]-->
    @show
</head>

<body class="layout-top-nav">
@include('layouts.analyticstracking')
<div class="wrapper">

    <header class="main-header" style="max-height: none">
        <nav class="navbar navbar-static-top" style="
                background-image: url('{{ asset('/img/navbg/bg2.jpg') }}');
                background-size: cover; background-color: #6792b4;
                height: 300px;
                vertical-align: middle;
                margin-bottom: 0;"
                >
            <div class="container-fluid">
                <div class="navbar-header" style="float: none">
                    <div class="text-center">
                        <img src="{{ asset('/img/packers_city.png') }}" class="img-responsive text-center" style="display: inline; margin: 10px 0 0 0">
                        <span class="navbar-brand">
                            {{--<b>Packers City</b>--}}
                        </span>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="text-left col-md-6">
                    <ul class="nav nav-pills">
                        <li class="active"><a href="/"><i class="fa fa-home"></i> Home</a></li>
                        <li><a href="/">About</a></li>
                        <li><a href="/">Contact</a></li>
                        <li style="margin-top: 8px;">
                            <div class="fb-like" data-href="http://packerscity.com" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
                        </li>
                    </ul>
                </div>
            </div><!-- /.container-fluid -->
        </nav>

        <a name="info"></a>
        <nav style="background-color: #33B5E5; min-height: 50px;">
            @section('nav')
                <div class="text-center" style="padding-top: 8px;">
                    <span style='font-size: 1.5em; color: #fff; font-weight: bolder; font-family: Monaco, "Lucida Console", monospace'>
                        Call us at <span class="shadow-z-2" style="font-family: 'Courier New', Monospace; border-radius: 5px; background-color: #008080; color: #fff; padding: 5px;">+91-1234567890</span> to get competitive price for your next relocation
                    </span>
                </div>
            @show
        </nav>
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper">
        <div class="container-fluid">
            @yield('content')
        </div><!-- /.container -->
    </div><!-- /.content-wrapper -->

    <footer class="main-footer">
        @section('footer')
        <div class="container shadow-z-2" style="margin: 0; padding-top: 10px; background-color: #f5f5f5; width: 100%">
                <p class="text-center">
                    <strong>Copyright &copy; 2015 <a href="#">Packers City</a>.</strong> All rights reserved.
                </p>
        </div><!-- /.container -->
        @show
    </footer>
</div><!-- ./wrapper -->


@section('scripts')
<script src="{{ asset('/libs/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('/libs/bower_components/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/libs/bower_components/bootstrap-material-design/dist/js/ripples.min.js') }}"></script>
<script src="{{ asset('/libs/bower_components/bootstrap-material-design/dist/js/material.min.js') }}"></script>

<script src="{{ asset('/libs/bower_components/admin-lte/plugins/slimScroll/jquery.slimScroll.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/libs/bower_components/admin-lte/plugins/fastclick/fastclick.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>

<script>
        $(document).ready(function(){
            $.material.init();

            $.ajaxSetup({
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });

            $('button.js-btn-quote').click(function(evt) {
                evt.preventDefault();
                var form = $('#quote-form');
                form.find("button[type='submit']").attr('disabled','disabled');
                form.find("button[type='submit']").val('Processing...');

                var result = form.closest('.panel');
                result.html('');

                var url = form.attr('action');
                var method = form.attr('method');
                var data = form.serialize();
                $.ajax({
                    type: method,
                    url: url,
                    data: data,
                    success: function(response)
                    {
                        form.remove();
                        result.html('<div class="alert alert-success" style="color: #fff;">' + response + '</div>');
                    },
                    error: function(){
                        form.find("button[type='submit']").removeAttr('disabled');
                        result.html('<div class="alert alert-danger" style="color: #fff;">Please check your input and try again.</div>');
                    }
                });

                return false;
            });

            // Facebook Initialization
            window.fbAsyncInit = function() {
                FB.init({
                    appId      : '816039715145733',
                    xfbml      : true,
                    version    : 'v2.3'
                });
            };

            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            // End of Facebook Initialization
        });
</script>
@show

</body>
</html>