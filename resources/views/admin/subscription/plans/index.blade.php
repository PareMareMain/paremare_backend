@extends('admin.layouts.adminLayout')
@section('title','Subscription Management')
<link rel="stylesheet" href="{{ asset('admin/assets/css/subscription.css') }}">
@section('content')
<div class="container-fluid">
	<div class="block-header">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12">
				<h2>Plans</h2>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i></a>
					</li>
					<li class="breadcrumb-item">Plan</li>
					<li class="breadcrumb-item active">List</li>
				</ul>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="d-flex flex-row-reverse">
					<div class="page_action">
						{{-- <a href="javascript:;" class="addPlus" id="addPlus"><button type="button" class="btn btn-primary"><i class="fa fa-Plus"></i>
								Add Plan</button></a> --}}
						{{-- <button type="button" class="btn btn-secondary"><i class="fa fa-send"></i> Send
                            report</button> --}}
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
					{{-- <h2>Departments List</h2> --}}
					{{-- <a href="javascript:;" class="cst-plan-tab-action" data-target="customerPlan"><button type="button" class="btn btn-primary">
							Customer Plan</button></a>
					<a href="javascript:;" class="cst-plan-tab-action" data-target="vendorPlan"><button type="button" class="btn btn-primary">
							Vandor Plan</button></a> -- --}}
							<button type="button" id="click_plan" class="btn btn-primary">Add Plan</button>
				</div>
				<div class="body cst-plan-section" id="customerPlan">
					<div class="table-responsive">
						<table class="table table-bordered table-hover js-basic-example dataTable table-custom">
							<thead>
								<tr>
									<th>Id</th>
									<th>Plan Name</th>
									<th>Amount</th>
									<!-- <th>Per Post</th> -->
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($data as $key=>$value)
								<tr>
									<td>{{$key + 1}}</td>
									<td class="mb-0 planName">{{$value->name ?? '--'}}</td>
									<td class="mb-0">{{$value->amount ?? 0 }}</td>

									<td class="cst-td-action">
										<a href="javascript:;" data-id="{{ $value->id }}" id="editPlus" class="editPlus cst-action-btn"><button type="button" class="btn btn-sm btn-outline-secondary" title="edit" style="height:35;width:35"><i class="fa fa-pencil" style="color:#7ca4dd"></i></button></a>
										<a href="javascript:;" data-id="{{ $value->id }}" data-type="{{ $value->type }}" id="statusPlus" class="statusPlus cst-action-btn">
											<div class="form-group">
												<label class="switch">
													<input type="checkbox" class="status" value="1" {{$value->status == 1?'checked':''}}>
													<span class="slider round"></span>
												</label>
											</div>
										</a>
										<!-- <form method="post" action="{{route('plan.delete',$value->id)}}" id="deletePlusForm">
											@method('delete')
											@csrf

											<button type="button" class="btn btn-sm btn-outline-secondary" title="view" id="deletePlus"><i class="fa fa-trash" style="color:red"></i></button>
										</form> -->
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>


				<div class="body cst-plan-section" id="vendorPlan" style="display: none;">
					<div class="table-responsive">
						<table class="table table-bordered table-hover js-basic-example dataTable table-custom">
							<thead>
								<tr>
									<th>Id</th>
									<th>Plan Name</th>
									<th>Amount</th>
									<!-- <th>Per Post</th> -->
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							@foreach($vendordata as $key=>$value)
								<tr>
									<td>{{$key + 1}}</td>
									<td class="mb-0 planName">{{$value->name ?? '--'}}</td>
									<td class="mb-0">{{$value->amount ?? 0 }}</td>

									<td class="cst-td-action">
										<a href="javascript:;" data-id="{{ $value->id }}" id="editPlus" class="editPlus cst-action-btn"><button type="button" class="btn btn-sm btn-outline-secondary" title="edit" style="height:35;width:35"><i class="fa fa-pencil" style="color:#7ca4dd"></i></button></a>
										<a href="javascript:;" data-id="{{ $value->id }}" data-type="{{ $value->type }}" id="statusPlus" class="statusPlus cst-action-btn">
											<div class="form-group">
												<label class="switch">
													<input type="checkbox" class="status" value="1" {{$value->status == 1?'checked':''}}>
													<span class="slider round"></span>
												</label>
											</div>
										</a>
										<!-- <form method="post" action="{{route('plan.delete',$value->id)}}" id="deletePlusForm">
											@method('delete')
											@csrf

											<button type="button" class="btn btn-sm btn-outline-secondary" title="view" id="deletePlus"><i class="fa fa-trash" style="color:red"></i></button>
										</form> -->
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
<div class="modal" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Subscription</h5>
			</div>
			<div class="modal-body">
				<form action="{{ route('plan.create') }}" method="post" id="addForm">
					@csrf
					<div class="form-group">
						<label for="name">Plan Name</label>
						<input type="text" name="name" class="form-control">
					</div>
					<div class="form-group">
						<label for="name">Amount</label>
						<input type="number" name="amount" class="form-control" step="0.01">
					</div>
					<div class="form-group">
						<label for="name">Plan Type</label>
						<select name="plan_type" class="form-control">
							<option value="">Select</option>
							<option value="1">Daily</option>
							<option value="2">Monthly</option>
							<option value="3">Yearly</option>
							<option value="4">Six Month</option>
						</select>
					</div>
					<div class="form-group">
						<label for="name">Description</label>
						<textarea name="description" class="form-control" id="description"> </textarea>
					</div>
					<div class="form-group">
						<label class="switch">
							<input type="checkbox" name="status" value="1">
							<span class="slider round"></span>
						</label>
					</div>
					<div align="center">
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Subscription</h5>
			</div>
			<div class="modal-body">
				<form action="{{ route('plan.edit') }}" method="post" id="editForm">
					@csrf
					<input type="hidden" name="id" id="id">
					<input type="hidden" name="type" id="type">
					<div class="form-group">
						<label for="name">Plan Name</label>
						<input type="text" name="name" class="form-control" id="name">
					</div>
					<div class="form-group">
						<label for="name">Amount</label>
						<input type="number" name="amount" class="form-control" id="amount" step="0.01">
					</div>
					<div class="form-group">
						<label for="name">Plan Type</label>
						<select name="plan_type" class="form-control" id="plan_type">
							<option value="">Select</option>
							<option value="1">Daily</option>
							<option value="2">Monthly</option>
							<option value="3">Yearly</option>
							<option value="4">Six Month</option>
						</select>
					</div>
					<div class="form-group edit">
						<label for="name">Description</label>
						<textarea name="description" class="form-control" id="description"> </textarea>
					</div>
					<div class="form-group">
						<label class="switch">
							<input type="checkbox" name="status" id="status" value="1">
							<span class="slider round"></span>
						</label>
					</div>
					<div align="center">
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>

				</form>

			</div>

		</div>
	</div>
</div>
@stop
@section('scripts')
<script type="text/javascript" src="{{ asset('admin/assets/js/subscription.js') }}"></script>
<script>
	$('#click_plan').on('click',function(){
        $('#addModal').modal('show')
    });
</script>
@stop