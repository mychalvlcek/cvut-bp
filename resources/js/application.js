// onload events
$(function() {
// register validation
	$('form').validate({
		onKeyup : true,
		eachValidField : function() {
			$(this).closest('.control-group').removeClass('error').addClass('success');
		},
		eachInvalidField : function() {
			$(this).closest('.control-group').removeClass('success').addClass('error');
		},
		conditional : {
			confirm : function() {
				return $(this).val() == $('#password').val();
			}
		}
	});
	$.validateExtend({
		email : {
			required : true,
			pattern : /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/
		}
	});

});
// delete buttons
$('a.delete-btn').click(function() {
	return confirm('Opravdu chcete položku smazat?');
});
// global tooltips
$('[rel=tooltip]').tooltip();
// alerts
$('.alert').alert();