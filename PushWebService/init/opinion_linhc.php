<!DOCTYPE html>
<html>
<head>




<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
<title>意见栏</title>
<link rel="stylesheet"  href="static/jqm/jquery.mobile-1.3.2.min.css" /> 
<script src="static/jq/jquery-1.10.2.min.js"></script> 
<script src="static/jqm/jquery.mobile-1.3.2.min.js"></script>

<script language='javascript' type='text/javascript'>
    function check() { //检查是否填完整
        var v = document.getElementById('opinion').value;
        if ( v == "" ) {
            document.getElementById('tishi').style.display="block";
            return false;
        }
        return true;
    }
    function init() {  //初始化
        // alert($_GET['nick']);
        document.getElementById('hostId').value = $_GET['nick'];
        document.getElementById('opinion').value = "";
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
</script>

<script type="text/javascript">
$(document).ready(function(){
  init();
});
</script>

<style type="text/css">
    .feed_content {
    color: #8e8d8b;
    font-size: 18px;
}
   .title {
text-align: center;
font-size: 20px;
font-family: Microsoft YaHei;
}
</style>

</head>

<body style="width:100%;margin:0 auto;">



<?php 
    require_once('config1.php');  //注意，这里用了不同的数据库

    //判断是否登录，没登录自动调转登陆界面
    if (!isset($_GET['nick'])) {
                //跳转    
                $url = "login.php";
                echo "<script language='javascript' type='text/javascript'>";  
                echo "window.location.href='$url'";  
                echo "</script>";  

    }
    if ( isset($_POST['opinion'])) {
        $userid = $_GET['nick'];
        $opinion = $_POST['opinion'];
        $query="insert into opinion(hostId,opinion,chtime)values('$userid','$opinion',now())";//插入SQL语句
        mysql_query($query,$link_ID); //发送留言到数据库
    }

    //最新20条发言显示在最下面
    $str="select * from opinion order by id desc limit 20"; //查询字符串
    $result=mysql_query($str,$link_ID); //送出查询
?>

    <div data-role="header">
        <h1 class="title">校园信息栏</h1>
    </div>



    <!-- 输出前20个意见 -->
<!--     <div >
        <h1 style = "margin-left:35%;">校园信息栏</h1>
    </div> -->


    <ul data-role="listview">
    <?php while($row=mysql_fetch_array($result)){  ?>
    <li>
       <h2> <?php echo $row['hostId']  ?>说：</h2>    
       <div class="feed_content"> <?php echo $row['opinion']  ?> </div>
       <p class="feed_time"></p>
    </li>
    <?php } ?>    
    </ul>

<form  id="opinionForm" method="post" action=<?php echo '"opinion.php?nick='.$_GET['nick'].'"' ?> >    
    <div>
       <input type="text" id="hostId" style="display:none">
    </div>
    <div>
        <p style="font-size: 18px; text-align: center;">意见：</p>
        <textarea id="opinion" name="opinion" rows="10" cols="20"></textarea>
    </div>
    <label style="display:none" class = "tishi" id = "tishi" >请将信息填完整</label>
    <input type="submit" value="提交" data-role = "button" onclick="return check();">
</form>  



</body>

</html>