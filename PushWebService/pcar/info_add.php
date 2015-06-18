<!DOCTYPE html>
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

    <link rel="stylesheet"  href="static/jqm/jquery.mobile-1.3.2.min.css" /> 
    <script src="static/jq/jquery-1.10.2.min.js"></script> 
    <script src="static/jqm/jquery.mobile-1.3.2.min.js"></script>

</head>



<body style="width:100%;margin:0 auto;">
	<div data-role="page" id="page" data-theme = "none"> <!--data-theme = "a"-->
    <link rel="stylesheet" type="text/css" href="static/css/info.css">
	<!-- 考虑到时侯引入漂亮的背景图片  -->
	<!--<div id = "blurBg"><img src = "static/img/background.jpg" ></div> -->
	<div><!--  data-role="content" -->

	<div id="newRecordList" class="showList">
	<div class="questionnairebody">
	<form class="updateForm" action="formTo.php" method="POST"  >
        <!-- csrf_token -->
        <div class="form-group inlineInfo" data-role="fieldcontain">
        
        <label class="date1">出发时间：</label>
        <table data-mode="reflow">
                <tr>
                   <td>
        <input type="text" name="year1" id="updateyear1" class="form-control date1">
                   </td>
                   <td>
        <label for="year1" class="inline date1">年</label>  
                   </td>
                   <td>
        <input type="text" name="month1" id="updatemonth1" class="form-control date1">
                  </td>
                  <td>
        <label for="month1" class="inline date1">月</label>
                </td>
                </tr>
        <!-- </table>
        <table data-mode="reflow"> -->
                <tr> <td>
        <input type="text" name="day1" id="updateday1" class="form-control date1">
                </td>
                <td>
        <label for="day1" class="inline date1" >日</label>
                 </td>
                  <td>
        <input type="text" name="hour1" id="updatehour1" class="form-control date1">
                </td>
                <td>
        <label for="hour1" class="inline date1">时</label>
                </td>
                 <td>
        <input type="text" name="min1" id="updatemin1" class="form-control date1">
                </td>
                <td>
        <label for="min1" class="inline date1" >分</label>
                </td></tr>
        </table>
    </div>
    
    <!-- 时间控件修改 -->
    



    <div>
        <label class = "end_place">终点:</label>
        <input type="text" name="end_place" id="linhc_end_place" class="form-control end_place">


        <label class = "start_place">出发地点:</label>
        <input type="text" name="start_place" id="linhc_start_place" class="form-control start_place">
        

        <label class = "host">发起人(学号):</label>

        <input type="text" name="host" id="linhc_host" class="form-control host" value=<?php if (isset($host)) echo '"'.$host.'"'; else echo '""'; ?>>
        
        <label class = "phone">电话号码:</label>

        <input type="text" name="phone" id="linhc_phone" class="form-control phone" value=<?php if (isset($phone)) echo '"'.$phone.'"'; else echo '""'; ?>>

        <label class = "name">姓名:</label>

        <input type="text" name="name" id="linhc_name" class="form-control name" value=<?php if (isset($name)) echo '"'.$name.'"'; else echo '""'; ?>>
        

        


        <label class = "content">备注信息:</label>
        <input type="text" name="content" id="linhc_content" class="form-control content">
        
        <label style="display:none" class = "tishi" id = "tishi" >请将信息填完整</label>

        
    </div>
        <div class="form-group">
                <input type="submit" value="提交" name="submit" id='submit_button' onclick="return wcheck();">
    </div>

    </form>
</div>
</div>


	</div><!-- /content --> 
	<!-- message --> 
<script language='javascript' type='text/javascript'>
function wcheck(){
    var u = true;
    var v = document.getElementById('updateyear1').value;
    if( v == '' ){
        u = false;
    }
    v = document.getElementById('updatemonth1').value;
    if( v == '' ){
        u = false;
    }
    v = document.getElementById('updateday1').value;
    if( v == '' ){
        u = false;
    }
    v = document.getElementById('updatemin1').value;
    if( v == '' ){
        u = false;
    }

    v = document.getElementById('updatehour1').value;
    if( v == '' ){
        u = false;
    }

    v = document.getElementById('linhc_end_place').value;
    if( v == '' ){
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


    if ( u == false ) {
        document.getElementById('tishi').style.display="block";
        return false;
    }  else {
        return true;
    }
    return true
}

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
