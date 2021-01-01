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
<div class="reson_area section_padding">
       <div class="container-fluid">
        <div class="row justify-content-center" id="fund">
            <div class="col-lg-12 ">
                <div class="section_title text-center mb-55">
                    <h3><span>START YOUR FREE ONLINE FUNDRAISER</span></h3>
                    <p>Raise money for a variety of humanitarian causes. Choose the one that is most important to you.</p>
                </div>
            </div>
        </div>
        <center><h3><span style="font-family: Yeseva One", cursive;">CAMPAIGN CATEGORY</span></h3><div class="line"></div></center><br/>
    <div class="row">
        <div class="owl-carousel owl-theme">
            <div class="item" onclick="campaignpage(1);"> 
                <div class="home-content">
                <img src="{{ asset('public/frontend/img/home/types/animals.jpg') }}" alt="Animals" style="height: 150px" >
                <div class="content">
                    <h4>Animals</h4>
                </div>
                 <!-- <center><i class="fas fa-hippo"></i>
                    <h4>Animals</h4></center> -->
            </div></div>
            <div class="item" onclick="campaignpage(2);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/charity.jpg') }}" alt="Charity" style="height:150px;">
                    <div class="content">
                        <h4>Charity</h4>
                    </div>
                     <!-- <center><i class="fa fa-heart"></i>
                        <h4>Charity</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(3);">    <div class="home-content">
                <img src="{{ asset('public/frontend/img/home/types/dance.jpg') }}" alt="Dance" style="height: 150px;">
                <div class="content">
                    <h4>Dance</h4>
                </div>
                 <!-- <center><i class="fa fa-users" aria-hidden="true"></i>
                    <h4>Community</h4></center> -->
            </div></div>
            <div class="item" onclick="campaignpage(4);"> <div class="home-content">
                <img src="{{ asset('public/frontend/img/home/types/community.jpg') }}" alt="Community" style="height:150px;">
                <div class="content">
                    <h4>Community</h4>
                </div>
                 <!-- <center><i class="fa fa-users" aria-hidden="true"></i>
                    <h4>Community</h4></center> -->
            </div></div>
            <div class="item" onclick="campaignpage(5);"> <div class="home-content">
                <img src="{{ asset('public/frontend/img/home/types/books.jpg') }}" alt="Comics & Books" style="height:150px;">
                <div class="content">
                    <h4>Comics & Books</h4>
                </div>
                 <!-- <center><i class="fa fa-book"></i>
                    <h4>Comics & Books</h4></center> -->
            </div></div>
            <div class="item" onclick="campaignpage(6);">         <div class="home-content">
                <img src="{{ asset('public/frontend/img/home/types/club.jpg') }}" alt="Clubs & Organization" style="height:150px;">
                <div class="content">
                    <h4>Clubs & Organization</h4>
                </div>
                 <!-- <center><i class="fa fa-credit-card"></i>
                    <h4>Clubs & Organization</h4></center> -->
            </div></div>
            <div class="item" onclick="campaignpage(7);">       <div class="home-content">
                <img src="{{ asset('public/frontend/img/home/types/children.jpg') }}" alt="Children" style="height:150px;">
                <div class="content">
                    <h4>Children</h4>
                </div>
                 <!-- <center> <i class="fa fa-child" aria-hidden="true"></i>
                    <h4>Children</h4></center> -->
            </div></div>
            <div class="item" onclick="campaignpage(8);">
                
                <div class="home-content">
                <img src="{{ asset('public/frontend/img/home/types/accident.jpg') }}" alt="Accidents & Disasters" style="height:150px;">
                <div class="content">
                    <h4>Accidents & Disasters</h4>
                </div>
                </div>
            </div>
            <div class="item" onclick="campaignpage(9);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/adoption.jpg') }}" alt="Adoption" style="height: 150px;">
                    <div class="content">
                        <h4>Adoption</h4>
                    </div>
                </div>
            </div>
            <div class="item" onclick="campaignpage(10);"> <div class="home-content">
                <img src="{{ asset('public/frontend/img/home/types/art.png') }}" alt="Notebook" style="height: 150px;">
                <div class="content">
                    <h4>Art</h4>
                </div>
                 <!-- <center><i class="fas fa-palette"></i>
                    <h4>Art</h4></center> -->
            </div></div>
            <div class="item" onclick="campaignpage(11);">      <div class="home-content">
                <img src="{{ asset('public/frontend/img/home/types/accident.jpg') }}" alt="Business & Technology" style="height: 150px;">
                <div class="content">
                    <h4>Business & Technology</h4>
                </div>
                  <!-- <center><i class="far fa-building"></i>
                    <h4>Business & Technology</h4></center> -->
            </div></div>
            <div class="item" onclick="campaignpage(12);">   <div class="home-content">
                <img src="{{ asset('public/frontend/img/home/types/home.jpg') }}" alt="Buy & Home" style="height: 150px;">
                <div class="content">
                    <h4>Buy & Home</h4>
                </div>
                 <!-- <center><i class="fa fa-home" aria-hidden="true"></i>
                    <h4>Buy & Home</h4></center> -->
            </div></div>
            <div class="item" onclick="campaignpage(13);"> <div class="home-content">
                <img src="{{ asset('public/frontend/img/home/types/emergency.jpg') }}" alt="Emergencies" style="height: 150px;">
                <div class="content">
                    <h4>Emergencies</h4>
                </div>
                 <!-- <center><i class="fa fa-heart"></i>
                    <h4>Charity</h4></center> -->
            </div></div>
            <div class="item" onclick="campaignpage(14);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/films.jpg') }}" alt="Films" style="height:150px;">
                    <div class="content">
                        <h4>Films & Short Films</h4>
                    </div>
                     <!-- <center> <i class="fa fa-child" aria-hidden="true"></i>
                        <h4>Children</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(15);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/foods.jpg') }}" alt="Food" style="height:150px;">
                    <div class="content">
                        <h4>Food</h4>
                    </div>
                     <!-- <center><i class="fa fa-credit-card"></i>
                        <h4>Clubs & Organization</h4></center> -->
                </div> 
            </div>
            <div class="item" onclick="campaignpage(16);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/music.jpg') }}" alt="Music" style="height:150px;">
                    <div class="content">
                        <h4>Music & Albums</h4>
                    </div>
                     <!-- <center><i class="fa fa-book"></i>
                        <h4>Comics & Books</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(17);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/old.jpg') }}" alt="Old" style="height:150px;">
                    <div class="content">
                        <h4>Old Age Homes</h4>
                    </div>
                     <!-- <center><i class="fa fa-users" aria-hidden="true"></i>
                        <h4>Community</h4></center> -->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="owl-carousel owl-theme">
            <div class="item" onclick="campaignpage(18);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/energy.jpg') }}" alt="Energy" style="height: 150px;">
                    <div class="content">
                        <h4>Energy & Environments</h4>
                    </div>
                     <!-- <center><i class="fa fa-users" aria-hidden="true"></i>
                        <h4>Community</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(19);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/travel.jpg') }}" alt="travel" style="height: 150px;">
                    <div class="content">
                        <h4>Travels & Trips</h4>
                    </div>
                     <!-- <center><i class="fa fa-heart"></i>
                        <h4>Charity</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(20);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/women.jpg') }}" alt="Women empower" style="height: 150px;">
                    <div class="content">
                        <h4>Women Empowerment</h4>
                    </div>
                     <!-- <center> <i class="fa fa-child" aria-hidden="true"></i>
                        <h4>Children</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(21);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/military.jpg') }}" alt="Military" style="height: 150px;">
                    <div class="content">
                        <h4>Military & Veterns</h4>
                    </div>
                     <!-- <center><i class="fa fa-credit-card"></i>
                        <h4>Clubs & Organization</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(22);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/medical.jpg') }}" alt="Medical" style="height: 150px;">
                    <div class="content">
                        <h4>Medical & Health</h4>
                    </div>
                     <!-- <center><i class="fa fa-book"></i>
                        <h4>Comics & Books</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(23);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/events.jpg') }}" alt="Events" style="height: 150px;">
                    <div class="content">
                        <h4>Special Events</h4>
                    </div>
                     <!-- <center><i class="fa fa-users" aria-hidden="true"></i>
                        <h4>Community</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(24);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/calamity.jpg') }}" alt="Calamaties" style="height: 150px;">
                    <div class="content">
                        <h4>Natural Disasters</h4>
                    </div>
                     <!-- <center><i class="fa fa-users" aria-hidden="true"></i>
                        <h4>Community</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(25);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/education.jpg') }}" alt="educations" style="height: 150px;">
                    <div class="content">
                        <h4>Education Purpose</h4>
                    </div>
                     <!-- <center><i class="fa fa-heart"></i>
                        <h4>Charity</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(26);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/enter.jpg') }}" alt="Entrepreneur" style="height: 150px;">
                    <div class="content">
                        <h4>Entrepreneur</h4>
                    </div>
                     <!-- <center> <i class="fa fa-child" aria-hidden="true"></i>
                        <h4>Children</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(27);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/rural.jpg') }}" alt="Rural" style="height: 150px;">
                    <div class="content">
                        <h4>Rural Development</h4>
                    </div>
                     <!-- <center><i class="fa fa-credit-card"></i>
                        <h4>Clubs & Organization</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(28);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/reales.jpg') }}" alt="Real Estate" style="height: 150px;">
                    <div class="content">
                        <h4>Real Estate</h4>
                    </div>
                     <!-- <center><i class="fa fa-book"></i>
                        <h4>Comics & Books</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(29);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/ngo.png') }}" alt="Non Profit Organizations" style="height: 150px;">
                    <div class="content">
                        <h4>Non Profit Organizations</h4>
                    </div>
                     <!-- <center><i class="fa fa-users" aria-hidden="true"></i>
                        <h4>Community</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(30);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/loan.jpg') }}" alt="Loan" style="height: 150px;">
                    <div class="content">
                        <h4>Repay a Loan</h4>
                    </div>
                     <!-- <center><i class="fa fa-users" aria-hidden="true"></i>
                        <h4>Community</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(31);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/marriage.jpg') }}" alt="marriage" style="height: 150px;">
                    <div class="content">
                        <h4>Marriage Events</h4>
                    </div>
                     <!-- <center><i class="fa fa-heart"></i>
                        <h4>Charity</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(32);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/debts.jpg') }}" alt="Debts" style="height: 150px;">
                    <div class="content">
                        <h4>Get Out Of debts</h4>
                    </div>
                     <!-- <center> <i class="fa fa-child" aria-hidden="true"></i>
                        <h4>Children</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(33);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/sports.jpg') }}" alt="Sports" style="height: 150px;">
                    <div class="content">
                        <h4>Sports Events</h4>
                    </div>
                     <!-- <center><i class="fa fa-book"></i>
                        <h4>Comics & Books</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(34);">
                <div class="home-content">
                    <img src="{{ asset('public/frontend/img/home/types/software.jpg') }}" alt="Software" style="height: 150px;">
                    <div class="content">
                        <h4>Develop a Software</h4>
                    </div>
                     <!-- <center><i class="fa fa-users" aria-hidden="true"></i>
                        <h4>Community</h4></center> -->
                </div>
            </div>
            <div class="item" onclick="campaignpage(35);">
                <div class="home-content others" style="height: 150px;">
                    <center>  <i class="fa fa-folder fa-2x" aria-hidden="true"></i>
                <a href="explore.html" target="_blank" rel="noopener noreferrer"> <h4>Others</h4></a></center>
                </div>
            </div>

        </div>
    </div>
       </div>
   </div>
@if(empty($data))
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
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center mb-55">
                        <h3><span>{{ $data->campaign->title }}</span></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                                <?php echo $data->discription; ?>
                </div>
            </div>
        </div>
    </div> <!-- cd-timeline -->
@endif
  @endsection

  @section('js')

    <script type="text/javascript">
        $('.owl-carousel1').owlCarousel({
    loop:true,
    margin:10,
    dots:false,
    nav:true,
    mouseDrag:false,
    autoplay:true,
    animateOut: 'slideOutUp',
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }

});
$('.owl-carousel').owlCarousel({
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
    window.location.replace('campaign-view?id='+id);
}
    </script>

    @endsection