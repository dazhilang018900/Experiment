<!DOCTYPE html>
<?php require_once('config.php'); ?>
<html>

<head>
	
	<meta http-equiv="Content-Type" charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=0" />
	<title>应用列表</title>

    <link rel="stylesheet"  href="static/jqm/jquery.mobile-1.3.2.min.css" /> 
    <script src="static/jq/jquery-1.10.2.min.js"></script> 
	<script src="static/jqm/jquery.mobile-1.3.2.min.js"></script>

	
	
</head>

<body style="width:100%;margin:0 auto;">
<?php
	if (!isset( $_GET['nick'])) {
		echo '<div><h1><a href="../b736/index.php">b736</a></h1></div>';
		echo '<div><h1><a href="../pcar/index.php">拼车</a></h1></div>';
		echo '<div><h1><a href="/init/login.php">你尚未登录，请先登录</a></h1></div>';
	}else {
		echo '<div><h1><a href="../b736/index.php?nick='.$_GET['nick'].'">b736</a></h1></div>';
		echo '<div><h1><a href="../pcar/index.php?nick='.$_GET['nick'].'">拼车</a></h1></div>';
	}
?>
</body>
</html>









