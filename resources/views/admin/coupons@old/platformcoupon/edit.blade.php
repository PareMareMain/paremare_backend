@extends('admin.layouts.adminLayout')
@section('title','Coupan Management')
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
                                <li class="breadcrumb-item active">Edit Coupon</li>
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
                                <h4>Edit Coupon</h4>

                            </div>
                            <div class="card-body mt-3">
                                <div class="basic-form">
                                    <form action="{{route('platform.update',$data->id)}}" id="myform" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter Title Name" value="{{ $data->tag_title }}" name="tag_title" id="tag_title">
                                        </div>
                                        <div class="form-group">
                                            <label>Tag Name</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter offer Name" value="{{ $data->tag_name }}" name="tag_name" id="tag_name">
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
                                                <option value="percentage" <?php if($data->offer_type=='percentage'){ echo 'selected';} ?> >Percentage</option>
                                                <option value="amount" <?php if($data->offer_type=='amount'){ echo 'selected';} ?> >Amount</option>
                                                <option value="buy-get" <?php if($data->offer_type=='buy-get'){ echo 'selected';} ?> >Buy X and Get Y</option>
                                                <option value="buy-get-percentage" <?php if($data->offer_type=='buy-get-percentage'){ echo 'selected';} ?> >Buy X and Get Y Percentage</option>
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
                                            <label>End Date</label>
                                            <input type="date" class="form-control input-default" value="{{ $data->end_date }}" name="end_date" id="end_date">
                                        </div>
                                        <div class="form-group">
                                            <label>What Inside</label>
                                            <input type="text" class="form-control input-default" placeholder="Enter What Inside Content" value="{{ $data->what_inside }}" name="what_inside" id="what_inside">
                                        </div>
                                        <div class="form-group">
                                            <label>How To Redeem</label>
                                            <textarea class="form-control input-default" placeholder="Enter How To Redeem Content" name="how_to_redeem" id="how_to_redeem">{{ $data->how_to_redeem }}</textarea>
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
<script>
    CKEDITOR.replace( 'how_to_redeem' );
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
