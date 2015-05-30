<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nepal United || Earthquake Relief Efforts</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="{{ asset('/libs/vendor/admin-lte/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/libs/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/libs/vendor/admin-lte/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/libs/vendor/admin-lte/plugins/iCheck/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/libs/vendor/animate.css/animate.min.css') }}" rel="stylesheet" type="text/css" />

    <!--[if lt IE 9]>
    <script src="{{ asset('/libs/vendor/html5shiv/dist/html5shiv.min.js') }}"></script>
    <script src="{{ asset('/libs/vendor/respond/dest/respond.min.js') }}"></script>
    <![endif]-->

    <style>
        .login-page {
            background: #feffe8;
            background: -moz-linear-gradient(-45deg,  #feffe8 0%, #d6dbbf 100%);
            background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#feffe8), color-stop(100%,#d6dbbf));
            background: -webkit-linear-gradient(-45deg,  #feffe8 0%,#d6dbbf 100%);
            background: -o-linear-gradient(-45deg,  #feffe8 0%,#d6dbbf 100%);
            background: -ms-linear-gradient(-45deg,  #feffe8 0%,#d6dbbf 100%);
            background: linear-gradient(135deg,  #feffe8 0%,#d6dbbf 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#feffe8', endColorstr='#d6dbbf',GradientType=1 );
        }

        img.bg {
            /* Set rules to fill background */
            min-height: 100%;
            min-width: 1024px;

            /* Set up proportionate scaling */
            width: 100%;
            height: auto;

            /* Set up positioning */
            position: fixed;
            top: 0;
            left: 0;
        }

        @media screen and (max-width: 1024px) { /* Specific to this particular image */
            img.bg {
                left: 50%;
                margin-left: -512px;   /* 50% */
            }
        }
    </style>
</head>
<body class="login-page">

<img id="main-bg" class="bg">

<div class="login-box box box-default" style="display: none">
    <div class="login-logo box-header">
        <a href="../../index2.html"><b>Nepal United</b> - Login</a>
    </div><!-- /.login-logo -->
    <div class="login-box-body box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> <strong>Whoops!</strong> There were some problems with your input.</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form role="form" method="POST" action="{{ url('/auth/login') }}" autocomplete="off">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group has-feedback">
                <input type="text" class="form-control input-lg" placeholder="Email" name="email" autofocus=""/>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control input-lg" placeholder="Password" name="password"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember" checked="checked" aria-checked="true"> Remember Me
                        </label>
                    </div>
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div><!-- /.col -->
            </div>
        </form>

        <!--
        <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a> -->

    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

<!-- jQuery 2.1.3 -->
<script src="{{ asset('/libs/vendor/admin-lte/plugins/jQuery/jQuery-2.1.3.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('/libs/vendor/admin-lte/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- iCheck -->
<script src="{{ asset('/libs/vendor/admin-lte/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });

    $(document).ready(function(){
        // Animate and Display Login Modal
        var animations = ["bounce", "flash", "pulse", "rubberBand", "shake", "swing", "tada", "wobble", "bounceIn", "bounceInDown", "bounceInLeft", "bounceInRight", "bounceInUp", "fadeIn", "fadeInDown", "fadeInDownBig", "fadeInLeft", "fadeInLeftBig", "fadeInRight", "fadeInRightBig", "fadeInUp", "fadeInUpBig", "flipInX", "flipInY", "lightSpeedIn", "rotateIn", "rotateInDownLeft", "rotateInDownRight", "rotateInUpLeft", "rotateInUpRight", "rollIn", "zoomIn", "zoomInDown", "zoomInLeft", "zoomInRight", "zoomInUp", "slideInDown", "slideInLeft", "slideInRight", "slideInUp"];
        var animation = animations[Math.floor(Math.random()*animations.length)];
        $(".login-box").show().addClass("animated " + animation);

        var backgrounds = ['bg1.jpg', 'bg2.jpg', 'bg3.jpg', 'bg4.jpg'];
        var background = backgrounds[Math.floor(Math.random()*backgrounds.length)];
        $('#main-bg').attr('src', "{{ asset('/img') }}/" + background);
        $('#main-bg').addClass("animated fadeIn");
    });
</script>
</body>
</html>