
@extends('admin.layouts.adminLayout')
@section('title','Setting Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Setting</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Setting</li>
                    <li class="breadcrumb-item active">Faq</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                        <a href="{!!url('admin/faq/category')!!}" class="btn btn-md btn-primary"><i class="fa fa-Plus"></i>Category</button></a>
                        <a href="javascript:;" id="addModel" class="btn btn-md btn-primary"><i class="fa fa-Plus"></i> Add Faq</button></a>
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
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $value)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$value->question ?? '--'}}</td>
                                        <td>{{ \Str::limit($value->answer, 20, ' (...)'); }}</td>
                                        <td>
                                            <a href="javascript:;" data-id="{{ $value->id }}" id="editModel" data-title="{{ $value->question }}" data-desc="{{ $value->answer }}" data-categoryid="{{ $value->category_id }}" title="edit faq"><button type="button" class="btn btn-sm btn-outline-secondary" title="edit"><i class="fa fa-pencil"></i></button></a>
                                            <a href="#" title="delete coupon" class="delete" data-id="{{$value->id}}" data-url="{{route('faq.delete',$value->id)}}"><button type="button" class="btn btn-sm btn-outline-secondary" title="delete"><i class="fa fa-trash"></i></button></a>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Faq <span class='plan_title'></span></h5>

            </div>
            <div class="modal-body">
                <form class="formModel" id="formModel" action="{{ route('faq.add') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Category</label>
                        <select name="category" class="form-control">
                             <option value="">Select</option>
                            @if($categories)
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{__($category->name)}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Question</label>
                        <input type="text" name="question" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="amount">Answer</label>
                        <textarea name="answer" cols="30" rows="10" class="form-control"></textarea>
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
                <h5 class="modal-title" id="exampleModal">Edit Faq <span class='plan_title'></span></h5>

            </div>
            <div class="modal-body">
                <form class="editModel" id="editFormModel" action="{{ route('faq.edit') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name">Category</label>
                        <select name="category" class="form-control" id="category">
                             <option value="">Select</option>
                            @if($categories)
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{__($category->name)}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Question</label>
                        <input type="text" name="question" id="question" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="amount">Answer</label>
                        <textarea name="answer" id="answer" cols="30" rows="10" class="form-control"></textarea>
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
{{--  <script>
$('.delete').on('click',function(e){
    e.preventDefault();
    let id=$(this).attr('data-url');
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
                window.location.href=id;
            }
        })
})
</script>  --}}
<script>
    $('#addModel').on('click',function(){
        $('#exampleModal').modal('show')
    })
</script>
<script>
    $('body').on('click','#editModel',function(){
        $('#id').val($(this).attr('data-id'))
        $('#question').val($(this).attr('data-title'))
        $('#answer').val($(this).attr('data-desc'))
        $('#category').val($(this).attr('data-categoryid')).change()
        $('#exampleEditModal').modal('show')
    })
</script>
<script>
    $(document).ready(function () {

        $('#formModel').validate({ // initialize the plugin
            rules: {
                category: {
                    required: true,
                },
                question: {
                    required: true,
                },
                answer: {
                    required: true,
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
                category: {
                    required: true,
                },
                question: {
                    required: true,
                },
                answer: {
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
