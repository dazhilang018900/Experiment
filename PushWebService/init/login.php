<!DOCTYPE html>
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
<div data-role="page" id="page" data-theme = "none">
	<div data-role="header">
    <h1>校园信息服务系统</h1>
  </div>

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
				$url = "../index.php?nick=".$name;
				echo "<script language='javascript' type='text/javascript'>";  
				echo "window.location.href='$url'";  
				echo "</script>";  
				$u = true;
			}
		}
		$u = false;
	}

?>	

<form name="login" action="login.php" method=post>
	<div class="form-group inlineInfo" data-role="fieldcontain" style = "margin-top:50px;">
		<table data-mode="reflow">
                <tr>
                	<td>
		<label class="username">用户名</label>
					</td>
					<td>
		<input type="text" name="name" id="name" class="form-control username">
	</td>
               </tr>
				<tr>
               	<td>
		<label class="pwd">密码</label>
				</td>
				<td>
		<input type="password" name="password" id="password" class="form-control pwd">
				</td>
			</tr>
		<tr>
		<label style=<?php if ( $u == true ) echo '"display:none"'; else echo '"display:block"'; ?> class = "tishi" id = "tishi" >用户名或者密码错误</label>
		</tr>
	</table>
	</div>	
		<div class="form-group">
			<input name="log" type="submit"  data-role = "button" value="登录">
		</div>

</form>
	<div data-role="footer">
    	<h1>北京大学通信与信息安全实验室</h1>
  	</div>
</div>
</body>
</html>