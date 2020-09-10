// CREATING THE REQUEST

function createRequestObject()
{
	try
	{
		xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
	}
	catch(e)
	{
		alert('Sorry, but your browser doesn\'t support XMLHttpRequest.');
	}
	return xmlhttp;
}

var http = createRequestObject();
var sess = createRequestObject();
var check_ok = false;

// IMAGE REFRESHING

function refreshimg()
{
	var url = urlBase+'/media/js/captcha/image_req.php';
	dorefresh(url, displayimg);
}

function dorefresh(url, callback)
{
	sess.open('POST', urlBase+'/media/js/captcha/newsession.php', true);
	sess.send(null);
	http.open('POST', url, true);
	http.onreadystatechange = displayimg;
	http.send(null);
}

function displayimg()
{
	if(http.readyState == 4)
	{
		var showimage = http.responseText;
		document.getElementById('captchaimage').innerHTML = showimage;
	}
}

// SUBMISSION

function check()
{
	var submission = document.getElementById('captcha_id').value;
	var url = urlBase+'/media/js/captcha/process.php?captcha=' + submission;

	data = $.ajax({
		type: "GET",
		url: url,
		async: false
	}).responseText;

	if(data == '1')
	 	return true;
	else 
		return false;
}
