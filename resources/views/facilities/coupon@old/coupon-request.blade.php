
@extends('facilities.layouts.vendorLayout')
@section('title','Coupan Management')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    {{--  <h1>Hello, <span>Welcome Here</span></h1>  --}}
                </div>
            </div>
        </div><!-- /# column -->
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Coupon Request</li>
                    </ol>
                </div>
            </div>
        </div><!-- /# column -->
    </div><!-- /# row -->
    <section id="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-title">
                        <h4>Coupon Redeem</h4>
                        {{--  <p>A very basic simple user cards.</p>  --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse ($data as $key=>$value)
                <div class="col-lg-4">
                    <div class="card">
                        <div class="user-card-profile round-img text-center">
                            <img class="height-150" src="{{ $value->users->profile_image }}" alt="">
                        </div>
                        <div class="designation m-t-27 m-b-27 text-center">
                            <h4>{{ $value->users->name ?? 'N/A'}}</h4>
                            <h6>Coupon Code:{{ $value->coupons->coupon_code ?? '--' }}</h6>
                        </div>
                        <div class="social-connect text-center">
                            @if($value->status=='vendor_redeem')
                                <a href="{{ route('coupon.couponInvoice',$value->id) }}" class="btn btn-primary btn-sm" id="submit">View Invoice</a>
                            @else
                                <a href="{{ route('coupon.couponRequestdetail',$value->id) }}" class="btn btn-primary btn-sm">View Details</a>
                            @endif

                        </div>
                    </div>
                </div>
            @empty
            <div class="col-lg-4">
                <div class="card text-center">
                   <h4>No Records</h4>
                </div>
            </div>
            @endforelse
            {{ $data->links()}}
        </div>
    </section>
</div>
@stop
@section('scripts')
@stop
