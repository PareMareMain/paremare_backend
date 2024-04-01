@extends('facilities.layouts.vendorLayout')
@section('title','Banner Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>{{__("Create Banner")}}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    {{-- <li class="breadcrumb-item"></li> --}}
                    <li class="breadcrumb-item active">{{__("Create Banner")}}</li>
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
        <div class="col-lg-9">
            <div class="card">
                <div class="card-title">
                    {{--  <h4>Add Banner</h4>  --}}

                </div>
                <div class="card-body mt-3">
                    <div class="basic-form">
                        <form action="{{route('vendor-banner.store')}}" id="myform" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>{{__("Banner Name")}}</label>
                                <input type="text" class="form-control input-default" placeholder="{{__('Enter Banner Title')}}" name="name_en" id="name_en">
                            </div>
                            <div class="form-group d-none">
                                <label>{{__("Banner Name(Arabic)")}}</label>
                                <input type="text" class="form-control input-default" placeholder="{{__('Enter Banner Title in Arabic')}}" name="name_ar" id="name_ar">
                            </div>
                            <div class="form-group">
                                <label>{{__("Choose Redirection Type")}}</label>
                                <select name="is_redirection_available" id="is_redirection_available" class="form-control">
                                    <option value="" selected disabled hidden>{{__("Choose One")}}</option>
                                    <option value="yes">{{__("Yes")}}</option>
                                    <option value="no">{{__("No")}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{__("Image")}}</label>
                                <input type="file" class="form-control input-default" name="image" id="image">
                            </div>
                            <div id="imgAppend">

                            </div>
                            <button type="submit" class="btn btn-default mt-4">{{__("Submit")}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script type="text/javascript">

    $(document).ready(function (e) {
       $('#image').change(function(){

        let reader = new FileReader();

        reader.onload = (e) => {

          $('#imgAppend').html(`<img src="`+e.target.result+`" alt="Banner Image" style="width: 180px;height:150px;">`);
        }

        reader.readAsDataURL(this.files[0]);

       });

    });

    </script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
<script>
    $(document).ready(function () {

        $('#myform').validate({ // initialize the plugin
            rules: {
                name_en: {
                    required: true,
                },
                name_ar: {
                    required: true,
                },
                image: {
                    required: true,
                },
                vendor_id: {
                    required: true,
                },
                is_redirection_available:{
                    required:true,
                }
            },
            messages: {
                name_en: {
                    required: "{{__('This field is required.')}}",
                },
                name_ar: {
                    required: "{{__('This field is required.')}}",
                },
                image: {
                    required: "{{__('This field is required.')}}",
                },
                vendor_id: {
                    required: "{{__('This field is required.')}}",
                },
                is_redirection_available:{
                    required:"{{__('This field is required.')}}",
                }
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
