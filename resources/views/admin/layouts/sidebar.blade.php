<div class="sidebar-scroll">
    <div class="user-account d-flex">
        <div class="user-img-w mr-2"><img src="{{ asset('/new_logo_no_tag.png') }}" class="rounded-circle user-photo" alt="User Profile Picture"></div>
        <div class="dropdown">
            <span>{{ Auth::user()->name??'' }},</span>
            <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{ Auth::user()->admin_type }}</strong></a>
            <ul class="dropdown-menu dropdown-menu-right account">
                {{--  <li><a href="doctor-profile.html"><i class="icon-user"></i>My Profile</a></li>
                <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li>
                <li class="divider"></li>  --}}
                <li><a href="javascript:;" class="logout"><i class="icon-power"></i>Logout</a></li>
            </ul>
        </div>
        <hr>
    </div>
    <!-- Tab panes -->
    <div class="tab-content padding-0">
        <div class="tab-pane active" id="menu">
            <nav id="left-sidebar-nav" class="sidebar-nav">
                @if(Auth::user()->admin_type==='Super-Admin')
                <ul class="metismenu li_animation_delay">

                    <li class="<?php // if(@$pages=='dashboard'){echo 'active';} ?>"><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li> 
                   {{--  <li class="<?php //if(@$pages=='admin'){echo 'active';} ?>"><a href="{{route('sub-admin.index')}}"><i class="fa fa-user-circle-o"></i><span>Sub-Admin</span></a></li>--}}
                    <li class="<?php if(@$pages=='category'){echo 'active';}?>"><a href="#Apps" class="has-arrow"><i class="fa fa-list-alt"></i><span>Category Management</span></a>
                        <ul>
                            <li class="<?php if(@$subPages=='category'){echo 'active';}?>"><a href="{{route('category.index')}}">Categories</a></li>
                            <li class="<?php if(@$subPages=='tag'){echo 'active';}?>"><a href="{{route('tag.index')}}">Tags</a></li>
                        </ul>
                    </li>
                    <li class="<?php if(@$pages=='user'){echo 'active';}?>"><a href="#Apps" class="has-arrow"><i class="fa fa-users"></i><span>User Management</span></a>
                        <ul>
                            <li class="<?php if(@$subPages=='user'){echo 'active';}?>"><a href="{{route('user.index')}}">User</a></li>
                            <li class="<?php if(@$subPages=='vendor'){echo 'active';}?>"><a href="{{route('vendor.index')}}">Vendor</a></li>
                           {{-- <li class="<?php if(@$subPages=='vendor'){echo 'active';}?>"><a href="{{route('vendor.change-request')}}">Vendor Change Request</a></li>-- --}}

                        </ul>
                    </li>
                    <li class="<?php if(@$pages=='coupon'){echo 'active';}?>"><a href="#Apps" class="has-arrow"><i class="fa fa-gift"></i><span>Coupon Management</span></a>
                        <ul>
                            <li class="<?php if(@$subPages=='couponRequest'){echo 'active';}?>"><a href="{{ route('coupon.request.index') }}">Coupon</a></li>
                            <li class="<?php if(@$subPages=='coupon'){echo 'active';}?>"><a href="{{ route('coupon.getCouponRedeemedList') }}">Redeemed Coupons</a></li> 
                            {{--
                                <li class="<?php if(@$subPages=='coupon'){echo 'active';}?>"><a href="{{ route('coupon.getCouponRedeemedList') }}">Coupons</a></li> 
                                
                                <li class="<?php if(@$subPages=='platform'){echo 'active';}?>"><a href="{{route('platform.index')}}">Add Platform Coupon</a></li>--}}

                        </ul>
                    </li>
                    <li class="<?php if(@$pages=='promo'){echo 'active';}?>"><a href="#Apps" class="has-arrow"><i class="fa fa-gift"></i><span>Promo Code</span></a>
                        <ul>
                            <li class="<?php if(@$subPages=='list'){echo 'active';}?>"><a href="{{ route('admin.promo.index') }}">Promo List</a></li>                                
                            <li class="<?php if(@$subPages=='create'){echo 'active';}?>"><a href="{{route('admin.promo.create')}}">Add Promo Code</a></li>
                            <li class="<?php if(@$subPages=='promo'){echo 'active';}?>"><a href="{{route('admin.promo.list')}}">User Promo Code</a></li>
                            
                        </ul>
                    </li>
                    <li class="<?php if(@$pages=='setting'){echo 'active';}?>"><a href="#Apps" class="has-arrow"><i class="fa fa-cog"></i><span>Settings</span></a>
                        <ul>
                            <li class="<?php if(@$subPages=='aboutus'){echo 'active';}?>"><a href="{{ route('setting',['type'=>'aboutus']) }}">About Us</a></li>
                            <li class="<?php if(@$subPages=='faq'){echo 'active';}?>"><a href="{{ route('faq') }}">FAQ</a></li>
                            <li class="<?php if(@$subPages=='contactus'){echo 'active';}?>"><a href="{{ route('contactUs') }}">Contact Us</a></li>
                            <li class="<?php if(@$subPages=='terms'){echo 'active';}?>"><a href="{{ route('setting',['type'=>'terms']) }}">Terms and Conditions</a></li>
                            <li class="<?php if(@$subPages=='privacy'){echo 'active';}?>"><a href="{{ route('setting',['type'=>'privacy']) }}">Privacy Policy</a></li>
                        </ul>
                    </li>
                    <li class="<?php if(@$pages=='banner'){echo 'active';} ?>"><a href="{{ route('banner.index') }}"><i class="fa fa-bars"></i><span>Banner Management</span></a></li> 
                    <li class="<?php if(@$pages=='subscription'){echo 'active';}?>"><a href="#Apps" class="has-arrow"><i class="fa fa-life-ring"></i><span>Subscription</span></a>

                        <ul>
                            <li class="<?php if(@$subPages=='plan'){echo 'active';}?>"><a href="{{ route('plan.index') }}">Plan</a></li>
                            {{--  <li class="<?php if(@$subPages=='subscribed'){echo 'active';}?>"><a href="{{ route('payment.index') }}">List</a></li> -- --}}
                        </ul>
                    </li>

                    {{-- <li class="<?php if(@$pages=='menus'){echo 'active';} ?>"><a href="{{ route('admin.getAllMenus') }}"><i class="fa fa-list"></i><span>{{__("Menu/Services")}}</span></a></li>-- --}}
                </ul>

                @elseif(Auth::user()->admin_type=='Admin')
                @php
                    $menu = App\Models\Menu::with('submenu')->get()->toArray();
                @endphp
                <ul class="metismenu li_animation_delay">
                    <li class="<?php if(@$pages=='dashboard'){echo 'active';} ?>"><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
                    @isset($menu)
                        @foreach($menu as $key=>$value)
                            @php
                                $adminMenu = App\Models\AdminMenu::where('admin_id',Auth::user()->id)->where('menu_id',$value['id'])->where('permission',true)->first();
                            @endphp
                            @if($adminMenu)
                                @if(count($value['submenu'])>0)
                                    <li class="<?php if(@$pages==$value['tag']){echo 'active';}?>"><a href="#Apps" class="has-arrow"><i class="fa fa-list-alt"></i><span>{{ $value['name'] }}</span></a>
                                        <ul>
                                            @isset($value['submenu'])
                                                @foreach ($value['submenu'] as $val)
                                                    @php
                                                        $adminSubMenu = App\Models\AdminSubMenu::where('admin_id',Auth::user()->id)->where('sub_menu_id',$val['id'])->where('permission',true)->first();
                                                    @endphp
                                                    @if($adminSubMenu)
                                                        @if($val['tag']=='terms' || $val['tag']=='privacy' || $val['tag']=='aboutus')
                                                            <li class="<?php if(@$subPages==$val['tag']){echo 'active';}?>"><a href="{{ route('setting',['type'=>$val['route']]) }}">{{ $val['name'] }}</a></li>
                                                        @else
                                                            <li class="<?php if(@$subPages==$val['tag']){echo 'active';}?>"><a href="{{route($val['route'])}}">{{ $val['name'] }}</a></li>
                                                        @endif
                                                    @endif

                                                @endforeach

                                            @endisset

                                        </ul>
                                    </li>
                                @else
                                    <li class="<?php if(@$pages==$value['tag']){echo 'active';} ?>"><a href="{{route($value['route'])}}"><i class="fa fa-dashboard"></i><span>{{ $value['name'] }}</span></a></li>
                                @endif
                            @endif
                        {{--  <li class="<?php if(@$pages=='dashboard'){echo 'active';} ?>"><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
                        <li class="<?php if(@$pages=='category'){echo 'active';}?>"><a href="#Apps" class="has-arrow"><i class="fa fa-list-alt"></i><span>Category Management</span></a>
                            <ul>
                                <li class="<?php if(@$subPages=='category'){echo 'active';}?>"><a href="{{route('category.index')}}">Categories</a></li>
                            </ul>
                        </li>
                        <li class="<?php if(@$pages=='user'){echo 'active';}?>"><a href="#Apps" class="has-arrow"><i class="fa fa-users"></i><span>User Management</span></a>
                            <ul>
                                <li class="<?php if(@$subPages=='user'){echo 'active';}?>"><a href="{{route('user.index')}}">User</a></li>
                                <li class="<?php if(@$subPages=='vendor'){echo 'active';}?>"><a href="{{route('vendor.index')}}">Vendor</a></li>
                            </ul>
                        </li>
                        <li class="<?php if(@$pages=='coupon'){echo 'active';}?>"><a href="#Apps" class="has-arrow"><i class="fa fa-gift"></i><span>Coupon Management</span></a>
                            <ul>
                                <li class="<?php if(@$subPages=='coupon'){echo 'active';}?>"><a href="{{ route('coupon.getCouponList') }}">Coupons</a></li>
                                <li class="<?php if(@$subPages=='couponRequest'){echo 'active';}?>"><a href="{{ route('coupon.request.index') }}">Coupon Requests</a></li>
                                <li class="<?php if(@$subPages=='platform'){echo 'active';}?>"><a href="{{route('platform.index')}}">Add Platform Coupon</a></li>

                            </ul>
                        </li>
                        <li class="<?php if(@$pages=='setting'){echo 'active';}?>"><a href="#Apps" class="has-arrow"><i class="fa fa-cog"></i><span>Setting</span></a>
                            <ul>
                                <li class="<?php if(@$subPages=='terms'){echo 'active';}?>"><a href="{{ route('setting',['type'=>'terms']) }}">Terms and Conditions</a></li>
                                <li class="<?php if(@$subPages=='privacy'){echo 'active';}?>"><a href="{{ route('setting',['type'=>'privacy']) }}">Privacy and Policy</a></li>
                                <li class="<?php if(@$subPages=='aboutus'){echo 'active';}?>"><a href="{{ route('setting',['type'=>'aboutus']) }}">About Us</a></li>
                                <li class="<?php if(@$subPages=='faq'){echo 'active';}?>"><a href="{{ route('faq') }}">Faq</a></li>
                                <li class="<?php if(@$subPages=='contactus'){echo 'active';}?>"><a href="{{ route('contactUs') }}">Contact-us</a></li>
                            </ul>
                        </li>
                        <li class="<?php if(@$pages=='banner'){echo 'active';} ?>"><a href="{{ route('banner.index') }}"><i class="fa fa-bars"></i><span>Banner Management</span></a></li>  --}}
                        @endforeach
                    @endisset
                </ul>
                @endif
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
