@extends('admin.layouts.adminLayout')
@section('title','Dashboard')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Analytical</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Analytical</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                        {{--  <button type="button" class="btn btn-primary"><i class="fa fa-download"></i> Download report</button>
                        <button type="button" class="btn btn-secondary"><i class="fa fa-send"></i> Send report</button>  --}}
                    </div>
                    <div class="p-2 d-flex">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix row-deck">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card number-chart">
                <div class="body">
                    <span class="text-uppercase">ALL Users</span>
                    <h4 class="mb-0 mt-2">{{ $totalUser }}</h4>
                    <small class="text-muted">Analytics for last week</small>
                </div>
                <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                data-line-Width="1" data-line-Color="#39afa6" data-fill-Color="#73cec7">4,1,5,2,7,3,4</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card number-chart">
                <div class="body">
                    <span class="text-uppercase">All Vendors</span>
                    <h4 class="mb-0 mt-2">{{ $totalVendor }}</h4>
                    <small class="text-muted">Analytics for last week</small>
                </div>
                <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                data-line-Width="1" data-line-Color="#ffa901" data-fill-Color="#efc26b">1,4,2,3,6,2</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card number-chart">
                <div class="body">
                    <span class="text-uppercase">Total User Subscription</span>
                    <h4 class="mb-0 mt-2">0</h4>
                    <small class="text-muted">Analytics for last week</small>
                </div>
                <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                data-line-Width="1" data-line-Color="#38c172" data-fill-Color="#84d4a6">1,4,2,3,1,5</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 d-none">
            <div class="card number-chart">
                <div class="body">
                    <span class="text-uppercase">Total Vendor Subscription</span>
                    <h4 class="mb-0 mt-2">0</h4>
                    <small class="text-muted">Analytics for last week</small>
                </div>
                <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                data-line-Width="1" data-line-Color="#226fd8" data-fill-Color="#7ea7de">1,3,5,1,4,2</div>
            </div>
        </div>
    </div>

    <div class="row clearfix row-deck d-none">
        <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card top_widget">
                        <div id="top_counter3" class="carousel slide" data-ride="carousel" data-interval="2300">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="body">
                                        <div class="icon"><i class="fa fa-money"></i></div>
                                        <div class="content">
                                            <div class="text mb-2 text-uppercase">Vendor Revenue</div>
                                            <h4 class="number mb-0">{{ $totalEarning }}<span class="font-12 text-muted"></span></h4>
                                            <small class="text-muted">Analytics for last week</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="body">
                                        <div class="icon"><i class="fa fa-money"></i></div>
                                        <div class="content">
                                            <div class="text mb-2 text-uppercase">Discount Through Platform</div>
                                            <h4 class="number mb-0">{{ $totalDiscount }}<span class="font-12 text-muted"></span></h4>
                                            <small class="text-muted">Analytics for last week</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="card top_widget">
                        <div id="top_counter1" class="carousel slide" data-ride="carousel" data-interval="2500">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="body">
                                        <div class="icon"><i class="fa fa-gift"></i></div>
                                        <div class="content">
                                            <div class="text mb-2 text-uppercase">Coupon Redeemed</div>
                                            <h4 class="number mb-0">{{ $totalRedeemed }} <span class="font-12 text-muted"></span></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="body">
                                        <div class="icon"><i class="fa fa-gift"></i></div>
                                        <div class="content">
                                            <div class="text mb-2 text-uppercase">Pending Request</div>
                                            <h4 class="number mb-0">{{ $totalPending }}<span class="font-12 text-muted"></span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="card top_widget">
                        <div id="top_counter4" class="carousel slide" data-ride="carousel" data-interval="2300">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="body">
                                        <div class="icon"><i class="fa fa-gift"></i></div>
                                        <div class="content">
                                            <div class="text mb-2 text-uppercase">Total Coupon</div>
                                            <h4 class="number mb-0">{{ $totalCoupon }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="body">
                                        <div class="icon"><i class="fa fa-gift"></i></div>
                                        <div class="content">
                                            <div class="text mb-2 text-uppercase">Shared Coupon</div>
                                            <h4 class="number mb-0">{{ $totalShared }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="card">
                <div class="header">
                    <h2>Properties Analytics</h2>
                    <ul class="header-dropdown">
                        {{--  <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another Action</a></li>
                                <li><a href="javascript:void(0);">Something else</a></li>
                            </ul>
                        </li>  --}}
                    </ul>
                </div>
                <div class="body">
                    <div id="Properties-Analytics" style="height: 17rem"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="card">
                <div class="header">
                    <h2>Coupon Ratio</h2>
                </div>
                <div class="body">
                    <div id="Gender-Ratio" style="height: 14rem"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
@stop
