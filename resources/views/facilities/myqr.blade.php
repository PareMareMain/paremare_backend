@extends('facilities.layouts.vendorLayout')
@section('title','QRCode')
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
                        <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /# column -->
    </div>
    <section id="main-content">
        <div class="row">
        <div class="col-lg-6">
            <div class="card">
            <div class="card-body">
                <div class="user-profile">
                <div class="row">
                    <div class="col-lg-4">
                    {{-- <label for="">Selfie Image</label> --}}
                    <div class="user-photo m-b-30">
                        <h4>QR Code</h4>
                        {!!Auth::user()->qr_code!!}

                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>

    </section>
@stop
