@extends('admin.layouts.adminLayout')
@section('title', 'User List')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>User Profile</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">User</li>
                    <li class="breadcrumb-item active">Profile</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                        {{--  <button type="button" class="btn btn-primary"><i class="fa fa-download"></i> Download report</button>--}}
                        <a href="{{route('user.index')}}"><button type="button" class="btn btn-primary"><i class="fa fa-Plus"></i> Back</button></a>
                    </div>
                    <div class="p-2 d-flex">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-8 col-md-12">
            <div class="card member-card">
                <div class="header primary-bg text-light mb-3">
                    <h4 class="mt-2 mb-0">{{ $user->name ?? 'Unknown' }}</h4>
                    <span>{{ $user->phone_code?? '' }}{{ $user->phone_number?? 'Phone' }}</span>
                </div>
                <div class="member-img">
                    @if($user->profile_image)
                        <a href="javascript:void(0);"><img src="{{ $user->profile_image }}" class="rounded-circle" alt="profile-image"></a>
                    @else
                    <a href="javascript:void(0);"><img src="../assets/images/lg/avatar2.jpg" class="rounded-circle" alt="profile-image"></a>
                    @endif
                </div>
                <div class="body">
                    {{--  <ul class="social-links list-unstyled">
                        <li><a title="facebook" href="javascript:void(0);"><i class="fa fa-facebook"></i></a></li>
                        <li><a title="twitter" href="javascript:void(0);"><i class="fa fa-twitter"></i></a></li>
                        <li><a title="instagram" href="javascript:void(0);"><i class="fa fa-instagram"></i></a></li>
                    </ul>  --}}
                    <p class="text-muted mb-3">{{ $user->address_one ?? '' }}<br> {{  $user->address_two ?? '' }}</p>
                    <div class="row  d-none">
                        <div class="col-6">
                            <h5 class="mb-1">{{$userClaimedCoupon ?? 0}}</h5>
                            <small>Coupon Claimed</small>
                        </div>
                        <div class="col-4 d-none">
                            <h5 class="mb-1">{{$userSharedCoupon ?? 0}}</h5>
                            <small>Total Share</small>
                        </div>
                        <div class="col-6">
                            <h5 class="mb-1">{{$userTotalSaving}} AED</h5>
                            <small>Total Saving</small>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="body">
                    <ul class="nav nav-tabs-new2">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#about">About</a></li>
                    </ul>
                    <div class="tab-content pl-0 pr-0 pb-0">
                        <div class="tab-pane active" id="about">

                            <small class="text-muted">Email address: </small>
                            <p>
                            <input type="text" class="form-control " placeholder="Enter email" id="email" value="{{$user->email}}">    
                            </p>
                            <hr>
                            <small class="text-muted">Phone: </small>
                            <p style="display: flex;">
                            <input type="text" class="form-control " placeholder="Country code" id="country_code" value="{{$user->country_code}}" style="width: 100px">
                            <input type="text" class="form-control " placeholder="Phone number" id="phone_number" value="{{$user->phone_number}}">
                            {{-- $user->country_code?? '' }}{{ $user->phone_number?? 'Not available' --}}
                            </p>
                            <hr>
                            <small class="text-muted">Address : </small>
                            <p>{{ $user->address_one ?? 'Not available' }}</p>
                            <hr>
                            {{-- <small class="text-muted">Address Two: </small>
                            <p>{{ $user->address_two ?? '--' }}</p>
                            <hr>
                            <ul class="list-unstyled">
                                <li>
                                    <div>Marketing</div>
                                    <div class="progress progress-xs mb-3">
                                        <div class="progress-bar l-blue " role="progressbar" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100" style="width: 89%"> <span class="sr-only">62% Complete</span> </div>
                                    </div>
                                </li>
                                <li>
                                    <div>Maths</div>
                                    <div class="progress progress-xs mb-3">
                                        <div class="progress-bar l-green " role="progressbar" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100" style="width: 56%"> <span class="sr-only">87% Complete</span> </div>
                                    </div>
                                </li>
                                <li>
                                    <div>Communication</div>
                                    <div class="progress progress-xs mb-3">
                                        <div class="progress-bar l-amber" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%"> <span class="sr-only">32% Complete</span> </div>
                                    </div>
                                </li>
                                <li>
                                    <div>English</div>
                                    <div class="progress progress-xs mb-3">
                                        <div class="progress-bar l-blush" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: 43%"> <span class="sr-only">56% Complete</span> </div>
                                    </div>
                                </li>
                            </ul>  --}}
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" align="center" id="profile_update" data-id="{{ $user->id }}">Update</button>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="body">
                    <button type="button" class="btn btn-primary" id="subscribe"><i class="fa fa-Plus"></i> Subscribe Free</button>
                    <div class="tab-content pl-0 pr-0 pb-0">
                        <div class="tab-pane active" id="about">                                 
                            <div class="form-group">
                                <label for="plan_type">Choose plan</label>
                                <select class="form-control input-default" name="plan_type" id="plan_type">
                                    <option value="" selected hidden disabled>Select Plan</option>
                                    @foreach ($plan as $key=>$value)
                                        <option data-uid="{{$user->id}}" data-plan_type="{{$value->plan_type}}" value="{{$value->id}}" {{0 ? 'selected': ''}}>{{$value->name}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="body">
                    <ul class="nav nav-tabs-new2">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#about">Subscribed Plans</a></li>
                    </ul>
                    <div class="tab-content pl-0 pr-0 pb-0">
                        <div class="tab-pane active" id="about">
                            <div class="d-flex justify-content-around"><small class="text-muted"># </small><small class="text-muted">Plan </small><small class="text-muted">Start Date </small><small class="text-muted">End Date </small><small class="text-muted">Amount </small><small class="text-muted"></small></div>
                            <hr>
                            
                            @foreach ($subscription_list as $key => $value)
                                <div class="d-flex justify-content-around">

                                <span> {{$key + 1}}.</span> <span>{{ $value['plan'][0]['name'] ?? '--' }}</span><span>{{ $value['start_date'] ?? '--' }}</span><span> {{ $value['end_date'] ?? '--' }}</span><span> {{ $value['amount'] ?? '--' }}</span>
                                @if($value['amount'] == 0)
                                <span class="del_subscription" data-id="{{$value['id']}}">
                                    <i class='fa fa-trash'></i>
                                </span>
                                @else  
                                <span></span>
                                @endif
                                </div>
                                <hr>
                            @endforeach
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script type="text/javascript">
var id = 0;
var planType = 0;
var uid = '';

    $(document).ready(function (e) {
    $('body').on('change','#plan_type',function(){
        id=$(this).val();
        const selectedOption = $(this).find('option:selected');
        planType = selectedOption.data('plan_type');
        uid = selectedOption.data('uid');
    });
    $('body').on('click','#subscribe',function(){
        if( planType != 0 ){
            $.ajax({
            type: "POST",
            url: "{{route('free.subscription')}}",
            data:{
                _token: "{{ csrf_token() }}",
                amount:0,
                description:{ plan_type:planType, id:id, uid:uid}
                
            },
            beforeSend: function() {
                $("#pageLoader").show();
            },
            success: function(data) {
                $("#pageLoader").hide();
                if(data.status==true){
                    Swal.fire(data.message)
                    window.location.reload();
                    return false
                }
            }
        });
        }else{
            Swal.fire("Please choose any plan")
                    return false
        }
    });

    $('body').on('click','#profile_update',function(){
        let id              =   $(this).data("id");
        let email           =   $("#email").val();
        let country_code    =   $("#country_code").val();
        let phone_number    =   $("#phone_number").val();

        $.ajax({
            type: "POST",
            url: "{{route('update.user.profile')}}",
            data:{
                _token: "{{ csrf_token() }}",
                email:email,
                country_code:country_code,
                phone_number:phone_number,
                id:id   
            },
            beforeSend: function() {
                $("#pageLoader").show();
            },
            success: function(data) {
                $("#pageLoader").hide();
                if(data.status==true){
                    Swal.fire(data.message)
                    return false
                }
                // window.location.reload();
            }
        });

    });

    $('body').on('click','.del_subscription',function(){
        let id=$(this).data("id");
        console.log(id);
            $.ajax({
            type: "POST",
            url: "{{route('freeuserplan.delete')}}",
            data:{
                _token: "{{ csrf_token() }}",
                id:id   
            },
            beforeSend: function() {
                $("#pageLoader").show();
            },
            success: function(data) {
                $("#pageLoader").hide();
                if(data.status==true){
                    Swal.fire(data.message)
                    return false
                }
                window.location.reload();
            }
        });
    });
});
</script>
@stop