@extends('admin.layouts.adminLayout')
@section('title','Category Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Edit Category</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Edit</li>
                    <li class="breadcrumb-item active">Category</li>
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
                <div class="card-title mt-2">
                    <h4>Edit Category</h4>

                </div>
                <div class="card-body mt-3">
                    <div class="basic-form">
                        <form action="{!! url('admin/faq/category/update/'.$data->id) !!}" id="myform" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Category Name" name="name_en" value="{{ ($data->getTranslation('name', 'en') != '')  ? $data->getTranslation('name', 'en') : '' }}">
                            </div>
                            <div class="form-group d-none">
                                <label>Name(Arabic)</label>
                                <input type="text" class="form-control input-default" placeholder="Enter category Name in Arabic" name="name_ar" id="name_ar" value="{{ ($data->getTranslation('name', 'ar') != '')  ? $data->getTranslation('name', 'ar') : '' }}">
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control input-default" name="image">
                            </div>
                            @if($data->image)
                                <div class="form-group edit-img-w">
                                    <img src="{{asset($data->image)}}" alt="Station image" >
                                </div>
                            @endif
                            <button type="submit" class="btn btn-default mt-4">Submit</button>
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
                name: {
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
