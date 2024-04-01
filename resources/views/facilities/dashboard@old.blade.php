@extends('facilities.layouts.vendorLayout')
@section('title','Dashboard')
@section('content')
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
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>
    <!-- /# row -->
    <section id="main-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="ti-money color-success border-success"></i>
                        </div>
                        <div class="stat-content dib">
                            <div class="stat-text">Total Booking</div>
                            <div class="stat-digit">1,012</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="ti-user color-primary border-primary"></i>
                        </div>
                        <div class="stat-content dib">
                            <div class="stat-text">Left Locker</div>
                            <div class="stat-digit">961</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="ti-layout-grid2 color-pink border-pink"></i>
                        </div>
                        <div class="stat-content dib">
                            <div class="stat-text">Total Locker</div>
                            <div class="stat-digit">770</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="stat-widget-one">
                        <div class="stat-icon dib"><i class="ti-link color-danger border-danger"></i></div>
                        <div class="stat-content dib">
                            <div class="stat-text">Referral</div>
                            <div class="stat-digit">2,781</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-title">
                        <h4>Fee Collections and Expenses</h4>

                    </div>
                    <div class="card-body">
                        <div class="ct-bar-chart m-t-30"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">

                    <div class="card-body">
                        <div class="ct-pie-chart"></div>
                    </div>
                </div>
            </div>
        </div> --}}

    </section>
</div>
@stop
@section('scripts')
@stop
