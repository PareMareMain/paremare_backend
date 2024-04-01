@extends('admin.layouts.adminLayout')
@section('title','Setting')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 p-r-0 title-margin-right">
            <div class="page-header">
                <div class="page-title">
                    <h1>Faq</h1>
                </div>
            </div>
        </div>
        <!-- /# column -->
        <div class="col-lg-4 p-l-0 title-margin-left">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Faq List</li>
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
                <a href="javascript:;" id="addModel" class="btn btn-md btn-primary">Add</a>
                <div class="card">

                    <div class="bootstrap-data-table-panel">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key=>$value)

                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$value->question ?? '--'}}</td>
                                        <td>{{$value->answer ?? '--'}}</td>
                                        <td>

                                            <a href="javascript:;" data-id="{{ $value->id }}" id="editModel" data-title="{{ $value->question }}" data-desc="{{ $value->answer }}" title="edit faq"><i class="ti-pencil" style="font-size: 15px;float:left;"></i></a>
                                            <a href="#" title="delete user" class="delete" data-id="{{$value->id}}" data-url="{{route('faq.delete',$value->id)}}"><i class="ti-trash" style="font-size: 15px;float:left;"></i></a>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Faq <span class='plan_title'></span></h5>

            </div>
            <div class="modal-body">
                <form class="formModel" id="formModel" action="{{ route('faq.add') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Question</label>
                        <input type="text" name="question" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="amount">Answer</label>
                        <textarea name="answer" cols="30" rows="30" class="form-control"></textarea>
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
                        <label for="name">Question</label>
                        <input type="text" name="question" id="question" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="amount">Answer</label>
                        <textarea name="answer" cols="30" id="answer" rows="500" class="form-control"></textarea>
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
</script>
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
        $('#exampleEditModal').modal('show')
    })
</script>
<script>
    $(document).ready(function () {

        $('#formModel').validate({ // initialize the plugin
            rules: {
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
