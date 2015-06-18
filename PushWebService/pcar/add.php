<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html>
<title>表单提交</title> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
     <a href="index.php">返回首页</a>
<?php

	$activityid = $_POST['activityid'];
	$userid = $_POST['userid'];
	$phone = $_POST['phone'];
	$name = $_POST['name'];
	
	
	//activity表的值加1
	$sql1="select * from carshare_activity where id = '$activityid'";
	$result1=mysql_query($sql1,$link_ID);
	$row=mysql_fetch_array($result1);
	$num = $row['guest_num']+1;
	$sql = "UPDATE carshare_activity SET guest_num = '$num' WHERE id = '$activityid'";
	mysql_query($sql,$link_ID);
	
	//查看guest是否登记过，没的话加入
	$sql1="select * from carshare_guest where userId = '$userid'";
	$result1=mysql_query($sql1,$link_ID);
	if ( mysql_num_rows($result1) == 0 ) {
		$query="insert into carshare_guest(userId,phone,userName)values('$userid','$phone','$name')";//插入SQL语句
		mysql_query($query,$link_ID); //发送留言到数据库
		
	}
	

	//activity_guest表中建立联系
	$query="insert into carshare_activity_guest(activity_id,guest_id)values('$activityid','$userid')";//插入SQL语句
	mysql_query($query,$link_ID); 
	
	//推送给host
	$query = "select * from carshare_activity where id = '$activityid'";
	$result = mysql_query($query,$link_ID); 
	$row= mysql_fetch_array($result);
	$host = $row ['host_id'];
	$place = $row['end_place'];

	// $title = base64_encode($place."有新人加入");
	$title = " somebody have joined your pcar";
	$title=base64_encode("有新人加入拼车");
	//$title = base64_decode($title);
	$message =" click the pcar to see details";
	$message=base64_encode('studentId:'.$userid.' phone:'.$phone.' destination:'.$place);
	//$message = base64_decode($message);
	$url = 'http://219.223.222.231:8080/androidpn/notification.do?action=user_send&title='.$title.'&message='.$message.'&uri=xxx&username='.$host;
	$http = file_get_contents($url);
	

	//跳转	
	$url = "info.php?nick=".$userid;
	echo "<script language='javascript' type='text/javascript'>";  
	echo "window.location.href='$url'";  
	echo "</script>";  
	
	
	
?>
</body>
</html>