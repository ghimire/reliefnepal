@extends('layouts.auth')

@section('scripts')
    @parent
    <script data-main="js/init.js" src="{{ asset('/libs/bower_components/requirejs/require.js') }}"></script>
@stop