<html>
<head>
<style>
a:link {
  text-decoration: none;
}
</style>
</head>
</html>

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
    echo 'You are logged as '.$_COOKIE['user_id'].'<br/><br>';
    $viplevel=test_vip($_COOKIE['user_id'],$conn);
    if($viplevel){
        echo "Welcome VIP: ".$viplevel."<br>";
    }
    //点击“Log Out”，则转到logOut.php页面进行cookie的注销

    echo "<br>";
    echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="logOut.php"><input type="submit" style="width:90px;" value="Log Out '.$_COOKIE['user_id'].'" name="Regist"></a>';

      echo "&nbsp<br>"; echo "&nbsp<br>";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href=loged.php><input type=submit style=width:90px; color:black;font-size:13px; name=goBack value=back></a>";
    echo "&nbsp;<br>";
    echo "&nbsp;<br>";
    echo "<h2><center>Welcome to ZPRLX Airplane Company</center></h2>";

    echo "<style>table, th, td {border: 2px solid black;border-collapse: collapse;}</style>";
    //LINKS
    echo '<br>';
    echo '<br>';

    if(isset($_POST["delete"])){
        $i_no=$_POST["hidden"];
        $sqlDeleteInsurace="DELETE FROM INSURANCE WHERE I_NO='$i_no'";
        mysql_query($sqlDeleteInsurace,$conn);
    }

//  Withdraw tickets, buy insurance;
$sql = "SELECT * FROM FLIGHT F, Ticket T , INSURANCE I
        WHERE F.F_NO=T.F_NO AND T.T_NO = I.T_NO AND T.P_ID='$user_id'";
$result = mysql_query($sql,$conn);

if (mysql_num_rows($result) > 0) {
    // output data of each row
   echo "<h4 style=text-align:center>All your insurance is presented in following table:</h4>";
   echo "<table align=center>

   <tr>
   <th>Flight Number</th>
   <th>Departure</th>
   <th>Destiny</th>
   <th>Date</th>
   <th>Departure Time</th>
   <th>Arrive Time</th>
   <th>Insurance Company</th>
   <th>Insurance Type</th>
   <th>Insurance Price</th>
   <th>Insurance Payback</th>
   <th>Withdraw Insurance</th>
   </tr>";

    while($row = mysql_fetch_array($result)) {
        echo "<form action=insurance.php method=post>";
        echo "<tr>";
        echo "<td align=center valign=middle>" . $row['F_NO'] ." </td>";
        echo "<td align=center valign=middle>" . $row["F_START"]."</td>";
        echo "<td align=center valign=middle>" . $row["F_DESTINY"]."</td>";
        echo "<td align=center valign=middle width=8%>" . $row["T_DATE"]."</td>";
        echo "<td align=center valign=middle>" . $row["F_DEPARTURETIME"]."</td>";
        echo "<td align=center valign=middle>" . $row["F_TIMEARR"]."</td>";
        echo "<td align=center valign=middle>" . $row["I_COPORATION"]."</td>";
        echo "<td align=center valign=middle>" . $row["I_TYPE"]."</td>";
        echo "<td align=center valign=middle>$" . $row["I_PRICE"]."</td>";
        echo "<td align=center valign=middle>$" . $row["I_PAYBACK"]."</td>";
        echo "<td align=center valign=middle><input type=submit name=delete value=WithdrawInsurance></td>";
        echo "<input type=hidden name=hidden value=" . $row["I_NO"] . " >";
        echo "</tr>";
        echo "</form>";
     }
    echo "</table>";

} else {
  echo "<br>";
  echo "You have not bought any insurance";
}



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
