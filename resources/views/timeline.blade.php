<!DOCTYPE html>
<html lang="en">

<head>
    @include('inc.head')
</head>

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
            <div class="timeline-cover" @if ($user->profile_cover != NULL)
                style="background:url({{ asset('storage/images/profiles/cover_images/'.$user->profile_cover) }});background-position:
                center;
                background-size: cover;"
                @endif
                >

                <!--Timeline Menu for Large Screens-->
                <div class="timeline-nav-bar hidden-sm hidden-xs">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="profile-info">
                                @if ($user->profile_photo != NULL)
                                <img src="{{ asset('storage/images/profiles/user_images/'.$user->profile_photo) }}"
                                    alt="" class="img-responsive profile-photo" />
                                @else
                                <img src="http://placehold.it/300x300" alt="" class="img-responsive profile-photo" />
                                @endif

                                <h3>{{$user->first_name}} {{$user->last_name}}</h3>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <ul class="list-inline profile-menu">
                                <li><a href="timeline.html" class="active">Timeline</a></li>
                                <li><a href="/profile/edit-basic">About</a></li>
                                <li><a href="timeline-album.html">Album</a></li>
                                <li><a href="timeline-friends.html">Friends</a></li>
                            </ul>
                            <ul class="follow-me list-inline">
                                <li>23 people following her</li>

                                @auth
                                @if (Auth::user()->id != $user->id)
                                <!-- if it is not the auth timeline -->
                                <li><button class="btn-primary">Add Friend</button></li>
                                @endif
                                @endauth

                            </ul>
                        </div>
                    </div>
                </div>
                <!--Timeline Menu for Large Screens End-->

                <!--Timeline Menu for Small Screens-->
                <div class="navbar-mobile hidden-lg hidden-md">
                    <div class="profile-info">
                        @if ($user->profile_photo != NULL)
                        <img src="{{ asset('storage/images/profiles/user_images/'.$user->profile_photo) }}" alt=""
                            class="img-responsive profile-photo" />
                        @else
                        <img src="http://placehold.it/300x300" alt="" class="img-responsive profile-photo" />
                        @endif

                        <h4>{{$user->first_name}} {{$user->last_name}}</h4>
                        <p class="text-muted">Creative Director</p>
                    </div>
                    <div class="mobile-menu">
                        <ul class="list-inline">
                            <li><a href="timline.html" class="active">Timeline</a></li>
                            <li><a href="timeline-about.html">About</a></li>
                            <li><a href="timeline-album.html">Album</a></li>
                            <li><a href="timeline-friends.html">Friends</a></li>
                        </ul>
                        @auth
                        @if (Auth::user()->id != $user->id)
                        <!-- if it is not the auth timeline -->
                        <li><button class="btn-primary">Add Friend</button></li>
                        @endif
                        @endauth
                    </div>
                </div>
                <!--Timeline Menu for Small Screens End-->

            </div>
            <div id="page-contents">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-7">

                        <!-- Post Create Box
              ================================================= -->
                        @auth
                        @if (Auth::user()->id == $user->id)

                        <div class="create-post">
                            <div class="row">
                                <div class="col-md-7 col-sm-7">
                                    <div class="form-group">
                                        @if ($user->profile_photo != NULL)
                                        <img src="{{ asset('storage/images/profiles/user_images/'.$user->profile_photo) }}"
                                            alt="" class="profile-photo-md" />
                                        @else
                                        <img src="http://placehold.it/300x300" alt="" class="profile-photo-md" />
                                        @endif

                                        <textarea name="texts" id="exampleTextarea" cols="30" rows="1"
                                            class="form-control" placeholder="Write what you wish"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-5">
                                    <div class="tools">
                                        <ul class="publishing-tools list-inline">
                                            <li><a href="#"><i class="ion-compose"></i></a></li>
                                            <li><a href="#"><i class="ion-images"></i></a></li>
                                            <li><a href="#"><i class="ion-ios-videocam"></i></a></li>
                                            <li><a href="#"><i class="ion-map"></i></a></li>
                                        </ul>
                                        <button class="btn btn-primary pull-right">Publish</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <br><br><br>
                        @endif
                        @endauth
                        @guest
                        <br><br><br>
                        @endguest

                        <!-- Post Create Box End-->
                        @if(count($user->posts)>0)
                        @foreach ($user->posts as $post)

                        <!-- Post Content
              ================================================= -->
                        <div class="post-content">

                            <!--Post Date-->
                            <div class="post-date hidden-xs hidden-sm">
                                <h5>{{$user->first_name}}</h5>
                                <p class="text-grey">
                                    {{$post->updated_at->format('d M y')}}<br>{{$post->updated_at->format('H:i a')}}</p>
                            </div>
                            <!--Post Date End-->

                            @if ($post->attachment != NULL)
                            <img src="{{ asset('storage/images/post_images/'.$post->attachment)}}" alt="post-image"
                                class="img-responsive post-image" />
                            <!--<img src="http://placehold.it/1920x1280" alt="post-image"
                                class="img-responsive post-image" /> -->
                            @endif

                            <div class="post-container">
                                @if ($user->profile_photo != NULL)
                                <img src="{{ asset('storage/images/profiles/user_images/'.$user->profile_photo) }}"
                                    alt="user" class="profile-photo-md pull-left" />
                                @else
                                <img src="http://placehold.it/300x300" alt="user" class="profile-photo-md pull-left" />
                                @endif

                                <div class="post-detail">
                                    <div class="user-info">
                                        <h5>

                                            @auth
                                            @if (Auth::user()->id != $user->id)
                                            <a href="timeline" class="profile-link">{{$user->first_name}}
                                                {{$user->last_name}}</a>
                                            <span class="following">following</span>
                                            @else
                                            <a href="/user_{{$user->id}}/timeline" class="profile-link">{{$user->first_name}}
                                                {{$user->last_name}}</a>
                                            @endif
                                            @endauth
                                        </h5>

                                    </div>
                                    <div class="reaction">
                                        <a class="btn text-green"><i class="icon ion-thumbsup"></i> 13</a>
                                        <a class="btn text-red"><i class="fa fa-thumbs-down"></i> 0</a>
                                    </div>
                                    <div class="line-divider"></div>
                                    @if($post->content != NULL)
                                    <div class="post-text">
                                        <p>{{$post->content}}
                                            <i class="em em-anguished"></i></p>
                                    </div>
                                    <div class="line-divider"></div>
                                    @endif

                                    <div class="post-comment">
                                        <img src="http://placehold.it/300x300" alt="" class="profile-photo-sm" />
                                        <p><a href="timeline.html" class="profile-link">Diana </a><i
                                                class="em em-laughing"></i> Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                                            aliqua. Ut enim ad minim veniam, quis nostrud </p>
                                    </div>
                                    <div class="post-comment">
                                        <img src="http://placehold.it/300x300" alt="" class="profile-photo-sm" />
                                        <p><a href="timeline.html" class="profile-link">John</a> Lorem ipsum dolor sit
                                            amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud </p>
                                    </div>
                                    <div class="post-comment">
                                        <img src="http://placehold.it/300x300" alt="" class="profile-photo-sm" />
                                        <input type="text" class="form-control" placeholder="Post a comment">
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                        @endif
                        <!--Post End-->

                    </div>
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
