@extends('layouts.nonauth')

@section('title')
    {{ $organization->name }} || Packers City
@stop

@section('meta-social')
    <meta name="description" content="{{ str_limit($organization->description, $limit = 150, $end = '...') }}">
    <!-- for Facebook -->
    <meta property="fb:app_id" content="816039715145733" />
    <meta property="og:type" content="profile" />
    <meta property="og:title" content="{{ $organization->name }}" />
    <meta property="og:image" content="@if($organization->profile_picture){{ 'http://packercity.com'.$organization->profile_picture }}@else{{ 'http://packercity.com'.asset('img/profiles/organization-500x250.png') }}@endif" />
    <meta property="og:url" content="{{ $organization->website }}" />
    <meta property="og:description" content="{{ str_limit($organization->description, $limit = 150, $end = '...') }}" />

    <!-- for Twitter -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="{{ $organization->name }}" />
    <meta name="twitter:description" content="{{ str_limit($organization->description, $limit = 150, $end = '...') }}" />
    <meta name="twitter:image" content="@if($organization->profile_picture){{ 'http://packercity.com'.$organization->profile_picture }}@else{{ 'http://packercity.com'.asset('img/profiles/organization-500x250.png') }}@endif" />
@stop

@section('content')
    @parent

    <div class="content">
        <div class="results col-md-12">
            <ul class="result-grid row">
                <li class="result col-sm-12 col-md-12">
                    <div class="col-md-6 animated fadeIn">
                        <div class="result-grid row">
                            <div class="result col-sm-12 col-xs-12 col-md-12">
                            @include('partials.organization', array('organization' => $organization, 'thumbnail' => false))
                            </div>
                        </div>

                        <div>
                            <br/>
                            @include('partials.quick-quote')
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h3 class="text-muted">
                            Similar Packers &amp; Movers
                        </h3>
                        <ul class="result-grid row">
                            @foreach ($paid_organizations as $organization)
                            <li class="result col-sm-6 col-md-4">
                                @include('partials.organization-thumb', array('organization' => $organization, 'thumbnail' => true))
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            </ul>

        </div>
    </div>


@stop