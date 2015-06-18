<!DOCTYPE html>
<?php require_once('config.php'); 
?>
<html>

<head>
	
	<meta http-equiv="Content-Type" charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=0" />
	<title>拼车信息</title>

    <link rel="stylesheet"  href="static/jqm/jquery.mobile-1.3.2.min.css" /> 
    <script src="static/jq/jquery-1.10.2.min.js"></script> 
	<script src="static/jqm/jquery.mobile-1.3.2.min.js"></script>
    


	
	
</head>

<body style="width:100%;margin:0 auto;">
	<div data-role="page" id="page" data-theme = "none"> <!--data-theme = "a"-->
  	<link rel="stylesheet" type="text/css" href="static/css/info.css">
	<!--background-->
	<!--  data-role="content" -->

	<div id = "blurBg"><img src = "static/img/background.jpg" ></div>
<?php
	//判断是否登录，没登录自动调转登陆界面
	if (!isset($_GET['nick'])) {
				//跳转	
				$url = "../init/login.php";
				echo "<script language='javascript' type='text/javascript'>";  
				echo "window.location.href='$url'";  
				echo "</script>";  

	}
?>


	<div data-role="header">
		<h1 class="title">目前已有的拼车信息</h1>
	</div>
	<div data-inline="false" data-type="">
	<li>
		<a href=<?php if ( isset($_GET['nick']) ) echo '"info_add.php?nick='.$_GET['nick'].'"'; else echo '"info_add.php"'; ?> data-role="button" id=a2><span>添加拼车信息</span></a>			　　 
	</li>
	 </div>

	<div class="newsList">
	<ul data-role="listview" data-icon="false" data-filter="true" data-filter-placeholder="搜索目的地 或者出发时间..."><br>
	<?php
		$sql1="select * from carshare_activity order by startTime desc";
		$result1=mysql_query($sql1,$link_ID);
		if ( mysql_num_rows($result1) != 0 ) {
		?>
		
		<?php 
			while($row=mysql_fetch_array($result1)){
				$sT = $row['startTime'];
				$sT = strtotime($sT);
				$s = time();
				if ( $sT < $s ) continue;

?>
	
	<li  id="listtest">
		<?php 
			if ( isset($_GET['nick'])) {
				$host = $_GET['nick'];
				echo '<a href="info_detail.php?id='.$row['id'].'&nick='.$host.'">'; //传入id跟nick
			}
			else
				echo '<a href="info_detail.php?id='.$row['id'].'">'; //传入id
		?> 
			<h2>{<?php echo $row['end_place']; ?>}&nbsp&nbsp&nbsp{<?php echo $row['startTime']; ?>}&nbsp&nbsp&nbsp{<?php echo $row['guest_num']; ?>}</h2>
		</a>
	</li>
	
	
<?php
			}?>
	</ul>

<?php			
		}
		else echo '<div id="empty">暂无拼车信息</div>';
	?>
	</div>
	</div>
</body>
</html>









