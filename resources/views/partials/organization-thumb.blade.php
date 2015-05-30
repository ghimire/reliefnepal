    <div class="merchant">
        @if ($organization->type == 'paid')
            <div class="discount"><span class="percent"><i class="fa fa-thumbs-up"></i></span></div>
        @endif

        <div class="merchant-thumb">
            <a href="{{ $organization->getUrl() }}#info">
                <img src="{{ $organization->profile_picture }}" alt="" class="img-responsive">
            </a>
        </div>

        <h4 class="pull-left"><a href="{{ $organization->getUrl() }}#info" class="link-merchant">{{ $organization->truncateName() }}</a></h4>

        <div class="clearfix"></div>

        <address style="">
            <i class="fa fa-map-marker"></i> {{ $organization->address }}
            &nbsp;
        </address>

        <div class="clearfix"></div>
        <address class="phone">
            <i class="fa fa-phone"></i> {{ $organization->phone }}
            &nbsp;
        </address>

        <div class="clearfix"></div>
    </div>