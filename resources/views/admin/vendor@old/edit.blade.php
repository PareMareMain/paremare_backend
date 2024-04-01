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
                                <li class="breadcrumb-item active">Edit Vendor</li>
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
                                <h4>Edit Vendor</h4>

                            </div>
                            <div class="card-body mt-3">
                                <div class="basic-form">
                                    <form action="{{route('vendor.update',$data->id)}}" id="myform" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Name" name="name" value="{{$data->name}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter email" name="email" value="{{$data->email}}" @if($data->email) disabled @endif>

                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter facilities Address" id="address" name="address" value="{{$data->location}}">
                                            <input type="hidden" name="latitude" id="latitude" value="{{$data->latitude}}">
                                            <input type="hidden" name="longitude" id="longitude" value="{{$data->longitude}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Vendor Image</label>
                                            <input type="file" class="form-control input-default" name="image" id="image">
                                        </div>
                                        @if($data->profile_image)
                                        <div class="form-group">
                                            <img id="preview" src="{{$data->profile_image}}" style="height:120px;width:150px;">
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
                },
                address: {
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
<script>
    $('#address').on('keypress',function(){
        $('#latitude').val('');
        $('#longitude').val('');

    });
    $('#address').on('keydown',function(){
        $('#latitude').val('');
        $('#longitude').val('');

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
