<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!--  <script src="{{ asset('js/app.js') }}" defer></script> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">
   
    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('dropzone/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dropzone/basic.min.css') }}">
    <link href="{{ asset('toastr/toastr.css') }}" rel="stylesheet" type="text/css">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!--admin template-->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/iconkit.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-jvectormap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toast.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/modernizr-2.8.3.min.js') }}"></script>

    <style>
        .custom-file-label::after {
           content: "Elegir" !important
       }
   </style>

    <!-- Styles 
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
    </head>
    <body>
       <div id="app">
        <div class="wrapper">
            <header class="header-top" header-theme="light">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <div class="top-menu d-flex align-items-center">
                            <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>

                            <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button>
                        </div>
                        <div class="top-menu d-flex align-items-center">


                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <img class="avatar" src="{{ asset('img/logueado.png') }}" alt="">




                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                    @guest
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                    @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                    @endif
                                    @else
                                    <a class="dropdown-item" style="text-transform: lowercase;"><i class="ik ik-user dropdown-icon"></i>{{ Auth::user()->name   }} </a>
                                    <!--
                                        <a class="dropdown-item" href=""><i class="ik ik-settings dropdown-icon"></i> Mi Cuenta</a>-->



                                        <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="ik ik-power dropdown-icon"></i> Cerrar sesión
                                           <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form></a>
                                    </div>
                                </div>
                                @endguest

                            </div>
                        </div>
                    </div>
                </header>

                <div class="page-wrap">
                    <div class="app-sidebar colored">
                        <div class="sidebar-header">
                            <a class="header-brand" href="index.html">
                                <span class="text">Upa llanos</span>
                            </a>
                            <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
                            <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
                        </div>
                        <div class="sidebar-content">
                            <div class="nav-container">
                                <nav id="main-menu-navigation" class="navigation-main">

                                    <div class="nav-item active">
                                        <a href="{{route('empresas.create')}}"><i class="ik ik-menu
                                            "></i><span>Inicio</span></a>
                                        </div>

                                        <div class="nav-item">





                                            @if(Auth::user()->rol=='is_admin_rol')
                                            <a href="{{route('nosotrosAdmin.index')}}"><i class="ik users ik-users
                                                "></i><span>Nosotros</span></a>
                                                <a href="{{route('categoria.index')}}"><i class="ik grid ik-grid
                                                    "></i><span>Categorías</span></a>
                                                    <a href="{{route('subcategoria.index')}}"><i class="ik layers ik-layers
                                                        "></i><span>Subcategorías</span></a>
                                                        <a href="{{route('departamento.index')}}"><i class="ik map ik-map
                                                            "></i><span>Departamentos</span></a>
                                                            <a href="{{route('ciudad.index')}}"><i class="ik map-pin ik-map-pin
                                                                "></i><span>Ciudades</span></a>
                                                                <a href="{{route('publicidad.index')}}"><i class="ik edit ik-edit
                                                                    "></i><span>Publicidad</span></a>

                                                                    <a href="{{route('empresas.index')}}"><i class="ik file-text ik-file-text
                                                                        "></i><span>Empresas</span></a>

                                                                      <a href="{{route('promocion.index')}}"><i class="ik shopping-cart ik-shopping-cart
                                                                        "></i><span>Promociones</span></a>


                                                                        @endif


                                                                        @php
                                                                        $empresa=App\Empresa::where('user_id',Auth::user()->id)->first();

                                                                    @endphp

                                                                    @if(Auth::user()->rol!='is_admin_rol')

                                                                    @if($empresa)


                                                                    <a href="{{route('promocion.index')}}"><i class="ik shopping-cart ik-shopping-cart
                                                                        "></i><span>Promociones</span></a>
                                                                        @endif
                                                                         @endif

                                                                    </div>


<!--
                                                <div class="nav-item has-sub">
                                                    <a href="javascript:void(0)"><i class="ik ik-settings"></i><span>Administración</span></a>
                                                    <div class="submenu-content">

                                                        <a href="" class="item-link">Datos de la institución</a>


                                                        <a href="" class="item-link">Roles</a>
                                                        <a href="" class="item-link">Usuarios</a>



                                                    </div>
                                                </div>
                                            -->


                                            <div class="nav-item">

                                                <a  href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="ik ik-power dropdown-icon"></i> {{ __('Logout') }}

                                                </a>

                                            </div>


                                        </nav>
                                    </div>
                                </div>
                            </div>
                                        <!--
                                        @can('Ver chat')

                                        <chat :user-id="{{auth()->id()}}"/> </chat>
                                        @endcan
                                    -->

                                    @yield('content')


                                </div>

                                <footer class="footer">
                                    <div class="w-100 clearfix">
                                        <span class="text-center text-sm-left d-md-inline-block">Copyright © 2020 Ing:Edwin Guerrero</span>

                                    </div>
                                </footer>

                            </div>
                        </div>
                        
                        <script  src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
                        <script  src="{{ asset('js/bootstrap.min.js') }}"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
                       

                      
                        <script  src="{{ asset('js/bootstrap-select.min.js') }}"></script>

                        <!--<script src="{{asset('dropzone/dropzone.min.js')}}"></script>-->
                        <script src="{{asset('dropzone/dropzone-menu.js')}}"></script>

                        <script src="{{ asset('toastr/toastr.js')}}" type="text/javascript"></script>

                        <script  src="{{ asset('js/popper.min.js') }}"></script>
                        
                        <script  src="{{ asset('js/perfect-scrollbar.min.js') }}"></script>
                        <script  src="{{ asset('js/screenfull.js') }}"></script>
                        <script  src="{{ asset('js/theme.min.js') }}"></script>
                        <script  src="{{ asset('js/toast.min.js') }}"></script>
                        <script  src="{{ asset('js/toastr.min.js') }}"></script>
                        <script  src="{{ asset('js/virtual-key.js') }}"></script>




                        <script>


                            @if(Session::has('message'))
                            var type="{{Session::get('alert-type','info')}}"

                            switch(type){
                             case 'info':
                             toastr.info("{{ Session::get('message') }}");
                             break;
                             case 'success':
                             toastr.success("{{ Session::get('message') }}");
                             break;
                             case 'warning':
                             toastr.warning("{{ Session::get('message') }}");
                             break;
                             case 'error':
                             toastr.error("{{ Session::get('message') }}");
                             break;
                         }
                         @endif

                         Dropzone.options.dropzonegaleria = {
                            addRemoveLinks : true,
                            uploadMultiple: false,
                            paramName: "url",
                            maxFilezise: 10,
                            maxFiles: 3,
                            acceptedFiles: "image/png, image/jpeg",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            init: function() {
                                this.on("error", function(file, response) {
                                    if(response.message) {
                                       toastr.error(response.message);
                                   }


                               });

                            }

                        };
                        //Menú-portafolio
                        Dropzone.options.dropzonemenu = {
                            addRemoveLinks : true,
                            uploadMultiple: false,
                            paramName: "file",
                            maxFilezise: 10,
                            maxFiles: 10,
                            acceptedFiles: "image/png, image/jpeg",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            init: function() {
                                this.on("error", function(file, response) {
                                    if(response.message) {
                                       toastr.error(response.message);
                                   }


                               });

                            }

                        };


                        /*

                        $('#delete').on('show.bs.modal', function (event) {
                          var button = $(event.relatedTarget) 
                          var id = button.data('id')
                          var action = button.data('action')  
                          var modal = $(this)
                          modal.find('.modal-body #id').val(id);
                          modal.find('form').attr("action", action)
                      });
                      */

                  </script>
              </body>
              </html>
