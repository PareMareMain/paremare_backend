<div class="sidebar-scroll">
    <div class="user-account">
        @if(Auth::user()->profile_image)
        <div class="user-img-w"><img src="{{ Auth::user()->profile_image }}" class="rounded-circle user-photo" alt="User Profile Picture"></div>
        @else
        <div class="user-img-w"><img src="{{ asset('admin/assets/images/user.png') }}" class="rounded-circle user-photo" alt="User Profile Picture"></div>
        @endif
        <div class="dropdown">

            <span>{{ Auth::user()->name??'' }},</span>
            <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong></strong></a>
            <ul class="dropdown-menu dropdown-menu-right account">

                {{--  <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li>
                <li class="divider"></li>  --}}
                <li><a href="javascript:;" class="logout"><i class="fa fa-power-off"></i>{{__("Logout")}}</a></li>
            </ul>
        </div>
        <hr>
    </div>
    <!-- Tab panes -->
    <div class="tab-content padding-0">
        <div class="tab-pane active" id="menu">
            <nav id="left-sidebar-nav" class="sidebar-nav">
                <ul class="metismenu li_animation_delay">

                    <li class="<?php if(@$pages=='dashboard'){echo 'active';} ?>"><a href="{{route('vendor.dashboard')}}"><i class="fa fa-dashboard"></i><span>{{__("Dashboard")}}</span></a></li>
                    <li class="<?php if(@$pages=='profile'){echo 'active';} ?>"><a href="{{ route('vendor.profile') }}"><i class="fa fa-user-md"></i>{{__("My Profile")}}</a></li>
                    <li class="<?php if(@$pages=='coupon'){echo 'active';} ?>"><a href="{{ route('coupon.index') }}"><i class="fa fa-gift"></i><span>{{__("Coupon Management")}}</span></a></li>
                    <li class="<?php if(@$pages=='history'){echo 'active';} ?>"><a href="{{route('coupon.couponRedeemList')}}"><i class="fa fa-users"></i><span>{{__("Redeemed Coupons")}}</span></a></li>
                    {{--<li class="<?php if(@$pages=='redeem'){echo 'active';}?>"><a href="#Apps" class="has-arrow"><i class="fa fa-users"></i><span>{{__("Coupon Redeem")}}</span></a>
                        <ul>
                            <li class="<?php if(@$subPages=='redeem'){echo 'active';}?>"><a href="{{route('coupon.couponApplyedList')}}">{{__("Pending Request")}}</a></li>--
                            <li class="<?php if(@$subPages=='history'){echo 'active';}?>"><a href="{{route('coupon.couponRedeemList')}}">{{__("History")}}</a></li>

                        </ul>
                    </li>-- --}}

                    {{--<li class="<?php if(@$pages=='banner'){echo 'active';} ?>"><a href="{{ route('vendor-banner.index') }}"><i class="fa fa-bars"></i><span>{{__("Banner Management")}}</span></a></li>
                    <li class="<?php if(@$pages=='menus'){echo 'active';} ?>"><a href="{{ route('vendor.getMenus') }}"><i class="fa fa-list"></i><span>{{__("Menu/Services")}}</span></a></li>-- --}}
                    <li class="<?php if(@$pages=='password'){echo 'active';} ?>"><a href="{{ route('vendor.change_password') }}"><i class="fa fa-key"></i>{{__("Change Password")}}</a></li>
                </ul>
            </nav>
        </div>
        <div class="tab-pane" id="setting">
            <h6>Choose Skin</h6>
            <ul class="choose-skin list-unstyled">
                <li data-theme="purple"><div class="purple"></div></li>
                <li data-theme="blue"><div class="blue"></div></li>
                <li data-theme="cyan" class="active"><div class="cyan"></div></li>
                <li data-theme="green"><div class="green"></div></li>
                <li data-theme="orange"><div class="orange"></div></li>
                <li data-theme="blush"><div class="blush"></div></li>
                <li data-theme="red"><div class="red"></div></li>
            </ul>

            <ul class="list-unstyled font_setting mt-3">
                <li>
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="font" value="font-nunito" checked="">
                        <span class="custom-control-label">Nunito Google Font</span>
                    </label>
                </li>
                <li>
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="font" value="font-ubuntu">
                        <span class="custom-control-label">Ubuntu Font</span>
                    </label>
                </li>
                <li>
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="font" value="font-raleway">
                        <span class="custom-control-label">Raleway Google Font</span>
                    </label>
                </li>
                <li>
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="font" value="font-IBMplex">
                        <span class="custom-control-label">IBM Plex Google Font</span>
                    </label>
                </li>
            </ul>

            <ul class="list-unstyled mt-3">
                <li class="d-flex align-items-center mb-2">
                    <label class="toggle-switch theme-switch">
                        <input type="checkbox">
                        <span class="toggle-switch-slider"></span>
                    </label>
                    <span class="ml-3">Enable Dark Mode!</span>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <label class="toggle-switch theme-rtl">
                        <input type="checkbox">
                        <span class="toggle-switch-slider"></span>
                    </label>
                    <span class="ml-3">Enable RTL Mode!</span>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <label class="toggle-switch theme-high-contrast">
                        <input type="checkbox">
                        <span class="toggle-switch-slider"></span>
                    </label>
                    <span class="ml-3">Enable High Contrast Mode!</span>
                </li>
            </ul>

            <hr>
            <h6>General Settings</h6>
            <ul class="setting-list list-unstyled">
                <li>
                    <label class="fancy-checkbox">
                        <input type="checkbox" name="checkbox" checked>
                        <span>Allowed Notifications</span>
                    </label>
                </li>
                <li>
                    <label class="fancy-checkbox">
                        <input type="checkbox" name="checkbox">
                        <span>Offline</span>
                    </label>
                </li>
                <li>
                    <label class="fancy-checkbox">
                        <input type="checkbox" name="checkbox">
                        <span>Location Permission</span>
                    </label>
                </li>
            </ul>

            <a href="#" target="_blank" class="btn btn-block btn-primary">Buy this item</a>
            <a href="https://themeforest.net/user/wrraptheme/portfolio" target="_blank" class="btn btn-block btn-secondary">View portfolio</a>
        </div>

    </div>
</div>
