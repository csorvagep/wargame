// JavaScript Document
$(document).ready(function(e) {
	
    var $emo = $('#emo')
	.toggle(function() {
			$('#smile').fadeIn(350);
		}, function() {
			$('#smile').fadeOut(350);
		});
	
	$('a','#smile').click(function(e) {
        e.preventDefault();
		
		inEmo($(this).attr("href"));
    });
	$emo.mouseleave(function(e) {
        if($('#smile').is(':visible'))
			$('#smile').click();
    });
	
	var $link = $('#link')
	.data("visible",false)
	.click(function(e) {
		if(($(e.target).is('p') && $(e.target).text() == "link") || $(e.target).is('#link'))
			if($link.data("visible")) {
				$('#link_div').fadeOut(350); // slideUp
				$link.data("visible",false);
				$('input[name="ref"]').focus();
			} else {
				$('#link_div').fadeIn(350); // slideDown
				$link.data("visible",true);
			}
    })
	.mouseleave(function(e) {
        var timer_id = window.setTimeout(function() {
			if($link.data("visible"))
				 $link.removeData("timer_id").click();
		},600);
		
		$link.data("timer_id",timer_id);
    })
	.mouseenter(function(e) {
        if($link.data("visible") && typeof($link.data("timer_id")) != "undefined")
		{
			window.clearTimeout($link.data("timer_id"));
			$link.removeData("timer_id");
		}	
    });
	
	$('#addlink').submit(function(e) {
		e.preventDefault();
		var href = $('input[name="ref"]');
		var ref_text = $('input[name="link"]');
		if(href.val() == "")
			return;
		if(ref_text.val() == "")
			link_text = "[url='" + href.val() + "']" + href.val();
		else
			link_text = "[url='" + href.val() + "']" + ref_text.val();
		insertTag(' '+link_text,'[/url] ');
		href.val("http://");
		ref_text.val("");
		$link.click();
	});

});