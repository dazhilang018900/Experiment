//传递内容给show.php
function sendContent(obj) {
	xmlhttp = new XMLHttpRequest();
	url = "show.php?message=" + obj.value;
	//url = "show.php?message=on";
	xmlhttp.open("get",url,true);
	xmlhttp.send();
	return false;
}
