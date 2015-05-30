@extends('layouts.nonauth')

@section('content')
    @parent

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Top Packers and Movers
            <small>Search Results</small>
        </h1>
    </section>

    <div class="content">
        <div class="results col-md-9">

            <ul class="result-grid row animated fadeIn">
                @foreach ($organizations as $organization)
                    <li class="result col-sm-6 col-md-4">
                    @include('partials.organization-thumb', array('organization' => $organization, 'thumbnail' => true))
                    </li>
                @endforeach
            </ul>

        </div>

        <div class="col-md-3">
            <div class="">
                @include('partials.quick-quote')
            </div>

            <div class="alert alert-danger animated swing">
                <h2 class="text-center">
                    <p>Looking for a fast relocation?</p>
                    <small style="color: #f5f5f5">We are here to help!</small>
                    <div class="clearfix"></div>
                    <img class="img-responsive" src="{{ asset('/img/misc/support1.jpg') }}" style="display: inline"/>
                </h2>
            </div>

            <div class="alert alert-info">
                <h2 class="text-center">
                    <p>Best Packers And Movers will help you move to your destination</p>
                </h2>
                <h2 class="text-center" style="color: #ffff00">
                    Call +91-1234567890</small>
                </h2>
            </div>
        </div>


    </div>


@stop