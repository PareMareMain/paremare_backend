@extends('admin.layouts.adminLayout')
@section('title','Coupan Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Edit Coupon Detail</h2>
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
                    <h4>Edit Coupon</h4>

                </div>
                <div class="card-body mt-3">
                    <div class="basic-form">
                        <form action="{{route('platform.update',$data->id)}}" id="myform" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Title Name" value="{{ ($data->getTranslation('tag_title', 'en') != '')  ? $data->getTranslation('tag_title', 'en') : '' }}" name="tag_title_en" id="tag_title_en">
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
                            <div class="form-group">
                                <label>Discount Percentage</label>
                                <input type="number" class="form-control input-default" value="{{ @$data->discount }}" placeholder="Enter Flat Percentage" name="discount" id="discount">
                            </div>
                            {{--<div class="form-group d-none">
                                <label>Title(Arabic)</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Title Name" value="{{ ($data->getTranslation('tag_title', 'ar') != '')  ? $data->getTranslation('tag_title', 'ar') : '' }}" name="tag_title_ar" id="tag_title_ar">
                            </div>
                            <div class="form-group">
                                <label>Tag Name</label>
                                <input type="text" class="form-control input-default" placeholder="Enter offer Name" value="{{ ($data->getTranslation('tag_name', 'en') != '')  ? $data->getTranslation('tag_name', 'en') : '' }}" name="tag_name_en" id="tag_name_en">
                            </div>
                            <div class="form-group d-none">
                                <label>Tag Name(Arabic)</label>
                                <input type="text" class="form-control input-default" placeholder="Enter offer Name in Arabic" value="{{ ($data->getTranslation('tag_name', 'ar') != '')  ? $data->getTranslation('tag_name', 'ar') : '' }}" name="tag_name_ar" id="tag_name_ar">
                            </div>
                            <div class="form-group">
                                <label>Coupon Code</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Coupon Code" value="{{ $data->coupon_code }}" name="coupon_code" id="coupon_code">
                            </div>
                            <div class="form-group">
                                <label>Coupon Total Limit</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Total Limit" value="{{ $data->total_limit }}" name="total_limit" id="total_limit">
                            </div>
                            <div class="form-group">
                                <label>Coupon Per User Limit</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Per User" value="{{ $data->limit_per_user }}" name="limit_per_user" id="limit_per_user">
                            </div>
                            <div class="form-group">
                                <label>Coupon Share Limit</label>
                                <input type="text" class="form-control input-default" placeholder="Enter Share Limit" value="{{ $data->share_limit }}" name="share_limit" id="share_limit">
                            </div>
                            <div class="form-group">
                                <label>Offer Type</label>
                                <select name="offer_type" id="offer_type" class="form-control input-default">
                                    <option value="" selected hidden disabled>Select Offer Type</option>
                                    <option value="percentage" <?php if($data->offer_type=='percentage'){ echo 'selected';} ?> >Percentage(نسبة مئوية)</option>
                                    <option value="amount" <?php if($data->offer_type=='amount'){ echo 'selected';} ?> >Amount(كمية)</option>
                                    <option value="buy-get" <?php if($data->offer_type=='buy-get'){ echo 'selected';} ?> >Buy X and Get Y(اشترِ X واحصل على Y)</option>
                                    <option value="buy-get-percentage" <?php if($data->offer_type=='buy-get-percentage'){ echo 'selected';} ?> >Buy X and Get Y Percentage(اشتر X واحصل على النسبة المئوية Y)</option>
                                </select>
                            </div>
                            <div id="append_offer_fields">
                                @if($data->offer_type=='buy-get')
                                    <div class="form-group">
                                        <label>Buy Quantity</label>
                                        <input type="text" class="form-control input-default" value="@if($data->offer_type=='buy-get') {{ $data->buy_items }} @endif" placeholder="Enter buy items quantity" name="buy_items" id="buy_items">
                                    </div>
                                    <div class="form-group">
                                        <label>Get Quantity</label>
                                        <input type="text" class="form-control input-default" value="@if($data->offer_type=='buy-get') {{ $data->free_items }} @endif" placeholder="Enter free items quantity" name="free_items" id="free_items">
                                    </div>
                                @elseif($data->offer_type=='amount')
                                    <div class="form-group">
                                        <label>Flat Amount</label>
                                        <input type="text" class="form-control input-default" value="@if($data->offer_type=='amount') {{ $data->discount }} @endif" placeholder="Enter Flat Amount" name="discount" id="discount">
                                    </div>
                                @elseif($data->offer_type=='buy-get-percentage')
                                    <div class="form-group">
                                        <label>Buy Quantity</label>
                                        <input type="text" class="form-control input-default" value="@if($data->offer_type=='buy-get-percentage') {{ $data->buy_items }} @endif" placeholder="Enter buy items quantity" name="buy_items" id="buy_items">
                                    </div>
                                    <div class="form-group">
                                        <label>Discount Percentage</label>
                                        <input type="text" class="form-control input-default" value="@if($data->offer_type=='buy-get-percentage') {{ $data->discount }} @endif" placeholder="Enter Flat Percentage" name="discount" id="discount">
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label>Discount Percentage</label>
                                        <input type="text" class="form-control input-default" value="@if($data->offer_type=='percentage') {{ $data->discount }} @endif" placeholder="Enter Flat Percentage" name="discount" id="discount">
                                    </div>
                                @endif

                            </div>
                            <div class="form-group">
                                <label>Want to Show Code</label>
                                <select name="is_hidden" id="is_hidden" class="form-control input-default">
                                    <option value="" selected hidden disabled>Choose Option</option>
                                    <option value="yes" @if($data->is_hidden=='yes') selected @endif>Yes</option>
                                    <option value="no" @if($data->is_hidden=='no') selected @endif>No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" class="form-control input-default" value="{{ $data->end_date }}" name="end_date" id="end_date">
                            </div>
                            <div class="form-group">
                                <label>What Inside(Arabic)</label>
                                <input type="text" class="form-control input-default" placeholder="Enter What Inside Content in Arabic" value="{{ ($data->getTranslation('what_inside', 'ar') != '')  ? $data->getTranslation('what_inside', 'ar') : '' }}" name="what_inside_ar" id="what_inside_ar">
                            </div>
                            <div class="form-group">
                                <label>How To Redeem(Arabic)</label>
                                <textarea class="form-control input-default" placeholder="Enter How To Redeem Content in Arabic" name="how_to_redeem_ar" id="how_to_redeem_ar">{{ ($data->getTranslation('how_to_redeem', 'ar') != '')  ? $data->getTranslation('how_to_redeem', 'ar') : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>How To Redeem</label>
                                <textarea class="form-control input-default" placeholder="Enter How To Redeem Content" name="how_to_redeem_en" id="how_to_redeem_en">{{ ($data->getTranslation('how_to_redeem', 'en') != '')  ? $data->getTranslation('how_to_redeem', 'en') : '' }}</textarea>
                            </div>
                            -- --}}
                            <div class="form-group">
                                <label>{{ __("How To Redeem") }}</label>
                                <select class="form-control" name="redeem_type" id="redeem-type-select">
                                    <option value="">{{ __("Select Redeem Type") }}</option>
                                    <option value="online" {{ $data->redeem_type == 'online' ? 'selected' : '' }}>{{ __("Online") }}</option>
                                    <option value="in_the_store" {{ $data->redeem_type == 'in_the_store' ? 'selected' : '' }}>{{ __("In the Store") }}</option>
                                    <option value="both" {{ $data->redeem_type == 'both' ? 'selected' : '' }}>{{ __("Both") }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Coupon Description</label>
                                <input type="text" class="form-control input-default" placeholder="Enter What Inside Content" value="{{ ($data->getTranslation('what_inside', 'en') != '')  ? $data->getTranslation('what_inside', 'en') : '' }}" name="what_inside_en" id="what_inside_en">
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
                tag_title: {
                    required: true,
                },
                tag_name: {
                    required: true,
                },
                coupon_code: {
                    required:true,
                },
                offer_type: {
                    required: true,
                },
                what_inside: {
                    required:true,
                },
                buy_items: {
                    required:true,
                },
                free_items :{
                    required:true
                },
                discount : {
                    required:true,
                },
                end_date : {
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
    {{ $data->discount }}
</script>
<script>
     var offer='{{ json_encode(json_decode($data)) }}'
     var is="{{ $data->id }}";
     console.log(is)
    $('#offer_type').on('change',function(){
        var items=$(this).val();

        if(items=='buy-get'){
            $('#append_offer_fields').html(`<div class="form-group">
                <label>Buy Quantity</label>
                <input type="text" class="form-control input-default" value="@if($data->offer_type=='buy-get') {{ $data->buy_items }} @endif" placeholder="Enter buy items quantity" name="buy_items" id="buy_items">
            </div>
            <div class="form-group">
                <label>Get Quantity</label>
                <input type="text" class="form-control input-default" value="@if($data->offer_type=='buy-get') {{ $data->free_items }} @endif" placeholder="Enter free items quantity" name="free_items" id="free_items">
            </div>`)
        }else if(items=='amount'){
            $('#append_offer_fields').html(`<div class="form-group">
                <label>Flat Amount</label>
                <input type="text" class="form-control input-default" value="@if($data->offer_type=='amount') {{ $data->discount }} @endif" placeholder="Enter Flat Amount" name="discount" id="discount">
            </div>`)
        }else if(items=='buy-get-percentage'){
            $('#append_offer_fields').html(`<div class="form-group">
                <label>Buy Quantity</label>
                <input type="text" class="form-control input-default" value="@if($data->offer_type=='buy-get-percentage') {{ $data->buy_items }} @endif" placeholder="Enter buy items quantity" name="buy_items" id="buy_items">
            </div>
            <div class="form-group">
                <label>Discount Percentage</label>
                <input type="text" class="form-control input-default" value="@if($data->offer_type=='buy-get-percentage') {{ $data->discount }} @endif" placeholder="Enter Flat Percentage" name="discount" id="discount">
            </div>`)
        }else{
            $('#append_offer_fields').html(`<div class="form-group">
                <label>Discount Percentage</label>
                <input type="text" class="form-control input-default" value="@if($data->offer_type=='percentage') {{ $data->discount }} @endif" placeholder="Enter Flat Percentage" name="discount" id="discount">
            </div>`)
        }
    })
</script>
@stop
