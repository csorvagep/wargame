// JavaScript Document

function valasz(str,i)
{
	document.addcom.msg.focus();
	document.addcom.msg.select();
	document.addcom.msg.value="Válasz "+str+" üzenetére: (#"+i+")\n\n";
}

function insertTag(aTag, eTag) {
	var input = document.forms['addcom'].elements['msg'];
	input.focus();
	if(typeof document.selection != 'undefined') {  // Internet Explorer 
		var range = document.selection.createRange();
		var insText = range.text;
		range.text = aTag + insText + eTag;
		range = document.selection.createRange();
		if (insText.length == 0) {
			range.move('character', -eTag.length);
		} else {
			if (eTag.length) range.moveStart('character', aTag.length + insText.length + eTag.length);      
			else range.moveStart('character', aTag.length);
		}
		range.select();
	} else if(typeof input.selectionStart != 'undefined') {// Mozilla 
		var start = input.selectionStart;
		var end = input.selectionEnd;
		var insText = input.value.substring(start, end);
		input.value = input.value.substr(0, start) + aTag + insText + eTag + input.value.substr(end);
		var pos;
		if (insText.length == 0) {
			pos = start + aTag.length;
		} else {
			if (eTag.length) pos = start + aTag.length + insText.length + eTag.length;
			else pos = start + aTag.length;
		}
		input.selectionStart = pos;
		input.selectionEnd = pos;
	} else	// misc Browser 
		input.value += aTag + eTag;
}
function insertLink() {
	myText = prompt('A link szövege, ami megjelenik a kommentben.','');
	if (!myText) return;
	myLink = prompt('URL, ide fog mutatni a link. (http://-rel kezdõdik)','http://');
	if (!myLink) return;
	internal = false;
	if (!internal) myLink = myLink.substring(0,5).toLowerCase() + myLink.substring(5,myLink.length);
	myLinkText = "[url='" + myLink + "'] " + myText + " [/url]";
	insertTag(' ' + myLinkText + ' ','');
}
function replaceString(searchText,replaceText,subjectText) {
	arrayOfStrings = subjectText.split(searchText);
	newString = '';
	for (var i=0; i < arrayOfStrings.length-1; i++) {
		newString += (arrayOfStrings[i] + replaceText);
	}
	newString += arrayOfStrings[arrayOfStrings.length-1];
	return newString
}
function inString(haystack,needle) {
	for (var i=0; i < haystack.length; i++) {
		if (haystack.charAt(i) == needle) return i;
	}
	return -1;
}
function inEmo(smile)
{
	insertTag(smile,'');
}
function inLink()
{
	href = document.forms['addcom'].elements['ref'];
	ref_text = document.forms['addcom'].elements['link'];
	if(href.value == "")
		return;
	if(ref_text.value == "")
		link_text = "[url='" + href.value + "']" + href.value;
	else
		link_text = "[url='" + href.value + "']" + ref_text.value;
	insertTag(' '+link_text,'[/url] ');
	href.value = "http://";
	ref_text.value = "";
	document.getElementById('link_div').style.display="none";
	setTimeout("document.getElementById('link_div').style.display=''",100);
}