<?php require_once('config.php'); ?>
<?php
	
//根据经纬度返回代号指定地方
//0——无法确定地址
//1——北大园区
//2——春园路口
function findAddress($longitude,$latitude) {   //根据输入经纬度找地址
	//调整不同gps间的误差
	$delta = 0.000;
	if ( $longitude == NULL || $latitude == NULL ) {
		return 0;
	} else if ( abs($longitude-113.974-$delta) <= 0.0015 ) {   
		return 1;
	} else if ( abs($longitude-113.979-$delta) <= 0.0015 ) {
		return 2;
	} else if ( abs($longitude-113.976-$delta) <= 0.0015 ) {
		return 3;
	} else {
		return 0;
	}
}
function countDays($a,$b){   //计算相差天数
 $a_dt=getdate($a);
 $b_dt=getdate($b);
 $a_new=mktime(12,0,0,$a_dt['mon'],$a_dt['mday'],$a_dt['year']);
 $b_new=mktime(12,0,0,$b_dt['mon'],$b_dt['mday'],$b_dt['year']);
 return round(abs($a_new-$b_new)/86400);
}

function showTime( $a ) {
	$b = strtotime($a);
	$c = countDays($b, strtotime(time()));
	if ( $c < 1 ) return date("H:i:s",$b);
	else return date('Y-m-d H:i:s',$b);
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
						$title = base64_encode(sayAddress($longitude,$latitude));
						$t = time();
						$message= base64_encode("有人上车了，时间是".date("H:i:s",$t));
						$url = 'http://219.223.222.231:8080/androidpn/notification.do?action=appPush&title='.$title.'&message='.$message.'&uri=xxx&appName=b736';
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

<!DOCTYPE html>
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
left:10%;
font-size:20px;
}
</style>
<style type="text/css">
showlist1
{
position:absolute;
top:30%;
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
<div style = "display:block;position:absolute; top:0; left:0;z-index:1;">
<!-- <button style="float:left;" onclick="getloc1()">已上车</button> -->
<!-- <button style="float:right;" onclick="getloc2()">在等车</button> -->
</div>
<div style="position:absolute; top:0; left:0;width:100%; height:100%;z-index:-1;opacity:0.5;">
<img src="static/img/background.jpg" width=100% height=100% style="z-index:-99;">
</div>
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
  <div>北大园区:<?php if ( $result = mysql_fetch_array($result1)) echo showTime($result['chtime']); else echo "无法确定" ?></div>
  <div>春园路口:<?php if ( $result = mysql_fetch_array($result2)) echo showTime($result['chtime']); else echo "无法确定" ?></div>
</showtable1>
<showlist1>
<!--<input name="msgButton" type="button" id="msgButton" value="展开其他人分享消息" onClick="showMessage();"/>-->
<button id="msgButton"  onclick="showMessage();">展开其他人分享消息</button>
<div id="msg" >
</div>
</showlist1>
</div>
</body>
</html>
<script language="JavaScript">
function getloc1(){
        if (navigator.geolocation) {
            var options = {
                enableHighAccuracy: true,
            };            
            navigator.geolocation.getCurrentPosition(handleSuccess1, handleError1, options);
        } else {
            alert("1");
        }
        }
function handleSuccess1(position){
    // 获取到当前位置经纬度  本例中是chrome浏览器取到的是google地图中的经纬度
    var lng = position.coords.longitude;
    var lat = position.coords.latitude;
	url = "&longitude=" + lng + "&latitude=" + lat + "&action=on";
	window.location.replace(location.href+url);
    // 调用百度地图api显示
}

function handleError1(error){
    var code = error.code;
    switch(code){
        case 1:
        alert("没有权限");
        break;
        case 2:
        alert("无法确定位置");
        break;
        case 3:
        alert("超时");
    }              
}



function getloc2(){
        if (navigator.geolocation) {
            var options = {
                enableHighAccuracy: true,
            };            
            navigator.geolocation.getCurrentPosition(handleSuccess2, handleError2, options);
        } else {
            alert("1");
        }
        }
function handleSuccess2(position){
    // 获取到当前位置经纬度  本例中是chrome浏览器取到的是google地图中的经纬度
    var lng = position.coords.longitude;
    var lat = position.coords.latitude;
	url = "&longitude=" + lng + "&latitude" + lat + "&action=wait";
	window.location.replace(location.href+url);
    // 调用百度地图api显示
}

function handleError2(error){
    var code = error.code;
    switch(code){
        case 1:
        alert("没有权限");
        break;
        case 2:
        alert("无法确定位置");
        break;
        case 3:
        alert("超时");
    }              
}


/*function scrollWindow(){   //定位滚动条
	this.scroll(0,75000);
	//setTimeout('scrollWindow()',200);
}*/

function msgBoard(){
	// value="打开"
	var value = document.getElementById('msgButton').value;
	// alert(value);
	if(value == "展开其他人分享消息"){
		document.getElementById('msgButton').value = "隐藏其他人分享消息";
	}else{
		document.getElementById('msgButton').value = "展开其他人分享消息";
		document.getElementById('msg').innerHTML = "";
		return;
	}
	xmlHttp=GetXmlHttpObject();
	   if (xmlHttp==null)
	  {
	    alert ("Browser does not support HTTP Request")
	    return
	  } 
	  var url="message.php";
	  xmlHttp.onreadystatechange=stateChanged;
	  xmlHttp.open("GET",url,true);
	  xmlHttp.send(null);

}
function myrefresh()
{
   window.location.replace(location.pathname+'?nick='+$_GET['nick']);
}
function msgRefresh()
{
	if ( msgButton == true )
		showMessage();
}
var $_GET = (function(){
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if(typeof(u[1]) == "string"){
        u = u[1].split("&");
        var get = {};
        for(var i in u){
            var j = u[i].split("=");
            get[j[0]] = j[1];
        }
        return get;
    } else {
        return {};
    }
})();


function showMessage( )//异步输出信息
{
	if ( msgButton == false )
		msgButton = true;
	else msgButton = false;
	if ( msgButton == true ) {
		document.getElementById('msgButton').innerHTML = "隐藏其他人分享消息";
	}else {
		document.getElementById('msgButton').innerHTML = "展开其他人分享消息";
		document.getElementById('msg').innerHTML = "";
		return;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request")
	  return
	} 
	var url="message.php";
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function stateChanged() 
{ 
 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
	 //显示返回内容
	 var msg = xmlHttp.responseText;
	 document.getElementById('msg').innerHTML = msg;

 }
}

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp=new XMLHttpRequest();
	 }
	catch (e)
	 {
	 // Internet Explorer
	 try
	 {
	  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
	 }
	 catch (e)
     {
	  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
	 }
	 }
	return xmlHttp;
}

var msgButton = false;//控制是否展示消息按钮
setTimeout('msgRefresh()',10000); //指定10秒刷新一次
//setTimeout('myrefresh()',10000); //指定10秒刷新一次
//setTimeout('scrollWindow()',8000); //指定8秒跳转一次
</script>

