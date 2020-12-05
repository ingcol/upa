<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="{{asset('js/app.js') }}" defer></script> 
    <link rel="stylesheet" href="{{ asset('css/web/animate-3.7.0.css')}}">
    <link rel="stylesheet" href="{{ asset('css/web/font-awesome-4.7.0.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/web/flat-icon/flaticon.css')}}">
    <link rel="stylesheet" href="{{ asset('css/web/bootstrap-4.1.3.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/web/owl-carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/web/nice-select.css')}}">
    <link rel="stylesheet" href="{{ asset('css/web/style.css')}}">
</head>
<body style="background: #f7f7f7; overflow-x: hidden;">
    <div id="app">

        <!-- Preloader Starts -->
        <div class="preloader">
            <div class="spinner"></div>
        </div>
        <!-- Preloader End -->

        <!-- 
        <header class="header-area single-page" style="background-image:url('{{ asset('img/header.jpg')}}">
            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="logo-area">
                                <a href="index.html"><img src="{{ asset('img/logo.png') }}" alt="logo"></a>
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div class="custom-navbar">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>  
                            <div class="main-menu main-menu-light">
                                <ul>
                                    <li class="active"><a href="index.html">home</a></li>
                                    <li><a href="about.html">about us</a></li>
                                    <li><a href="job-category.html">category</a></li>
                                    <li><a href="#">blog</a>
                                        <ul class="sub-menu">
                                            <li><a href="blog-home.html">Blog Home</a></li>
                                            <li><a href="blog-details.html">Blog Details</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact-us.html">contact</a></li>
                                    <li><a href="#">pages</a>
                                        <ul class="sub-menu">
                                            <li><a href="job-search.html">Job Search</a></li>
                                            <li><a href="job-single.html">Job Single</a></li>
                                            <li><a href="pricing-plan.html">Pricing Plan</a></li>
                                            <li><a href="elements.html">Elements</a></li>
                                        </ul>
                                    </li>
                                    <li >
                                        <a href="#" class="login">Login</a>
                                        <a href="#" class="btn btn-danger btn-sm rounded ">Registrarse</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-title text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <h2>Bienvenido a upa llanos</h2>
                            <p>Líderes en directorios</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>Header Area Starts -->

        
<header class="bg-white" style="box-shadow: 0 0 5px #ccc">
        <div class="header-area blog-menu">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="logo-area">
                          
                            <a href="index.html"><img src="{{ asset('img/logo.png') }}" alt="logo"></a>
                           
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="custom-navbar">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>  
                        <div class="main-menu">
                            <ul>
                                <li class="active"><a href="{{route('web.index')}}">Inicio</a></li>
                                <li><a href="{{route('nosotros.index')}}">Nosotros</a></li>
                                
                                <li><a  href="{{route('contacto.index')}}">Contacto</a></li>
                                <!--
                                <li><a href="#">pages</a>
                                    <ul class="sub-menu">
                                        <li><a href="job-search.html">Job Search</a></li>
                                        <li><a href="job-single.html">Job Single</a></li>
                                        <li><a href="pricing-plan.html">Pricing Plan</a></li>
                                        <li><a href="elements.html">Elements</a></li>
                                    </ul>
                                </li>
                            -->
                             <li><a  href="{{route('login')}}">Ingresar</a></li>
                                <li class="menu-btn">
                                    <!--<a href="#" class="login">log in</a>-->
                                    <a href="{{route('register')}}" style="padding:  4px 16px; border-radius: 20px; background: #ff9902;" class="text-white">Registrarse</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    


        
        @yield('content')

        <!--footer-->
      


    </div>
    

    <script src="{{ asset('js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/web/vendor/jquery-2.2.4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="{{ asset('js/web/vendor/bootstrap-4.1.3.min.js')}}"></script>
    <script src="{{ asset('js/web/vendor/wow.min.js')}}"></script>
    <script src="{{ asset('js/web/vendor/owl-carousel.min.js')}}"></script>

    <script src="{{ asset('js/web/vendor/ion.rangeSlider.js')}}"></script>
    <script src="{{ asset('js/web/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>



    </html>