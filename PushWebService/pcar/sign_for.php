<!DOCTYPE html>

<html>
<?php require_once('config.php'); ?>
<?php
	//根据当前用户的学号，往数据库里查找资料，如果有的话自动填上
	if ( isset($_GET['nick'])) {
		$host = $_GET['nick'];
		$sql1 = "select * from carshare_guest where userId = '$host'";
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
	<script src="check_for_sign.js"></script>

	
	
</head>

<body style="width:100%;margin:0 auto;">

<div id="newRecordList" class="showList">
<div class="questionnairebody">
<form class="signForm" id="signForm" method="post" action="add.php" >
           
    <div class="form-group inlineInfo" >
    <div>
        <table >
                <tr>
                   <td>
        <label class = "useid ">学号:</label>
                    </td>
                    <td>
        <input type="text" name="userid" id="linhc_useid" class="form-control host" value=<?php if (isset($host)) echo '"'.$host.'"'; else echo '""'; ?>>
                    </td>
                    </tr>
                    <tr>
                   <td>
        <label class = "phone">电话号码:</label>
                    </td>
                    <td>
        <input type="text" name="phone" id="linhc_phone" class="form-control phone" value=<?php if (isset($phone)) echo '"'.$phone.'"'; else echo '""'; ?>>
                    </td>
                    </tr>
                    <tr>
                   <td>
        <label class = "name">姓名:</label>
                    </td>
                    <td>
        <input type="text" name="name" id="linhc_name" class="form-control name" value=<?php if (isset($name)) echo '"'.$name.'"'; else echo '""'; ?>>
                    </td>
                    </tr>
        </table>    
        <input type="hidden" value="<?php echo $_GET['id']; ?>" name="activityid" id="activityid" class="form-control name">
        <label style="display:none" class = "tishi" id = "tishi" >请将信息填完整</label>
        <label style="display:none" class = "tishi1" id = "tishi1" >你已经报名过了</label>
        
    </div>
    <div>
        <input id="signBtn" class="btn btn-info btn-sm" type="submit" value="确认报名" onclick="return check();"/>
    </div>
</div>






</form>

</div>


</div>
	
	
<script language='javascript' type='text/javascript'>


var xmlHttp;
var f = false;
function checkSign(id,guest)//判断该用户是否已报名过这个活动
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request")
	  return
	} 
	var url="checkSign.php";
	url=url+"?id="+id;
	url=url+"&guest="+guest;
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);
} 

function stateChanged() 
{ 
 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
	 //返回yes表示报名过，no表示没有报名过
	if ( xmlHttp.responseText == "no" )
	{
		f = true;
	}
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

function checkSelf() //检查是否自己报自己
{
	var v = document.getElementById('linhc_useid').value;
//	alert(v);
//	alert($_GET['nick']);
	if ( v == $_GET['nick'] ) return false;
	else return true;
}

function check(){
    var u = true;
    var v = document.getElementById('linhc_useid').value;
    if(v == ''){
	u = false;
    }
    v = document.getElementById('linhc_phone').value;
    if(v == ''){
	u = false;
    }
    v = document.getElementById('linhc_name').value;
    if(v == ''){
	u = false;
    }
    if ( u == false ) {
		document.getElementById('tishi').style.display="block";
		document.getElementById('tishi1').style.display="none";	
		return false;
    	}  else {
		document.getElementById('tishi').style.display="none";
		v = document.getElementById('linhc_useid').value;
		q = $_GET['id'];
		checkSign(q,v);//看是否已报过
		if ( f == false )
		{
			document.getElementById('tishi1').style.display="block";
			return false;
		}
		if ( checkSelf())
			return true;
		else {
			document.getElementById('tishi1').style.display="block";
			return false;

		}
    }

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

<!-- /content --> 
</body>
</html>




