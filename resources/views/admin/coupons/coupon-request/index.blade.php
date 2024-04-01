
@extends('admin.layouts.adminLayout')
@section('title','Coupon Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Coupon</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Coupon</li>
                    {{-- <li class="breadcrumb-item active">Request</li>-- --}}
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
                                    <th>Vendor Name</th>
                                    <th>Title</th>
                                    <th>Coupon Description</th>
                                    {{--<th>Coupon Code</th>
                                    <th>Offer Type</th>
                                    <th>Offer</th>
                                    <th>Admin Approvel</th>-- --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $value)
                                
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{ $value->vendorDetail->name ?? '--' }}</td>
                                        <td>{{$value->tag_title ?? 'N/A'}}</td>
                                        <td>{{$value->what_inside ?? 'N/A'}}</td>
                                        {{--<td>{{$value->coupon_code ?? '--'}}</td>
                                        <td>{{$value->offer_type ?? ''}}</td>
                                        <td>{{$value->tag_name ?? ''}}</td>
                                        <td>
                                            @if($value->admin_approval=='Rejected')
                                                <a href="javascript:;" class="btn btn-danger btn-sm">Rejected</a>
                                            @elseif($value->admin_approval=='Approved')
                                                <a href="javascript:;" class="btn btn-success btn-sm">Approved</a>
                                            @else
                                                <a href="{{ route('approveVendorCouponStatus',['id'=>$value->id,'status'=>'Approved']) }}" class="btn btn-success btn-sm">Approve</a>
                                                <a href="#" data-id="{{ $value->id }}" data-vendor="{{ $value->vendor_id }}" class="btn btn-danger btn-sm showReasonModel">Reject</a>
                                            @endif
                                        </td>-- --}}
                                        <td>
                                            <a href="{{route('coupon.getCouponRequestDetails',$value->id)}}" class="" data-id="{{$value->id}}" data-url=""><button type="button" class="btn btn-sm btn-outline-secondary" title="View Details"><i class="fa fa-eye"></i></button></a>
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
<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Reason For Rejection</h5>
        </div>
        <div class="modal-body">
            <form action="{{route('rejectVendorCouponStatus')}}" method="post" id="myForm">
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="vendorId" name="vendor_id">
                <div class="form-group">
                    <textarea type="text" class="form-control" name="reason" id="reason"></textarea>
                </div>

                @csrf
                <div align="center">
                    <button type="submit" class="btn btn-primary btn-sm">Reject</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
@stop
@section('scripts')
<script>
    $('body').on('click','.showReasonModel',function(){
        $('#id').val($(this).attr('data-id'))
        $('#vendorId').val($(this).attr('data-vendor'))
        $('#exampleModal').modal('show')
    })
</script>
<script>
    $(document).ready(function () {

        $('#myForm').validate({ // initialize the plugin
            rules: {
                reason: {
                    required: true,
                },
            },
        });

    });
</script>

@stop
