<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin: login</title>

    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">

    <!-- Styles -->
    <link href="{{asset('admin/css/lib/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/lib/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/lib/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/lib/helper.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <style>
        .login-logo span{
            color:#000 !important;
        }
        .login-form{
            background: #d5d5d5 !important;
        }
        .bg-primary{
            background: #fff !important;
        }

    </style>
</head>

<body class="bg-primary">

    <div class="unix-login">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="index.html"><span>ClubJ</span></a>
                        </div>
                        <div class="login-form">
                            <h4>Admin Login</h4>
                            <form id="myform" method="post" action="{{route('login')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Email address</label>
                                    <input type="email" class="form-control" placeholder="Email" name="email">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password">
                                </div>
                                {{-- <div class="checkbox">
                                    <label>
										<input type="checkbox"> Remember Me
									</label>
                                    <label class="pull-right">
										<a href="#">Forgotten Password?</a>
									</label>

                                </div> --}}
                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('admin/js/lib/jquery.min.js')}}"></script>
    <script src="{{asset('admin/js/lib/jquery-validation/dist/jquery.validate.js')}}"></script>
    <script src="{{asset('admin/js/lib/jquery-validation/dist/additional-methods.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script>
        $(document).ready(function() {
            toastr.options.timeOut = 1000;
            @if (Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @elseif(Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif
        });

    </script>
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
