<?php
/**cookies注销页面*/
if(isset($_COOKIE['user_id'])||isset($_COOKIE['m_id'])){
    //将各个cookie的到期时间设为过去的某个时间，使它们由系统删除，时间以秒为单位
    setcookie('user_id','',time()-3600);
    setcookie('f_no','',time()-3600);
    setcookie('date','',time()-3600);
    setcookie('t_no','',time()-3600);
    setcookie('m_id','',time()-3600);
}
//location首部使浏览器重定向到另一个页面
  echo "&nbsp;<br>";  echo "&nbsp;<br>";  echo "&nbsp;<br>";  echo "&nbsp;<br>";
	echo "<center><font size=5>Logging Out</font></center>";
	echo "<center><img src=img/loading_default_en.gif style=width:485px;height:215px;><center>";
	header("refresh:1;url=logIn.php");
?>
