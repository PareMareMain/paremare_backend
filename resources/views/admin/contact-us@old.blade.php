@extends('admin.layouts.adminLayout')
@section('title','Setting')
@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            {{-- <h1>Hello, <span>Welcome Here</span></h1> --}}
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Contact Us</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
            </div>
            <!-- /# row -->
            <section id="main-content">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-title">
                                <h4>Edit Contact Us</h4>

                            </div>
                            <div class="card-body mt-3">
                                <div class="basic-form">
                                    <form action="{{ route('contactUs') }}" id="myform" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Phone Number" name="phone" id="phone" value="{{ $data->phone }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Email Address" name="email" id="email" value="{{ $data->email }}">

                                        </div>
                                        <button type="submit" class="btn btn-default mt-4">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script>
    $(document).ready(function () {

        $('#myform').validate({ // initialize the plugin
            rules: {
                phone: {
                    required: true,
                },
                email: {
                    required:true,
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
@stop
