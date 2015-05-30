@extends('layouts.nonauth')

@section('content')
    @parent
    <section class="content-header">
        <h1>
            Nepal United
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
    </div>
@stop