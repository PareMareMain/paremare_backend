@extends('admin.layouts.adminLayout')
@section('title','Coupon Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Coupon List</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Coupon</li>
                    <li class="breadcrumb-item active">List</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                        {{--  <button type="button" class="btn btn-primary"><i class="fa fa-Plus"></i> Add User</button>  --}}
                        {{--  <button type="button" class="btn btn-secondary"><i class="fa fa-send"></i> Send report</button>  --}}
                    </div>
                    <div class="p-2 d-flex">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    {{--  <h2>Departments List</h2>  --}}
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Vendor Name</th>
                                    <th>Off</th>
                                   {{--  <th>Coupon Code</th>
                                    <th>Status</th> -- --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $value)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {{ $value->users->name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $value->vendorDetails->getTranslation('name', 'en') ?? '--' }}
                                        </td>
                                        {{-- <td>
                                            @if($value->coupons->offer_type=='buy-get')
                                                Buy And Get
                                            @elseif($value->coupons->offer_type=='buy-get-percentage')
                                                Buy And Get Percentage
                                            @elseif($value->coupons->offer_type=='percentage')
                                                Percentage
                                            @elseif($value->coupons->offer_type=='amount')
                                                Amount
                                            @endif
                                        </td>
                                         <td>
                                            @if($value->coupons->offer_type=='buy-get')
                                                Buy {{ $value->coupons->buy_items ?? '' }} And Get {{ $value->coupons->free_items ?? '' }} Free
                                            @elseif($value->coupons->offer_type=='buy-get-percentage')
                                                Buy {{ $value->coupons->buy_items ?? '' }} And Get {{ $value->coupons->discount ?? '' }} % off
                                            @elseif($value->coupons->offer_type=='percentage')
                                                {{ $value->coupons->discount ?? '' }} % off
                                            @elseif($value->coupons->offer_type=='amount')
                                            {{ $value->coupons->discount ?? '' }} AED off
                                            @endif

                                        </td>
                                       <td>{{ $value->coupons->coupon_code ?? '--' }}</td> 
                                            <td>
                                            {{ $value->status=='user_redeem'?'Pending':'Redeemed' }}
                                        </td> -- --}}
                                        <td>{{ $value->coupons->discount ?? '--' }}</td> 
                                        <td>
                                            <a href="{{ route('coupon.getCouponDetails',$value->id) }}"><button type="button" class="btn btn-sm btn-outline-secondary" title="view"><i
                                                class="fa fa-eye"></i></button></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
{{--  <script>
    document.querySelector(".delete").onclick = function (e) {
        e.preventDefault();
        let id=$(this).attr('data-url');
        swal(
            {
            title: "Are you sure to delete ?",
            text: "You will not be able to recover this imaginary file !!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it !!",
            closeOnConfirm: false,
            },
            function () {
                // swal({
                //     title: "Deleted !!",
                //     text: "Record updated sucessfully",
                //     type: "success"
                //     },
                //     function(){
                //         window.location.reload()
                //     }
                // );
                window.location.href=id;
            }
        );
};
</script>  --}}
@stop
