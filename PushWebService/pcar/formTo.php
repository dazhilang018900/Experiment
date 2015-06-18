<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html>
<title>表单提交</title> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<body>
<?php
	$year1 = $_POST['year1'];
	$month1 = $_POST['month1'];
	$day1 = $_POST['day1'];
	$hour1 = $_POST['hour1'];
	$min1 = $_POST['min1'];
	
	$year2 = $_POST['year2'];
	$month2 = $_POST['month2'];
	$day2 = $_POST['day2'];
	$hour2 = $_POST['hour2'];
	$min2 = $_POST['min2'];

	$host = $_POST['host'];
	$phone = $_POST['phone'];
	$name = $_POST['name'];
	$theme = $_POST['theme'];
	$content = $_POST['content'];
	$start_place = $_POST['start_place'];
	$end_place = $_POST['end_place'];
	$datetime1 = mktime($hour1,$min1,0,$month1,$day1,$year1);
	$datetime2 = mktime($hour2,$min2,0,$month2,$day2,$year2);
	$d1 = date('Y-m-d H:i:s',$datetime1);
	$d2 = date('Y-m-d H:i:s',$datetime2);

	//判断其个人信息是否已经进入数据库，没有的话就补进去
	$sql1="select * from carshare_host where userId = '$host'";
	$result1=mysql_query($sql1,$link_ID);
	if ( mysql_num_rows($result1) == 0 ) {
		$query="insert into carshare_host(userID,phone,userName)values('$host','$phone','$name')";//插入SQL语句
		mysql_query($query,$link_ID); //发送留言到数据库
	}

	$query="insert into carshare_activity(startTime,endTime,start_place,end_place,host_id,theme,content)values('$d1','$d2','$start_place','$end_place','$host','$theme','$content')";//插入SQL语句
	mysql_query($query,$link_ID); //发送留言到数据库
	//$url = "info.php?nick=".$host;
	$url = "/pcar/index.php?nick=".$host;
	echo "<script language='javascript' type='text/javascript'>";  
	echo "window.location.href='$url'";  
	echo "</script>";  
?>
	
</body>
</html>