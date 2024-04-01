@extends('admin.layouts.adminLayout')
@section('title','Banner Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Edit Banner</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Edit</li>
                    <li class="breadcrumb-item active">Banner</li>
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
                    <h4>Add Banner</h4>

                </div>
                <div class="card-body mt-3">
                    <div class="basic-form">
                        <form action="{{route('banner.store')}}" id="myform" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Banner Name</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Banner Title" name="name_en" id="name_en">
                            </div>
                            <div class="form-group d-none">
                                <label>Banner Name(Arabic)</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Banner Title in Arabic" name="name_ar" id="name_ar">
                            </div>
                            <div class="form-group">
                                <label>Vendor Name</label>
                                <select name="vendor_id" id="vendorId" class="form-control js-example-basic-single userId">
                                    <option value="null" selected>None</option>
                                    @foreach($users as $key=>$value)
                                        <option value="{{ $value->id }}">{{ ($value->getTranslation('name', 'en') != '')  ? $value->getTranslation('name', 'en') : '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group Redirection">
                                <label>Choose Redirection Type</label>
                                <select name="is_redirection_available" id="is_redirection_available" class="form-control">
                                    <option value="" selected disabled hidden>Choose One</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control input-default" id="images" name="images[]" multiple>
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
</div>
@stop
@section('scripts')
<script type="text/javascript">

$(document).ready(function () {
            $('#images').change(function () {
                let files = this.files;

                // Clear the existing images in the container
                $('#imgAppend').html('');

                // Loop through each selected file
                for (let i = 0; i < files.length; i++) {
                    let reader = new FileReader();

                    reader.onload = (e) => {
                        // Create an img element for each image
                        let imgElement = $('<img>');
                        imgElement.attr('src', e.target.result);
                        imgElement.attr('alt', 'Image');
                        imgElement.attr('height', '150px');

                        // Append the img element to the container
                        $('#imgAppend').append(imgElement);
                    };

                    reader.readAsDataURL(files[i]);
                }
            });
        });

    // $(document).ready(function (e) {
    //    $('#images').change(function(){

    //     let reader = new FileReader();

    //     reader.onload = (e) => {

    //       $('#imgAppend').html(`<img src="`+e.target.result+`" alt="Banner Image" style="width: 180px;height:150px;">`);
    //     }

    //     reader.readAsDataURL(this.files[0]);

    //    });

    // });

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
    $('#vendorId').on('change',function(){
        let data=$(this).val();
        console.log(data)
        if(data!=null && data!="null"){
            console.log('llll')
            $(".Redirection").show()
        }else{
            console.log('kkkk')
            $(".Redirection").hide()
        }
    })
</script>
@stop
