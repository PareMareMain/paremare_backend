@extends('facilities.layouts.vendorLayout')
@section('title','Coupon Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>{{__("Create Coupon")}} </h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    {{-- <li class="breadcrumb-item"></li> --}}
                    <li class="breadcrumb-item active">{{__("Create Coupon")}}</li>
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
                <div class="card-title">
                    <h4>{{__("Add Coupon")}}</h4>

                </div>
                <div class="card-body mt-3">
                    <div class="basic-form">
                        <form action="{{route('coupon.store')}}" id="myform" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>{{__("Title")}}</label>
                                <input type="text" class="form-control input-default" placeholder="{{__('Enter Title Name')}}" name="tag_title_en" id="tag_title_en">
                            </div>
                            {{-- <div class="form-group d-none">
                                <label>{{__("Title(Arabic)")}}</label>
                                <input type="text" class="form-control input-default" placeholder="{{__('Enter Title Name in Arabic')}}" name="tag_title_ar" id="tag_title_ar">
                            </div>
                            <div class="form-group">
                                <label>{{__("Tag Name")}}</label>
                                <input type="text" class="form-control input-default" placeholder="{{__('Enter offer Name')}}" name="tag_name_en" id="tag_name_en">
                            </div> 
                            <div class="form-group">
                                <label>{{__("Tag Name(Arabic)")}}</label>
                                <input type="text" class="form-control input-default" placeholder="{{__('Enter offer Name in Arabic')}}" name="tag_name_ar" id="tag_name_ar">
                            </div> 
                            <div class="form-group">
                                <label>{{__("Coupon Code")}}</label>
                                <input type="text" class="form-control input-default" placeholder="{{__('Enter Coupon Code')}}" name="coupon_code" id="coupon_code">
                            </div>
                            <div class="form-group">
                                <label>{{__("Coupon Total Limit")}}</label>
                                <input type="number" class="form-control input-default" min="1" placeholder="{{__('Enter Total Limit')}}" name="total_limit" id="total_limit">
                            </div>
                            <div class="form-group">
                                <label>{{ __("Coupon Total Limit") }}</label>
                                <i class="fa fa-info-circle info-icon" data-toggle="popover" data-placement="right" data-content="Total Coupons available on the Club J App"></i>
                                <input type="number" class="form-control input-default" min="1" placeholder="{{ __('Enter Total Limit') }}" name="total_limit" id="total_limit">
                            </div>
                            <div class="form-group">
                                <label>{{__("Coupon Per User Limit")}}</label>
                                <i class="fa fa-info-circle info-icon" data-toggle="popover" data-placement="right" data-content="Number of times the coupon can be used per user"></i>
                                <input type="number" class="form-control input-default" min="1" placeholder="{{__('Enter Per User')}}" name="limit_per_user" id="limit_per_user">
                            </div>
                             {{--<div class="form-group">
                                <label>{{__("Coupon Share Limit")}}</label>
                                <i class="fa fa-info-circle info-icon" data-toggle="popover" data-placement="right" data-content="Information about the coupon Share Limit."></i>
                                <input type="number" class="form-control input-default" min="1" placeholder="{{__('Enter Share Limit')}}" name="share_limit" id="share_limit">
                            </div> 
                            <div class="form-group">
                                <label>{{__("Offer Type")}}</label>
                                <select name="offer_type" id="offer_type" class="form-control input-default">
                                    <option value="" selected hidden disabled>{{__("Select Offer Type")}}</option>
                                    <option value="percentage">{{__("Percentage")}}</option>
                                    <option value="amount">{{__("Amount")}}</option>
                                    <option value="buy-get">{{__("Buy-Get")}}</option>
                                    <option value="buy-get-percentage">{{__("Buy X and Get Y Percentage")}}</option>
                                </select>
                            </div>
                            <div id="append_offer_fields">

                            </div>
                            <div class="form-group">
                                <label>{{__("End Date")}}</label>
                                <input type="date" class="form-control input-default" name="end_date" id="end_date">
                            </div>
                            <div class="form-group">
                                <label>Coupon Description (Arabic)</label>
                                <input type="text" class="form-control input-default" placeholder="{{__('Enter Coupon Description in Arabic')}}" name="what_inside_ar" id="what_inside_ar">
                            </div>
                            <div class="form-group">
                                <label>{{__("How To Redeem")}}</label>
                                <textarea class="form-control input-default" placeholder="{{__('Enter How To Redeem Content')}}" name="how_to_redeem_en" id="how_to_redeem_en"></textarea>
                            </div>
                            <div class="form-group">
                                <label>{{__("How To Redeem(Arabic)")}}</label>
                                <textarea class="form-control input-default" placeholder="{{__('Enter How To Redeem Content in Arabic')}}" name="how_to_redeem_ar" id="how_to_redeem_ar"></textarea>
                            </div> --}}
                            <div class="form-group">
                                <label>Coupon Description</label>
                                <i class="fa fa-info-circle info-icon" data-toggle="popover" data-placement="right" data-content="Information about the offer"></i>
                                <input type="text" class="form-control input-default" placeholder="{{__('Enter Coupon Description')}}" name="what_inside_en" id="what_inside_en">
                            </div>
                            <div class="form-group">
                                <label>{{__('Discount Percentage')}}</label>
                                <input type="number" class="form-control input-default" min="1" placeholder="{{__('Enter Flat Percentage')}}" name="discount" id="discount">
                            </div>
                            @if (isset($userData->website) && isset($userData->pin))
                                <div class="form-group">
                                    <label>{{ __("How To Redeem") }}</label>
                                    <select class="form-control" name="redeem_type" id="redeem-type-select">
                                        <option value="">{{ __("Select Redeem Type") }}</option>
                                        <option value="online">{{ __("Online") }}</option>
                                        <option value="in_the_store">{{ __("In the Store") }}</option>
                                        <option value="both">{{ __("Both") }}</option>
                                    </select>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-default mt-4">{{__('Submit')}}</button>
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
                    required:true
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
                redeem_type: {
                required: true
                }
            },
            messages: {
                tag_title_en: {
                    required: "{{__('This field is required.')}}",
                },
                tag_name_en: {
                    required: "{{__('This field is required.')}}",
                },
                tag_title_ar: {
                    required: "{{__('This field is required.')}}",
                },
                tag_name_ar: {
                    required: "{{__('This field is required.')}}",
                },
                coupon_code: {
                    required:"{{__('This field is required.')}}",
                },
                offer_type: {
                    required: "{{__('This field is required.')}}",
                },
                what_inside_en: {
                    required:"{{__('This field is required.')}}",
                },
                what_inside_ar: {
                    required:"{{__('This field is required.')}}",
                },
                buy_items: {
                    required:"{{__('This field is required.')}}",
                },
                free_items :{
                    required:"{{__('This field is required.')}}"
                },
                discount : {
                    required:"{{__('This field is required.')}}",
                },
                end_date : {
                    required:"{{__('This field is required.')}}",
                },
                total_limit : {
                    required:"{{__('This field is required.')}}",
                },
                limit_per_user : {
                    required:"{{__('This field is required.')}}",
                },
                share_limit : {
                    required:"{{__('This field is required.')}}",
                },
                redeem_type: {
                required: "Please select a redeem type."
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
    $('#offer_type').on('change',function(){
        var items=$(this).val();
        if(items=='buy-get'){
            $('#append_offer_fields').html(`<div class="form-group">
                <label>{{__('Buy Quantity')}}</label>
                <input type="number" class="form-control input-default" min="1" placeholder="{{__('Enter buy items quantity')}}" name="buy_items" id="buy_items">
            </div>
            <div class="form-group">
                <label>{{__('Get Quantity')}}</label>
                <input type="number" class="form-control input-default" min="1" placeholder="{{__('Enter free items quantity')}}" name="free_items" id="free_items">
            </div>`)
        }else if(items=='amount'){
            $('#append_offer_fields').html(`<div class="form-group">
                <label>{{__('Flat Amount')}}</label>
                <input type="number" class="form-control input-default" min="1" placeholder="{{__('Enter Flat Amount')}}" name="discount" id="discount">
            </div>`)
        }else if(items=='buy-get-percentage'){
            $('#append_offer_fields').html(`<div class="form-group">
                <label>{{__('Buy Quantity')}}</label>
                <input type="number" class="form-control input-default" min="1" placeholder="{{__('Enter buy items quantity')}}" name="buy_items" id="buy_items">
            </div>
            <div class="form-group">
                <label>{{__('Discount Percentage')}}</label>
                <input type="number" class="form-control input-default" min="1" max="100" placeholder="{{__('Enter Flat Percentage')}}" name="discount" id="discount">
            </div>`)
        }else{
            $('#append_offer_fields').html(`<div class="form-group">
                <label>{{__('Discount Percentage')}}e</label>
                <input type="number" class="form-control input-default" min="1" max="100" placeholder="{{_('Enter Flat Percentage')}}" name="discount" id="discount">
            </div>`)
        }
    })
</script>

{{-- Script for showing the popover message when click on the i icon that is just after the Labels--}}
<script>
    $(document).ready(function() {
        var currentPopover;

        $('[data-toggle="popover"]').popover({
            trigger: 'manual'
        });

        $(document).on('click', function(e) {
            if ($(e.target).data('toggle') !== 'popover' && !$(e.target).parents().is('.popover.show')) {
                hideCurrentPopover();
            }
        });

        $('[data-toggle="popover"]').on('click', function() {
            var clickedPopover = $(this).data('bs.popover');

            if (currentPopover && currentPopover !== clickedPopover) {
                hideCurrentPopover();
            }

            currentPopover = clickedPopover;
            $(this).popover('toggle');
        });

        function hideCurrentPopover() {
            if (currentPopover) {
                currentPopover.hide();
                currentPopover = null;
            }
        }
    });
</script>
@stop
