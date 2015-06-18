<?php require_once('config.php'); ?>
<?php
	
//根据经纬度返回代号指定地方
//0——无法确定地址
//1——北大园区
//2——春园路口
function findAddress($longitude,$latitude) {   //根据输入经纬度找地址
	if ( $longitude == NULL || $latitude == NULL ) {
		return 0;
	} else if ( abs($longitude-113.974) <= 0.0015 ) {   
		return 1;
	} else if ( abs($longitude-113.979) <= 0.0015 ) {
		return 2;
	} else if ( abs($longitude-113.976) <= 0.0015 ) {
		return 3;
	} else {
		return 0;
	}
}
function sayAddress($longitude,$latitude) {   //根据输入经纬度找地址
	$result = findAddress($longitude,$latitude);
	if ( $result == 0 ) return "无法确定";
	else if ( $result == 1 ) return "北大园区";
	else if ( $result == 2 ) return "春园路口";
	else if ( $result == 3 ) return "a208";
	else return "无法确定";
}
function wordchange($word) {
	if ( $word == 'on' ) return "上车了";
	else if ( $word == 'wait' ) return "等车中";
	else return $word;
}

//将信息保存到数据库
if(isset($_GET['nick'])){
	$nick = $_GET['nick'];
	if ( isset($_GET['longitude']) && isset($_GET['latitude'])) {   //判断是否有经纬度传入，没有按默认为null处理
		//$message = $_GET['action'];
		$longitude = $_GET['longitude'];
		$latitude = $_GET['latitude'];
		if ( isset($_GET['action'])) { //如果有操作的话就进行接下来的判断，没有就直接保存
			$message = $_GET['action'];
			if ( $message == 'wait' ) {
				$query="insert into b736(chtime,nick,words,longitude,latitude)values(now(),'$nick','$message','$longitude','$latitude')";//插入SQL语句
				mysql_query($query,$link_ID); //发送留言到数据库
			} else { //尝试更新班车到达时间
				$result = findAddress($longitude,$latitude);
				if ( $result == 0 ) {  //无法确定地址的当做无用信息
					$query="insert into b736(chtime,nick,words,longitude,latitude)values(now(),'$nick','$message','$longitude','$latitude')";//插入SQL语句
					mysql_query($query,$link_ID); //发送留言到数据库
				} else {
					$query="select * from b736 where destination = '$result' order by chtime desc limit 1;" ; //查询字符串
					$res = mysql_query($query,$link_ID); 
					$u = true; //判断是否需更新班车到达时间
					if ( $res = mysql_fetch_array($res)) {
						$time1 = $res['chtime'];
						$time2 = time();
						$u = false;
						if ( $time2 - $time1 >= 10 * 60  ) { //超过十分钟认为是另一班车
							$u = true;
						}
					}
					if ( $u == false ) {
						$query="insert into b736(chtime,nick,words,longitude,latitude)values(now(),'$nick','$message','$longitude','$latitude')";//插入SQL语句
						mysql_query($query,$link_ID); //发送留言到数据库
					}	else {  //更新班车到达时间
						$query="insert into b736(chtime,nick,words,longitude,latitude,destination)values(now(),'$nick','$message','$longitude','$latitude','$result')";//插入SQL语句
						mysql_query($query,$link_ID); //发送留言到数据库
						//进行信息推送
						$url = 'http://localhost/test/index.php?nick=mengmeng&longitude=113.974&latitude=12.33&action=on';
						$http = file_get_contents($url);
					}
				}
			}
		}
		else {
			$query="insert into b736(chtime,nick,words,longitude,latitude)values(now(),'$nick','check','$longitude','$latitude')";//插入SQL语句
			mysql_query($query,$link_ID); //发送留言到数据库
		}
	} else if ( isset($_GET['action'])) {
			$message = $_GET['action'];
			//echo $message;
			$query="insert into b736(chtime,nick,words)values(now(),'$nick','$message')";//插入SQL语句
			mysql_query($query,$link_ID); //发送留言到数据库
	} else {
		$query="insert into b736(chtime,nick,words)values(now(),'$nick','check')";//插入SQL语句
		mysql_query($query,$link_ID); //发送留言到数据库
	}
}
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
<title>b736消息栏</title>
<style type="text/css">
showtable1
{
position:absolute;
top:5%;
left:25%;
}
</style>
<style type="text/css">
showlist1
{
position:absolute;
top:25%;
left:5%;
height:60%;
width:90%;
overflow-y:scroll;
}
</style>
<style type="text/css">
</style>
</head>
<body>
<div style="position:absolute; left:0; top:0; width:100%; height:100%">
<img src="bear.jpg" width=100% height=100%>
</div>
<div style="position:absolute; width:100%; height:100%">
<?php 
	//提取班车信息
	$sql1="select * from b736 where destination = 1 order by chtime desc limit 1";
	$result1=mysql_query($sql1,$link_ID);
	$sql2="select * from b736 where destination = 2 order by chtime desc limit 1";
	$result2=mysql_query($sql2,$link_ID);
?>
<showtable1>
  <div>上一班公交到达时间: </div>
  <div>北大园区:<?php if ( $result = mysql_fetch_array($result1)) echo $result['chtime']; else echo "无法确定" ?></div>
  <div>春园路口:<?php if ( $result = mysql_fetch_array($result2)) echo $result['chtime']; else echo "无法确定" ?></div>
</showtable1>
<showlist1>
  <div>目前其他人等车情况</div>
<?php 
	//最新20条发言显示在最下面
	$str="select * from b736 where words = 'on' or words = 'wait' order by id desc limit 20"; //查询字符串
 	$result=mysql_query($str,$link_ID); //送出查询
 	while($row=mysql_fetch_array($result)){
?>
    <div>昵称:
    <?php echo $row['nick']; ?>
    说:
	</div>
	<div>
    <?php echo wordchange($row['words']);?>
    [<?php echo sayAddress($row['longitude'],$row['latitude']);?>]
    [<?php echo $row['chtime'];?>]
	<div>
<?php } ?>
</showlist1>
</div>
</body>
</html>
<script language="JavaScript">
function scrollWindow(){   //定位滚动条
	this.scroll(0,75000);
	//setTimeout('scrollWindow()',200);
}
function myrefresh()
{
   window.location.replace(location.pathname);
}
setTimeout('myrefresh()',8000); //指定8秒刷新一次
//setTimeout('scrollWindow()',8000); //指定8秒跳转一次
</script>

