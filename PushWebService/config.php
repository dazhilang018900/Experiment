<?php
	ob_start();
//session_start();
//error_reporting(0); //�ݴ����
$link_ID=mysql_connect("localhost","root","1234");//����Mysql������
mysql_select_db("android",$link_ID); //ѡ�����ݿ�
mysql_query("set names 'utf8'",$link_ID);//ѡ������ʽ
date_default_timezone_set("Asia/Hong_Kong"); //���÷���ʱ���ʽ
?>