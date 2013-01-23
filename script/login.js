$(document).ready(function(e) {
    if($('#username').val() != "")
		$('#password').focus();
	else
		$('#username').focus();
		
	$('#login').submit(function() {
		$('#password').val(Sha1.hash($('#password').val()));
	});
});