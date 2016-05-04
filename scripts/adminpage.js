$(document).ready(function() {
	$('#emsend').click(function() {
		$('#hinput').val('send');
		document.getElementById('emform').submit();
	});
});