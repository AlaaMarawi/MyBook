<!DOCTYPE html>
<html lang="en">

<head>
    @include('inc.head')

<body>

    <!-- Header
    ================================================= -->
    <header id="header">
        @include('inc.navbar')

    </header>
    <!--Header End-->

    <div class="container">
        <!-- Timeline
      ================================================= -->
        <div class="timeline">
            <div class="timeline-cover"
             @if ($user->profile_cover != NULL)
             style="background:url({{ asset('storage/images/profiles/cover_images/'.$user->profile_cover) }});background-position: center;
             background-size: cover;"
            @endif
            >

                <!--Timeline Menu for Large Screens-->
                <div class="timeline-nav-bar hidden-sm hidden-xs">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="profile-info">
                                @if ($user->profile_photo != NULL)
                                <img src="{{ asset('storage/images/profiles/user_images/'.$user->profile_photo) }}" alt="" class="img-responsive profile-photo" />
                                @else
                                <img src="http://placehold.it/300x300" alt="" class="img-responsive profile-photo" />
                                @endif

                                <h3>{{$user->first_name}} {{$user->last_name}}</h3>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <ul class="list-inline profile-menu">
                                <li><a href="/home">Timeline</a></li>
                                <li><a href="/profile/edit-basic" class="active">About</a></li>
                                <li><a href="timeline-album.html">Album</a></li>
                                <li><a href="timeline-friends.html">Friends</a></li>
                            </ul>
                            <ul class="follow-me list-inline">
                                <li>23 people following her</li>


                            </ul>
                        </div>
                    </div>
                </div>
                <!--Timeline Menu for Large Screens End-->

                <!--Timeline Menu for Small Screens-->
                <div class="navbar-mobile hidden-lg hidden-md">
                    <div class="profile-info">
                        @if ($user->profile_photo != NULL)
                        <img src="{{ asset('storage/images/profiles/user_images/'.$user->profile_photo) }}" alt="" class="img-responsive profile-photo" />
                        @else
                        <img src="http://placehold.it/300x300" alt="" class="img-responsive profile-photo" />
                        @endif

                        <h4>{{$user->first_name}} {{$user->last_name}}</h4>
                        <p class="text-muted">Creative Director</p>
                    </div>
                    <div class="mobile-menu">
                        <ul class="list-inline">
                            <li><a href="timline.html">Timeline</a></li>
                            <li><a href="timeline-about.html" class="active">About</a></li>
                            <li><a href="timeline-album.html">Album</a></li>
                            <li><a href="timeline-friends.html">Friends</a></li>
                        </ul>
                    </div>
                </div>
                <!--Timeline Menu for Small Screens End-->

            </div>
            <div id="page-contents">

                <div class="row">
                    <div class="col-md-3">
                        <!--Edit Profile Menu-->
                        <ul class="edit-menu">
                            <li class="active"><i class="icon ion-ios-information-outline"></i><a
                                    href="edit-basic">Basic Information</a></li>
                            <li><i class="icon ion-ios-briefcase-outline"></i><a href="edit-work-edu">Education and
                                    Work</a></li>
                            <li><i class="icon ion-ios-heart-outline"></i><a href="edit-interests">My
                                    Interests</a></li>
                                    <li><i class="icon ion-ios-book-outline"></i><a href="edit-interests">My
                                        Bookshelf</a></li>
                            <li><i class="icon ion-ios-settings"></i><a href="edit-settings">Account
                                    Settings</a></li>
                            <li><i class="icon ion-ios-locked-outline"></i><a href="edit-password">Change
                                    Password</a></li>
                        </ul>
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            @include('inc.messages')
                        </div>
                        <!-- Basic Information
              ================================================= -->
                        <div class="edit-profile-container">
                            <div class="block-title">
                                <h4 class="grey"><i class="icon ion-android-checkmark-circle"></i>Edit basic information
                                </h4>
                                <div class="line"></div>
                                <p>You can edit your profile here, Do not forget to click on Submit!</p>


                                <div class="line"></div>
                            </div>
                            <div class="edit-block">
                                <!--  <form name="basic-info" id="basic-info" class="form-inline" method="POST" action="{{ action('HomeController@update') }}"  > -->
                                {!! Form::open(['action' => ['HomeController@update'] , 'method' =>
                                'POST','name'=>"basic-info",'class'=>"form-inline",'enctype' => 'multipart/form-data'])
                                !!}
                                <div class="row">
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('user_image', 'Upload User Image',['class'=>'btn btn-xs btn-primary']) !!} {!! Form::file('user_image',['class'=>'form-control','style'=>'visibility:hidden']) !!}

                                    </div>
                                    <div class="form-group col-xs-4">
                                        {!! Form::label('profile_cover', 'Upload Profile Cover',['class'=>'btn btn-xs btn-primary']) !!} {!! Form::file('profile_cover',['class'=>'form-control','style'=>'visibility:hidden']) !!}
                                    </div>
                                </div>
                                <div class="line"></div>
                                <div class="row">
                                    <h5>Bio</h5>
                                    <textarea id="my-info" name="bio" class="form-control"
                                        placeholder="Some texts about me" rows="3" cols="400">{{$user->bio}}</textarea>
                                </div>
                                <div class="line"></div>
                                <div class="row">
                                    <div class="form-group col-xs-6">
                                        <label for="firstname">First name</label>
                                        <input id="firstname" class="form-control input-group-lg" type="text"
                                            name="firstname" title="Enter first name" placeholder="First name"
                                            value="{{$user->first_name}}" />
                                    </div>
                                    <div class="form-group col-xs-6">
                                        <label for="lastname" class="">Last name</label>
                                        <input id="lastname" class="form-control input-group-lg" type="text"
                                            name="lastname" title="Enter last name" placeholder="Last name"
                                            value="{{$user->last_name}}" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label for="email">My email</label>
                                        <input id="email" class="form-control input-group-lg" type="text" name="Email"
                                            title="Enter Email" placeholder="My Email" value="{{$user->email}}" />
                                    </div>
                                </div>
                                <div class="row">
                                    <p class="custom-label"><strong>Date of Birth</strong></p>
                                    <div class="form-group col-sm-3 col-xs-6">
                                        <label for="day" class="sr-only"></label>
                                        @php
                                        //day list
                                        $daylist=[];
                                        array_push($daylist, 'Day');
                                        for ($i=0; $i < 31; $i++) { array_push($daylist, $i+1); } $selectedDay=0;
                                            $selectedMon=0; $selectedYear=0; @endphp @if ($user->birth_date != NULL)
                                            @php
                                            $selectedDay=(int)$user->birth_date->format('d');
                                            $selectedMon=(int)$user->birth_date->format('m');
                                            $selectedYear=(int)$user->birth_date->format('Y');
                                            @endphp

                                            @endif
                                            {{ Form::select('day',
                                            $daylist, $selectedDay,['class' => 'form-control','id'=>'day'])}}

                                    </div>
                                    <div class="form-group col-sm-3 col-xs-6">
                                        <label for="month" class="sr-only"></label>
                                        {!! Form::selectMonth('month',
                                        $selectedMon, ['placeholder' => 'Month','class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-sm-6 col-xs-12">
                                        <label for="year" class="sr-only"></label>
                                        {!! Form::selectYear('year', 1960, 2012, $selectedYear, ['placeholder' =>
                                        'Year','class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group gender">
                                    <span class="custom-label"><strong>I am a: </strong></span>
                                    <!-- {!!  Form::radio('category_id', '1'); !!} -->
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="M" @if ($user->gender == 'M')
                                        checked
                                        @endif >Male
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="F" @if ($user->gender == 'F')
                                        checked
                                        @endif>Female
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="N" @if ($user->gender == NULL ||
                                        $user->gender == 'N')
                                        checked
                                        @endif>Rather not say
                                    </label>

                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-6">
                                        <label for="city"> My city</label>
                                        <input id="city" class="form-control input-group-lg" type="text" name="city"
                                            title="Enter city" placeholder="Your city" value="Istanbul" />
                                    </div>
                                    <div class="form-group col-xs-6">
                                        <label for="country">My country</label>
                                        @include('inc.country-select')
                                    </div>
                                </div>
                                {{Form::hidden('_method', 'PUT')}}
                                {{csrf_field()}}
                                <button class="btn btn-primary">Save Changes</button>
                                <!-- </form> -->
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <!--Sticky Timeline Activity Sidebar-->
                    @include('inc.activity-sidebar')
                </div>
            </div>
        </div>
    </div>


    @include('inc.footer')

    <!--preloader-->
    <div id="spinner-wrapper">
        <div class="spinner"></div>
    </div>
    <!-- Scripts
    ================================================= -->
    <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery.sticky-kit.min.js')}}"></script>
    <script src="{{asset('js/jquery.scrollbar.min.js')}}"></script>
    <script src="{{asset('js/script.js')}}"></script>

</body>

</html>
