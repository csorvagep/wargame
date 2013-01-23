function ujablak() {
	ablak = open("/upload", "uj_ablak", "width=480,height=200,status=no,menubar=no,scrollbars=no,resizable=no");
}

function valt(chk, text) {
	if (document.forms['settings'].elements[chk].checked == '1') {
		document.forms['settings'].elements[text].disabled = "";
		document.forms['settings'].elements[text].style.background = "";
	} else {
		document.forms['settings'].elements[text].disabled = "disabled";
		document.forms['settings'].elements[text].style.background = "#333";
	}
}


$(document).ready(function(e) {
	$('a[href="del"]', '#avatar').click(function(e) {
		e.preventDefault();
		document.location.href = "/settings?avatar=del";
	});
	$('a[href="upload"]', '#avatar').click(function(e) {
		e.preventDefault();
		ujablak();
	});

	if (! $('#koli').is(':checked'))
		$('#szoba').parent('div').hide();

	$pw = $('.pw').hide();

	$('#chgpass').click(function(e) {
		if ($(this).is(':checked'))
			$pw.slideDown();
		else
			$pw.slideUp();
	});

	$('#koli').click(function(e) {
		if ($(this).is(':checked'))
			$('#szoba').parent('div').slideDown();
		else
			$('#szoba').val('').parent('div').slideUp();
	});

	$("#setting_form").submit(function() {
		if ($("#chgpass").is(":checked")) {
			$('#oldpass').val(Sha1.hash($('#oldpass').val()));
			$('#pass').val(Sha1.hash($('#pass').val()));
			$('#repass').val(Sha1.hash($('#repass').val()));
		}
	});
});
