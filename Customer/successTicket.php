<?php
/**cookies注销页面*/
if(isset($_COOKIE['user_id'])&&isset($_COOKIE['f_no'])&&isset($_COOKIE['date'])){
    //将各个cookie的到期时间设为过去的某个时间，使它们由系统删除，时间以秒为单位
    setcookie('f_no','',time()-3600);
    setcookie('date','',time()-3600);
	echo "<h2 style=text-align:center>Congratulations!<h2>";
	echo "<h2 style=text-align:center>Booking successed!<h2>";
	echo "<h2 style=text-align:center>You will go back to homepage in 1 second<h2>";
//	$home_url = 'loged.php';
//	header('Location:'.$home_url);
	echo "<center><img src=img/flyMeAway.gif style=width:480px;height:400px;><center>";
	header("refresh:1;url=loged.php");

}
//location首部使浏览器重定向到另一个页面

?>