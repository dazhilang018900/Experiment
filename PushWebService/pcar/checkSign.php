<?php
	require_once('config.php');
	$id = $_GET['id'];
	$guest = $_GET['guest'];
	$sql1 = "select * from carshare_activity_guest where activity_id = '$id' and guest_id = '$guest'";
	$result1 = mysql_query($sql1,$link_ID);
	if ( mysql_num_rows($result1) != 0 ) {
		echo 'yes';
	}
	else echo 'no';
?>