<?php
//已登录页面，显示登录用户名




if(isset($_COOKIE['user_id'])){
    $user_id=$_COOKIE['user_id'];
    $servername = "cs4111.couswvsem0vf.us-east-1.rds.amazonaws.com";
    $username = "xl2523";
    $password = "databaseCS4111";
    $dbname = 'cs4111';
    $conn = mysql_connect($servername,$username,$password);
    mysql_select_db($dbname, $conn);

    //点击“Log Out”，则转到logOut.php页面进行cookie的注销

    echo 'You are Logged as '.$_COOKIE['user_id'].'<br/>';
    echo "&nbsp;<br>";
    $viplevel=test_vip($_COOKIE['user_id'],$conn);
    if($viplevel){
        echo "Welcome VIP:".$viplevel."<br>";
    }
    echo "<br>";
    echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="logOut.php"><input type="submit" style="width:90px;" value="Log Out '.$_COOKIE['user_id'].'" name="Regist"></a>';

      echo "&nbsp<br>"; echo "&nbsp<br>";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href=loged.php><input type=submit style=width:90px; color:black;font-size:13px; name=goBack value=back></a>";
      echo '<br>';
      echo '&nbsp<br>';
    echo "<center><font size=5>Welcome to ZPRLX Airplane Company</font></center>";

    echo "<style>table, th, td {border: 2px solid black;border-collapse: collapse;}</style>";
    //LINKS
    echo '<br>';
    echo '<br>';

if(isset($_POST["add"])){
        $sqlDeleteInsurace="INSERT INTO FEEDBACK (CREW_NO, P_ID, FE_GRADE, FE_MESSAGE) VALUES ('$_POST[hidden]','$user_id','$_POST[fe_grade]','$_POST[fe_message]')";
        mysql_query($sqlDeleteInsurace,$conn);
    }


$sql = "SELECT DISTINCT CREW_NO, T.F_NO, CREW_NAME FROM Ticket T, CABINCREW C WHERE C.F_NO=T.F_NO AND T.P_ID='$user_id'";
$result = mysql_query($sql,$conn);


echo "<font size=3 color=white>This is some text!</font>";
echo "<center><font size=4 color=black>Please Comment the Cabin Crew!</font></center><br>";
echo "<font size=5 color=white>This is some text!</font>";
//通过白色文字来将表格尽量垂直居中； 如果不在第一行输入<br>，则两个echo都会输出在同一行


echo "<font size=5 color=white>This is some text!</font>";
//通过白色文字来将表格尽量垂直居中； 如果不在第一行加入<br>，则两个echo都会输出到同一行

echo "<table border=1 align=center>
<tr>
<th>FLIGHT_NO</th>
<th>CREW_NAME</th>
<th>FE_GRADE</th>
<th>FE_MESSAGE</th>
<th></th>
</tr>";
//建立一个专门用于删除修改信息的表格
    while($row = mysql_fetch_array($result)) {
echo "<form action=passenger_feedback.php method=post>";
echo "<tr>";
echo "<td>" . $row['F_NO'] ." </td>";
echo "<td>" . $row['CREW_NAME'] ." </td>";

// echo "<td><input type=text name=fe_grade></td>";
echo "<td><select name=fe_grade style=width:100px;><option name=fe_grade value = A>A</option> <option name=fe_grade value = B>B</option> <option name=fe_grade value = C>C</option> <option name=fe_grade value = D>D</option></td>";
echo "</select>";

echo "<td><input type=text name=fe_message></td>";

echo "<td><input type=submit name=add value=Comment></td>";
echo "<input type=hidden name=hidden value=" . $row['CREW_NO'] . ">";
echo "</form>";
}
echo "</table>";






//Not loged
}else{
	echo 'Please login at first';
}

function test_vip($user_id,$conn){
     $sqlvip="SELECT * FROM VIP_PASSENGER WHERE P_ID='$user_id'";
     $vip=mysql_query($sqlvip,$conn);
     if(mysql_num_rows($vip) != 0){
        $row = mysql_fetch_array($vip);
        return $row["VP_LEVEL"];
     }else{
        return FALSE;
     }
}

/**在已登录页面中，可以利用用户的cookie如$_COOKIE['username']、
 * $_COOKIE['user_id']对数据库进行查询，可以做好多好多事情*/
?>
