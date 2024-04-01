@extends('admin.layouts.adminLayout')
@section('title', 'Coupon Management')
@section('content')
<style>
    .btn-group-sm>.btn, .btn-sm{
        line-height: 0.8 !important;
    }
</style>
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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Coupon List</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /# column -->
        </div>
        <!-- /# row -->
        <section id="main-content">
            <div class="row">
                <div class="col-lg-12">
                    {{--  <a href="{{ route('category.create') }}" class="btn btn-md btn-primary">Add</a>  --}}
                    <div class="card">
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="myTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User Name</th>
                                            <th>Coupon Code</th>
                                            <th>Offer Type</th>
                                            <th>Offer</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    {{ $value->users->name ?? 'N/A' }}
                                                </td>
                                                <td>{{ $value->coupons->coupon_code ?? '--' }}</td>
                                                <td>
                                                    @if($value->coupons->offer_type=='buy-get')
                                                        Buy And Get
                                                    @elseif($value->coupons->offer_type=='buy-get-percentage')
                                                        Buy And Get Percentage
                                                    @elseif($value->coupons->offer_type=='percentage')
                                                        Percentage
                                                    @elseif($value->coupons->offer_type=='amount')
                                                        Amount
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($value->coupons->offer_type=='buy-get')
                                                        Buy {{ $value->coupons->buy_items ?? '' }} And Get {{ $value->coupons->free_items ?? '' }} Free
                                                    @elseif($value->coupons->offer_type=='buy-get-percentage')
                                                        Buy {{ $value->coupons->buy_items ?? '' }} And Get {{ $value->coupons->discount ?? '' }} % off
                                                    @elseif($value->coupons->offer_type=='percentage')
                                                        {{ $value->coupons->discount ?? '' }} % off
                                                    @elseif($value->coupons->offer_type=='amount')
                                                    {{ $value->coupons->discount ?? '' }} AED off
                                                    @endif

                                                </td>
                                                <td>
                                                    {{ $value->status=='user_redeem'?'Pending':'Redeemed' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('coupon.getCouponDetails',$value->id) }}" title="View Details and KYC"><i class="ti-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('scripts')
@stop
