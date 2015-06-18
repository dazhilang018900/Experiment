<?php
	require_once('config.php');
	$host_id = $_GET['nick'];
	$sql="select * from carshare_host where userId = '$host_id'";
	$result=mysql_query($sql,$link_ID);
	$row=mysql_fetch_array($result);
 ?>
 <!DOCTYPE html>
<html>

<head>
	
	<meta http-equiv="Content-Type" charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=0" />
	<title>与我联系</title>

    <link rel="stylesheet"  href="static/jqm/jquery.mobile-1.3.2.min.css" /> 
    <script src="static/jq/jquery-1.10.2.min.js"></script> 
	<script src="static/jqm/jquery.mobile-1.3.2.min.js"></script>

	
	
</head>

<body style="width:100%;margin:0 auto;">
<?php
	$name = $row['userName'];
	$phone = $row['phone'];
	echo '<div><h1>姓名：'.$name.'</h1></div>';
	echo '<div><h1>手机号：'.$phone.'</h1></div>';
?>
</body>
</html>









