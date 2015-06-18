//进行信息推送
$title = urlencode("中国人民万岁");
$message= urlencode("现在时间是".date("H:i:s",$t));
$url = 'http://219.223.222.231:8080/androidpn/notification.do?action=appPush&title='.$title.'&message='.$message.'&uri=xxx&appName=b736';
$http = file_get_contents($url);