<?php 
	require_once('config.php'); 
	$u = true;
	if (isset( $_POST['name'])) {
		$name = $_POST['name'];
		$sql="select * from apn_user where name = '$name'";
		$result=mysql_query($sql,$link_ID);
		$password = md5($_POST['password']);
		if ( mysql_num_rows($result) != 0 ) {
			$result = mysql_fetch_array($result);
			if ( $password == $result['password']) {
				//跳转	
				$url = "index.php?nick=".$name;
				echo "<script language='javascript' type='text/javascript'>";  
				echo "window.location.href='$url'";  
				echo "</script>";  

			}
		}
		$u = false;
	}

?>
<html>
<head>
	
	<meta http-equiv="Content-Type" charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=0" />
	<title>登录</title>
	<link rel="stylesheet"  href="static/jqm/jquery.mobile-1.3.2.min.css" /> 
    <script src="static/jq/jquery-1.10.2.min.js"></script> 
	<script src="static/jqm/jquery.mobile-1.3.2.min.js"></script>
	
</head>
<body>
<form name="login" action="login1.php" method=post>
用户名<input type="text" name="name" id="name" class="form-control username">
密码<input type="password" name="password" id="password" class="form-control pwd">
		<label style=<?php if ( $u == true ) echo '"display:none"'; else echo '"display:block"'; ?> class = "tishi" id = "tishi" >用户名或者密码错误</label>
			<input name="log" type="submit"  data-role = "button" value="登录">

</form>
</body>
</html>