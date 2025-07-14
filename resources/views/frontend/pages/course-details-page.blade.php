@extends('frontend.layouts.master')
@push('meta')
    <meta property="og:title" content="{{ $course->title }}">
    <meta property="og:description" content="{{ $course->seo_description }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset($course->thumbnail) }}">
    <meta property="og:type" content="Course">
@endpush
@section('content')
    <!--===========================
                BREADCRUMB START
            ============================-->
    <section class="wsus__breadcrumb course_details_breadcrumb"
        style="background: url({{ asset(config('settings.site_breadcrumb')) }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12 wow fadeInUp">
                        <div class="wsus__breadcrumb_text">
                            <p class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                @if($i <= $course->reviews()->avg('rating'))
                                <i class="fas fa-star"></i>
                                @else
                                <i class="far fa-star"></i>
                                @endif
                                @endfor
                                <span>({{ number_format($course->reviews()->avg('rating'), 2) ?? 0 }} Reviews)</span>

                            </p>
                            <h1>{{ $course->title }}</h1>
                            <ul class="list">
                                <li>
                                    <span><img src="{{ asset($course->instructor->image) }}" alt="user"
                                            class="img-fluid"></span>
                                    By {{ $course->instructor->name }}
                                </li>
                                <li>
                                    <span><img src="{{ asset('frontend/assets/images/globe_icon_blue.png') }}"
                                            alt="Globe" class="img-fluid"></span>
                                    {{ $course->category->name }}
                                </li>
                                <li>
                                    <span><img src="{{ asset('frontend/assets/images/calendar_blue.png') }}" alt="Calendar"
                                            class="img-fluid"></span>
                                    Last updated {{ date('d/M/Y', strtotime($course->updated_at)) }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--===========================
                BREADCRUMB END
            ============================-->


    <!--===========================
                COURSES DETAILS START
            ============================-->
    <section class="wsus__courses_details pb_120 xs_pb_100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 wow fadeInLeft">
                    <div class="wsus__courses_details_area mt_40">

                        <ul class="nav nav-pills mb_40" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true">Overview</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-contact" type="button" role="tab"
                                    aria-controls="pills-contact" aria-selected="false">Pembuat</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-disabled-tab2" data-bs-toggle="pill"
                                    data-bs-target="#pills-disabled2" type="button" role="tab"
                                    aria-controls="pills-disabled2" aria-selected="false">Review</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab" tabindex="0">
                                <div class="wsus__courses_overview box_area">
                                    <h3>Description</h3>
                                    <p>{!! $course->description !!}</p>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab" tabindex="0">
                                <div class="wsus__courses_instructor box_area">
                                    <h3>Instructor Details</h3>
                                    <div class="row align-items-center">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="wsus__courses_instructor_img">
                                                <img src="{{ asset($course->instructor->image) }}" alt="Instructor"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-md-6">
                                            <div class="wsus__courses_instructor_text">
                                                <h4>{{ $course->instructor->name }}</h4>
                                                <p class="designation">{{ $course->instructor->headline }}</p>
                                                <ul class="list">
                                                    @php
                                                        $coursesId = $course->instructor->courses()->pluck('id')->toArray();
                                                        $reviewsCount = \App\Models\Review::whereIn('course_id', $coursesId)->count();
                                                    @endphp
                                                    <li><i class="fas fa-star"></i> <b> {{ $reviewsCount }} Reviews</b></li>
                                                    <li><strong>4.7 Rating</strong></li>
                                                    <li>
                                                        <span><img src="{{ asset('frontend/assets/images/book_icon.png') }}" alt="book"
                                                                class="img-fluid"></span>
                                                        {{ $course->instructor->courses()->count() }} kegiatan
                                                    </li>
                                                    {{-- <li>
                                                        <span><img src="{{ asset('frontend/assets/images/user_icon_gray.png') }}" alt="user"
                                                                class="img-fluid"></span>
                                                        {{ $course->instructor->students()->count() }} Students
                                                    </li> --}}
                                                </ul>

                                                <p class="description">
                                                    {{ $course->instructor->bio }}
                                                </p>
                                                <ul class="link d-flex flex-wrap">
                                                    @if($course->instructor->facebook)
                                                    <li><a href="{{ $course->instructor->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                                                    @endif
                                                    @if($course->instructor->x)
                                                    <li><a href="{{ $course->instructor->x }}"><i class="fab fa-twitter"></i></a></li>
                                                    @endif
                                                    @if($course->instructor->linkedin)
                                                    <li><a href="{{ $course->instructor->linkedin }}"><i class="fab fa-linkedin-in"></i></a></li>
                                                    @endif
                                                    @if($course->instructor->website)
                                                    <li><a href="{{ $course->instructor->website }}"><i class="fas fa-link"></i></a></li>
                                                    @endif
                                                    @if($course->instructor->github)
                                                    <li><a href="{{ $course->instructor->github }}"><i class="fab fa-github"></i></a></li>
                                                    @endif


                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="pills-disabled2" role="tabpanel"
                                aria-labelledby="pills-disabled-tab2" tabindex="0">
                                <div class="wsus__courses_review box_area">
                                    <h3>Customer Reviews</h3>
                                    <div class="row align-items-center mb_50">
                                        <div class="col-xl-4 col-md-6">
                                            <div class="total_review">
                                                <h2>{{ number_format($course->reviews()->avg('rating'), 2) ?? 0 }}</h2>
                                                <p>
                                                   @for($i = 1; $i <= number_format($course->reviews()->avg('rating'), 2) ?? 0; $i++)
                                                    <i class="fas fa-star"></i>
                                                   @endfor

                                                </p>
                                                <h4>{{ $course->reviews()->count() }} Ratings</h4>
                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-md-6">
                                            <div class="review_bar">
                                                <div class="review_bar_single">
                                                    <p>5 <i class="fas fa-star"></i></p>
                                                    <div id="bar1" class="barfiller">
                                                        <div class="tipWrap">
                                                            <span class="tip"></span>
                                                        </div>
                                                        <span class="fill" data-percentage="85"></span>
                                                    </div>
                                                    <span class="qnty">{{ $course->reviews()->where('rating', 5)->count() }}</span>
                                                </div>
                                                <div class="review_bar_single">
                                                    <p>4 <i class="fas fa-star"></i></p>
                                                    <div id="bar2" class="barfiller">
                                                        <div class="tipWrap">
                                                            <span class="tip"></span>
                                                        </div>
                                                        <span class="fill" data-percentage="70"></span>
                                                    </div>
                                                    <span class="qnty">{{ $course->reviews()->where('rating', 4)->count() }}</span>
                                                </div>
                                                <div class="review_bar_single">
                                                    <p>3 <i class="fas fa-star"></i></p>
                                                    <div id="bar3" class="barfiller">
                                                        <div class="tipWrap">
                                                            <span class="tip"></span>
                                                        </div>
                                                        <span class="fill" data-percentage="50"></span>
                                                    </div>
                                                    <span class="qnty">{{ $course->reviews()->where('rating', 3)->count() }}</span>
                                                </div>
                                                <div class="review_bar_single">
                                                    <p>2 <i class="fas fa-star"></i></p>
                                                    <div id="bar4" class="barfiller">
                                                        <div class="tipWrap">
                                                            <span class="tip"></span>
                                                        </div>
                                                        <span class="fill" data-percentage="30"></span>
                                                    </div>
                                                    <span class="qnty">{{ $course->reviews()->where('rating', 2)->count() }}</span>
                                                </div>
                                                <div class="review_bar_single">
                                                    <p>1 <i class="fas fa-star"></i></p>
                                                    <div id="bar5" class="barfiller">
                                                        <div class="tipWrap">
                                                            <span class="tip"></span>
                                                        </div>
                                                        <span class="fill" data-percentage="10"></span>
                                                    </div>
                                                    <span class="qnty">{{ $course->reviews()->where('rating', 1)->count() }}</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <h3>Reviews</h3>

                                    @foreach($reviews as $review)
                                        <div class="wsus__course_single_reviews">
                                            <div class="wsus__single_review_img">
                                                @if($review->user_id && $review->user)
                                                    <img src="{{ asset($review->user->image) }}" alt="user" class="img-fluid">
                                                @else

                                                @endif
                                            </div>
                                            <div class="wsus__single_review_text">
                                                <h4>{{ $review->user_id ? $review->user->name : $review->name }}</h4>
                                                <h6>{{ date('d M Y', strtotime($review->created_at)) }}
                                                    <span>
                                                        @for($i = 1; $i <= $review->rating; $i++)
                                                            <i class="fas fa-star"></i>
                                                        @endfor
                                            </span>
                                        </h6>
                                        <p>{{ $review->review }}</p>
                                    </div>
                                </div>


                                    @endforeach

                                    <div>
                                        {{ $reviews->links() }}
                                    </div>

                                </div>
                                @auth
                                <div class="wsus__courses_review_input box_area mt_40">
                                    <h3>Write a Review</h3>
                                    <p class="short_text">Your email address will not be published. Required fields are
                                        marked *</p>
                                    <div class="select_rating d-flex flex-wrap">Your Rating:
                                        <ul id="starRating" data-stars="5"></ul>
                                    </div>
                                    <form action="{{ route('review.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" name="rating" value="" id="rating">
                                            <input type="hidden" name="course" value="{{ $course->id }}">
                                            <div class="col-xl-12">
                                                <textarea rows="7" placeholder="Review" name="review"></textarea>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <button type="submit" class="common_btn">Submit Now</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @else
                                 <!-- GUEST -->
                                 <div class="select_rating d-flex flex-wrap align-items-center mb-3">
                                    <span class="me-2">Your Rating:</span>
                                        <ul id="starRating" data-stars="5" style="list-style: none; padding-left: 0; display: flex;">
                                        </ul>
                                    </div>

                                    <form action="{{ route('review.store') }}" method="POST">
                                        @csrf
                                        <input type="" name="rating" value="" id="rating">
                                        <input type="hidden" name="course" value="{{ $course->id }}">

                                        <div class="col-xl-12 mb-3">
                                            <input type="text" name="name" class="form-control" placeholder="Nama Anda" required>
                                        </div>
                                        <div class="col-xl-12 mb-3">
                                            <input type="email" name="email" class="form-control" placeholder="Email Anda" required>
                                        </div>
                                        <div class="col-xl-12 mb-3">
                                            <textarea rows="7" placeholder="Review" name="review" required></textarea>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <button type="submit" class="common_btn">Submit Now</button>
                                        </div>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 wow fadeInRight">
                    <div class="wsus__courses_sidebar">


                            <div class="wsus__courses_sidebar_video" style="position: relative; display: inline-block;">
                                <!-- Thumbnail -->
                                <img src="{{ asset($course->thumbnail) }}" alt="Video Thumbnail" class="img-fluid">

                                <!-- Ikon Klik Video -->
                                <a href="{{ asset('files/1/shares/' . basename($course->demo_video_source)) }}"
                                   target="_blank"
                                   class="play_btn">
                                   <img src="{{ asset('frontend/assets/images/play_icon_white.png') }}" alt="Play"
                                   class="img-fluid">
                                </a>
                            </div>



                        <h3 class="wsus__courses_sidebar_price">
                            @if($course->discount > 0)
                           <del>{{ $course->price }}</del>
                            @elseif($course->price <= 0)

                            @else
                               {{ $course->price }}
                            @endif
                        </h3>

                        <div class="wsus__courses_sidebar_list_info">
                            <ul>

                                <li>
                                    <p>
                                        <span><img src="{{ asset('frontend/assets/images/network_icon_black.png') }}"
                                                alt="network" class="img-fluid"></span>
                                        Nama Ketua RT
                                    </p>
                                    {{ $course->level->name }}
                                </li>
                                <li>
                                    <p>
                                        <span><img src="{{ asset('frontend/assets/images/language_icon_black.png') }}"
                                                alt="Language" class="img-fluid"></span>
                                        Nama ketua KarangTaruna RT
                                    </p>
                                    {{ $course->language->name }}
                                </li>
                            </ul>
                        </div>
                        <div class="wsus__courses_sidebar_instructor">
                            <div class="image_area d-flex flex-wrap align-items-center">
                                <div class="img">
                                    <img src="{{ asset($course->instructor->image) }}" alt="Instructor" class="img-fluid">
                                </div>
                                <div class="text">
                                    <h3>{{ $course->instructor->name }}</h3>
                                    <p><span>Dokumentasi</span></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--===========================
                COURSES DETAILS END
            ============================-->
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/shakilahmed0369/ez-share/dist/ez-share.min.js"></script>

<script>
    $(function() {
      $('#starRating li').on('click', function() {
        var $starRating = $('#starRating').find('.active').length;

        $('#rating').val($starRating);
      })
    })
</script>
@endpush
