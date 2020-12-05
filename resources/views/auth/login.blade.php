@extends('layouts.app_login')

@section('content')
<div class="auth-wrapper">
    <div class="container-fluid h-100">
        <div class="row flex-row h-100 bg-white">
            <div class="col-xl-8 col-lg-6 col-md-5 p-0 d-md-block d-lg-block d-sm-none d-none">

                <div class="lavalite-bg" style="background-image: url('{{ asset('img/upa.jpg') }}">
                    <div class="lavalite-overlay-login"></div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0">
                <div class="authentication-form mx-auto">
                    <div class="text-center">
                        <!--<img src="{{ asset('img/logo.png') }}" alt="">-->
                    </div>
                    <br>
                    <h3 class="text-center">Bienvenido a upa llanos</h3>
                    <br>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <input id="email" type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required>
                            <i class="ik ik-user"></i>
                            @if ($errors->has('email'))
                            <span class="help-block">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                          @endif
                      </div>
                      <div class="form-group">
                         <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">

                         @error('password')
                         <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <i class="ik ik-lock"></i>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn form-control form-bg-warning"> <i class="ik ik-arrow-up-circle"></i> Ingresar</button>
                    </div>

                    <div class="sign-btn text-left">

                        @if (Route::has('password.request'))
                        <a class="text-left" href="{{ route('password.request') }}">
                            ¿Olvido su contraseña?
                        </a>
                        @endif
                    </label>
                </div>



            </form>

        </div>

    </div>
</div>
</div>
</div>
@endsection