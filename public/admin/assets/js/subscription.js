(function ($) {

	$('body').on('click', '#addPlus', function () {
		$('#addModal').modal('show')
	})

	$('body').on('click', '.editPlus', function () {
		$.ajax({
			type: "get",
			url: "/admin/subscription/plan/" + $(this).attr('data-id'),
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function (response) {
				console.log(response);
				$('#id').val(response.data.id);
				$('#type').val(response.data.type);
				$('#name').val(response.data.name);
				$('#amount').val(response.data.amount);
				$('#plan_type').val(response.data.plan_type);
				$('.edit #description').text(response.data.description);
				if (response.data.status == 1) {
					$('#status').prop('checked', true).val(1);
				} else {
					$('#status').prop('checked', false).val(0);

				}
			},
			error: function (error) {
				console.log(error);
			}
		});
		// $('#name').val($(this).attr('data-name'))
		// $('#amount').val($(this).attr('data-amount'))
		$('#EditModal').modal('show')
	});

	$(document).on('change', 'input[name="status"]', function () {
		$.ajax({
			type: 'POST',
			url: "/admin/subscription/plan/check",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				"_token": $('meta[name="csrf-token"]').attr('content'),
				"id": $('#id').val(),
				"type": $('#type').val()
			},
			success: function (response) {
				if (response.data && response.data.status == 1) {
					Swal.fire({
						title: "Error",
						text: response.data.name + ' plan already enabled, Please disabled first',
						icon: "error",
						confirmButtonText: "Okay",
					});
					$(this).prop('checked', false).val(0);
				}
			},
			error: function (error) {
				console.log(error);
				$(this).prop('checked', false).val(0);
			}
		})
		if ($(this).prop('checked') == true) {
			$(this).val(1);
		} else if ($(this).prop('checked') == false) {
			$(this).val(0);
		}
	});


	$(document).on('change', '.statusPlus', function () {
		let $this = $(this);
		$.ajax({
			type: 'POST',
			url: "/admin/subscription/plan/changestatus",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				"_token": $('meta[name="csrf-token"]').attr('content'),
				"id": $this.data('id'),
				"status": ($this.find('.status').prop('checked') == true ? 1 : 0),
				"type": $this.data('type')
			},
			success: function (response) {
				if (response.data && response.data.status == 1 && $this.data('id') != response.data.id) {
					Swal.fire({
						title: "Error",
						text: response.data.name + ' plan already enabled, Please disabled first',
						icon: "error",
						confirmButtonText: "Okay",
					});
					$this.find('.status').prop('checked', false).val(0);
				} else {
					Swal.fire({
						title: "Success",
						text: response.data.name + ' plan ' + ($this.find('.status').prop('checked') == true ? 'enabled' : 'disabled') + ' successfully',
						icon: "success",
						confirmButtonText: "Okay",
					});
					if ($this.find('.status').prop('checked') == true) {
						$this.find('.status').val(1);
					} else if ($this.find('.status').prop('checked') == false) {
						$this.find('.status').val(0);
					}
					// $this.find('.status').prop('checked', true).val(1);
				}
			},
			error: function (error) {
				console.log(error);
				$this.find('.status').prop('checked', false).val(0);
			}
		})
		if ($this.find('.status').prop('checked') == true) {
			$this.find('.status').val(1);
		} else if ($this.find('.status').prop('checked') == false) {
			$this.find('.status').val(0);
		}
	});


	$(document).on("click", "#deletePlus", function () {
		var id = $(this).data('id');
		Swal.fire({
			title: "{{__('Are you Sure?')}}",
			icon: 'info',
			showCancelButton: true,
			confirmButtonText: 'Ok',
		}).then((result) => {
			if (result.value) {
				$(this).closest('#deletePlusForm').submit();
			}
		});
	});

	$(document).on('click', '.cst-plan-tab-action', function () {
		$('.cst-plan-section').hide();
		$('#' + $(this).data('target')).show();
	});


	$(document).ready(function () {

		$('#addForm').validate({ // initialize the plugin
			rules: {
				name: {
					required: true,
				},
				amount: {
					required: true,
					// number: true
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


	$(document).ready(function () {

		$('#editForm').validate({ // initialize the plugin
			rules: {
				name: {
					required: true,
				},
				amount: {
					required: true,
					// number: true
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

})(jQuery)