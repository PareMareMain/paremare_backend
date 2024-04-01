@extends('admin.layouts.adminLayout')
@section('title','User Management')
@section('content')


{{--  =======>  --}}
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Edit Profile</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Edit</li>
                    <li class="breadcrumb-item active">User Profile</li>
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
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                </div>
                <div class="tab-content">
                    <form action="{{route('user.update',$user->id)}}" id="myform" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="tab-pane active" id="Settings">

                            <div class="body">
                                <h6>Logo</h6>
                                <div class="media">
                                    <div class="media-left m-r-15">
                                        @if($user->profile_image)
                                            <img src="{{ $user->profile_image }}" class="user-photo media-object" alt="User" id="preview" style="width:140px;height:140px;">
                                        @else
                                            <img src="{{ asset('admin/assets/images/user.png') }}" class="user-photo media-object" alt="User" id="preview" style="width:140px;height:140px;">
                                        @endif
                                    </div>
                                    <div class="media-body">
                                        <p>Upload your Logo.
                                            <br> <em>Image should be at least 140px x 140px</em></p>
                                        <div class="btn btn-default uploadButton" id="btn-upload-photo">Upload Logo
                                        <input type="file" name="image" id="image" class="uploadImage"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="body">
                                <h6>Basic Information</h6>
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control " placeholder="Enter Name" name="name" value="{{$user->name}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control " placeholder="Enter email" name="email" value="{{$user->email}}" disabled>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Address 1</label>
                                            <textarea class="form-control " placeholder="Enter address one" name="address_one">{{$user->address_one}}</textarea>
                                            {{-- <input type="text" class="form-control " placeholder="Enter station Address" id="address" name="address" value="{{$user->address}}">
                                            <input type="hidden" name="latitude" id="latitude" value="{{$user->latitude}}">
                                            <input type="hidden" name="longitude" id="longitude" value="{{$user->longitude}}"> --}}
                                        </div>
                                        <div class="form-group">
                                            <label>Address 2</label>
                                            <textarea class="form-control " placeholder="Enter address two" name="address_two">{{$user->address_two}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" align="center">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>





{{--  <========  --}}
@stop
@section('scripts')
<script>
    $(document).ready(function () {

        $('#myform').validate({ // initialize the plugin
            rules: {
                name: {
                    required: true,
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
<script type="text/javascript">

    $(document).ready(function (e) {
       $('#image').change(function(){

        let reader = new FileReader();

        reader.onload = (e) => {

          $('#preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);

       });

    });

</script>
@stop
