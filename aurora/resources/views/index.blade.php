<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurora | Home</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon-16x16.png">
    <link rel="manifest" href="../assets/img/site.webmanifest">
    <script src="https://kit.fontawesome.com/75daafee80.js" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/welcome.css')}}">

</head>

<body>
    <div id="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <h1 id="logo">Aurora</h1>
                </div>
                <div class="col-md-6">
                    <ul id="nav">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-3 d-flex justify-content-end align-items-center">
                    <div class="register-login">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/home') }}" class="">Home</a>
                            @else
                                <a href="{{ route('login') }}" class="btn-sign-in">Sign In</a>
        
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn-sign-up">Sign Up</a>
                                @endif
                            @endauth
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner section -->
    <div id="banner" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="banner-title">
                        <h2 class="title">Some Heading goes here</h2>
                        <p class="lead">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde sit, excepturi
                            quaerat illo</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- services section -->
    <div class="background">
        <div class="container section">
            <div class="row">
            <div class="col-md-12">
                <h2 class="section-head">Our Services</h2>
            </div>

                <div class="col-sm-6 col-md-4">
                    <div class="box-section">
                        <i class="fa-solid fa-paper-plane"></i>
                        <h3>Some Heading</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius, nam?</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="box-section">
                        <!-- <i class="fa fa-anchor"></i> -->
                        <i class="fa-solid fa-paperclip"></i>
                        <!-- <i class="fa-solid fa-rocket-launch"></i> -->
                        <h3>Some Heading</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius, nam?</p>
                    </div>
                </div>
                <div class=" col-sm-6 col-md-4">
                    <div class="box-section">
                        <i class="fa-solid fa-computer"></i>
                        <h3>Some Heading</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius, nam?</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Testimonials section -->
    <div id="Testimonial" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-head text-white">Testimonials</h2>
                </div>
                <div class="col-md-6">
                    <div class="testimonials">
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quisquam quo aperiam veritatis.
                            Neque, aut nihil.</p>
                        <img src="{{asset('assets/img/welcome-images/Bill gates.jpg')}}" alt="Bill gates">
                        <div class="auther">Bill gates</div>
                        <div class="company">Microsoft</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="testimonials">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae dicta repudiandae cupiditate
                            ratione consequuntur autem!</p>
                        <img src="{{asset('assets/img/welcome-images/Steve jobs.jpg')}}" alt="Steve jobs">
                        <div class="auther">Steve jobs</div>
                        <div class="company">Apple</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- News section -->
    <div class="background">
        <div id="news" class="section container">
            <div class="row">
            <div class="col-md-12">
                <h2 class="section-head">Recent News</h2>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="news-post">
                    <img src="{{asset('assets/img/welcome-images/news-1.jpg')}}" alt="">
                    <div class="news-body">
                        <h3><a href="#">News Heading 1</a></h3>
                        <div class="post-date">March,26,2023</div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi, natus?</p>
                        <a href="#" class="readmore">Readmore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="news-post">
                    <img src="{{asset('assets/img/welcome-images/news-2.jpg')}}" alt="">
                    <div class="news-body">
                        <h3><a href="#">News Heading 2</a></h3>
                        <div class="post-date">March,26,2023</div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi, natus?</p>
                        <a href="#" class="readmore">Readmore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="news-post">
                    <img src="{{asset('assets/img/welcome-images/news-3.jpg')}}" alt="">
                    <div class="news-body">
                        <h3><a href="#">News Heading 3</a></h3>
                        <div class="post-date">March,26,2023</div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi, natus?</p>
                        <a href="#" class="readmore">Readmore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="news-post">
                    <img src="{{asset('assets/img/welcome-images/news-4.jpg')}}" alt="">
                    <div class="news-body">
                        <h3><a href="#">News Heading 4</a></h3>
                        <div class="post-date">March,26,2023</div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi, natus?</p>
                        <a href="#" class="readmore">Readmore</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Footer widgets -->
    <div id="footer-sidebar">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="footer-widgets">
                        <h4>About Company</h4>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nobis natus quis vero animi debitis
                            ad.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum, numquam!</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="footer-widgets">
                        <h4>Latest News</h4>
                        <ul id="footer-menu">
                            <li><a href="#">Lorem ipsum dolor sit amet consectetur.</a></li>
                            <li><a href="#">Lorem ipsum dolor sit amet consectetur.</a></li>
                            <li><a href="#">Lorem ipsum dolor sit amet consectetur.</a></li>
                            <li><a href="#">Lorem ipsum dolor sit amet consectetur.</a></li>
                            <li><a href="#">Lorem ipsum dolor sit amet consectetur.</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="footer-widgets">
                        <h4>Company Address</h4>
                        <address>
                            <b>Sami Zafar,Inc.</b><br>
                            #block-12, #house-66, Khanewal<br>
                            Punjab, Pakistan<br>
                            ph: 03000781788
                        </address>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <div id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">copyright@2023 | Sami Zafar,Inc.</div>
                <div class="col-md-6">
                    <ul id="social-menu" class="float-md-right">
                        <li><a href="#"><i class="fa-brands fa-square-facebook"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-square-twitter"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>