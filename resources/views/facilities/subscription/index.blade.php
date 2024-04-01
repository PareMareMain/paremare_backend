@extends('facilities.layouts.vendorLayout')
@section('title','My Profile')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>{{__("My Profile")}}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}"><i class="fa fa-dashboard"></i></a></li>
                    {{-- <li class="breadcrumb-item">Dash</li> --}}
                    <li class="breadcrumb-item active">{{__('Profile')}}</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                        {{-- <button type="button" class="btn btn-primary"><i class="fa fa-download"></i> Edit Profile</button> --}}
                        {{-- <button type="button" class="btn btn-secondary"><i class="fa fa-send"></i> Send report</button> --}}
                    </div>
                    <div class="p-2 d-flex">

                    </div>
                </div>
            </div>
        </div>
    </div>
@php
    $lang='en';
    if(session()->get('locale')=='en'|| session()->get('locale')==null || session()->get('locale')==''){
        $lang='en';

    }else{
        $lang='ar';
    }
@endphp

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card profile-header">
                <div class="body text-center">
                    <div class="profile-image mb-3 text-center"> <img class="img-fluid rounded" src="{{Auth::user()->profile_image ?? ''}}" alt=""> </div>
                    <div class="mt-4">
                        <h4 class="mb-0"><strong>
                            @if($lang=='en')
                                {{ (Auth::user()->getTranslation('name', 'en') != '')  ? Auth::user()->getTranslation('name', 'en') : '' }}
                            @else
                                {{ (Auth::user()->getTranslation('name', 'ar') != '')  ? Auth::user()->getTranslation('name', 'ar') : '' }}
                            @endif
                        </strong></h4>
                        <span class="job_post">{{Auth::user()->country_code ?? ''}}{{Auth::user()->phone_number ?? 'N/A'}}</span>
                        <p>{{Auth::user()->location ?? 'N/A'}}</p>

                    </div>
                    <div>
                        <a href="{{route('vendor.editProfile')}}" class="btn btn-primary btn-round">{{__("Edit")}}</a>
                    </div>
                </div>
            </div>

            {{-- <div class="card">
                <div class="header">
                    <h2>Reviews</h2>
                </div>
                <div class="body">
                    <div class="reviews">
                        <span class="text-muted">Staff</span>
                        <p>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-outline"></i>
                            <i class="fa fa-star-outline"></i>
                        </p>
                        <span class="text-muted">Helpfulness</span>
                        <p>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </p>
                        <span class="text-muted">Knowledge</span>
                        <p>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-outline"></i>
                            <i class="fa fa-star-outline"></i>
                        </p>
                        <span class="text-muted">Cost</span>
                        <p>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-outline"></i>
                            <i class="fa fa-star-outline"></i>
                            <i class="fa fa-star-outline"></i>
                        </p>
                    </div>
                </div>
            </div>            --}}
        </div>
        {{-- <div class="col-lg-6 col-md-12 d-flex">
                <div class="card-new">
                    <div class="ster-sec">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                    @if(Auth::user()->getSubscriptionDetail())
                        @if(Auth::user()->getSubscriptionDetail()->end_date > (\Carbon\Carbon::now()->format('Y-m-d')))
                            <h2>{{__("Thanks to be Part of us!")}}</h2>
                            <p>{{__("Access to add unlimited banners benefits till")}} {{\Carbon\Carbon::parse(Auth::user()->getSubscriptionDetail()->end_date)->format('M d,Y')}}</p>
                            <a href="javascript:;" class="btn btn-primary btn-round">{{__("Active")}}</a>
                        @else
                            <h2>Become a Club J Member</h2>
                            <p>Access to all the coupens Present in the App.</p>
                            <a href="javascript:;" class="btn btn-primary btn-round paymentConfirm" >{{__("Activate New Plan")}}</a>
                        @endif
                    @else
                        <h2>Become a Club J Member</h2>
                        <p>Access to all the coupens Present in the App.</p>
                        <a href="javascript:;" class="btn btn-primary btn-round paymentConfirm" >{{__("Activate New Plan")}}</a>
                    @endif
                </div> --}}


            {{-- <!-- <div class="card">
                <div class="header">
                    <h1> {{__("Subscrption Plan")}}</h1>
                </div>
                <div class="body">
                    <div class="workingtime">
                        @if(Auth::user()->getSubscriptionDetail())
                            <span class="text-muted">{{__("Start Date")}}</span>
                            <p>{{\Carbon\Carbon::parse(Auth::user()->getSubscriptionDetail()->end_date)->format('d M,Y') ?? ''}}</p>
                            <span class="text-muted">{{__("End Date")}}</span>
                            <p>{{\Carbon\Carbon::parse(Auth::user()->getSubscriptionDetail()->end_date)->subDays(1)->format('d M,Y') ?? ''}}</p>
                            @if(Auth::user()->getSubscriptionDetail()->end_date >\Carbon\Carbon::now()->format('Y-m-d'))
                                <a href="javascript:;" class="btn btn-primary btn-round text-center">{{__("Active")}}</a>
                            @else
                                <a href="javascript:;" class="btn btn-primary btn-round paymentConfirm" >{{__("Activate New Plan")}}</a>
                            @endif
                        @endif

                    </div>
                </div>
            </div> --> --}}
        {{-- </div> --}}
    </div>
</div>
@stop
@section('scripts')

@stop
