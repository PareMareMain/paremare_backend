@extends('admin.layouts.adminLayout')
@section('title','User Management')
@section('content')
<style>
    .cross-pos {
        position: absolute;
        right: 10px;
        top: 10px;
    }
    #imgAppend div{
        position: relative;
        margin-block: 10px;
    }
    </style>
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Vendor</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Edit</li>
                    <li class="breadcrumb-item active">Vendor</li>
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
                    <form action="{{route('vendor.store')}}" id="myform" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="tab-pane active" id="Settings">

                            <div class="body">
                                <h6>Logo</h6>
                                <div class="media">
                                    <div class="media-left m-r-15">
                                        <img src="{{ asset('admin/assets/images/user.png') }}" class="user-photo media-object" alt="User" id="preview" style="width:140px;height:140px;">
                                    </div>
                                    <div class="media-body">
                                        <p>Upload your logo.
                                            <br> <em>Image should be at least 140px x 140px</em></p>
                                        <div class="btn btn-default uploadButton" id="btn-upload-photo">Upload logo
                                            <input type="file" name="image" id="image" class="uploadImage">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="body">
                                <div class="row clearfix">
                                    {{--<div class="col-lg-6 col-md-12">
                                        <h6>Banner</h6>
                                        <div class="media">
                                            <div class="media-left m-r-15">
                                                <img src="{{ asset('admin/assets/images/banner.jpg') }}" class="user-photo media-object" alt="User" id="preview_b" style="width:500px;height:140px;">
                                            </div>
                                            <div class="media-body">
                                                <p>Upload your banner.
                                                <div class="btn btn-default uploadButton" id="btn-upload-photo">Upload banner
                                                    <input type="file" name="image_b" id="image_b" class="uploadImage">
                                                </div>
                                            </div>
                                        </div>
                                    </div>-- --}}
                                    <div class="col-lg-6 col-md-12">
                                        <h6>Banner</h6>
                                        <div class="media">
                                            <div class="media-left m-r-15" id="imgAppend" style="width:500px;height:200px;overflow-y: scroll;">
                                                
                                            </div>
                                            <div class="media-body">
                                                <p>Upload your banner.
                                                <div class="btn btn-default uploadButton" id="btn-upload-photo">Upload banner
                                                    <input type="file" class="uploadImage" id="images" name="images[]" multiple>
                                                </div>
                                            </div>
                                        </div>
                                        <span style="color:red;">Image size 390x140</span>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                            <h6>Menu</h6>
                                            <div class="media">
                                                <div class="media-left m-r-15">
                                                    <iframe src="{{ @$menu[0]->image }}" width="500px" height="200px" id="preview_menu_image"></iframe>
                                                   {{--  <img src="{{ asset('admin/assets/images/banner.jpg') }}" class="user-photo media-object" alt="User" id="preview_menu_image" style="width:500px;height:200px;"> --}}
                                                </div>
                                                <div class="media-body">
                                                    <p>Upload your Menu.
                                                    <div class="btn btn-default uploadButton" id="btn-upload-photo">Upload Menu
                                                        <input type="file" name="menu_image" id="menu_image" class="uploadImage">
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="body">
                                <h6>Basic Information</h6>
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Name" name="name_en" id="name_en" value="{{old('name_en')}}">
                                        </div>
                                        <div class="form-group d-none">
                                            <label>Name(Arabic)</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Name in Arabic" name="name_ar" id="name_ar" value="{{old('name_ar')}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Email Address</label> 
                                            <input type="text" class="form-control input-default" placeholder="Enter email" name="email" id="email" value="{{old('email')}}">

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">{{__("Phone Code")}}</label>
                                                    <select name="country_code" id="country_code" class="form-control js-example-basic-single">
                                                        
                                                        <option value="" selected hidden disabled>Code</option>
                                                        @foreach($countries as $key => $value)
                                                            <option value="+{{$value->phonecode}}" @if($value->phonecode==971) selected @endif>{{$value->nicename}}(+{{$value->phonecode}})</option>
                                                        @endforeach
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <input type="text" class="form-control input-default" placeholder="Enter Phone Number" name="phone" id="phone" value="{{old('phone')}}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="10" minlength="8">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Categories</label>
                                            <select class="form-control input-default" name="category" id="category">
                                                <option value="" selected hidden disabled>Select Category</option>
                                                @foreach ($category as $key=>$value)
                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="form-group" id="sub-category">

                                        </div>
                                        <div class="form-group" id="category-tags">

                                        </div>

                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Vendor Address" id="address" name="address">
                                            <input type="hidden" name="latitude" id="latitude">
                                            <input type="hidden" name="longitude" id="longitude">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Website</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Website Link" id="website" name="website">
                                        </div>
                                        <div class="form-group">
                                            <label>Get link</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Link" id="getlink" name="getlink">
                                        </div>
                                        <div class="form-group">
                                            <label>Instagram</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Instagram Link" id="instagram" name="instagram">
                                        </div>
                                        <div class="form-group">
                                            <label>Verification PIN</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Verification PIN" id="pin" name="pin" maxlength="9">
                                        </div>
                                        <div class="form-group">
                                            <label>About</label>
                                            <textarea type="text" class="form-control" name="about" id="about"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <ul class="list-unstyled mt-3">
                                                <li class="d-flex align-items-center mb-2">
                                                    <label class="toggle-switch top-merchant">
                                                        <input type="checkbox" name="is_top" id="is_top">
                                                        <span class="toggle-switch-slider"></span>
                                                    </label>
                                                    <span class="ml-3">Top Merchant</span>
                                                </li>
                                                <li class="d-flex align-items-center mb-2">
                                                    <label class="toggle-switch featured-merchant">
                                                        <input type="checkbox" name="is_featured" id="is_featured">
                                                        <span class="toggle-switch-slider"></span>
                                                    </label>
                                                    <span class="ml-3">Featured</span>
                                                </li>
                                            </ul>
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
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
    $(document).ready(function () {

        $('#myform').validate({ // initialize the plugin
            rules: {
                name_en: {
                    required: true,
                },
                name_ar: {
                    required: true,
                },
                address: {
                    required: true,
                },
                phone: {
                    required:true,
                },
                email: {
                    required:true,
                    email:true,
                },
                category: {
                    required:true,
                },
                subcategory: {
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
<script type="text/javascript">
	$('#myform').submit(function () {

		var numberOfChecked = $('#latitude').val();
        if(numberOfChecked){
        	return true
        }else{
            Swal.fire('Select valid address from list')
            return false
        }
	});
</script>
<script>
    $('body').on('change','#category',function(){
        var id=$(this).val();
        $.ajax({
            type: "GET",
            url: "{{route('getSubCategories')}}",
            data:{id:id},
            beforeSend: function() {
                $("#pageLoader").show();
            },
            success: function(data) {
                $("#pageLoader").hide();
                $('#sub-category').html(data.data)
            }
        });

        $.ajax({
            type: "GET",
            url: "{{route('getCategoryTags')}}",
            data:{id:id},
            beforeSend: function() {
                $("#pageLoader").show();
            },
            success: function(data) {
                $("#pageLoader").hide();
                $('#category-tags').html(data.data)
            }
        });
    })
</script>
<script type="text/javascript">
	// $('#myform').submit(function () {
        $('#email').on('blur',function(){
        var email = $(this).val();
        var domainPattern = /^[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
        var parts = email.split('@');
        if (!domainPattern.test(parts[1])) {
            Swal.fire('Invalid Email')
            return false; // Domain part is invalid
        }
        $.ajax({
            type: "GET",
            url: "{{route('check-email-exist')}}",
            data:{email:email},
            beforeSend: function() {
                $("#pageLoader").show();
            },
            success: function(data) {
                $("#pageLoader").hide();
                if(data.status==true){
                    Swal.fire(data.msg)
                    return false
                }
            }
        });
    })
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

       $('#image_b').change(function(){

        let reader = new FileReader();

        reader.onload = (e) => {

          $('#preview_b').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);

       });

       $('#menu_image').change(function(){

        let reader = new FileReader();

        reader.onload = (e) => {

          $('#preview_menu_image').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);

       });

       $('#images').change(function () {
                let files = this.files;

                // Clear the existing images in the container
                $('#imgAppend').html('');

                // Loop through each selected file
                for (let i = 0; i < files.length; i++) {
                    let reader = new FileReader();

                    reader.onload = (e) => {
                        // // Create an img element for each image
                        // let imgElement = $('<img>');
                        // imgElement.attr('src', e.target.result);
                        // imgElement.attr('alt', 'Image');
                        // imgElement.attr('height', '150px');

                        // // Append the img element to the container
                        // $('#imgAppend').append(imgElement);

                         // Create an img element for each image
                        let imgElement = $('<img>');
                        imgElement.attr('src', e.target.result);
                        imgElement.attr('alt', 'Image');
                        imgElement.attr('height', '150px');
                        let divElement = $('<div>');

                        let btnElement = $('<button>');
                        btnElement.attr('type', 'button');
                        btnElement.attr('class', 'btn btn-sm btn-outline-danger cross-pos del-img');
                        
                        let iElement = $('<i>');
                        iElement.attr('class', 'fa fa-times');
                        iElement.attr('aria-hidden', 'true');
                        btnElement.append(iElement);

                        divElement.append(btnElement);
                        divElement.append(imgElement);

                        // Append the img element to the container
                        $('#imgAppend').prepend(divElement);
                    };

                    reader.readAsDataURL(files[i]);
                }
            });

            $(document).on('click','.del-img',function(){
                $(this).parent().remove();
            });
    });

</script>
@stop
