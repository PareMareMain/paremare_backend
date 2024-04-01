<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
    <div class="nano">
        <div class="nano-content">
            <ul>
                <div class="logo"><a href="index.html">
                        <!-- <img src="images/logo.png" alt="" /> --><span>ClubJ</span></a></div>
                <li class="label">Main</li>
                <li><a href="{{route('vendor.dashboard')}}"><i class="ti-home"></i> Dashboard </a></li>

                <li class="label">Apps</li>
                <li><a href="{{route('vendor.change_password')}}" class=""><i class="ti-key"></i> Change Password</a></li>
                <li><a href="{{route('coupon.index')}}" class=""><i class="ti-bookmark-alt"></i> Coupon Management</a></li>
                {{--  <li><a href="{{route('coupon.couponApplyedList')}}" class=""><i class="ti-bookmark-alt"></i> Coupon Request</a></li>
                <li><a href="{{route('coupon.couponRedeemList')}}" class=""><i class="ti-bookmark-alt"></i> Coupon Redeemed</a></li>
                <li><a href="{{route('coupon.onShopRedeemCreate')}}" class=""><i class="ti-bookmark-alt"></i>Apply Coupon</a></li>  --}}
                {{--  <li><a href="{{route('products.indexProducts')}}" class=""><i class="ti-bookmark-alt"></i> Product Management</a></li>  --}}
                <li><a class="sidebar-sub-toggle"><i class="ti-bookmark-alt"></i> Coupon Redeem <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="{{route('coupon.couponApplyedList')}}">Pending Request</a></li>
                        <li><a href="{{route('coupon.couponRedeemList')}}">History</a></li>
                        {{--  <li><a href="{{route('coupon.onShopRedeemCreate')}}">Apply Coupon</a></li>  --}}

                    </ul>
                </li>
                <li><a href="{{ route('vendor-banner.index') }}"><i class="ti-calendar"></i> Banner Management </a></li>
                <li><a href="#" class="logout"><i class="ti-power-off"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>
