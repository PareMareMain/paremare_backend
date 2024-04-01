@extends('admin.layouts.adminLayout')
@section('title','Coupan Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Coupon Detail</h2>
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
                    <h4>{{ $data->vendorDetail->name ?? 'N/A' }}</h4>
                    <div class="table-responsive">

                        <table class="table table-sm table-bordered mb-0">
                            <tbody>
                                <tr>
                                    {{--/{{ ($data->getTranslation('tag_title', 'ar') != '')  ? $data->getTranslation('tag_title', 'ar') : '' }} --}}
                                    <th scope="row">Coupon Title:</th>
                                    <td>{{ ($data->getTranslation('tag_title', 'en') != '')  ? $data->getTranslation('tag_title', 'en') : '' }}</td>
                                </tr>
                                {{-- <tr>
                                    <th scope="row">Tag Name:</th>
                                    <td>{{ ($data->getTranslation('tag_name', 'en') != '')  ? $data->getTranslation('tag_name', 'en') : '' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Coupon Code:</th>
                                    <td>{{ $data->coupon_code ?? 0 }} AED</td>
                                </tr>

                                @if($data && ($data->offer_type=='percentage'))
                                <tr>
                                    <th scope="row">Offer Type: </th>
                                    <td><span class="badge badge-primary">{{ $data->offer_type=='percentage'?'Percentage':'' }}</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Discount: </th>
                                    <td>{{ $data->discount }} %</span></td>
                                </tr>

                                @elseif($data && ($data->offer_type=='amount'))
                                    <tr>
                                        <th scope="row">Offer Type: </th>
                                        <td><span class="badge badge-primary">{{ $data->offer_type=='amount'?'Flat in AED':'' }}</span></td>
                                    </tr>
                                @elseif($data && ($data->offer_type=='buy-get-percentage'))
                                    <tr>
                                        <th scope="row">Offer Type: </th>
                                        <td><span class="badge badge-primary">{{ $data->offer_type=='buy-get-percentage'?'Buy X and Get Y Percentage Off':'' }}</span></td>
                                    </tr>   
                                @elseif($data && ($data->offer_type=='buy-get'))
                                    <tr>
                                        <th scope="row">Offer Type: </th>
                                        <td><span class="badge badge-primary">{{ $data->offer_type=='buy-get'?'Buy X and Get Y':'' }}</span></td>
                                    </tr>
                                @endif
                                <tr>
                                    <th scope="row">How to Redeem</th>
                                    <td>{{ ($data->getTranslation('how_to_redeem', 'en') != '')  ? $data->getTranslation('how_to_redeem', 'en') : '' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">End Date</th>
                                    <td>{{ ($data->end_date != null)  ? $data->end_date : '' }}</td>
                                </tr>
                                -- --}}
                                <tr>
                                    <th scope="row">Coupon Description</th>
                                    <td>{{ ($data->getTranslation('what_inside', 'en') != '')  ? $data->getTranslation('what_inside', 'en') : '' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">How to Redeem</th>
                                    @if($data && ($data->redeem_type=='in_the_store'))
                                    <td>{{ ($data->redeem_type != null)  ? 'With Pin' : '' }}</td>
                                    @elseif($data && ($data->redeem_type=='online'))
                                    <td>{{ ($data->redeem_type != null)  ? 'With Link' : '' }}</td>
                                    @elseif($data && ($data->redeem_type=='both'))
                                    <td>{{ ($data->redeem_type != null)  ? 'Pin/Link' : '' }}</td>
                                    @endif
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
