@extends('admin.layouts.adminLayout')
@section('title','Subscription Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Subscription</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i></a>
                    </li>
                    <li class="breadcrumb-item">Subscription</li>
                    <li class="breadcrumb-item active">List</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                        {{--  <a href="javascript:;" class="addPlus" id="addPlus"><button type="button" class="btn btn-primary"><i class="fa fa-Plus"></i>
                                Add Plan</button></a>  --}}
                        {{-- <button type="button" class="btn btn-secondary"><i class="fa fa-send"></i> Send
                            report</button> --}}
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
                    {{-- <h2>Departments List</h2> --}}
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Transaction Id</th>
                                    <th>Amount</th>
                                    <th>Expired On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key=>$value)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td class="mb-0">{{$value->transaction_id ?? '--'}}</td>
                                    <td class="mb-0">{{$value->amount ?? 0 }}</td>
                                    <td>{{$value->end_date ?? 1}}</td>
                                    <td>
                                        <a href="javascript:;"><button type="button" class="btn btn-sm btn-outline-secondary" title="edit"><i class="fa fa-pencil"></i></button></a>
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
