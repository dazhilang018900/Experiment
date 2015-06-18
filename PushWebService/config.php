<?php
	ob_start();
//session_start();
//error_reporting(0); //容错语句
$link_ID=mysql_connect("localhost","root","1234");//链接Mysql服务器
mysql_select_db("android",$link_ID); //选择数据库
mysql_query("set names 'utf8'",$link_ID);//选择编码格式
date_default_timezone_set("Asia/Hong_Kong"); //设置发言时间格式
?>