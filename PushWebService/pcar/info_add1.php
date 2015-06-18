<html>

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
        
        <label class="date1">开始时间：</label>
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
        <label class="date2">结束时间：</label>
        <table data-mode="reflow">
                <tr>
                   <td>
        <input type="text" name="year2" id="updateyear2" class="form-control date2">
                   </td>
                   <td>   
        <label for="year2" class="inline date2">年</label>
                   </td>
                   <td>
        <input type="text" name="month2" id="updatemonth2" class="form-control date2">
                  </td>
                  <td>
        <label for="month2" class="inline date2">月</label>
                        </td>
                </tr>
                 <tr> <td>
        <input type="text" name="day2" id="updateday2" class="form-control date2">
                </td>
                <td>
        <label for="day2" class="inline date2" >日</label>
                </td>
                <td>
        <input type="text" name="hour2" id="updatehour2" class="form-control date2">
                </td>
                <td>
        <label for="hour2" class="inline date2">时</label>
                </td>
                <td>
        <input type="text" name="min2" id="updatemin2" class="form-control date2">
                </td>
                <td>
        <label for="min2" class="inline date2" >分</label>
                </table>
        <!-- <input type="text" name="min2" id="updatemin2" class="form-control date2"> -->
    </div>
    
    <!-- 时间控件修改 -->
    



    <div>
        <label class = "host">发起人(学号):</label>

        <input type="text" name="host" id="linhc_host" class="form-control host">
        
        <label class = "phone">电话号码:</label>

        <input type="text" name="phone" id="linhc_phone" class="form-control phone">

        <label class = "name">姓名:</label>

        <input type="text" name="name" id="linhc_name" class="form-control name">
        

        <label class = "theme">主题:</label>
        <input type="text" name="theme" id="linhc_theme" class="form-control theme">
        


        <label class = "content">备注信息:</label>
        <input type="text" name="content" id="linhc_content" class="form-control content">
        

        <label class = "start_place">出发地点:</label>
        <input type="text" name="start_place" id="linhc_start_place" class="form-control start_place">
        


        <label class = "end_place">终点:</label>
        <input type="text" name="end_place" id="linhc_end_place" class="form-control end_place">
        
    </div>
        <div class="form-group">
                <input type="submit" value="提交" name="submit" id='submit_button'>
    </div>

    </form>
</div>
</div>


	</div><!-- /content --> 
	<!-- message --> 

</body>
</html>