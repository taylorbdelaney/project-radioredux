$(document).ready(function() {
	$('#content').html($('#content').html() + "<br><button id='test'>Test</button>");
	$('#test').click(function() {
		//clickPlay();
		//$("#player").contents().find("div.play-pause-btn").click();
		var iframe = document.getElementById('player');
		var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
		alert('here');
	});
});
	
function clickPlay() {
	var i=0;
	alert($('.clickable play-pause-btn').length);
	$.each($('.clickable play-pause-btn'), function() {
		alert(i);
		i++;
	});
}