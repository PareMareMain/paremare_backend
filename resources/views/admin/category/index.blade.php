@extends('admin.layouts.adminLayout')
@section('title','Category Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Category List</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Category</li>
                    <li class="breadcrumb-item active">List</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                        <a href="{{ route('category.create') }}"><button type="button" class="btn btn-primary"><i class="fa fa-Plus"></i> Add Category</button></a>
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
                                    <th>Image</th>
                                    <th>Category Name</th>
                                    <th>Sub-Category</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $value)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if ($value->image)
                                                <div class="img-w">
                                                    <img src="{{ $value->image }}" alt="category image" >
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ ($value->getTranslation('name', 'en') != '')  ? $value->getTranslation('name', 'en') : ''}} </td> {{--/ {{($value->getTranslation('name', 'ar') != '')  ? $value->getTranslation('name', 'ar') : ''}} --}}
                                        <td><a href="{{ route('subcategory.index', $value->id) }}"><u> View List</u></a></td>
                                        <td>
                                            @if ($value->status == 'active')
                                                <a href="{{ route('category.changestatus', ['id' => $value->id, 'status' => 'inactive']) }}" class="btn btn-success btn-sm">{{ $value->status ?? '' }}</a>
                                            @else
                                                <a href="{{ route('category.changestatus', ['id' => $value->id, 'status' => 'active']) }}" class="btn btn-danger btn-sm">{{ $value->status ?? '' }}</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('category.edit', $value->id) }}"><button type="button" class="btn btn-sm btn-outline-secondary" title="edit"><i
                                                class="fa fa-pencil"></i></button></a>
                                            <a href="#" title="delete banner" class="delete" data-id="{{$value->id}}" data-url="{{route('category.delete',$value->id)}}"><button type="button" class="btn btn-sm btn-outline-secondary" title="delete"><i
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

