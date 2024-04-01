@extends('facilities.layouts.vendorLayout')
@section('title','Coupon Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>{{__("Banner List")}}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    {{-- <li class="breadcrumb-item"></li> --}}
                    <li class="breadcrumb-item active">{{__("Banner List")}}</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                        @if(Auth::user()->is_subscription_active)
                            <a href="{{ route('vendor-banner.create') }}" class="btn btn-md btn-primary"><button type="button" class="btn btn-primary"><i class="fa fa-Plus"></i>{{__("Add Banner")}}</button></a>
                        @else
                            <a href="javascript:;" class="btn btn-md btn-primary paymentConfirm"><button type="button" class="btn btn-primary"><i class="fa fa-Plus"></i>{{__("Add Banner")}}</button></a>
                        @endif
                        

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
                                    <th>{{__("Banner Name")}}</th>
                                    <th>{{__("Image")}}</th>
                                    <th>{{__("Status")}}</th>
                                    <th>{{__("Action")}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $value)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>{{ $value->name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($value->image)
                                            <div class="img-w"> <img src="{{ $value->image }}" alt="category image">
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($value->status == 'pending')
                                            <a href="javascript:;" class="btn btn-warning btn-sm">{{__("Pending")}}</a>
                                            @elseif($value->status == 'approved')
                                                <a href="javascript:;" class="btn btn-success btn-sm">{{__("Approved")}}</a>
                                            @else
                                                <a href="javascript:;" class="btn btn-danger btn-sm">{{__("Rejected")}}</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" title="delete banner" class="delete" data-id="{{$value->id}}" data-url="{{route('vendor-banner.delete',$value->id)}}"><button type="button" class="btn btn-sm btn-outline-secondary" title="delete"><i
                                                    class="fa fa-trash"></i></button></a>
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

@stop
