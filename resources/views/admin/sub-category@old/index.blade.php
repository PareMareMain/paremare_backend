@extends('admin.layouts.adminLayout')
@section('title','Categories Management')
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
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Category List</li>
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
                <a href="{{route('subcategory.create',$id)}}" class="btn btn-md btn-primary">Add</a>
                <div class="card">
                    <div class="bootstrap-data-table-panel">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Category Name</th>
                                        <th>Sub-Category Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key=>$value)

                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>
                                            @if($value->image)
                                            <div class="img-w"> <img src="{{$value->image}}" alt="category image"></div>
                                            @endif
                                        </td>
                                        <td>{{$value->category->name ?? 'N/A'}}</td>
                                        <td>{{$value->name ?? 'N/A'}}</td>
                                        <td>
                                            @if ($value->status == 'active')
                                                <a href="{{ route('subcategory.changestatus', ['id' => $value->id, 'status' => 'inactive']) }}" class="btn btn-success btn-sm">{{ $value->status ?? '' }}</a>
                                            @else
                                                <a href="{{ route('subcategory.changestatus', ['id' => $value->id, 'status' => 'active']) }}" class="btn btn-danger btn-sm">{{ $value->status ?? '' }}</a>
                                            @endif

                                        </td>
                                        <td>
                                            {{-- <a href="{{route('user.edit',$value->id)}}" title="Eidt details"><i class="ti-pencil" style="font-size: 15px;float:left;"></i></a> --}}
                                            <a href="{{route('subcategory.edit',['cat_id'=>$id,'id'=>$value->id])}}" title="edit category"><i class="ti-pencil" style="font-size: 15px;float:left;"></i></a>
                                            <a href="#" title="delete category" class="delete" data-id="{{$value->id}}" data-url="{{route('subcategory.delete',$value->id)}}"><i class="ti-trash" style="font-size: 15px;float:left;"></i></a>
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
{{-- <script>
    document.querySelector(".delete").onclick = function (e) {
        e.preventDefault();
        alert('hii')
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
</script> --}}
@stop
