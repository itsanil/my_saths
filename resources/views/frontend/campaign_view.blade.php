@extends('frontend.layout.main')
@section('title','Campaign-View')
@section('slider')


    <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center" style="background-image: url({{ asset('public/frontend/img/banner/fundraising.png') }});">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>Campaign</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('content')

@if($data->count() == 0)
 <div class="popular_causes_area section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center mb-55">
                        <h3><span>No Data Found for selected Category!...</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- cd-timeline -->

@else
 <div class="popular_causes_area section_padding">
        <div class="container">
            <div class="row">
                @foreach($data as $key => $value)
                    <div class="single_cause col-md-4" onclick="campaindetails('{{ $value->id }}');">
                        <div class="thumb">
                            <img src="{{ url('storage') }}/{{ $value->photo }}" alt="">
                        </div>
                        <div class="causes_content">
                            <h4>{{$value->title}}</h4>
                            <!-- <p>CMy Saathe helps empower your creative, entrepreneurial,and passion projects.</p> -->
                             <h6 style="font-weight: bold;">Needed Amount: ₹ {{ json_decode($value->project)->needed_amount }}</h6>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
</div>
@endif
   <div class="reson_area section_padding">
       <div class="container-fluid">
        <center><h3><span style="font-family: Yeseva One", cursive;">CAMPAIGN CATEGORY</span></h3><div class="line"></div></center><br/>
    <div class="row">
        <div class="owl-carousel1 owl-theme">
            @foreach ($category as $key => $value)
            @if($key < 18)
            <div class="item" onclick="campaignpage('{{ $value->id }}');"> 
                <div class="home-content">
                <img src="{{ url('storage/') }}/{{ $value->photo }}" alt="{{ $value->title }}" style="height: 150px" >
                <div class="content">
                    <h4>{{ $value->title }}</h4>
                </div>
                 <!-- <center><i class="fas fa-hippo"></i>
                    <h4>Animals</h4></center> -->
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="owl-carousel1 owl-theme">
            @foreach ($category as $key => $value)
            @if($key >= 18)
            <div class="item" onclick="campaignpage('{{ $value->id }}');"> 
                <div class="home-content">
                <img src="{{ url('storage/') }}/{{ $value->photo }}" alt="{{ $value->title }}" style="height: 150px" >
                <div class="content">
                    <h4>{{ $value->title }}</h4>
                </div>
                 <!-- <center><i class="fas fa-hippo"></i>
                    <h4>Animals</h4></center> -->
                </div>
            </div>
            @endif
            @endforeach

        </div>
    </div>
       </div>
   </div>
  @endsection

  @section('js')

    <script type="text/javascript">

$('.owl-carousel1').owlCarousel({
    loop:true,
    margin:10,
    dots:false,
    nav:false,
    autoplay:true,
    autoplayTimeout:1000,
    
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:6
        }
    }
});

function campaignpage(id){
    window.location.replace('campaign-list?id='+id);
}

function campaindetails(id){
    window.location.replace('campaign-view/'+id);
}
    </script>

    @endsection