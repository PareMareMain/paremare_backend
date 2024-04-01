<!doctype html>
<html lang="en">

<head>
<title>Vendor :: Login</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Iconic Bootstrap 4.5.0 Admin Template">
<meta name="author" content="WrapTheme, design by: ThemeMakker.com">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/font-awesome/css/font-awesome.min.css') }}">

<!-- MAIN CSS -->
<link rel="stylesheet" href="{{ asset('admin/assets/css/main.css') }}">
<style>
    .error{
        color:brown;
    }
    .auth-box .top img {
        width: 60%;
        margin-bottom: -47px;
    }
</style>
</head>

<body data-theme="light" class="font-nunito">
	<!-- WRAPPER -->
	<div id="wrapper" class="theme-cyan">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle auth-main realestate">
				<div class="auth-box">

					<div class="card">
                        <div class="top" align="center">
                            {{--  <img src="{{ asset('admin/assets/images/logo-white.svg') }}" alt="Iconic">  --}}
                            <img src="{{ asset('/new_logo_tag.png') }}" alt="Iconic">
                            {{--  <h1>ClubJ</h1>  --}}
                        </div>
                        <div class="header">
                            <p class="lead">Login to your account</p>
                        </div>
                        <div class="body">
                            <form class="form-auth-small" id="myform" method="post" action="{{route('vendor.login')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="signin-email" class="control-label sr-only">Email</label>
                                    <input type="email" class="form-control" name="email" id="signin-email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="signin-password" class="control-label sr-only">Password</label>
                                    <input type="password" class="form-control" id="signin-password" name="password" placeholder="Password">
                                </div>
                                {{--  <div class="form-group clearfix">
                                    <label class="fancy-checkbox element-left">
                                        <input type="checkbox">
                                        <span>Remember me</span>
                                    </label>
                                </div>  --}}
                                <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                                {{--  <div class="bottom">
                                    <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="page-forgot-password.html">Forgot password?</a></span>
                                    <span>Dont have an account? <a href="page-register.html">Register</a></span>
                                </div>  --}}
                            </form>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
    <script src="{{asset('admin@old/js/lib/jquery.min.js')}}"></script>
    <script src="{{asset('admin@old/js/lib/jquery-validation/dist/jquery.validate.js')}}"></script>
    <script src="{{asset('admin@old/js/lib/jquery-validation/dist/additional-methods.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script>
        $(document).ready(function () {

            $('#myform').validate({ // initialize the plugin
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                    },
                },
                // submitHandler: function(form) {
                //     $.ajax({
                //         url: form.action,
                //         type: form.method,
                //         data: $(form).serialize(),
                //         success: function(response) {
                //             if(response.status==true){
                //                 window.location.href="{{route('dashboard')}}";
                //             }
                //             //window.location.reload()
                //         }
                //     });
                // }
            });

        });
        </script>
</body>
</html>
