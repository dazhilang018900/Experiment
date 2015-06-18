<script language="javascript" src="speak.js"></script>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
<title>b736-board</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<form action='show.php' method='POST' align="center" >
	<input type='hidden' name='test' value='test1'/>
	<input name='b1' type= 'button' value='等车中' onClick="return sendContent(this)" />
	<input name='b2' type= 'button' value='已上车'  onClick="return sendContent(this)" />
</form>
</body>
</html>