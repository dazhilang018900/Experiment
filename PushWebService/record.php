<?php
		require_once('config.php');
		$nameOrin = 1401212743;
		for ( $i = 0; $i <= 1000; $i++ ) {
			$name = $nameOrin+$i;
			$password = md5($name);
			$username = $name;
			$email = $name."@sz.pku.edu.cn";
			$query="insert into apn_user(name,password,username,email)values('$name','$password','$username','$email')";//插入SQL语句
			mysql_query($query,$link_ID); //发送留言到数据库
		}
?>