@extends('admin.layouts.adminLayout')
@section('title','User Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Vendor List</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Vendor</li>
                    <li class="breadcrumb-item active">List</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                        <a href="{{route('vendor.create')}}"><button type="button" class="btn btn-primary"><i class="fa fa-Plus"></i> Add Vendor</button></a>
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
                                    <th>Id</th>
                                    <th>Logo Image</th>
                                    <th>Name</th>
                                    <th>Email Address</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th class="d-none">Subsciption</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key=>$value)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>
                                            @if($value->profile_image)
                                            <div class="img-w"><img src="{{$value->profile_image}}" alt="selfie"></div>
                                            @endif
                                        </td>
                                        <td class="mb-0">{{ ($value->getTranslation('name', 'en') != '')  ? $value->getTranslation('name', 'en') : '' }} </td>
                                        {{--/ {{ ($value->getTranslation('name', 'ar') != '')  ? $value->getTranslation('name', 'ar') : '' }} --}}
                                        <td>{{$value->email ?? 'N/A'}}</td>
                                        <td>{{$value->country_code ?? ''}}{{$value->phone_number ?? ''}}</td>
                                        <td>{{$value->location ?? 'N/A'}}</td>
                                        <td class="d-none">@if($value->is_subscription_active==true) <button type="button" class="btn btn-primary courcer" style="cursor:default">Subscribed</button> @else <button type="button" class="btn btn-warning courcer" style="cursor:default">Pending</button> @endif</td>
                                        <td>

                                            <a href="{{route('vendor.edit',$value->id)}}" title="View details"><button type="button" class="btn btn-sm btn-outline-secondary" title="edit"><i class="fa fa-pencil"></i></button></a>
                                            <a href="#" title="delete user" class="delete" data-id="{{$value->id}}" data-url="{{route('vendor.getDeleted',$value->id)}}"><button type="button" class="btn btn-sm btn-outline-secondary" title="delete"><i class="fa fa-trash"></i></button></a>
                                            {{--  <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert"
                                                title="Delete" data-type="confirm"><i class="fa fa-trash-o"></i></button>  --}}
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
