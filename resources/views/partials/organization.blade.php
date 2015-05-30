
    <div itemscope itemtype="http://schema.org/Review" style="display: none">
                                <div itemprop="itemReviewed" itemscope itemtype="http://schema.org/LocalBusiness">
                                    <span itemprop="name">{{ $organization->name }}</span> ({{ $organization->city }})
                                </div>
                                <span itemprop="author" itemscope itemtype="http://schema.org/Organization">
                                    <span itemprop="name">Nepal United</span>
                                </span>
                            </div>

    <div class="merchant" style="{{ 'font-size:1.2em' }}">
        <div class="merchant-thumb">
            <a href="{{ 'javascript:void(0)' }}">
                <img src="{{ $organization->profile_picture }}" alt="" class="img-responsive">
            </a>
        </div>

        <p class="alert alert-danger row" style="margin-bottom: 0; font-size: 1.4em;">
            <a href="javascript:void(0)" class="link-merchant" style="color: #fff; font-weight: normal">{{ $organization->name }}</a>
        </p>

        <div class="clearfix"></div>
        <address style="">
            <i class="fa fa-map-marker"></i> {{ $organization->address }}
            &nbsp;
        </address>

        <div class="clearfix"></div>
        <address class="phone">
            <i class="fa fa-phone"></i> {{ $organization->phone }}
        </address>

        <div class="clearfix"></div>
        <address>
            @if($organization->website)
            <a class="button button-primary pull-left" target="_blank" href="{{ $organization->website }}">
                <i class="fa fa-globe"></i> Visit Website
            </a>
            @endif
            &nbsp;
            <div class="clearfix"></div>
        </address>

        @if($organization->description)
        <div class="clearfix"></div>
        <hr>
        <p class="merchant-intro" style="white-space: pre-wrap">{{ $organization->description }}</p>
        @endif

        <div class="clearfix"></div>
        <p class="alert alert-info row" style="margin-bottom: 0; color: #fff">
            <i class="fa fa-map-marker"></i> Location
        </p>

        <div class="clearfix"></div>
        <div class="col-md-12" style="padding: 0">
            <div class="flexible-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15548.378828015087!2d77.5458494!3d13.029640650000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae3d69742c2493%3A0x4cd3ecd783d21d81!2sBengaluru%2C+Karnataka+560022%2C+India!5e0!3m2!1sen!2snp!4v1430678994900" width="600" height="480" frameborder="0" style="border:0"></iframe>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>