<!DOCTYPE html>
<html>

<head>
    <!-- favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon.png')}}">
    <!-- title -->
    <title>
        Login Free Bottle &ndash; Vimerson Health
    </title>

    <!-- admin stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin.css')}}">

    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);

        body {
            margin: 0;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
            background-color: #f5f8fa;
        }

        .navbar-laravel {
            box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
            display: none;
        }

        .navbar-brand,
        .nav-link,
        .my-form,
        .login-form {
            font-family: Raleway, sans-serif;
        }

        .my-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .my-form .row {
            margin-left: 0;
            margin-right: 0;
        }

        .login-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .login-form .row {
            margin-left: 0;
            margin-right: 0;
        }
    </style>
</head>

<section class="login-content">
    <div class="container-fluid h-100">
        <div class="row align-items-center justify-content-center h-100">
            <div class="col-md-12 p-0 h-100">
                <div class="card h-100">
                    <div class="row h-100">
                        <div class="col-md-8 pr-md-0">
                            <div class="auth-left-wrapper">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <div class="auth-form-wrapper px-4 py-5">
                                <div class="auth-logo mb-5">
                                    <img src="https://cdn.shopify.com/s/files/1/0971/5718/files/logo.png" class="img-fluid rounded-normal" alt="logo">
                                </div>
                                <h2 class="pt-5 font-weight-bold mb-4">Login</h2>

                                <form action="{{ route('login.post') }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="email_address">Email address</label>
                                        <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                        @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>

                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                        <label class="custom-control-label pl-2" for="remember">Remember me</label>
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary w-100 mr-2 mb-2 mb-md-0 text-white">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>

</html>