<!DOCTYPE html>

<html>

<head>
	
	<meta http-equiv="Content-Type" charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=0" />
	<title>一起走吧</title>
	
    <link rel="stylesheet"  href="static/jqm/jquery.mobile-1.3.2.min.css" /> 
    <script src="static/jq/jquery-1.10.2.min.js"></script> 
	<script src="static/jqm/jquery.mobile-1.3.2.min.js"></script>

	
	
</head>

<body style="width:100%;margin:0 auto;">

	<div id = "main-block">	
		<div data-role="footer">
			<h1>拼车信息公告栏</h1>
		</div>


		<div data-role="content" data-theme="f" id = "linhc_page">
			<div data-inline="false" data-type="">

				<li> 
				     <a href=<?php if ( isset($_GET['nick']) ) echo '"info.php?nick='.$_GET['nick'].'"'; else echo '"info.php"'; ?> data-role="button" id=a1><span>查看已有的拼车信息</span></a>
				</li>
				<li>
				     <a href=<?php if ( isset($_GET['nick']) ) echo '"info_add.php?nick='.$_GET['nick'].'"'; else echo '"info_add.php"'; ?> data-role="button" id=a2><span>增加拼车信息</span></a>			　　 
				</li>

			</div>
	    </div>

	</div>


	
	
	</div><!-- /content --> 
</body>
</html>






