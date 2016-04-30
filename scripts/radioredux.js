$(document).ready(function() {
	$('#yrselect').change(function() {
		if ($('#yrselect').val() != "na") {
			$('#yearForm').submit();
		}
	});
	
	$('#tbh').width($('#tb').width()+30);
});