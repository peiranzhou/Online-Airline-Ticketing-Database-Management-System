<?php
/**cookies注销页面*/
if(isset($_COOKIE['user_id'])&&isset($_COOKIE['t_no'])){
    //将各个cookie的到期时间设为过去的某个时间，使它们由系统删除，时间以秒为单位
    setcookie('t_no','',time()-3600);
	echo "<h2 style=text-align:center>Congratulations!<h2>";
	echo "<h2 style=text-align:center>Buying Insurance successed!<h2>";
	echo "<h2 style=text-align:center>You will go to show and withdraw insurance page in 1 second<h2>";
//	$home_url = 'insurance.php';
//	header('Location:'.$home_url);
	echo "<center><img src=img/flyMeAway.gif style=width:480px;height:400px;><center>";
	header("refresh:1;url=insurance.php");

}
//location首部使浏览器重定向到另一个页面

?>