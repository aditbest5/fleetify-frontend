<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>SignIn Boxed | CORK - Multipurpose Bootstrap Dashboard Template </title>
    <link rel="icon" type="image/x-icon" href="{{asset('template/assets/img/favicon.ico')}}"/>
    <link href="{{asset('layouts/modern-light-menu/css/light/loader.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('layouts/modern-light-menu/css/dark/loader.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('layouts/modern-light-menu/loader.js')}}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{asset('template/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    
    <link href="{{asset('layouts/modern-light-menu/css/light/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('template/assets/css/light/authentication/auth-boxed.css')}}" rel="stylesheet" type="text/css" />
    
    <link href="{{asset('layouts/modern-light-menu/css/dark/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('template/assets/css/dark/authentication/auth-boxed.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    
</head>
<body class="form">

    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">
    
            <div class="row">
    
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">
    
                            <div class="row">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <form action="{{ route('dosignup') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12 mb-3">
                                    
                                        <h2>Sign Up</h2>
                                        <p>Enter your email and password to register</p>
                                        
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control add-billing-address-input">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" name="address" class="form-control add-billing-address-input">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <div class="form-check form-check-primary form-check-inline">
                                                <input class="form-check-input me-3" type="checkbox" id="form-check-default">
                                                <label class="form-check-label" for="form-check-default">
                                                    I agree the <a href="javascript:void(0);" class="text-primary">Terms and Conditions</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-secondary w-100">SIGN UP</button>
                                        </div>
                                    </div>
                                </form>
                                

                                <div class="col-12">
                                    <div class="text-center">
                                        <p class="mb-0">Already have an account ? <a href="{{route('login')}}" class="text-warning">Sign in</a></p>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>

    </div>
    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{asset('template/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->


</body>
</html>