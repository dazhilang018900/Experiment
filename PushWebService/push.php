<?php
	$title = base64_encode("北大园区");
	$message= base64_encode("北大园区");
	$url = 'http://219.223.222.231:8080/androidpn/notification.do?action=appPush&title='.$title.'&message='.$message.'&uri=xxx&appName=b736';
	$http = file_get_contents($url);
?>