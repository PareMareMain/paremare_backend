
@extends('facilities.layouts.vendorLayout')
@section('title','Coupan Redeem')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>{{__("Redeemed Coupons")}}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    {{-- <li class="breadcrumb-item"></li> --}}
                    <li class="breadcrumb-item active">{{__("Coupons Request")}}</li>
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
        @forelse ($data as $key=>$value)
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="body">

                    <img src="{{ $value->users->profile_image }}" alt=""  class="img-fluid rounded mb-3">
                    <h6 class="mb-4 font-weight-bold">{{ $value->users->name ?? 'N/A'}}</h6>
                    <ul class="list-unstyled">
                        {{-- <li class="d-flex justify-content-between">
                            <label class="mb-2 font-weight-bold text-muted">{{__("Coupon Code")}}:</label>
                            <span>{{ $value->coupons->coupon_code ?? '--' }}</span>
                        </li>-- --}}
                        <li class="d-flex justify-content-between">
                            <label class="mb-2 font-weight-bold text-muted">{{__("Coupon Title")}}:</label>
                            <span>{{ $value->coupons->tag_title ?? '--' }}</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <label class="mb-2 font-weight-bold text-muted">{{__("Redeem Date")}}:</label>
                            <span>{{ \Carbon\Carbon::parse($value->created_at)->format('d M,Y') }}</span>
                        </li>
                        {{-- <li class="d-flex justify-content-between">
                            <label class="mb-2 font-weight-bold text-muted">{{__("Expire Date")}}:</label>
                            <span class="text-danger">{{ \Carbon\Carbon::parse($value->coupons->end_date)->format('d M,Y') }}</span>
                        </li>
                        <li class="d-flex justify-content-between d-none">
                            <label class="mb-2 font-weight-bold text-muted">{{__("Offer Type")}}:</label>
                            @if($value->coupons->offer_type=='percentage')
                                <span>Percentage</span>
                            @elseif($value->coupons->offer_type=='amount')
                                <span>Amount</span>
                            @elseif($value->coupons->offer_type=='buy-get')
                                <span>Buy X and Get Y</span>
                            @elseif($value->coupons->offer_type=='buy-get-percentage')
                                <span>Buy X and Get Y Percentage</span>
                            @endif
                        </li> -- --}}
                    </ul>
                    {{-- @if($value->status=='vendor_redeem')
                        <a href="{{ route('coupon.couponInvoice',$value->id) }}" class="btn btn-primary" role="button">{{__("Read more")}}</a>
                    @else
                        <a href="{{ route('coupon.couponRequestdetail',$value->id) }}" class="btn btn-primary" role="button">{{__("Read more")}}</a>
                    @endif --}}

                </div>
            </div>
        </div>
        @empty
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <h4>{{__("No Records")}}</h4>
            </div>
        @endforelse
            {{ $data->links()}}
    </div>
</div>
@stop
@section('scripts')
@stop
