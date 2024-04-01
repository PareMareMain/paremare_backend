// custom js 
$(document).ready(function() {
		
	$('.ddselect').on('mousedown', function(e){
		var $self = $(this);
		var isSelected = $self.attr("selected");
		$self.attr("selected", !isSelected);	
	});

});