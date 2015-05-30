@extends('layouts.auth')

@section('scripts')
    @parent
    <script data-main="js/init.js" src="{{ asset('/libs/vendor/requirejs/require.js') }}"></script>
@stop