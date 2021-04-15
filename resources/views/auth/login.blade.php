<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.application.partials._head')
        @yield('styles')
    </head>
    <body  class="bg-gradient-primary">
        <div id="app">
            <div class="container">
                <!-- Outer Row -->
                <div class="row justify-content-center">

                    <div class="col-xl-10 col-lg-12 col-md-9">

                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                    <div class="col-lg-6">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">¡Bienvenido a Club Dar!</h1>
                                            </div>
                                            <form autocomplete="off" method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <input type="email" class="form-control form-control-user  @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}"  aria-describedby="emailHelp" placeholder="Correo elctrónico">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="password" name="password" placeholder="Contraseña" required autocomplete="current-password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox small">
                                                        <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="remember">Recuerdame</label>
                                                    </div>

                                                </div>
                                                <button type="submit" class="btn btn btn-user btn-block" style="background-color: #00A1E3;color: #FFF;">
                                                    Ingresar
                                                </button>
                                                <hr>
                                                <!--<a href="index.html" class="btn btn-google btn-user btn-block">
                                                    <i class="fab fa-google fa-fw"></i> Login with Google
                                                </a>
                                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                                    <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                                </a> -->
                                            </form>
                                            <!-- <hr>
                                             <div class="text-center">
                                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                                            </div>
                                            <div class="text-center">
                                                <a class="small" href="register.html">Create an Account!</a>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('js/app.js')}}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- js templates functions -->
    <script src="{{asset('js/sb-admin-2.js')}}"></script>

    </body>
</html>
