@extends('admin.layouts.adminLayout')
@section('title','Sub Admin Management')
@section('content')
<style>

* { margin: 0; padding: 0; }

#page-wrap {
  margin: auto 0;
}

.treeview {
  margin: 10px 0 0 20px;
}

ul {
  list-style: none;
}

.treeview li {
  background: url(http://jquery.bassistance.de/treeview/images/treeview-default-line.gif) 0 0 no-repeat;
  padding: 2px 0 2px 16px;
}

.treeview > li:first-child > label {
  /* style for the root element - IE8 supports :first-child
  but not :last-child ..... */

}

.treeview li.last {
  background-position: 0 -1766px;
}

.treeview li > input {
  height: 16px;
  width: 16px;
  /* hide the inputs but keep them in the layout with events (use opacity) */
  opacity: 0;
  filter: alpha(opacity=0); /* internet explorer */
  -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(opacity=0)"; /*IE8*/
}

.treeview li > label {
  background: url(https://www.thecssninja.com/demo/css_custom-forms/gr_custom-inputs.png) 0 -1px no-repeat;
  /* move left to cover the original checkbox area */
  margin-left: -20px;
  /* pad the text to make room for image */
  padding-left: 20px;
}

/* Unchecked styles */

.treeview .custom-unchecked {
  background-position: 0 -1px;
}
.treeview .custom-unchecked:hover {
  background-position: 0 -21px;
}

/* Checked styles */

.treeview .custom-checked {
  background-position: 0 -81px;
}
.treeview .custom-checked:hover {
  background-position: 0 -101px;
}

/* Indeterminate styles */

.treeview .custom-indeterminate {
  background-position: 0 -141px;
}
.treeview .custom-indeterminate:hover {
  background-position: 0 -121px;
}
</style>
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Vendor</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Permission</li>
                    <li class="breadcrumb-item active">Categories</li>
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
        <div class="col-lg-6">
            <div class="card">
                <div class="body">
                </div>
                <div class="tab-content">
                    <form action="{{route('sub-admin.permissions',$id)}}" id="myform" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="tab-pane active" id="Settings">
                            <div class="body">
                                <h6></h6>
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-12">
                                        <ul class="treeview">
                                            {{--  <li>
                                                <input type="checkbox" name="tall" id="tall">
                                                <label for="tall" class="custom-unchecked">Tall Things</label>

                                                <ul>
                                                     <li>
                                                         <input type="checkbox" name="tall-1" id="tall-1">
                                                         <label for="tall-1" class="custom-unchecked">Buildings</label>
                                                     </li>
                                                     <li>
                                                         <input type="checkbox" name="tall-2" id="tall-2">
                                                         <label for="tall-2" class="custom-unchecked">Giants</label>
                                                         <ul>
                                                             <li>
                                                                 <input type="checkbox" name="tall-2-1" id="tall-2-1">
                                                                 <label for="tall-2-1" class="custom-unchecked">Andre</label>
                                                             </li>
                                                             <li class="last">
                                                                 <input type="checkbox" name="tall-2-2" id="tall-2-2">
                                                                 <label for="tall-2-2" class="custom-unchecked">Paul Bunyan</label>
                                                             </li>
                                                         </ul>
                                                     </li>
                                                     <li class="last">
                                                         <input type="checkbox" name="tall-3" id="tall-3">
                                                         <label for="tall-3" class="custom-unchecked">Two sandwiches</label>
                                                     </li>
                                                </ul>
                                            </li>  --}}
                                            @isset($data)
                                                @foreach ($data as $key=>$value)
                                                    <li class="last">
                                                        <input type="checkbox" name="category[{{$key}}][]" id="short" value="{{ $value->id }}" @if($value->permission==true) checked @endif>
                                                        <label for="short" class="@if($value->permission==true) custom-checked @else custom-unchecked @endif">{{ $value->menu->name ?? 'N/A' }}</label>

                                                        <ul>
                                                            @isset($value->children)
                                                                @foreach ($value->children as $kk=>$item)
                                                                    <li class="ml-3">
                                                                        <input type="checkbox" name="category[{{ $key }}][children][]" id="short-1" value="{{ $item->id }}" @if($item->permission==true) checked @endif>
                                                                        <label for="short-1" class="@if($item->permission==true) custom-checked @else custom-unchecked @endif">{{ $item->subMenu->name ?? 'N/A' }}</label>
                                                                    </li>
                                                                @endforeach
                                                            @endisset
                                                        </ul>
                                                    </li>
                                                @endforeach
                                            @endisset

                                        </ul>

                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-5" align="center">Submit</button>
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
    $(function() {

        $('input[type="checkbox"]').change(checkboxChanged);

        function checkboxChanged() {
                var $this = $(this),
                    checked = $this.prop("checked"),
                    container = $this.parent(),
                    siblings = container.siblings();

                container.find('input[type="checkbox"]')
                .prop({
                    indeterminate: false,
                    checked: checked
                })
                .siblings('label')
                .removeClass('custom-checked custom-unchecked custom-indeterminate')
                .addClass(checked ? 'custom-checked' : 'custom-unchecked');

                checkSiblings(container, checked);
        }

        function checkSiblings($el, checked) {
            var parent = $el.parent().parent(),
                all = true,
                indeterminate = false;

            $el.siblings().each(function() {
                return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
            });

            if (all && checked) {
                parent.children('input[type="checkbox"]')
                .prop({
                    indeterminate: false,
                    checked: checked
                })
                .siblings('label')
                .removeClass('custom-checked custom-unchecked custom-indeterminate')
                .addClass(checked ? 'custom-checked' : 'custom-unchecked');

                    checkSiblings(parent, checked);
                }
                else if (all && !checked) {
                    indeterminate = parent.find('input[type="checkbox"]:checked').length > 0;

                    parent.children('input[type="checkbox"]')
                    .prop("checked", checked)
                    .prop("indeterminate", indeterminate)
                    .siblings('label')
                    .removeClass('custom-checked custom-unchecked custom-indeterminate')
                    .addClass(indeterminate ? 'custom-indeterminate' : (checked ? 'custom-checked' : 'custom-unchecked'));

                    checkSiblings(parent, checked);
                }
                else {
                    console.log(parent.find('input[type="checkbox"]:checked').length > 0);
                    $el.parents("li").children('input[type="checkbox"]')
                    .prop({
                        indeterminate: false,
                        checked: true
                    })
                    .siblings('label')
                    .removeClass('custom-checked custom-unchecked custom-indeterminate')
                    .addClass('custom-indeterminate');
                }
        }
    });
</script>
@stop
