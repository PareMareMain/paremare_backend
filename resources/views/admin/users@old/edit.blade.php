@extends('admin.layouts.adminLayout')
@section('title','User Management')
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
                                <li class="breadcrumb-item active">Edit Station</li>
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
                                <h4>Edit Fuel Station</h4>

                            </div>
                            <div class="card-body mt-3">
                                <div class="basic-form">
                                    <form action="{{route('user.update',$user->id)}}" id="myform" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Name" name="name" value="{{$user->name}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter email" name="email" value="{{$user->email}}" disabled>

                                        </div>
                                        <div class="form-group">
                                            <label>Address 1</label>
                                            <textarea class="form-control input-default" placeholder="Enter address one" name="address_one">{{$user->address_one}}</textarea>
                                            {{-- <input type="text" class="form-control input-default" placeholder="Enter station Address" id="address" name="address" value="{{$user->address}}">
                                            <input type="hidden" name="latitude" id="latitude" value="{{$user->latitude}}">
                                            <input type="hidden" name="longitude" id="longitude" value="{{$user->longitude}}"> --}}
                                        </div>
                                        <div class="form-group">
                                            <label>Address 2</label>
                                            <textarea class="form-control input-default" placeholder="Enter address two" name="address_two">{{$user->address_two}}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Profile Image</label>
                                            <input type="file" class="form-control input-default" name="image">
                                        </div>
                                        @if($user->profile_image)
                                            <div class="form-group edit-img-w">
                                                <img src="{{asset($user->profile_image)}}" alt="Station image">
                                            </div>
                                        @endif
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
                name: {
                    required: true,
                    email: true
                },
                address_one: {
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
@stop
