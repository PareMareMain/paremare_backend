@extends('admin.layouts.adminLayout')
@section('title','Coupan Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Coupon Redeemed Detail</h2>
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
                    <h2>More Details</h2>
                </div>
                <div class="body">
                    <h4>{{ $data->users->name ?? 'N/A' }}</h4>
                    <div class="table-responsive">

                        <table class="table table-sm table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Coupon Title</th>
                                    <td>{{ $data->coupons->tag_title ?? ''}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Coupon Description</th>
                                    <td>{{ $data->coupons->getTranslation('what_inside', 'en') ?? ''}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Vendor Name</th>
                                    <td>{{ $data->vendorDetails->getTranslation('name', 'en') ?? ''}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Redeem Date Time</th>
                                    <td>{{ $data->vendorDetails->created_at ?? ''}}</td>
                                </tr>
                                @if($data->coupons && ($data->coupons->offer_type=='percentage'))
                                <tr>
                                    <th scope="row">Offer Type: </th>
                                    <td><span class="badge badge-primary">{{ $data->coupons->offer_type=='percentage'?'Percentage':'' }}</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Discount: </th>
                                    <td>{{ $data->coupons->discount }} %</span></td>
                                </tr>

                                @elseif($data->coupons && ($data->coupons->offer_type=='amount'))
                                    <tr>
                                        <th scope="row">Offer Type: </th>
                                        <td><span class="badge badge-primary">{{ $data->coupons->offer_type=='amount'?'Flat in AED':'' }}</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Discount: </th>
                                        <td>{{ $data->coupons->discount }} AED</span></td>
                                    </tr>
                                @elseif($data->coupons && ($data->coupons->offer_type=='buy-get-percentage'))
                                    <tr>
                                        <th scope="row">Offer Type: </th>
                                        <td><span class="badge badge-primary">{{ $data->coupons->offer_type=='buy-get-percentage'?'Buy X and Get Y Percentage Off':'' }}</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Discount: </th>
                                        <td>Buy {{ $data->coupons->buy_items ?? 0 }} get {{ $data->coupons->discount ?? 0}} % off</span></td>
                                    </tr>
                                @elseif($data->coupons && ($data->coupons->offer_type=='buy-get'))
                                    <tr>
                                        <th scope="row">Offer Type: </th>
                                        <td><span class="badge badge-primary">{{ $data->coupons->offer_type=='buy-get'?'Buy X and Get Y':'' }}</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Discount: </th>
                                        <td>Buy {{ $data->coupons->buy_items ?? 0 }} get {{ $data->coupons->free_items ?? 0}} Free</span></td>
                                    </tr>
                                @endif

                                {{-- 
                                    <tr>
                                    <th scope="row">Total Amount:</th>
                                    <td>{{ $total ?? 0 }} AED</td>
                                </tr>
                                    <tr>
                                    <th scope="row">Discount Amount:</th>
                                    <td>{{ $data->total_discount ?? 0 }} AED</td>
                                </tr>
                                <tr>
                                    <th scope="row">Recieved Amount:</th>
                                    <td>{{ $data->total_paid ?? 0 }} AED</td>
                                </tr> --}}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@stop
