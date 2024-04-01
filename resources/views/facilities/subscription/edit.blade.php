@extends('facilities.layouts.vendorLayout')
@section('title','My Profile')
@section('content')
<style>
@keyframes blink {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
    100% {
        opacity: 1;
    }
}

.blink {
    animation: blink 1.0s infinite;
}

</style>
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>{{__("Vendor")}}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}"><i class="fa fa-dashboard"></i></a></li>
                    {{-- <li class="breadcrumb-item">Edit</li> --}}
                    <li class="breadcrumb-item active">{{__("Edit Profile")}}</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
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
                <div class="body">
                </div>
                <div class="tab-content">
                    <form action="{{route('vendor.updateProfile')}}" id="myform" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="tab-pane active" id="Settings">

                            <div class="body">
                                <h6>{{__("Logo")}}</h6>
                                <div class="media">
                                    <div class="media-left m-r-15">
                                        @if(Auth::user()->profile_image)
                                            <img src="{{Auth::user()->profile_image}}" class="user-photo media-object" alt="User" id="preview" style="width:140px;height:140px;">
                                        @else
                                            <img src="{{ asset('admin/assets/images/user.png') }}" class="user-photo media-object" alt="User" id="preview" style="width:140px;height:140px;">
                                        @endif
                                    </div>
                                    <div class="media-body">
                                        <p>{{__("Upload your logo")}}.
                                            <br> <em>{{__("Image should be at least 140px x 140px")}}</em></p>
                                            <div class="input-group">
                                            <div class="btn btn-default uploadButton" id="btn-upload-photo">{{__("Upload logo")}}
                                            <input type="file" name="image" id="image" class="uploadImage">

                                        </div>
                                            @if($changedProfileImage)
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-secondary info-button" data-toggle="tooltip" data-placement="top" title="{{ 'Needs approval of Admin for the new Profile Image' }}">
                                                        <i class="fa fa-info-circle blink"></i>
                                                    </button>
                                                </div>
                                            @endif
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="body">
                                <h6>{{__("Basic Information")}}</h6>
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-12">

                                        <div class="form-group">
                                            <label>{{__("Name")}}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control input-default" placeholder="{{__('Enter Name')}}" name="name_en" id="name_en" value="{{ (Auth::user()->getTranslation('name', 'en') != '')  ? Auth::user()->getTranslation('name', 'en') : '' }}">
                                                @if($changedNameEn)
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-secondary info-button" data-toggle="tooltip" data-placement="top" title="{{ 'Needs approval of Admin for the new Name "' . $changedNameEn->new_value . '"' }}">
                                                            <i class="fa fa-info-circle blink"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group d-none">
                                            <label>{{__("Name(Arabic)")}}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control input-default" placeholder="{{__('Enter Name in Arabic')}}" name="name_ar" id="name_ar" value="{{ (Auth::user()->getTranslation('name', 'ar') != '')  ? Auth::user()->getTranslation('name', 'ar') : '' }}">
                                                    @if($changedNameAr)
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-secondary info-button" data-toggle="tooltip" data-placement="top" title="{{ 'Needs approval of Admin for the new Name (Arabic) "' . $changedNameAr->new_value . '"' }}">
                                                                <i class="fa fa-info-circle blink"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>{{__("Email Address")}}</label>
                                            <input type="text" class="form-control input-default" placeholder="{{__('Enter email')}}" name="email" id="email" value="{{Auth::user()->email}}" disabled>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="">{{__("Phone Code")}}</label>
                                                    <select name="country_code" id="country_code" class="form-control">
                                                        <option value="+966">+966</option>
                                                        <option value="+91">+91</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label>{{ __("Phone Number") }}</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-default" placeholder="{{ __('Enter Phone Number') }}" name="phone" id="phone" value="{{ Auth::user()->phone_number }}">
                                                       @if($changedPhoneNumber)
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-secondary info-button" data-toggle="tooltip" data-placement="top" title="{{ 'Needs approval of Admin for the new Phone Number "'.$changedPhoneNumber->new_value. '"' }}">
                                                                    <i class="fa fa-info-circle blink"></i>
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __("Address") }}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control input-default" placeholder="{{ __('Enter Vendor Address') }}" id="address" name="address" value="{{ Auth::user()->location }}">
                                                <input type="hidden" name="latitude" id="latitude" value="{{ Auth::user()->latitude }}">
                                                <input type="hidden" name="longitude" id="longitude" value="{{ Auth::user()->longitude }}">
                                                @if($changedAddress)
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-secondary info-button" data-toggle="tooltip" data-placement="top" title="{{ 'Needs approval of Admin for the new Address "'.$changedAddress->new_value. '"' }}">
                                                            <i class="fa fa-info-circle blink"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary" align="center">{{__("Submit")}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        $('#myform').validate({ // initialize the plugin
            rules: {
                name_en: {
                    required: true,
                },
                name_ar: {
                    required: true,
                },
                address: {
                    required: true,
                },
                phone: {
                    required:true,
                },
            },
            messages: {
                name_en: {
                    required: "{{__('This field is required.')}}",
                },
                name_ar: {
                    required: "{{__('This field is required.')}}",
                },
                address: {
                    required: "{{__('This field is required.')}}",
                },
                phone: {
                    required:"{{__('This field is required.')}}",
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
<script type="text/javascript">
	$('#myform').submit(function () {

		var numberOfChecked = $('#latitude').val();
        if(numberOfChecked){
        	return true
        }else{
            Swal.fire("{{__('Select valid address from list')}}")
            return false
        }
	});
</script>
<script>
    $('body').on('change','#category',function(){
        var id=$(this).val();
        $.ajax({
            type: "GET",
            url: "{{route('getSubCategories')}}",
            data:{id:id},
            beforeSend: function() {
                $("#pageLoader").show();
            },
            success: function(data) {
                $("#pageLoader").hide();
                $('#sub-category').html(data.data)
            }
        });
    })
</script>
<script type="text/javascript">
	// $('#myform').submit(function () {
        $('#email').on('blur',function(){
        var email = $(this).val();
        $.ajax({
            type: "GET",
            url: "{{route('check-email-exist')}}",
            data:{email:email},
            beforeSend: function() {
                $("#pageLoader").show();
            },
            success: function(data) {
                $("#pageLoader").hide();
                if(data.status==true){
                    Swal.fire(data.msg)
                    return false
                }
            }
        });
    })
</script>
<script type="text/javascript">

    $(document).ready(function (e) {
       $('#image').change(function(){

        let reader = new FileReader();

        reader.onload = (e) => {

          $('#preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);

       });

    });

</script>
@stop
