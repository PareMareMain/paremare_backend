@extends('admin.layouts.adminLayout')
@section('title','Vendor Change Request Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Vendor Change Request</h2>
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
                                    <th>S.No.</th>
                                    <th>Image</th>
                                    <th>Vendor Name</th>
                                    <th>Field Name</th>
                                    <th>New Changes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vendorChangeRequest as $key => $value)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if($value->vendor->profile_image)
                                                <div class="img-w"><img src="{{ $value->vendor->profile_image }}" alt="selfie"></div>
                                            @endif
                                        </td>
                                        <td>{{ $value->vendor->name ?? 'N/A' }}</td>
                                        <td>{{ $value->field_name ?? '' }}</td>
                                        @if ($value->field_name == 'profile_image')
                                        <td>
                                            <a href="{{ $value->new_value }}" target="_blank">
                                                <div class="img-w"><img src="{{ $value->new_value }}" alt="selfie"></div>
                                            </a>
                                        </td>
                                        @else
                                            <td>{{ $value->new_value ?? '' }}</td>
                                        @endif
                                        <td>
                                            <button type="button" class="btn btn-warning courcer" style="cursor: default; margin-right: 8px; padding: 4px 7px; font-size: 12px;">Pending</button>
                                            <i class="fa fa-check approve-status" style="color:green; font-size:19px; margin-right:8px; cursor: pointer;" data-url="{{route('admin.approveChangeRequest',$value->id)}}" data-id="{{ $value->id }}"></i>
                                            <i class="fa fa-times reject-status" style="color:red; font-size:19px; cursor: pointer;" data-url="{{ route('admin.rejectChangeRequest', $value->id) }}" data-id="{{ $value->id }}"></i>
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
<script>
     $('.approve-status').on('click',function(e){
        e.preventDefault();
        let url = $(this).attr('data-url');
        Swal.fire({
            title: '{{__("Are you sure want to Approve these changes ?")}}',
            text: "",
            icon: 'Warning',
            showCancelButton: true,
            cancelButtonText: '{{__("Cancel")}}',
            confirmButtonColor: 'green',
            cancelButtonColor: 'rgb(115 121 137)',
            confirmButtonText: '{{__("Approve")}}'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    })

    $('.reject-status').on('click',function(e){
        e.preventDefault();
        let url = $(this).attr('data-url');
        Swal.fire({
            title: '{{__("Are you sure want to Reject these changes ?")}}',
            text: "",
            icon: 'Warning',
            showCancelButton: true,
            cancelButtonText: '{{__("Cancel")}}',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: 'rgb(115 121 137)',
            confirmButtonText: '{{__("Reject")}}'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    })
</script>

@stop
