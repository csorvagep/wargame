$(document).ready(function(e) {
	$('#reg').submit(function() {
		$('#pass').val(Sha1.hash($('#pass').val()));
		$('#repass').val(Sha1.hash($('#repass').val()));
	});
});