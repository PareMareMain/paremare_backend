@extends('facilities.layouts.vendorLayout')
@section('title','Change Password')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>{{__("Change Password")}}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    {{-- <li class="breadcrumb-item"></li> --}}
                    <li class="breadcrumb-item active">{{__("Change Password")}}</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                    </div>
                    <div class="p-2 d-flex">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-9 col-md-12">
            <div class="card">
                <div class="card-title">


                </div>
                <div class="card-body mt-3">
                    <div class="basic-form">
                        <form action="{{route('vendor.change_password')}}" id="myform" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>{{__("Old Password")}}</label>
                                <input type="password" class="form-control input-default" placeholder="{{__('Enter Old Password')}}" name="oldpassword" id="oldpassword" value="{{old('name')}}">
                            </div>
                            <div class="form-group">
                                <label>{{__("New Password")}}</label>
                                <input type="password" class="form-control input-default" placeholder="{{__('Enter New Password')}}" name="newpassword" id="newpassword" value="{{old('newpassword')}}">
                            </div>
                            <div class="form-group">
                                <label>{{__('Confirm New Password')}}</label>
                                <input type="password" class="form-control input-default" placeholder="{{__('Confirm your new password')}}" name="cpassword" id="cpassword" value="{{old('cpassword')}}">
                            </div>
                            <button type="submit" class="btn btn-default mt-4">{{__('Update')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script>
    $(document).ready(function () {

        $('#myform').validate({ // initialize the plugin
            rules: {
                oldpassword: {
                    required: true,
                },
                newpassword: {
                    required: true,
                },
                cpassword: {
                    required: true,
                    equalTo:'#newpassword'
                },
            },
            messages: {
                oldpassword: {
                    required: "{{__('This field is required.')}}",
                },
                newpassword: {
                    required: "{{__('This field is required.')}}",
                },
                cpassword: {
                    required: "{{__('This field is required.')}}",
                    equalTo:"{{__('Password and confirm password should be same.')}}"
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
