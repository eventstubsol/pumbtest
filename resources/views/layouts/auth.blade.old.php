<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.ico">

        @yield('styles')
        
		<!-- App css -->
		<link href="{{ asset('assets/css/bootstrap-purple.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
		<link href="{{ asset('assets/css/app-purple.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

		<!-- icons -->
		<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

        @yield('styles_after')
    </head>

    <body>
        
         <body class="loading authentication-bg authentication-bg-pattern">
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <div class="auth-logo">
                                        <a href="{{ route('login') }}" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="x" alt="APPLICATION LOGO HERE" height="22">
                                            </span>
                                        </a>
                    
                                        <a href="{{ route("event") }}" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="../assets/images/logo-light.png" alt="" height="22">
                                            </span>
                                        </a>
                                    </div>
                                    <p class="text-muted mb-4 mt-3">@yield('muted-text')</p>
                                </div>
                                
                                @yield('form')

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
                        

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p> <a href="@yield('footer-route')" class="{{ ($notFound ?? '') ? 'text-white' : 'text-white-50' }} ml-1">@yield('footer-text')</a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        @yield("extra")

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->


        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/app.min.js') }}"></script>
        
    </body>
</html>