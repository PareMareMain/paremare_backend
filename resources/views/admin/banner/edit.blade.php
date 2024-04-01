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
                    <h4>Edit Banner</h4>

                </div>
                <div class="card-body mt-3">
                    <div class="basic-form">
                        <form action="{{route('banner.update',$data->id)}}" id="myform" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label>Banner Name</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Banner Title" name="name_en" id="name_en" value="{{ ($data->getTranslation('name', 'en') != '')  ? $data->getTranslation('name', 'en') : '' }}">
                            </div>
                            <div class="form-group d-none">
                                <label>Banner Name(Arabic)</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Banner Title in Arabic" name="name_ar" id="name_ar" value="{{ ($data->getTranslation('name', 'ar') != '')  ? $data->getTranslation('name', 'ar') : '' }}">
                            </div>
                            <div class="form-group">
                                <label>Vendor Name</label>
                                <select name="vendor_id" id="vendorId" class="form-control js-example-basic-single userId">
                                    <option value="null" <?php if($data->vendor_id==null){echo 'selected';}?>>None</option>
                                    @foreach($users as $key=>$value)
                                        <option value="{{ $value->id }}" <?php if($data->vendor_id==$value->id){echo 'selected';}?>>{{ ($value->getTranslation('name', 'en') != '')  ? $value->getTranslation('name', 'en') : '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group Redirection" @if($data->vendor_id==null) style="display:none;" @endif>
                                <label>Choose Redirection Type</label>
                                <select name="is_redirection_available" id="is_redirection_available" class="form-control">
                                    <option value="" selected disabled hidden>Choose One</option>
                                    <option value="yes" <?php if($data->is_redirection_available=='yes'){echo 'selected';}?>>Yes</option>
                                    <option value="no" <?php if($data->is_redirection_available=='no'){echo 'selected';}?>>No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control input-default" name="image" id="image">
                            </div>
                            <div id="imgAppend">
                                @if($data->image)
                                    <img src="{{ $data->image }}" alt="Banner Image" style="width: 180px;height:150px;">
                                @endif
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
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
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
    $(document).ready(function () {

        $('#myform').validate({ // initialize the plugin
            rules: {
                name_en: {
                    required: true,
                },
                name_ar: {
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
