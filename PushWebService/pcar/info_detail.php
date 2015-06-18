<!DOCTYPE html>
<?php require_once('config.php'); ?>
<?php 
		$id = $_GET['id'];
		$sql1="select * from carshare_activity where id = '$id'";
		$result1=mysql_query($sql1,$link_ID);
		$row=mysql_fetch_array($result1)
?>
<html>

<head>
	
	<meta http-equiv="Content-Type" charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=0" />
	<title><?php echo $row['theme']; ?></title>

    <link rel="stylesheet"  href="static/jqm/jquery.mobile-1.3.2.min.css" /> 
    <script src="static/jq/jquery-1.10.2.min.js"></script> 
	<script src="static/jqm/jquery.mobile-1.3.2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="static/css/info.css">
	
	
</head>

<body >
	<div><!--  data-role="content" -->

<div id = "blurBg"><img src = "static/img/background.jpg" style="opacity:0.5;position:absolute;width: 100%;height:  auto;min-height:100%;z-index: 1;"></div>

<div class="introduceDetail">


	<form class="registerForm"  <?php echo 'action="infoformTo.php?id='.$row['id'].'";'; ?> method="POST" >
	<div class="newsList">
		<ul data-role="listview" data-icon="false" class="linhc_list">
			<li id="listtest">
				<!-- <h1>是吗？ {{info.guest}}</h1> -->
				<h2>已报名的人数： &nbsp<?php echo $row['guest_num']; ?></h2>
			</li> 
			<li id="listtest">
				<h2>出发地址：&nbsp<?php echo $row['start_place']; ?></h2>

			</li>
			<li id="listtest"> 
				<h2>到达地址：&nbsp <?php echo $row['end_place']; ?></h2>
			</li>
			<li id="listtest"> 
				<h2>大致出发时间：&nbsp<?php echo $row['startTime']; ?></h2>
			</li>
			<li id="listtest"> 
				<h2><?php echo $row['content']; ?></h2>
			</li>
		</ul>	
		<!-- <a datarole='button' href = ""> -->
		<a id="signForActivity" data-role="button" href="sign_for.php?id=<?php echo $_GET['id']; if (isset($_GET['nick'])) echo '&nick='.$_GET['nick']; ?>">报名</a>
		<!-- <button id="signForActivity" onclick="window.location.href("sign_for.php?id=<?php echo $_GET['id']; if (isset($_GET['nick'])) echo '&nick='.$_GET['nick']; ?>")">报名</button> -->
		<button  onclick="location.href='chat.php?nick=<?php echo $row['host_id']; ?>'">与我联系</button>

	</div>
	</form>


	</div><!-- /content --> 
</body>
</html>










