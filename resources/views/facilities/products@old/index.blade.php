@extends('facilities.layouts.vendorLayout')
@section('title','User Management')
@section('content')
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
                        <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Coupon List</li>
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
                <a href="#" class="btn btn-md btn-primary" id="addModel">Add</a>
                <div class="card">
                    <div class="bootstrap-data-table-panel">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Amount</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key=>$value)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$value->name ?? 'N/A'}}</td>
                                        <td>{{$value->amount ?? '--'}}</td>
                                        <td>@if($value->image)
                                        <div class="img-w"> <img src="{{ $value->image }}" alt=""></div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:;" id="editModel" data-id="{{ $value->id }}" data-image="{{ $value->image }}" data-name="{{ $value->name }}" data-amount="{{ $value->amount }}" title="Edit details"><i class="ti-pencil" style="font-size: 15px;float:left;"></i></a>
                                            <a href="#" title="delete coupon" class="delete" data-id="{{$value->id}}" data-url="{{route('products.delete',$value->id)}}"><i class="ti-trash" style="font-size: 15px;float:left;"></i></a>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product <span class='plan_title'></span></h5>

            </div>
            <div class="modal-body">
                <form class="formModel" id="formModel" action="{{ route('products.storeProducts') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" name="amount" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="amount">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                    <div id="append_image">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="formSubmit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{--  Edit Form  --}}

<div class="modal fade" id="exampleEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModal">Edit Product <span class='plan_title'></span></h5>

            </div>
            <div class="modal-body">
                <form class="editModel" id="editFormModel" action="{{ route('products.updateProducts') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" name="amount" id="amount" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="amount">Image</label>
                        <input type="file" name="image" id="imageEdit" class="form-control">
                    </div>
                    <div id="edit_append_image">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="formSubmit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop
@section('scripts')
<script>
    $('#addModel').on('click',function(){
        $('#exampleModal').modal('show')
    })
</script>
<script>
    $('#editModel').on('click',function(){
        var image = $(this).attr('data-image')
        $('#id').val($(this).attr('data-id'))
        $('#name').val($(this).attr('data-name'))
        $('#amount').val($(this).attr('data-amount'))
        $('#edit_append_image').html(`<img id="preview" src="`+ image +`" alt="" style="width:180px;height:180px;">`)
        $('#exampleEditModal').modal('show')
    })
</script>

<script type="text/javascript">

    $(document).ready(function (e) {
       $('#image').change(function(){

        let reader = new FileReader();

        reader.onload = (e) => {

          //$('#preview').attr('src', e.target.result);
          $('#append_image').html(`<img id="preview" src="`+ e.target.result +`" alt="" style="width:180px;height:180px;">`)

        }

        reader.readAsDataURL(this.files[0]);

       });

    });

</script>
<script type="text/javascript">

    $(document).ready(function (e) {
       $('#imageEdit').change(function(){

        let reader = new FileReader();

        reader.onload = (e) => {

          {{--  //$('#preview').attr('src', e.target.result);  --}}
          $('#edit_append_image').html(`<img id="preview" src="`+ e.target.result +`" alt="" style="width:180px;height:180px;">`)

        }

        reader.readAsDataURL(this.files[0]);

       });

    });

</script>
<script>
    $(document).ready(function () {

        $('#formModel').validate({ // initialize the plugin
            rules: {
                name: {
                    required: true,
                },
                image: {
                    required: true,
                },
                amount: {
                    required:true,
                },

            },
            // submitHandler: function(form) {
            //     $.ajax({
            //         url: form.action,
            //         type: form.method,
            //         data: $(form).serialize(),
            //         success: function(response) {
            //             if(response.status==true){
            //                 window.location.href="{{route('dashboard')}}";
            //             }
            //             //window.location.reload()
            //         }
            //     });
            // }
        });

    });
</script>
<script>
    $(document).ready(function () {

        $('#editFormModel').validate({ // initialize the plugin
            rules: {
                name: {
                    required: true,
                },
                amount: {
                    required:true,
                },

            },
            // submitHandler: function(form) {
            //     $.ajax({
            //         url: form.action,
            //         type: form.method,
            //         data: $(form).serialize(),
            //         success: function(response) {
            //             if(response.status==true){
            //                 window.location.href="{{route('dashboard')}}";
            //             }
            //             //window.location.reload()
            //         }
            //     });
            // }
        });

    });
</script>
@stop
