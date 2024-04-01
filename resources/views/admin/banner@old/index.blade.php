@extends('admin.layouts.adminLayout')
@section('title', 'Banner Management')
@section('content')
<style>
    .btn-group-sm>.btn, .btn-sm{
        line-height: 0.8 !important;
    }
</style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 p-r-0 title-margin-right">
                <div class="page-header">
                    <div class="page-title">
                        {{-- <h1>Hello, <span>Welcome Here</span></h1> --}}
                    </div>
                </div>
            </div>
            <!-- /# column -->
            <div class="col-lg-4 p-l-0 title-margin-left">
                <div class="page-header">
                    <div class="page-title">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Banner</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /# column -->
        </div>
        <!-- /# row -->
        <section id="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('banner.create') }}" class="btn btn-md btn-primary">Add</a>
                    <div class="card">
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="myTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Banner Name</th>
                                            <th>Vendor Name</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>

                                                <td>{{ $value->name ?? 'N/A' }}</td>
                                                <td>{{ $value->vendors->name ?? '--' }}</td>
                                                <td>
                                                    @if ($value->image)
                                                    <div class="img-w"> <img src="{{ $value->image }}" alt="category image"></div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($value->status == 'pending')
                                                        <a href="#" class="btn btn-success btn-sm">Approve</a>
                                                        <a href="#" class="btn btn-danger btn-sm">Reject</a>
                                                    @elseif($value->status == 'approved')
                                                        <a href="javascript:;" class="btn btn-success btn-sm">Approved</a>
                                                    @else
                                                        <a href="javascript:;" class="btn btn-danger btn-sm">Rejected</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- <a href="{{route('user.edit',$value->id)}}" title="Eidt details"><i class="ti-pencil" style="font-size: 15px;float:left;"></i></a> --}}
                                                    <a href="{{ route('banner.edit', $value->id) }}" title="edit banner"><i class="ti-pencil" style="font-size: 15px;float:left;"></i></a>
                                                    <a href="#" title="delete banner" class="delete" data-id="{{$value->id}}" data-url="{{route('banner.delete',$value->id)}}"><i class="ti-trash" style="font-size: 15px;float:left;"></i></a>
                                                    {{-- <a href="#" title="View Details and KYC"><i class="ti-eye"></i></a> --}}
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
        </section>
    </div>
@stop
@section('scripts')
@stop
