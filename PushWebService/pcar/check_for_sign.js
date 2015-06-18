var xmlHttp

function checkSign(id,quest)//判断该用户是否已报名过这个活动
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request")
	  return
	} 
	var url="checkSign.php"
	url=url+"?id="+id
	url=url+"&quest="+quest
	xmlHttp.onreadystatechange=stateChanged 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
	return xmlHttp.onreadystatechange;
} 

function stateChanged() 
{ 
 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
	 //返回yes表示报名过，no表示没有报名过
	if ( xmlHttp.responseText == "yes" )
	{
		return false;
	}
	else return true;
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