$(document).ready(function() {
	$('#yrselect').change(function() {
		if ($('#yrselect').val() != "na") {
			$('#yearForm').submit();
		}
	});
});