<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
    <div class="nano">
        <div class="nano-content">
            <ul>
                <div class="logo"><a href="{{route('dashboard')}}">
                        <!-- <img src="images/logo.png" alt="" /> --><span>ClubJ</span></a></div>
                <li class="label">Main</li>
                <li><a href="{{route('dashboard')}}"><i class="ti-home"></i> Dashboard </a></li>
                {{-- <li><a class="sidebar-sub-toggle"><i class="ti-home"></i> Dashboard <span
                            class="badge badge-primary">2</span> <span
                            class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="index.html">Dashboard 1</a></li>
                        <li><a href="index.html">Dashboard 2</a></li>
                    </ul>
                </li> --}}

                <li class="label">Apps</li>

                <li><a class="sidebar-sub-toggle"><i class="ti-user"></i>Categories Management<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="{{route('category.index')}}">Categories</a></li>
                    </ul>
                </li>
                <li><a class="sidebar-sub-toggle"><i class="ti-user"></i> User Management <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="{{route('user.index')}}">Users</a></li>
                        <li><a href="{{route('vendor.index')}}">Vendors</a></li>

                    </ul>
                </li>
                <li><a class="sidebar-sub-toggle"><i class="ti-wand"></i> Coupon Management <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="{{ route('coupon.getCouponList') }}">Coupons</a></li>
                        {{-- <li><a href="{{route('platform.index')}}">Add Platform Coupon</a></li> --}}

                    </ul>
                </li>
                <li><a class="sidebar-sub-toggle"><i class="ti-view-list-alt"></i> Setting <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="{{ route('setting',['type'=>'terms']) }}">Terms & Conditions</a></li>
                        <li><a href="{{ route('setting',['type'=>'privacy']) }}">Privacy & Policy</a></li>
                        <li><a href="{{ route('setting',['type'=>'aboutus']) }}">About Us</a></li>
                        <li><a href="{{ route('faq') }}">Faq</a></li>
                        <li><a href="{{ route('contactUs') }}">Contact-us</a></li>

                    </ul>
                </li>

                <li><a href="{{ route('banner.index') }}"><i class="ti-calendar"></i> Banner Management </a></li>
                {{--  <li><a href="{{ route('coupon.getCouponList') }}"><i class="ti-wand"></i>Coupons</a></li>  --}}
                <li><a href="#" class="logout"><i class="ti-power-off"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>
