<?php 
    require_once('config.php');
//根据经纬度返回代号指定地方
//0——无法确定地址
//1——北大园区
//2——春园路口
function findAddress($longitude,$latitude) {   //根据输入经纬度找地址
    //调整不同gps间的误差
    $delta = 0.000;
    if ( $longitude == NULL || $latitude == NULL ) {
        return 0;
    } else if ( abs($longitude-113.974-$delta) <= 0.0015 ) {   
        return 1;
    } else if ( abs($longitude-113.979-$delta) <= 0.0015 ) {
        return 2;
//    } else if ( abs($longitude-113.976-$delta) <= 0.0015 ) {
//        return 3;
    } else {
        return 0;
    }
}
function countDays($a,$b){   //计算相差天数
 $a_dt=getdate($a);
 $b_dt=getdate($b);
 $a_new=mktime(12,0,0,$a_dt['mon'],$a_dt['mday'],$a_dt['year']);
 $b_new=mktime(12,0,0,$b_dt['mon'],$b_dt['mday'],$b_dt['year']);
 return round(abs($a_new-$b_new)/86400);
}

function showTime( $a ) {
    $b = strtotime($a);
    $c = countDays($b, strtotime(time()));
    if ( $c < 1 ) return date("H:i:s",$b);
    else return date('Y-m-d H:i:s',$b);
}


function sayAddress($longitude,$latitude) {   //根据输入经纬度找地址
    $result = findAddress($longitude,$latitude);
    if ( $result == 0 ) return "无法确定";
    else if ( $result == 1 ) return "北大园区";
    else if ( $result == 2 ) return "春园路口";
 //   else if ( $result == 3 ) return "a208";
    else return "无法确定";
}
function wordchange($word) {
    if ( $word == 'on' ) return "上车了";
    else if ( $word == 'wait' ) return "等车中";
    else return $word;
}
	//最新20条发言显示在最下面
	$str="select * from b736 where words = 'on' or words = 'wait' order by id desc limit 20"; //查询字符串
 	$result=mysql_query($str,$link_ID); //送出查询
 	while($row=mysql_fetch_array($result)){
?>
    <div>
    <?php echo $row['nick']; ?>
    说:
	</div>
	<div>
    <?php echo wordchange($row['words']);?>
    [<?php echo sayAddress($row['longitude'],$row['latitude']);?>]
    [<?php echo $row['chtime'];?>]
	</div>
<?php } ?>