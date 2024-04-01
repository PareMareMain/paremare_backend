@extends('facilities.layouts.vendorLayout')
@section('title','Coupon Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>{{__('Coupon List')}}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    {{-- <li class="breadcrumb-item"></li> --}}
                    <li class="breadcrumb-item active">{{__('Coupon List')}}</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                        <a href="{{ route('coupon.create') }}"><button type="button" class="btn btn-primary"><i class="fa fa-Plus"></i> {{__("Add Coupon")}}</button></a>
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
                                    <th>{{__("Title")}}</th>
                                    <th>{{__("Description")}}</th>
                                    {{--<th>{{__("Coupon Code")}}</th>
                                    <th>{{__("Offer Type")}}</th>
                                    <th>{{__("Offer")}}</th>
                                    <th>{{__("Admin Status")}}</th>
                                    <th>{{__("Rejection Reason")}}</th>-- --}}
                                    <th>{{__("Action")}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $value)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{ ($value->getTranslation('tag_title', 'en') != '')  ? $value->getTranslation('tag_title', 'en') : ''}}</td>
                                        <td>{{ ($value->getTranslation('what_inside', 'en') != '')  ? $value->getTranslation('what_inside', 'en') : ''}}</td>
                                        {{-- <td>{{$value->tag_title ?? 'N/A'}}</td>
                                        <td>{{$value->coupon_code ?? '--'}}</td>
                                        <td class="d-none">{{$value->offer_type ?? ''}}</td>
                                        <td class="d-none">{{ ($value->getTranslation('tag_name', 'en') != '')  ? $value->getTranslation('tag_name', 'en') : ''}}</td>
                                         <td>{{$value->tag_name ?? ''}}</td> 
                                        <td class="d-none">
                                            @if($value->admin_approval=='Rejected')
                                                <a href="javascript:;" class="btn btn-danger btn-sm">{{__("Rejected")}}</a>
                                            @elseif($value->admin_approval=='Approved')
                                                <a href="javascript:;" class="btn btn-success btn-sm">{{__("Approved")}}</a>
                                            @else
                                            <a href="javascript:;" class="btn btn-warning btn-sm">{{__("Pending")}}</a>
                                            @endif
                                        </td>
                                        <td class="d-none">
                                            @if($value->admin_approval=='Rejected')
                                                <a href="javascript:;" class="reason_description" data-desc="{{ $value->reason ?? ' ' }}"><span>{{ \Str::limit($value->reason, 20, ' ...') }}</span></a>
                                            @else
                                                --
                                            @endif
                                        </td>-- --}}
                                        <td>
                                            <a href="{{ route('coupon.edit',$value->id) }}"><button type="button" class="btn btn-sm btn-outline-secondary" title="edit"><i
                                                class="fa fa-pencil"></i></button></a>
                                            <a href="#" title="delete coupon" class="delete" data-id="{{$value->id}}" data-url="{{route('coupon.delete',$value->id)}}"><button type="button" class="btn btn-sm btn-outline-secondary" title="delete"><i
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
<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{__("Rejection Reason")}}</h5>
        </div>
        <div class="modal-body">
            <div id="appendDesc">

            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
        </div>
      </div>
    </div>
  </div>
@stop
@section('scripts')
<script>
    $('body').on('click','.reason_description',function(){
        $('#appendDesc').text($(this).attr('data-desc'))
        $('#exampleModal').modal('show')
    })
</script>
@stop
