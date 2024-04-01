@extends('admin.layouts.adminLayout')
@section('title','Sub Admin Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Sub Admin</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Create</li>
                    <li class="breadcrumb-item active">Sub-Admin</li>
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
                    <form action="{{route('sub-admin.store')}}" id="myform" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="tab-pane active" id="Settings">

                            {{--  <div class="body">
                                <h6>Profile Photo</h6>
                                <div class="media">
                                    <div class="media-left m-r-15">
                                        <img src="{{ asset('admin/assets/images/user.png') }}" class="user-photo media-object" alt="User" id="preview" style="width:140px;height:140px;">
                                    </div>
                                    <div class="media-body">
                                        <p>Upload your photo.
                                            <br> <em>Image should be at least 140px x 140px</em></p>
                                        <div class="btn btn-default uploadButton" id="btn-upload-photo">Upload Photo
                                            <input type="file" name="image" id="image" class="uploadImage">
                                        </div>
                                    </div>
                                </div>
                            </div>  --}}
                            <div class="body">
                                <h6>Basic Information</h6>
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Name" name="name" id="name" value="{{old('name')}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter email" name="email" id="email" value="{{old('email')}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control input-default" placeholder="Enter password" name="password" id="password" value="{{old('password')}}" autocomplete = "new-password">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" align="center">Submit</button>
                            </div>
                        </div>
                    </form>
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
                name: {
                    required: true,
                },
                image: {
                    required: true,
                },
                email: {
                    required:true,
                    email:true,
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
