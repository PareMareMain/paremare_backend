
@extends('admin.layouts.adminLayout')
@section('title','Coupon Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Platform Coupon List</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Platform Coupon</li>
                    <li class="breadcrumb-item active">List</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                        <a href="{{ route('platform.create') }}"><button type="button" class="btn btn-primary"><i class="fa fa-Plus"></i> Add Coupon</button></a>
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
                                    <th>Title</th>
                                    {{--<th>Coupon Code</th>
                                    <th>Offer Type</th>
                                    <th>Offer</th>-- --}}
                                    <th>Vendor</th>
                                    <th>Coupon Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $value)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{ ($value->getTranslation('tag_title', 'en') != '')  ? $value->getTranslation('tag_title', 'en') : ''}} </td> {{--/ {{($value->getTranslation('tag_title', 'ar') != '')  ? $value->getTranslation('tag_title', 'ar') : ''}} --}}
                                        <td>{{ ($value->vendorDetail->getTranslation('name', 'en') != '')  ? $value->vendorDetail->getTranslation('name', 'en') : ''}} </td> 
                                        <td>{{ ($value->getTranslation('what_inside', 'en') != '')  ? $value->getTranslation('what_inside', 'en') : '' }} </td> 
                                        {{--<td>{{$value->coupon_code ?? '--'}}</td>
                                        <td>{{$value->offer_type ?? ''}}</td>
                                        <td>{{ ($value->getTranslation('tag_name', 'en') != '')  ? $value->getTranslation('tag_name', 'en') : ''}} / {{($value->getTranslation('tag_name', 'ar') != '')  ? $value->getTranslation('tag_name', 'ar') : ''}}</td>-- --}}
                                        <td>
                                            <a href="{{ route('platform.edit',$value->id) }}"><button type="button" class="btn btn-sm btn-outline-secondary" title="edit"><i class="fa fa-pencil"></i></button></a>
                                            <a href="#" title="delete coupon" class="delete" data-id="{{$value->id}}" data-url="{{route('platform.delete',$value->id)}}"><button type="button" class="btn btn-sm btn-outline-secondary" title="delete"><i class="fa fa-trash"></i></button></a>
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
