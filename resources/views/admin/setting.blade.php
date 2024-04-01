@extends('admin.layouts.adminLayout')
@section('title','Coupan Management')
@section('content')
@php
    $title='';
    if($type=='terms'){
        $title='Terms & Conditions';
    }elseif($type=='privacy'){
        $title='Privacy & Policy';
    }elseif($type=='aboutus'){
        $title='About Us';
    }
@endphp
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Edit {{ $title }}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Edit</li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
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
        <div class="col-lg-9 col-md-12">
            <div class="card">
                <div class="card-title mt-2">
                    <h4>Edit {{ $title }}</h4>

                </div>
                <div class="card-body mt-3">
                    <div class="basic-form">
                        <form action="{{ route('setting',$type) }}" id="myform" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{--  <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control input-default" placeholder="Enter title" name="title" id="title" value="{{ $data->title }}">
                            </div>  --}}
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description_en" id="description_en" class="form-control input-default" cols="30" rows="10">{{ ($data->getTranslation('description', 'en') != '')  ? $data->getTranslation('description', 'en') : '' }}</textarea>

                            </div>
                            {{-- <div class="form-group">
                                <label>Description (Arabic)</label>
                                <textarea name="description_ar" id="description_ar" class="form-control input-default" cols="30" rows="10">{{ ($data->getTranslation('description', 'ar') != '')  ? $data->getTranslation('description', 'ar') : '' }}</textarea>

                            </div>-- --}}
                            <button type="submit" class="btn btn-default mt-4">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script>
    CKEDITOR.replace( 'description_en' );
    CKEDITOR.replace( 'description_ar' );
</script>
@stop
