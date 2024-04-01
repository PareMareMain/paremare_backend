@extends('admin.layouts.adminLayout')
@section('title','Coupan Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Add Coupon Detail</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Coupon</li>
                    <li class="breadcrumb-item active">Detail</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                    </div>
                    <div class="p-2 d-flex">
                        <a href="{{route('coupon.request.index')}}"><button type="button" class="btn btn-primary"><i class="fa fa-Plus"></i> Back</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-9 col-md-12">
            <div class="card">
                <div class="card-title">
                    <h4>Add Coupon</h4>

                </div>
                <div class="card-body mt-3">
                    <div class="basic-form">
                        <form action="{{route('platform.store')}}" id="myform" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Title Name" name="tag_title_en" id="tag_title_en">
                            </div>
                            <div class="form-group">
                                <label>Vendor Name</label>
                                <select name="vendor_id" id="vendorId" class="form-control js-example-basic-single userId">
                                    <option value="" selected>None</option>
                                    @foreach($users as $key=>$value)
                                        <option value="{{ $value->id }}">{{ ($value->getTranslation('name', 'en') != '')  ? $value->getTranslation('name', 'en') : '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Discount Percentage</label>
                                <input type="number" class="form-control input-default" value="@if(@$data->offer_type=='percentage') {{ @$data->discount }} @endif" placeholder="Enter Flat Percentage" name="discount" id="discount">
                            </div>
                            {{--<div class="form-group">
                                <label>Title(Arabic)</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Title Name in Arabic" name="tag_title_ar" id="tag_title_ar">
                            </div>
                            <div class="form-group">
                                <label>Tag Name</label>
                                <input type="text" class="form-control input-default" placeholder="Enter offer Name" name="tag_name_en" id="tag_name_en">
                            </div>
                            <div class="form-group d-none">
                                <label>Tag Name(Arabic)</label>
                                <input type="text" class="form-control input-default" placeholder="Enter offer Name in Arabic" name="tag_name_ar" id="tag_name_ar">
                            </div>
                            <div class="form-group">
                                <label>Coupon Code</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Coupon Code" name="coupon_code" id="coupon_code">
                            </div>
                            <div class="form-group position-relative">
                                <label>Coupon Total Limit</label>
                                <i class="fa fa-info-circle info-pos pl-2" aria-hidden="true" title=""></i>
                                <input type="text" class="form-control input-default" placeholder="Enter Total Limit" name="total_limit" id="total_limit">
                            </div>
                            <div class="form-group position-relative">
                                <label>Coupon Per User Limit</label>
                                <i class="fa fa-info-circle info-pos pl-2" aria-hidden="true" title=""></i>
                                <input type="text" class="form-control input-default" placeholder="Enter Per User" name="limit_per_user" id="limit_per_user">
                            </div>
                            <div class="form-group position-relative">
                                <label>Coupon Share Limit</label>
                                <i class="fa fa-info-circle info-pos pl-2" aria-hidden="true" title=""></i>
                                <input type="text" class="form-control input-default" placeholder="Enter Share Limit" name="share_limit" id="share_limit">
                            </div>
                            <div class="form-group">
                                <label>Offer Type</label>
                                <select name="offer_type" id="offer_type" class="form-control input-default">
                                    <option value="" selected hidden disabled>Select Offer Type</option>
                                    <option value="percentage">Percentage(نسبة مئوية)</option>
                                    <option value="amount">Amount(كمية)</option>
                                    <option value="buy-get">Buy X and Get Y(اشترِ X واحصل على Y)</option>
                                    <option value="buy-get-percentage">Buy X and Get Y Percentage(اشتر X واحصل على النسبة المئوية Y)</option>
                                </select>
                            </div>
                            <div id="append_offer_fields">

                            </div>
                            <div class="form-group">
                                <label>Want to Show Code</label>
                                <select name="is_hidden" id="is_hidden" class="form-control input-default">
                                    <option value="" selected hidden disabled>Choose Option</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" class="form-control input-default" name="end_date" id="end_date">
                            </div>
                            <div class="form-group">
                                <label>What Inside(Arabic)</label>
                                <input type="text" class="form-control input-default" placeholder="Enter What Inside Content in Arabic" name="what_inside_ar" id="what_inside">
                            </div>
                            <div class="form-group">
                                <label>How To Redeem(Arabic)</label>
                                <textarea class="form-control input-default" placeholder="Enter How To Redeem Content in Arabic" name="how_to_redeem_ar" id="how_to_redeem_ar"></textarea>
                            </div>
                            <div class="form-group">
                                <label>How To Redeem</label>
                                <textarea class="form-control input-default" placeholder="Enter How To Redeem Content" name="how_to_redeem_en" id="how_to_redeem_en"></textarea>
                            </div>
                            -- --}}
                            <div class="form-group">
                                <label>{{ __("How To Redeem") }}</label>
                                <select class="form-control" name="redeem_type" id="redeem-type-select">
                                    <option value="">{{ __("Select Redeem Type") }}</option>
                                    <option value="online">{{ __("Online") }}</option>
                                    <option value="in_the_store">{{ __("In the Store") }}</option>
                                    <option value="both">{{ __("Both") }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Coupon Description</label>
                                <input type="text" class="form-control input-default" placeholder="Enter What Inside Content" name="what_inside_en" id="what_inside">
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
<script>
    $('#offer_type').on('change',function(){
        var items=$(this).val();
        if(items=='buy-get'){
            $('#append_offer_fields').html(`<div class="form-group">
                <label>Buy Quantity</label>
                <input type="text" class="form-control input-default" placeholder="Enter buy items quantity" name="buy_items" id="buy_items">
            </div>
            <div class="form-group">
                <label>Get Quantity</label>
                <input type="text" class="form-control input-default" placeholder="Enter free items quantity" name="free_items" id="free_items">
            </div>`)
        }else if(items=='amount'){
            $('#append_offer_fields').html(`<div class="form-group">
                <label>Flat Amount</label>
                <input type="text" class="form-control input-default" placeholder="Enter Flat Amount" name="discount" id="discount">
            </div>`)
        }else if(items=='buy-get-percentage'){
            $('#append_offer_fields').html(`<div class="form-group">
                <label>Buy Quantity</label>
                <input type="text" class="form-control input-default" placeholder="Enter buy items quantity" name="buy_items" id="buy_items">
            </div>
            <div class="form-group">
                <label>Discount Percentage</label>
                <input type="text" class="form-control input-default" placeholder="Enter Flat Percentage" name="discount" id="discount">
            </div>`)
        }else{
            $('#append_offer_fields').html(`<div class="form-group">
                <label>Discount Percentage</label>
                <input type="text" class="form-control input-default" placeholder="Enter Flat Percentage" name="discount" id="discount">
            </div>`)
        }
    })
</script>
@stop
