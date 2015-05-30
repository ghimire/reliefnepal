<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>Nepal Relief Efforts</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="_token" content="{{ csrf_token() }}"/>

    @section('head')
        <link href="{{ asset('/libs/bower_components/admin-lte/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/libs/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/libs/bower_components/ionicons/css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
        {{--<link href="{{ asset('/libs/bower_components/admin-lte/plugins/iCheck/flat/blue.css') }}" rel="stylesheet" type="text/css" />--}}
        <link href="{{ asset('/libs/bower_components/animate.css/animate.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/libs/bower_components/admin-lte/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/libs/bower_components/admin-lte/dist/css/skins/skin-green.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/css/custom-skin.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/auth.css') }}" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="{{ asset('/libs/bower_components/html5shiv/dist/html5shiv.js') }}"></script>
        <![endif]-->
    @show
</head>

<body class="skin skin-green">
<div data-container="wrapper" class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="#" class="logo"><b>Nepal United</b></a>

        <!-- Header Navbar -->
        @include('layouts.topnav')
    </header>

    <div class="main-wrapper">
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            @include('layouts.sidebar')
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div data-container="page" class="content-wrapper box box-default">
            @yield('content')
        </div><!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer" style="">
            <!-- To the right -->
            <div class="pull-right hidden-xs text-muted">
                {{ Inspiring::quote() }}
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2015 <a href="#">Nepal United</a>.</strong> All rights reserved.
        </footer>
    </div>

</div><!-- ./wrapper -->

@section('scripts')
    <script src="{{ asset('/libs/bower_components/modernizr/modernizr.js') }}" type="text/javascript"></script>
    <script>
        var GLOBAL = {
            'user': {
              "id": "{{ $user->id }}",
              "is_admin": "{{ $user->is_admin() }}" === "1",
              "roles": "{{ $user->roles }}"
            },
            'STATIC_URL': "{{ asset('/') }}",
            'DEFAULT_AVATAR': "{{ asset('/img/avatars/user-160x160.jpg') }}",
            'DEFAULT_ORGANIZATION': "{{ asset('/img/profiles/organization-500x250.png') }}"
        };

        var require = {
            baseUrl: GLOBAL.STATIC_URL,
            waitSeconds: 60,
            paths: {
                'async': 'libs/vendor/require-plugins/async.min',
                'backbone': 'libs/bower_components/backbone/backbone',
                'backbone.validateAll': 'libs/bower_components/Backbone.validateAll/src/javascripts/Backbone.validateAll.min',
                'backbone.validation': 'libs/bower_components/backbone.validation/dist/backbone-validation-min',
                'marionette': 'libs/bower_components/marionette/lib/backbone.marionette.min',
                'marionette.showanimated': 'libs/vendor/marionette.showanimated/marionette.showanimated',
                'tweenmax': 'libs/vendor/tweenmax/tweenmax.min',

                'bootstrap': 'libs/bower_components/admin-lte/bootstrap/js/bootstrap.min',
                'bootstrap.datatables': 'libs/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap',
                'bootstrap.daterangepicker': 'libs/bower_components/admin-lte/plugins/daterangepicker/daterangepicker',
                'bootstrap.datepicker': 'libs/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min',
                'bootstrap.timepicker': 'libs/bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.min',
                'bootstrap.select2': 'libs/bower_components/select2/select2.min',
                'bootstrap.slider': 'libs/bower_components/admin-lte/plugins/bootstrap-slider/bootstrap-slider',
                'bootstrap.switch': 'libs/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min',
                'image.uploader': 'libs/vendor/image-uploader/image-uploader',

                'jquery': 'libs/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.3.min',
                'jquery.ui': 'libs/bower_components/admin-lte/plugins/jQueryUI/jquery-ui-1.10.3.min',
                'jquery.datatables': 'libs/bower_components/admin-lte/plugins/datatables/jquery.dataTables',
                'jquery.inputmask': 'libs/bower_components/admin-lte/plugins/input-mask/jquery.inputmask',
                'jquery.slimscroll': 'libs/bower_components/admin-lte/plugins/slimScroll/jquery.slimscroll.min',
                'jquery.serializejson': 'libs/bower_components/jquery.serializeJSON/jquery.serializejson.min',
                'jquery.geocomplete': 'libs/vendor/geocomplete/jquery.geocomplete',

                'require-text': 'libs/bower_components/requirejs-text/text',
                'require-css': 'libs/bower_components/require-css/css.min',

                'underscore': 'libs/bower_components/underscore/underscore-min',

                'moment': 'libs/bower_components/moment/min/moment.min',
                'modernizr': 'libs/bower_components/modernizr/modernizr',
                'fastclick': 'libs/bower_components/admin-lte/plugins/fastclick/fastclick.min',
                'fullcalendar': 'libs/bower_components/admin-lte/plugins/fullcalendar/fullcalendar.min',
                'icheck': 'libs/bower_components/admin-lte/plugins/iCheck/icheck.min',
                'ionslider': 'libs/bower_components/admin-lte/plugins/ionslider/ion.rangeSlider.min',
                'imagesloaded': 'libs/bower_components/imagesloaded/imagesloaded.pkgd.min',
                'md5': 'libs/vendor/md5/md5.min',

                'adminlte': 'libs/bower_components/admin-lte/dist/js/app',
                'base.app': 'js/app'
            },

            shim: {
                'jquery': { exports: '$' },
                'jquery.ui': ['jquery'],
                'jquery.datatables': ['jquery'],
                'jquery.slimscroll': ['jquery'],
                'jquery.inputmask': ['jquery'],
                'jquery.serializejson': ['jquery'],
                'jquery.geocomplete': ['jquery', 'async!' + 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDU-EQOZG4zq1Jok07JiD721xC_vCRwCGM&libraries=geometry,places,drawing&sensor=false&v=3'],

                'backbone': { deps: ['underscore', 'jquery'], exports: 'Backbone' },
                'marionette': ['backbone'],
                'marionette.showanimated': ['tweenmax', 'marionette'],
                'tweenmax': ['jquery'],
                'backbone-poller': ['backbone'],
                'backbone.validateAll': ['backbone'],
                'backbone.validation': ['backbone'],

                'underscore': {exports: '_' },
                'bootstrap': ['jquery'],
                'modernizr': {exports: 'Modernizr'},
                'moment': { exports: 'moment' },
                'fullcalendar': ['css!libs/bower_components/admin-lte/plugins/fullcalendar/fullcalendar.min'],
                'icheck': ['css!libs/bower_components/admin-lte/plugins/iCheck/flat/blue'],
                'ionslider': ['css!libs/bower_components/admin-lte/plugins/ionslider/ion.rangeSlider'],

                'bootstrap.datatables': ['bootstrap', 'jquery.datatables', 'css!libs/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap'],
                'bootstrap.daterangepicker': ['bootstrap', 'css!libs/bower_components/admin-lte/plugins/daterangepicker/daterangepicker-bs3'],
                'bootstrap.datepicker': ['bootstrap', 'css!libs/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.standalone.min'],
                'bootstrap.timepicker': ['bootstrap', 'css!libs/bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.min'],
                'bootstrap.select2': ['bootstrap', 'css!libs/bower_components/select2/select2'],
                'bootstrap.slider': ['bootstrap', 'css!libs/bower_components/admin-lte/plugins/bootstrap-slider/slider'],
                'bootstrap.switch': ['bootstrap', 'css!libs/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min'],
                'image.uploader': ['bootstrap', 'css!libs/vendor/image-uploader/image-uploader'],
                'md5': {exports: 'md5' },

                'adminlte': [
                    'jquery',
                    'bootstrap',
                    'jquery.ui', 'fastclick', 'jquery.slimscroll', 'icheck', 'marionette.showanimated'
                    //'css!libs/bower_components/admin-lte/dist/css/AdminLTE.min',
                    //'css!libs/bower_components/admin-lte/dist/css/skins/skin-blue.min',
                    //'css!../css/app'
                ],

                'base.app': ['modernizr', 'adminlte', 'md5']
            },

            map: {
                '*': {
                    'css': 'require-css',
                    'text': 'require-text'
                }
            }
        };
    </script>
@show
</body>
</html>