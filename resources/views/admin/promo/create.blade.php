@extends('admin.layouts.adminLayout')
@section('title','Coupan Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Add Promo Detail</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Promo</li>
                    <li class="breadcrumb-item active">Detail</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                    </div>
                    <div class="p-2 d-flex">
                        <a href="{{route('platform.index')}}"><button type="button" class="btn btn-primary"><i class="fa fa-Plus"></i> Back</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-9 col-md-12">
            <div class="card">
                <div class="card-title">
                    <h4>Add Promo</h4>

                </div>
                <div class="card-body mt-3">
                    <div class="basic-form">
                        <form action="{{route('admin.promo.store')}}" id="myform" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Title Name" name="tag_title_en" id="tag_title_en">
                            </div>
                            <div class="form-group">
                                <label>Promo Code</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Promo Code" name="promo_code" id="promo_code">
                            </div>
                            <div class="form-group">
                                <label>Offer Type</label>
                                <select name="offer_type" id="offer_type" class="form-control input-default">
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Discount</label>
                                <input type="number" class="form-control input-default" value="{{ @$data->discount }}" placeholder="Enter Percentage" name="discount" id="discount">
                            </div>
                            <div class="form-group">
                                <label>Promo Description</label>
                                <input type="text" class="form-control input-default" placeholder="Enter What Inside Content" name="promo_description_en" id="what_inside">
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
    CKEDITOR.replace( 'how_to_redeem_en' );
    CKEDITOR.replace( 'how_to_redeem_ar' );
</script>
<script>
    $(document).ready(function () {

        $('#myform').validate({ // initialize the plugin
            rules: {
                tag_title_en: {
                    required: true,
                },
                tag_title_ar: {
                    required: true,
                },
                tag_name_en: {
                    required: true,
                },
                tag_name_ar: {
                    required: true,
                },
                coupon_code: {
                    required:true,
                },
                offer_type: {
                    required: true,
                },
                what_inside_en: {
                    required:true,
                },
                what_inside_ar: {
                    required:true,
                },
                buy_items: {
                    required:true,
                },
                free_items :{
                    required:true,
                },
                discount : {
                    required:true,
                },
                total_limit : {
                    required:true,
                },
                limit_per_user : {
                    required:true,
                },
                share_limit : {
                    required:true,
                },
                end_date : {
                    required:true,
                },
                is_hidden : {
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
