
@extends('admin.layouts.adminLayout')
@section('title','Coupon Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>User Promo Code List</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">User</li>
                    <li class="breadcrumb-item">Promo Code</li>
                    <li class="breadcrumb-item active">List</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                        {{-- <a href="{{ route('admin.promo.create') }}"><button type="button" class="btn btn-primary"><i class="fa fa-Plus"></i> Add Promo Code</button></a>
                         <button type="button" class="btn btn-secondary"><i class="fa fa-send"></i> Send report</button>  --}}
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
                        <table class="table table-bordered table-hover js-basic-promo dataTable table-custom">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Promo Title</th>
                                    <th>Price</th>
                                    <th>Offer Type</th>
                                    <th>Discount</th>
                                    <th>Discount Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($data as $key => $value)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{ ( isset($value->user->name) && $value->user->getTranslation('name', 'en') != '')  ? $value->user->getTranslation('name', 'en') : ''}} </td>
                                            <td>{{ (isset($value->promo->tag_title) && $value->promo->getTranslation('tag_title', 'en') != '')  ? $value->promo->getTranslation('tag_title', 'en') : ''}} </td>
                                            <td>{{ $value->price ?? '--' }}</td> 
                                            <td>{{ $value->promo->offer_type ?? '--' }}</td> 
                                            <td>{{ $value->discount ?? '--' }}</td> 
                                            <td>
                                                @if ($value->promo && $value->promo->offer_type === 'fixed') 
            
                                                    {{$value->price -= $value->discount}}

                                                @else 
                                                    {{$value->price *= (1 - ($value->discount / 100))}}
                                                @endif
                                            </td> 
                                            {{--  <td>{{ ucfirst($value->offer_type) ?? '--' }}</td> ($promo && $promo->offer_type === 'percentage')  
                                            <td>{{ ($value->promo->getTranslation('tag_title', 'en') != '')  ? $value->promo->getTranslation('tag_title', 'en') : ''}}</td> 
                                            <td>{{ ($value->getTranslation('promo_description', 'en') != '')  ? $value->getTranslation('promo_description', 'en') : '' }} </td> --}}
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
