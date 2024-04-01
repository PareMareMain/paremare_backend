@extends('facilities.layouts.vendorLayout')
@section('title','Banner Management')
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
                                <li class="breadcrumb-item active">Add Banner</li>
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
                                <h4>Add Banner</h4>

                            </div>
                            <div class="card-body mt-3">
                                <div class="basic-form">
                                    <form action="{{route('vendor-banner.store')}}" id="myform" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>Banner Name</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Banner Title" name="name" id="name">
                                        </div>
                                        <div class="form-group">
                                            <label>Choose Redirection Type</label>
                                            <select name="is_redirection_available" id="is_redirection_available" class="form-control">
                                                <option value="" selected disabled hidden>Choose One</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" class="form-control input-default" name="image" id="image">
                                        </div>
                                        <div id="imgAppend">

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
                name: {
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
