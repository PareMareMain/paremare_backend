@extends('admin.layouts.adminLayout')
<style>
.blocked {
    color: #fff!important;
    background-color: #dc3545!important;
    border-color: #dc3545!important;
}
</style>
@section('title','User Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>User List</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">User</li>
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
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email Address</th>
                                    <th>Phone Number</th>
                                    <th>Subscription</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key=>$value)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="mb-0">{{$value->name ?? 'N/A'}}</td>
                                        <td>{{$value->email ?? 'N/A'}}</td>
                                        <td>{{$value->country_code ?? ''}}-{{$value->phone_number ?? 'N/A'}}</td>
                                        <td>@if($value->is_subscription_active==true) <button type="button" class="btn btn-primary courcer" style="cursor:default">Subscribed</button> @else <button type="button" class="btn btn-warning courcer" style="cursor:default">Pending</button> @endif</td>
                                        <td>
                                            <a href="{{route('user.show',$value->id)}}"><button type="button" class="btn btn-sm btn-outline-secondary" title="view"><i
                                                    class="fa fa-eye"></i></button></a>
                                                    {{--  <a href="{{route('user.edit',$value->id)}}"><button type="button" class="btn btn-sm btn-outline-secondary" title="view"><i
                                                        class="fa fa-pencil"></i></button></a>  --}}
                                            <a href="{{route('user.blockUser',$value->id)}}"><button type="button" class="btn btn-sm btn-outline-warning js-sweetalert {{ $value->status == 'inactive' ? 'blocked': ''}}"
                                                title="Block User" data-type="confirm"><i class="fa fa-ban"></i></button></a>
                                           <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert delete-user" title="Block User" data-id="{{$value->id}}"><i class='fa fa-trash'></i></button>
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
$('.delete-user').on('click',function(e){
    e.preventDefault();
    let id=$(this).data("id");
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
            type: "POST",
            url: "{{route('user.deleted')}}",
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
        }
        })
})
</script>  
@stop
