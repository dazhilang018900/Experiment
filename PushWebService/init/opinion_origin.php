
<!DOCTYPE html>
<html>
<head>




<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
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

</head>
<body>

<title>意见栏</title>

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





    <!-- 输出前20个意见 -->
    <div >
        <h1 style = "margin-left:35%;">校园信息栏</h1>
    </div>

    <div>
    <ul data-role="listview" data-icon="false">
    <?php while($row=mysql_fetch_array($result)){  ?>
    <li>
       <?php echo $row['hostId']  ?>说：
    </li>
    <li>
       <?php echo $row['opinion']  ?>
    </li>
    <?php } ?>    
    </ul>
    <div>
<form  id="opinionForm" method="post" action=<?php echo '"opinion.php?nick='.$_GET['nick'].'"' ?> >    
    <div>
       <input type="text" id="hostId" style="display:none">
    </div>
    <div>
        意见：<textarea id="opinion" name="opinion" rows="10" cols="20"></textarea>
    </div>
    <label style="display:none" class = "tishi" id = "tishi" >请将信息填完整</label>
    <input type="submit" value="提交" data-role = "button" onclick="return check();">
</form>  



</body>