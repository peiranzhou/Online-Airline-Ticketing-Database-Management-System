<?php
/**cookies注销页面*/
if(isset($_COOKIE['user_id'])){
    //将各个cookie的到期时间设为过去的某个时间，使它们由系统删除，时间以秒为单位
	echo "<h2 style=text-align:center>Congratulations!<h2>";
	echo "<h2 style=text-align:center>Registion succeeded!<h2>";
	echo "<h2 style=text-align:center>You will log in in 2 seconds<h2>";
//	$home_url = 'loged.php';
//	header('Location:'.$home_url);
	echo "<center><img src=img/loading_default_en.gif style=width:485px;height:215px;><center>";
	header("refresh:2;url=loged.php");

}
//location首部使浏览器重定向到另一个页面

?>