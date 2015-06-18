<html>
<?php require_once('config.php'); ?>
<?php
	//根据当前用户的学号，往数据库里查找资料，如果有的话自动填上
	if ( isset($_GET['nick'])) {
		$host = $_GET['nick'];
		$sql1 = "select * from carshare_host where userId = '$host'";
		$result1 = mysql_query($sql1,$link_ID);
		if ( mysql_num_rows($result1) != 0 ) {
			$row= mysql_fetch_array($result1);
			$name = $row['userName'];
			$phone = $row['phone'];
		}
	}
?>
<head>
	<meta http-equiv="Content-Type" charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=0" />
	<title>添加拼车信息</title>
<script language='javascript' type='text/javascript'>
    
function check(){
    var u = true;
    var v = document.getElementById('updateyear1').value;
    if( v == '' ){
        u = false;
    }

    v = document.getElementById('updatemonth1').value;
    if( v == '' ){
        u = false;
    }

    alert("11");

    v = document.getElementById('updateday1').value;
    if( v == '' ){
        u = false;
    }
    alert("11");
    v = document.getElementById('min1').value;
    if( v == '' ){
        u = false;
    }

    v = document.getElementById('hour1').value;
    if( v == '' ){
        u = false;
    }
    alert("11");

    v = document.getElementById('linhc_end_place').value;
    if( v == '' ){
        alert("11");
        u = false;
    }

    v = document.getElementById('linhc_start_place').value;
    if( v == '' ){
        u = false;
    }

    v = document.getElementById('linhc_host').value;
    if( v == '' ){
        u = false;
    }

    v = document.getElementById('linhc_name').value;
    if( v == '' ){
        u = false;
    }

    v = document.getElementById('linhc_phone').value;
    if( v == '' ){
        u = false;
    }

    alert("11");

    if ( u == false ) {
        document.getElementById('tishi').style.display="block";
        return false;
    }  else {
        return false;
    }
    return false;
}
</script>

</head>



<body style="width:100%;margin:0 auto;">

	<form class="updateForm" action="formTo.php" method="POST"  onSubmit="return check()">
        <!-- csrf_token -->
    出发时间：<input type="text" name="year1" id="updateyear1" >
    年<input type="text" name="month1" id="updatemonth1" class="form-control date1">
    月  <input type="text" name="day1" id="updateday1" class="form-control date1">
    日 <input type="text" name="hour1" id="updatehour1" class="form-control date1">
    时 <input type="text" name="min1" id="updatemin1" class="form-control date1">
    终点:<input type="text" name="end_place" id="linhc_end_place" class="form-control end_place">
    出发地点:<input type="text" name="start_place" id="linhc_start_place" class="form-control start_place">
    发起人(学号):<input type="text" name="host" id="linhc_host" class="form-control host" value=<?php if (isset($host)) echo '"'.$host.'"'; else echo '""'; ?>>
    电话号码:<input type="text" name="phone" id="linhc_phone" class="form-control phone" value=<?php if (isset($phone)) echo '"'.$phone.'"'; else echo '""'; ?>>
    姓名:<input type="text" name="name" id="linhc_name" class="form-control name" value=<?php if (isset($name)) echo '"'.$name.'"'; else echo '""'; ?>>
    备注信息:<input type="text" name="content" id="linhc_content" class="form-control content">
    <label style="display:none" class = "tishi" id = "tishi" >请将信息填完整</label>
    <input type="submit" value="提交" name="submit" id='submit_button' >
    </form>


	</div><!-- /content --> 
	<!-- message --> 
<script language='javascript' type='text/javascript'>

function setTime()
{
    var myDate = new Date();
    var mytime = myDate.toLocaleTimeString();     //获取当前时间
    myDate.toLocaleString( );        //获取日期与时间
    document.getElementById("updateyear1").value = myDate.getFullYear();    //获取完整的年份(4位,1970-????)
    document.getElementById("updatemonth1").value = myDate.getMonth()+1;    //获取月份
    document.getElementById("updateday1").value = myDate.getDate();    //获取天
    document.getElementById("updatehour1").value = myDate.getHours();       //获取当前小时数(0-23)
    document.getElementById("updatemin1").value = myDate.getMinutes();     //获取当前分钟数(0-59)
    document.getElementById("linhc_end_place").value = "";   //设置出发地点

    //document.getElementById("updateyear2").value = myDate.getFullYear();    //获取完整的年份(4位,1970-????)
    //document.getElementById("updatemonth2").value = myDate.getMonth()+1;    //获取月份
    //document.getElementById("updateday2").value = myDate.getDate();    //获取天
    //document.getElementById("updatehour2").value = myDate.getHours();       //获取当前小时数(0-23)
    //document.getElementById("updatemin2").value = myDate.getMinutes();     //获取当前分钟数(0-59)

    document.getElementById("linhc_start_place").value = "北大宿舍楼";   //设置出发地点
    document.getElementById("linhc_content").value = "暂无信息";   

}


setTime();
</script>
</body>
</html>
