@extends('admin.layouts.adminLayout')
@section('title', 'User List')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 p-r-0 title-margin-right">
                <div class="page-header">
                    <div class="page-title">
                        {{-- <h1>Hello,
              <span>Welcome Here</span>
            </h1> --}}
                    </div>
                </div>
            </div>
            <!-- /# column -->
            <div class="col-lg-4 p-l-0 title-margin-left">
                <div class="page-header">
                    <div class="page-title">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">User Detail</li>
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
                    <div class="card">
                        <div class="card-title">
                            <h4>User Details</h4>

                        </div>
                        <div class="card-body">
                            <div class="user-profile">
                                <div class="row">
                                    <div class="col-lg-4">
                                        {{-- <label for="">Selfie Image</label> --}}
                                        <div class="user-photo m-b-30">

                                            @if ($user->profile_image)
                                                <img class="img-fluid" src="{{ asset($user->profile_image) }}"
                                                    alt="selfie" />
                                            @else
                                                {{-- <img class="img-fluid" src="{{ asset('admin/images/user-profile.jpg') }}"
                                                    alt="" /> --}}
                                            @endif

                                        </div>
                                    </div>
                                    @if ($user->profile_image)
                                        <div class="col-lg-8">
                                    @else
                                        <div class="col-lg-12">
                                    @endif

                                            <div class="user-profile-name">{{ $user->name ?? 'N/A' }}</div>

                                            <div class="custom-tab user-profile-tab">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li role="presentation" class="active">
                                                        <a href="#1" aria-controls="1" role="tab"
                                                            data-toggle="tab">About</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div role="tabpanel" class="tab-pane active" id="1">
                                                        <div class="contact-information">
                                                            <h4>Contact information</h4>
                                                            <div class="phone-content">
                                                                <span class="contact-title">Phone:</span>
                                                                <span
                                                                    class="phone-number">{{ $user->phone_code ?? '' }}{{ $user->phone_number ?? 'N/A' }}</span>
                                                            </div>
                                                            @if($user->location)
                                                            <div class="address-content">
                                                                <span class="contact-title">Address 1:</span>
                                                                <span
                                                                    class="mail-address">{{ $user->address_one ?? '' }}</span>
                                                            </div>
                                                            @endif
                                                            <div class="email-content">
                                                                <span class="contact-title">Email:</span>
                                                                <span
                                                                    class="contact-email">{{ $user->email ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>

                                                        {{-- <div class="basic-information">
                                                            <h4>Basic information</h4>
                                                            <div class="birthday-content">
                                                                <span class="contact-title">Birthday:</span>
                                                                <span
                                                                    class="birth-date">{{ \Carbon\Carbon::parse($user->dob)->format('d M,Y') }}</span>
                                                            </div>
                                                            <div class="gender-content">
                                                                <span class="contact-title">Gender:</span>
                                                                <span class="gender">{{ $user->gender ?? '' }}</span>
                                                            </div>
                                                        </div> --}}
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
