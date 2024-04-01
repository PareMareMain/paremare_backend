@extends('facilities.layouts.vendorLayout')
@section('title','Dashboard')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>{{__("Analytical")}}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">{{__("Dashboard")}}</li>
                    <li class="breadcrumb-item active">{{__("Analytical")}}</li>
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
                    <span class="text-uppercase">{{__('TOTAL COUPONS')}}</span>
                    <h4 class="mb-0 mt-2">{{ $totalCoupon }}<i class="fa fa-level-up font-12"></i></h4>
                    <small class="text-muted">{{__("Analytics for till today")}}</small>
                </div>
                <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                data-line-Width="1" data-line-Color="#39afa6" data-fill-Color="#73cec7">4,1,5,2,7,3,4</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card number-chart">
                <div class="body">
                    <span class="text-uppercase">{{__("TOTAL COUPON REDEEMED")}}</span>
                    <h4 class="mb-0 mt-2">{{ $totalRedeemed }}</h4>
                    <small class="text-muted">{{__("Analytics for till today")}}</small>
                </div>
                <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                data-line-Width="1" data-line-Color="#ffa901" data-fill-Color="#efc26b">1,4,2,3,6,2</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 d-none">
            <div class="card number-chart">
                <div class="body">
                    <span class="text-uppercase">{{__("TOTAL COUPON SHARED")}}</span>
                    <h4 class="mb-0 mt-2">{{ $totalShared }}</h4>
                    <small class="text-muted">{{__("Analytics for till today")}}</small>
                </div>
                <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                data-line-Width="1" data-line-Color="#38c172" data-fill-Color="#84d4a6">1,4,2,3,1,5</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 d-none">
            <div class="card number-chart">
                <div class="body">
                    <span class="text-uppercase">{{__("TOTAL PENDING REQUESTS")}}</span>
                    <h4 class="mb-0 mt-2">{{ $totalPending }}</h4>
                    <small class="text-muted">{{__("Analytics for till today")}}</small>
                </div>
                <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                data-line-Width="1" data-line-Color="#226fd8" data-fill-Color="#7ea7de">1,3,5,1,4,2</div>
            </div>
        </div>
    </div>
    <div class="row clearfix row-deck d-none">
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card top_widget">
                        <div id="top_counter3" class="carousel slide" data-ride="carousel" data-interval="2300">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="body">
                                        <div class="icon"><i class="fa fa-eye"></i></div>
                                        <div class="content">
                                            <div class="text mb-2 text-uppercase">{{__("Total Revenue")}}</div>
                                            <h4 class="number mb-0">{{ number_format(($totalEarning + $totalDiscount),2) }} AED<span class="font-12 text-muted"></span></h4>
                                            <small class="text-muted">{{__("Analytics for till today")}}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="body">
                                        <div class="icon"><i class="fa fa-eye"></i></div>
                                        <div class="content">
                                            <div class="text mb-2 text-uppercase">{{__("Total Recieved")}}</div>
                                            <h4 class="number mb-0">{{ number_format(($totalEarning),2) }} AED <span class="font-12 text-muted"></span></h4>
                                            <small class="text-muted">{{__("Analytics for till today")}}</small>
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
                                        <div class="icon"><i class="fa fa-user"></i></div>
                                        <div class="content">
                                            <div class="text mb-2 text-uppercase">{{__("Coupon Redeemed")}}</div>
                                            <h4 class="number mb-0">{{ $totalRedeemed }} <span class="font-12 text-muted"></span></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="body">
                                        <div class="icon"><i class="fa fa-user"></i></div>
                                        <div class="content">
                                            <div class="text mb-2 text-uppercase">{{__("Total Discount")}}</div>
                                            <h4 class="number mb-0">{{ number_format(($totalDiscount),2) }} AED<span class="font-12 text-muted"></span></h4>
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
                                        <div class="icon"><i class="fa fa-thumbs-o-up"></i></div>
                                        <div class="content">
                                            <div class="text mb-2 text-uppercase">{{__("Pending Request")}}</div>
                                            <h4 class="number mb-0">{{ $totalPending }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="body">
                                        <div class="icon"><i class="fa fa-smile-o"></i></div>
                                        <div class="content">
                                            <div class="text mb-2 text-uppercase">{{__("Total Coupon")}}</div>
                                            <h4 class="number mb-0">{{ $totalCoupon }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 d-none">
            <div class="card">
                <div class="header">
                    <h2>{{__("Properties Analytics")}}</h2>
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
        {{--  <div class="col-xl-6 col-lg-4 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Properties Stats</h2>
                    <ul class="header-dropdown">
                        <li><a class="tab_btn" href="javascript:void(0);" title="Weekly">W</a></li>
                        <li><a class="tab_btn" href="javascript:void(0);" title="Monthly">M</a></li>
                        <li><a class="tab_btn active" href="javascript:void(0);" title="Yearly">Y</a></li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another Action</a></li>
                                <li><a href="javascript:void(0);">Something else</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div id="chart-bar-rotated" style="height: 17rem"></div>
                </div>
            </div>
        </div>  --}}
    </div>

    {{--  <div class="row clearfix row-deck">
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card">
                <div class="header">
                    <h2>Gender Ratio</h2>
                </div>
                <div class="body">
                    <div id="Gender-Ratio" style="height: 14rem"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card">
                <div class="header">
                    <h2>Social Counter</h2>
                </div>
                <div class="body social_counter">
                    <ul class=" list-unstyled basic-list">
                        <li><i class="fa fa-facebook-square mr-1"></i> FaceBook <span class="badge badge-primary">16,785</span></li>
                        <li><i class="fa fa-twitter-square mr-1"></i> Twitter <span class="badge badge-default">2,365</span></li>
                        <li><i class="fa fa-linkedin-square mr-1"></i> Linkedin<span class="badge badge-success">9,021</span></li>
                        <li><i class="fa fa-behance-square mr-1"></i> Behance<span class="badge badge-info">1,725</span></li>
                        <li><i class="fa fa-dribbble mr-1"></i> Dribbble<span class="badge badge-info">11,725</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-4 col-md-6">
            <div class="card">
                <div class="header">
                    <h2>Ongoing Project</h2>
                    <ul class="header-dropdown">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another Action</a></li>
                                <li><a href="javascript:void(0);">Something else</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                              <th>Name</th>
                              <th>Lead</th>
                              <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <h6 class="mb-0">Rivera Height</h6>
                                    <span class="font-12 text-muted">Due Date: 25 Jan 2023</span>
                                </td>
                                <td>
                                    <a href="agent-profile.html">
                                        <img src="../assets/images/xs/avatar1.jpg" class="rounded-circle avatar" alt="">
                                        <span>Alexander</span>
                                    </a>
                                </td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" style="width:66%; " aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6 class="mb-0">Happy Homes</h6>
                                    <span class="font-12 text-muted">Due Date: 18 June 2021</span>
                                </td>
                                <td>
                                    <a href="agent-profile.html">
                                        <img src="../assets/images/xs/avatar2.jpg" class="rounded-circle avatar" alt="">
                                        <span>Isabella</span>
                                    </a>
                                </td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-success" role="progressbar" style="width:89%; " aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6 class="mb-0">Sivalik Park 2</h6>
                                    <span class="font-12 text-muted">Due Date: 22 Nov 2024</span>
                                </td>
                                <td>
                                    <a href="agent-profile.html">
                                        <img src="{{ asset('admin/assets/images/xs/avatar3.jpg') }}" class="rounded-circle avatar" alt="">
                                        <span>Chris</span>
                                    </a>
                                </td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" style="width:29%; " aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  --}}
</div>
@stop
@section('scripts')
<script>
    var sharedPercentag={{$sharedPercentage}};
    var pendingPercentage={{$pendingPercentage}};
    var redeemPercentage={{$redeemPercentage}};
    //  Use by Device
    $(document).ready(function(){

        console.log(sharedPercentag)
        console.log(pendingPercentage)
        console.log(redeemPercentage)
        var chart = c3.generate({
            bindto: '#Properties-Analytics', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    // ['data1', 48],
                    ['data2', sharedPercentag],
                    ['data3', pendingPercentage],
                    ['data4', redeemPercentage],
                ],
                type: 'pie', // default type of chart
                colors: {
                    // 'data1': Iconic.colors["theme-cyan1"],
                    'data2': Iconic.colors["theme-cyan1"],
                    'data3': Iconic.colors["theme-cyan5"],
                    'data4': Iconic.colors["theme-cyan2"],
                },
                names: {
                    // name of each serie
                    // 'data1': 'Commercial',
                    'data2': 'Shared Coupon',
                    'data3': 'Pending Requests',
                    'data4': 'Coupon Redeemed',
                }
            },
            axis: {
            },
            legend: {
                show: false, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });
</script>
@stop
