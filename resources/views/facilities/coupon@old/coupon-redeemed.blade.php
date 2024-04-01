@extends('facilities.layouts.vendorLayout')
@section('title','Coupan Management')
@section('content')
<style>
    .contact-title{
        width: 100% !important;
    }
</style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 p-r-0 title-margin-right">
                <div class="page-header">
                    <div class="page-title">
                    </div>
                </div>
            </div>
            <!-- /# column -->
            <div class="col-lg-4 p-l-0 title-margin-left">
                <div class="page-header">
                    <div class="page-title">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('vendor.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Invoice</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /# column -->
        </div>
        <!-- /# row -->
        <section id="main-content text-center">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-title">
                            <h4>Invoice</h4>

                        </div>
                        <div class="card-body">
                            <div class="user-profile">
                                <div class="row">
                                        <div class="col-lg-12">
                                            <div class="user-profile-name" style="align:center"><strong>{{ $data->users->name ?? 'N/A' }}</strong></div>

                                            <div class="custom-tab user-profile-tab">
                                                <div class="tab-content">
                                                    <div role="tabpanel" class="tab-pane active" id="1">
                                                        <div class="contact-information">
                                                            <div class="phone-content">
                                                                <span class="contact-title"><strong>Coupon Applied :</strong> {{ $data->coupons->coupon_code ?? ''}}</span>
                                                                <span class="phone-number"></span>
                                                            </div>
                                                            <div class="phone-content">
                                                                <span class="contact-title"><strong>Coupon Code :</strong> {{ $data->coupons->coupon_code ?? 'N/A'}}</span>
                                                                <span class="phone-number"></span>
                                                            </div>
                                                            @php
                                                                $total=((float)$data->total_paid + (float)$data->total_discount) ;

                                                            @endphp
                                                            @if($data->coupons && ($data->coupons->offer_type=='percentage'))
                                                                <div class="email-content">
                                                                    <span class="contact-title"><strong>Offer Type : </strong>{{ $data->coupons->offer_type=='percentage'?'Percentage':'' }}</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                                <div class="email-content">
                                                                    <span class="contact-title"><strong>Discount : </strong>{{ $data->coupons->discount }} %</span>
                                                                    <span class="contact-email"></span>
                                                                </div>

                                                            @elseif($data->coupons && ($data->coupons->offer_type=='amount'))
                                                                <div class="email-content">
                                                                    <span class="contact-title"><strong>Offer Type : </strong>{{ $data->coupons->offer_type=='amount'?'Flat in AED':'' }}</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                                <div class="email-content">
                                                                    <span class="contact-title"><strong>Discount : </strong>{{ $data->coupons->discount }} AED</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                            @elseif($data->coupons && ($data->coupons->offer_type=='buy-get-percentage'))
                                                                <div class="email-content">
                                                                    <span class="contact-title"><strong>Offer Type :</strong> {{ $data->coupons->offer_type=='buy-get-percentage'?'Buy X and Get Y Percentage Off':'' }}</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                                <div class="email-content">
                                                                    <span class="contact-title"><strong>Discount :</strong>Buy {{ $data->coupons->buy_items ?? 0 }} get {{ $data->coupons->discount ?? 0}} % off</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                            @elseif($data->coupons && ($data->coupons->offer_type=='buy-get'))
                                                                <div class="email-content">
                                                                    <span class="contact-title"><strong>Offer Type :</strong> {{ $data->coupons->offer_type=='buy-get'?'Buy X and Get Y':'' }}</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                                <div class="email-content">
                                                                    <span class="contact-title"><strong>Discount :</strong>Buy {{ $data->coupons->buy_items ?? 0 }} get {{ $data->coupons->free_items ?? 0}} Free</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                            @endif
                                                            <div class="email-content">
                                                                    <span class="contact-title"><strong> Total Amount :</strong> {{ $total ?? 0 }} AED</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                                <div class="email-content">
                                                                    <span class="contact-title"><strong>Discount Amount :</strong> {{ $data->total_discount ?? 0 }} AED</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                                <div class="email-content">
                                                                    <span class="contact-title"><strong>Recieved Amount :</strong> {{ $data->total_paid ?? 0 }} AED</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </section>
    </div>
@stop
