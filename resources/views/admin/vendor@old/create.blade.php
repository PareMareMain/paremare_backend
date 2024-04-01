@extends('admin.layouts.adminLayout')
@section('title','User Management')
@section('content')
<div  class="pageLoader" id="pageLoader"></div>
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
                                <li class="breadcrumb-item active">Add Vendor</li>
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
                                <h4>Add Vendor</h4>

                            </div>
                            <div class="card-body mt-3">
                                <div class="basic-form">
                                    <form action="{{route('vendor.store')}}" id="myform" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Name" name="name" id="name" value="{{old('name')}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter email" name="email" id="email" value="{{old('email')}}">

                                        </div>
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Phone Number" name="phone" id="phone" value="{{old('phone')}}">
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

                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Vendor Address" id="address" name="address">
                                            <input type="hidden" name="latitude" id="latitude">
                                            <input type="hidden" name="longitude" id="longitude">
                                        </div>
                                        <div class="form-group">
                                            <label> Vendor Image</label>
                                            <input type="file" class="form-control input-default" name="image" id="image">
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
                name: {
                    required: true,
                },
                address: {
                    required: true,
                },
                image: {
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
    })
</script>
<script type="text/javascript">
	// $('#myform').submit(function () {
        $('#email').on('blur',function(){
        var email = $(this).val();
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
@stop
