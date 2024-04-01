@extends('admin.layouts.adminLayout')
@section('title','Menus')
@section('content')
<style>
label.error {
    width: 100%;
    float: left;
    display: table;
    position: absolute;
    bottom: -30px;
}
.file {
        position: relative;
        display: inline-block;
    }
.file .hover {
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    position: absolute;
    right: 10px;
    top: 10px;
    opacity: 0;
    visibility: hidden;
    z-index: 2;
}
.file:hover .hover {
    opacity: 1;
    visibility: visible;
}

</style>
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>{{__("File Images")}}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
                    {{-- <li class="breadcrumb-item">App</li> --}}
                    <li class="breadcrumb-item active">{{__("File Manager")}}</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                        <button type="button" id="add_menu" class="btn btn-primary">Add Menu / Services</button>
                    </div>
                    <div class="p-2 d-flex">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        @forelse($menu as $key => $value)
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="card">
                <div class="file">
                        <div class="hover">
                            @if(Auth::User() && Auth::User()->admin_type)
                                <div class="button-group"  style="position: relative; margin-top: 15px; margin-right: -10px; transform: translateY(-50%);">
                                    <button type="button" class="btn btn-icon btn-info menu-info-description view-button" data-id="{{$value->id}}" data-description="{{$value->description}}">
                                        <i class="fa fa-info"></i>
                                    </button>
                                    @if (pathinfo($value->image, PATHINFO_EXTENSION) === 'pdf')
                                        <button type="button" onclick="window.open('{{$value->image}}', '_blank')" class="btn btn-icon btn-info view-button">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    @else
                                        <button type="button" onclick="window.open('{{$value->image}}', '_blank')" class="btn btn-icon btn-info view-button">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    @endif
                                </div>
                            @else
                                {{-- <button type="button" class="btn btn-icon btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button> --}}
                            @endif

                        </div>
                        <div class="image">
                            @if (pathinfo($value->image, PATHINFO_EXTENSION) === 'pdf')
                                <embed src="{{$value->image}}" type="application/pdf" class="pdf-preview" style="width: 200px; height: 200px;">
                            @else
                            <img src="{{$value->image}}" alt="img" class="img-fluid" style="width: 200px; height: 200px;">
                            @endif
                        </div>
                        @if(Auth::User() && Auth::User()->admin_type)
                            <div class="file-name">
                                <span class="m-b-5 text-muted">Uploaded By: <a href="{{ url('admin/vendor/' . $value->vendor_id . '/edit') }}" target="_blank">{{$value->vendor ? $value->vendor->name : ''}}</a></span>
                                <p><span class="date text-muted">Uploaded On: {{$value->created_at->format('d, M Y')}}</span></p>
                            </div>
                        @endif
                           {{-- Status button indicating "Pending" --}}
                        <div class="status-button d-flex justify-content-center mt-3 mb-3">
                            @if(Auth::User() && Auth::User()->admin_type)
                                @if ($value->status == App\Models\Image::STATE_PENDING)
                                    <button type="button" class="btn btn-danger btn-sm view-button">Pending</button>
                                    <i class="fa fa-check-circle  fa-2x ml-2 view-button" style="color: green;" data-id="{{$value->id}}" data-url="{{route('admin.approveMenus',$value->id)}}"></i>
                                @elseif ($value->status == App\Models\Image::STATE_APPROVED)
                                    <button type="button" class="btn btn-primary btn-sm view-button" style="background:rgb(45 157 45);">Approved</button>
                                @endif
                            @else
                                {{-- @if ($value->status == App\Models\Image::STATE_PENDING)
                                    <button type="button" class="btn btn-danger btn-sm view-button">Pending</button>
                                @elseif ($value->status == App\Models\Image::STATE_APPROVED)
                                    <button type="button" class="btn btn-primary btn-sm view-button" style="background:rgb(45 157 45);">Approved</button>
                                @endif --}}
                            @endif
                        </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-lg-3 col-md-4 col-sm-12">
            <h4>{{__("No Records")}}</h4>
        </div>
        @endforelse

    </div>

</div>
<div class="modal fade" id="Add_Room" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel">Add Menu / Services</h6>
            </div>
            <div class="modal-body">
                <form action="{{route('vendor.addMenus')}}" id="myform" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <label class="custom-file-label inputGroupFile01 mb-4" for="inputGroupFile01">{{__("Choose file")}}</label>
                                    <input type="file" name="image" class="custom-file-input" id="inputGroupFile01">
                                </div>
                            </div>
                            <div class="append_images">

                            </div>
                            <textarea class="form-control input-default mt-4" rows="6" placeholder="{{__('Enter Description')}}" name="description" id="description"></textarea>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__("Submit")}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{__("Cancel")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script type="text/javascript">
    $(document).ready(function (e) {
      $('#inputGroupFile01').change(function() {
        const file = this.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
          const previewContainer = $('.append_images');

          if (file.type.includes('image')) {
            // For image files, show an image preview
            previewContainer.html('<img src="'+e.target.result+'" style="height:150px;width:200px;">');
          } else if (file.type === 'application/pdf') {
            // For PDF files, show a PDF preview using PDF.js
            const pdfDataUri = e.target.result;
            const pdfPreviewHtml = '<iframe src="'+pdfDataUri+'" width="200" height="150"></iframe>';
            previewContainer.html(pdfPreviewHtml);
          } else {
            // For other file types, display an error message
            previewContainer.html('<p>Unsupported file type.</p>');
          }
        };

        reader.readAsDataURL(file);
      });

    $('.view-button').on('click', function(event) {
            event.stopPropagation();
        });
    });
  </script>

<script>
    $(document).ready(function() {
        $('.menu-info-description').on('click', function() {
            const menuId = $(this).data('id');
            const description = $(this).data('description');

            // Show SweetAlert modal with description and only a close button
            Swal.fire({
                title: 'Menu Description',
                html: description,
                showCloseButton: true,
                closeButtonAriaLabel: 'Close',
                showCancelButton: false,
            });
        });
    });

    $('.fa-check-circle').on('click',function(e){
        e.preventDefault();
        let id = $(this).attr('data-url');
        Swal.fire({
            title: '{{__("Are you sure want to Approve this Item ?")}}',
            text: "",
            icon: 'Warning',
            showCancelButton: true,
            cancelButtonText: '{{__("Cancel")}}',
            confirmButtonColor: 'green',
            cancelButtonColor: '#dc3545',
            confirmButtonText: '{{__("Approve")}}'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = id;
            }
        })
    })
</script>

@stop
