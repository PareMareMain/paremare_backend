@extends('facilities.layouts.vendorLayout')
@section('title','Coupan Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>{{__("Coupon Redeemed Detail")}}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
                    {{-- <li class="breadcrumb-item"></li> --}}
                    <li class="breadcrumb-item active">{{__("Coupon Details")}}</li>
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
    @php
        $total=((float)$data->total_paid + (float)$data->total_discount) ;

    @endphp
    <div class="row clearfix">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>{{__("More Details")}}</h2>
                </div>
                <div class="body">
                    <h4>{{ $data->users->name ?? 'N/A' }}</h4>
                    <div class="table-responsive">

                        <table class="table table-sm table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">{{__("Coupon Applied")}}:</th>
                                    <td>{{ $data->coupons->coupon_code ?? ''}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{__("Total Amount")}}:</th>
                                    <td>{{ $total ?? 0 }} AED</td>
                                </tr>

                                @if($data->coupons && ($data->coupons->offer_type=='percentage'))
                                <tr>
                                    <th scope="row">{{__("Offer Type")}}: </th>
                                    <td><span class="badge badge-primary">{{ $data->coupons->offer_type=='percentage'?'Percentage':'' }}</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">{{__("Discount")}}: </th>
                                    <td>{{ $data->coupons->discount }} %</span></td>
                                </tr>

                                @elseif($data->coupons && ($data->coupons->offer_type=='amount'))
                                    <tr>
                                        <th scope="row">{{__("Offer Type")}}: </th>
                                        <td><span class="badge badge-primary">{{ $data->coupons->offer_type=='amount'?'Flat in AED':'' }}</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__("Discount")}}: </th>
                                        <td>{{ $data->coupons->discount }} AED</span></td>
                                    </tr>
                                @elseif($data->coupons && ($data->coupons->offer_type=='buy-get-percentage'))
                                    <tr>
                                        <th scope="row">{{__("Offer Type")}}: </th>
                                        <td><span class="badge badge-primary">{{ $data->coupons->offer_type=='buy-get-percentage'?'Buy X and Get Y Percentage Off':'' }}</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__("Discount")}}: </th>
                                        <td>Buy {{ $data->coupons->buy_items ?? 0 }} get {{ $data->coupons->discount ?? 0}} % off</span></td>
                                    </tr>
                                @elseif($data->coupons && ($data->coupons->offer_type=='buy-get'))
                                    <tr>
                                        <th scope="row">{{__("Offer Type")}}: </th>
                                        <td><span class="badge badge-primary">{{ $data->coupons->offer_type=='buy-get'?'Buy X and Get Y':'' }}</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__("Discount")}}: </th>
                                        <td>Buy {{ $data->coupons->buy_items ?? 0 }} get {{ $data->coupons->free_items ?? 0}} Free</span></td>
                                    </tr>
                                @endif

                                <tr>
                                    <th scope="row">{{__("Discount Amount")}}:</th>
                                    <td>{{ $data->total_discount ?? 0 }} AED</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{__("Recieved Amount")}}:</th>
                                    <td>{{ $data->total_paid ?? 0 }} AED</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@stop
