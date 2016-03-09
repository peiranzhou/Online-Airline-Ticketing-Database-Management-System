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
    echo "&nbsp;<br>";  echo "&nbsp;<br>";  echo "&nbsp;<br>";
    echo "<center><font size=5>Welcome to ZPRLX Airplane Company</font></center>";
    echo "&nbsp;<br>";  echo "&nbsp;<br>";
    echo '<center>Welcome Back, Dear '.$_COOKIE['user_id'].' !<br/></center>';
    echo "&nbsp;<br>";
    $viplevel=test_vip($_COOKIE['user_id'],$conn);
    if($viplevel){
        echo "<center>Welcome VIP: ".$viplevel."<br></center>";
    }
    //点击“Log Out”，则转到logOut.php页面进行cookie的注销

    echo "<style>table, th, td {border: 2px solid black; border-collapse: collapse;}</style>";
    //LINKS
    echo '<br>';
    echo '<br>';
    echo '<center>';
    echo '<a href="searchFlight.php"><input type="submit" style="width:120px;" value="Buy Tickets" name="BuyTickets"></a>';
    echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
    echo '<a href="changevip.php"><input type="submit" style="width:140px;" value="VIP_MEMBERSHIP" name="withdraw_insurance"></a>';
    echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
    echo '<a href="insurance.php"><input type="submit" style="width:130px;" value="INSURANCE" name="withdraw_insurance"></a>';
    echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
    echo '<a href="changeinfo.php"><input type="submit" style="width:140px;" value="RENEW INFORMATION" name="RENEWINFO"></a>';
    echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
    echo '<a href="passenger_feedback.php"><input type="submit" style="width:120px;" value="Rating Crew" name="RatingCrew"></a>';

    echo '</center>';
    echo '<br><br>';

    if(isset($_POST["delete"])){
        $t_no=$_POST["hidden"];
        $sqlDeleteTicket="DELETE FROM Ticket WHERE T_NO='$t_no'";
        mysql_query($sqlDeleteTicket,$conn);
    }

    if(isset($_POST["insurance"])){
        setcookie('t_no',$_POST["hidden"]);
        $home_url = 'buyinsurance.php';
        header('Location: '.$home_url);
    }
  echo "<h4 style=text-align:center>All your booking is presented in following table:</h4>";

//  Withdraw tickets, buy insurance;
$sql = "SELECT * FROM FLIGHT F, Ticket T WHERE F.F_NO=T.F_NO AND T.P_ID='$user_id'";
$result = mysql_query($sql,$conn);

if (mysql_num_rows($result) > 0) {
    // output data of each row

   echo "<table align=center>
   <tr>
   <th>Flight Number</th>
   <th>Departure</th>
   <th>Destiny</th>
   <th>Date</th>
   <th>Departure Time</th>
   <th>Arrive Time</th>
   <th>Gate</th>
   <th>Seat Position</th>
   <th>Seat Class</th>
   <th>Price</th>
   <th>Company</th>
   <th>Withdraw</th>
   <th>Buy Insurance</th>
   </tr>";

    while($row = mysql_fetch_array($result)) {
        echo "<form action=loged.php method=post>";
        echo "<tr>";
        echo "<td align=center valing=middle width=10%>" . $row['F_NO'] ." </td>";
        echo "<td align=center valign=middle width=8%>" . $row["F_START"]."</td>";
        echo "<td align=center valign=middle width=6%>" . $row["F_DESTINY"]."</td>";
        echo "<td align=center valign=middle width=8%>" . $row["T_DATE"]."</td>";
        echo "<td align=center valign=middle width=12%>" . $row["F_DEPARTURETIME"]."</td>";
        echo "<td align=center valign=middle width=9%>" . $row["F_TIMEARR"]."</td>";
        echo "<td align=center valign=middle width=4%>" . $row["T_GATE"]."</td>";
        echo "<td align=center valign=middle width=9%>" . $row["T_SEAT"]."</td>";
        echo "<td align=center valign=middle width=7%>" . $row["T_CLASS"]."</td>";
        echo "<td align=center valign=middle width=6%>$" . $row["T_PRICE"]."</td>";
        echo "<td align=center valign=middle width=6%>" . $row["F_COMPANY"]."</td>";
        echo "<td align=center valign=middle width=7%><input type=submit name=delete value=Withdraw></td>";
        echo "<td align=center valign=middle><input type=submit name=insurance value=BuyInsurance></td>";
        echo "<input type=hidden name=hidden value=" . $row["T_NO"] . " >";
        echo "</tr>";
        echo "</form>";
     }
    echo "</table>";


} else {
  echo "<br>";
  echo "You have not bought any tickets";
}



//Not loged
}else{
	echo 'Please login at first';
}
echo '&nbsp;<br>';
echo '&nbsp;<br>';
echo '&nbsp;<br>';
echo '<center><a href="logOut.php"><input type="submit" style="width:90px;" value="Log Out '.$_COOKIE['user_id'].'" name="Regist"></a></center>';

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

<html>
<body background="img/Columbia University.JPG">
</body>
</html>
