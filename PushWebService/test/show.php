<?php require_once('config.php'); ?>
<?php require_once('global.php'); ?>
<?php
//session_start();
function findAddress($longitude,$latitude) {   //根据输入经纬度找地址
	if ( $longitude == NULL || $latitude == NULL ) {
		return "无法确定地址";
	} else if ( abs($longitude-22.593034) <= 0.0001 && abs($latitude-113.97423) < 0.0001 ) {   
		return "北大园区";
	} else if ( abs($longitude-22.593353) <= 0.0001 && abs($latitude-113.97954) < 0.0001 ) {
		return "春园路口";
	} else {
		return "无法确定地址";
	}
}
if(isset($_GET['message'])){
	$message = $_GET['message'];
	//$message = 'on';
	//检测是否存有账号，经纬度坐标
	if ( isset($_SESSION['nick'])) {
		$nick = $_SESSION['nick'];
	} else {
		$nick = "visitor";
	}
	if ( isset($_SESSION['longitude']) && isset($_SESSION['latitude'])) {   //判断是否有经纬度传入，没有按默认为null处理
		$longitude = $_SESSION['longitude'];
		$latitude = $_SESSION['latitude'];
		$query="insert into b736(chtime,nick,words,longitude,latitude)values(now(),'$nick','$message','$longitude','$latitude')";//插入SQL语句
		mysql_query($query,$link_ID); //发送留言到数据库
	} else {
		$query="insert into b736(chtime,nick,words)values(now(),'$nick','$message')";//插入SQL语句
		mysql_query($query,$link_ID); //发送留言到数据库
	}
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>b736消息栏</title>
</head>
<body>
<?php 
	//最新发言显示在最下面
	$sql="select * from b736 order by chtime asc";
	$result=mysql_query($sql,$link_ID);
	$total=mysql_num_rows($result);
	$info=($total/15-1)*15;
	if($total<15){
	$str="select * from b736 order by chtime asc;" ; //查询字符串
	}else{
	$str="select * from b736 order by chtime asc limit $info,15;" ; //查询字符串
	}
 	$result=mysql_query($str,$link_ID); //送出查询
 	while($row=mysql_fetch_array($result)){
?>
<table id="showlist" table  border="0" align="center" >
  
  <tr>
    <td width="10%" align="left" class="font">昵称:</td>
    <td width="15%" align="center" class="font"><?php echo $row['nick']; ?></td>
    <td width="5%" align="left" class="font">说:</td>
    <td width="10%" align="left" class="font"><?php echo $row['words'];?></td>
    <td width="10%" align="left" class="font">[<?php echo findAddress($row['longitude'],$row['latitude']);?>]</td>
    <td width="15%" align="left" class="font">[<?php echo $row['chtime'];?>]</td>
  </tr>
</table>
<?php } ?>
</body>
</html>
<script language="JavaScript">
function scrollWindow(){   //定位滚动条
	this.scroll(0,75000);
	//setTimeout('scrollWindow()',200);
}
function myrefresh()
{
   window.location.reload();
}
setInterval('myrefresh()',3000); //指定3秒刷新一次
//setTimeout('scrollWindow()',3000); //指定3秒跳转一次
</script>
