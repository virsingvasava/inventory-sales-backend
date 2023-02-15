<div class="row" style="display:none">
    @if (!empty($SoldBrands) && count($SoldBrands) > 0)
    @foreach ($SoldBrands as $key => $value)
    <div class="col-md-3">
        <a href="{{route('admin.dashboard.ajax_brand_dashboard', $value['id'])}}">
            <div class="brand-box-inr">
                <h4>{{ $value['name'] }}</h4>
                <div class="bb-left-part">
                    @if ($value['percentage'] != 0)
                    <span class="budge"><img src="{{ asset('theme/images/green-arrow-up.png') }}">{{ $value['percentage'] }}%</span>
                    @else
                    <span class="budge">-</span>
                    @endif
                    <h3>{{ $value['sold_items'] }}</h3>
                    <p>Pack Sold</p>
                </div>
                <div class="bb-right-part">
                    <h3>{{$value['total_amount']}}</h3>
                    <p>Total Sales</p>
                    <!-- <img src="{{asset('theme/images/small-chart.png')}}"> -->
                    <!-- <div id="clasic-area-chart" style="height:100px;"></div> -->
                </div>
            </div>
        </a>
    </div>
    @endforeach
    @endif
</div>

<div class="row">
    <div id="owl-demo" class="owl-carousel owl-theme">
        @if (!empty($SoldBrands) && count($SoldBrands) > 0)
        @foreach ($SoldBrands as $key => $value)
        <div class="item">
            <a href="{{route('admin.dashboard.ajax_brand_dashboard', $value['id'])}}">
                <div class="brand-box-inr">
                    <h4>{{ $value['name'] }}</h4>
                    <div class="bb-left-part">
                        @if ($value['percentage'] != 0)
                        <span class="budge"><img src="{{ asset('theme/images/green-arrow-up.png') }}">{{ $value['percentage'] }}%</span>
                        @else
                        <span class="budge">-</span>
                        @endif
                        <h3>{{ $value['sold_items'] }}</h3>
                        <p>Pack Sold</p>
                    </div>
                    <div class="bb-right-part">
                        <h3>{{$value['total_amount']}}</h3>
                        <p>Total Sales</p>
                        <!-- <img src="{{asset('theme/images/small-chart.png')}}"> -->
                        <!-- <div id="clasic-area-chart" style="height:100px;"></div> -->
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        @endif
    </div>
</div>
<link rel="stylesheet" type="text/css" href="{{asset('assets/slider/owl.theme.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/slider/owl.carousel.css')}}">
<script src="{{asset('assets/slider/owl.carousel.js')}}"></script>
<script>
    $(document).ready(function() {

        var owl = $("#owl-demo");

        owl.owlCarousel({
            items: 4,
            itemsDesktop: [1000, 4],
            itemsDesktopSmall: [900, 3],
            itemsTablet: [600, 2],
            itemsMobile: false
        });
        $(".next").click(function() {
            owl.trigger('owl.next');
        })
        $(".prev").click(function() {
            owl.trigger('owl.prev');
        })
        $(".play").click(function() {
            owl.trigger('owl.play', 1000);
        })
        $(".stop").click(function() {
            owl.trigger('owl.stop');
        })

    });
</script>