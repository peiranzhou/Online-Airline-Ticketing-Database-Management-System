<?php
//已登录页面，显示登录用户名

if(isset($_COOKIE['m_id'])){
    $m_id=$_COOKIE['m_id'];
    $servername = "cs4111.couswvsem0vf.us-east-1.rds.amazonaws.com";
    $username = "xl2523";
    $password = "databaseCS4111";
    $dbname = 'cs4111';
    $conn = mysql_connect($servername,$username,$password);
    mysql_select_db($dbname, $conn);
    echo "&nbsp;<br>"; echo "&nbsp;<br>";
    echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="logOut.php"><input type="submit" style="width:90px;" value="Log Out '.$m_id.'" name="Regist"></a>';
    echo "&nbsp;<br>"; echo "&nbsp;<br>";
    echo "<center><font size=5>Welcome to ZPRLX Airplane Company</font></center>";
    echo "&nbsp;<br>";  echo "&nbsp;<br>"; echo "&nbsp;<br>";
    echo '<center>Welcome Back, Manager '.$m_id.' <br/></center>';
    echo "&nbsp;<br>";
}
/**在已登录页面中，可以利用用户的cookie如$_COOKIE['username']、
 * $_COOKIE['user_id']对数据库进行查询，可以做好多好多事情*/


echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br>';
echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br>';
echo '<center><a href="manager_flight.php" ><input type="submit" style="width:150px;" value="Flight Information" name="flightinfo"></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
              <a href="manager_cabincrew.php"><input type="submit" style="width:150px;" value="Cabin Crew Information" name="cabincrewinfo"></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
echo '<a href="manager_feedback.php"><input type="submit" style="width:150px;" value="Feedback Information" name="feedbackinfo"></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
              <a href="manager_passenger.php"><input type="submit" style="width:150px;" value="Passenger Information" name="passengerinfo"></a></center>';
echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br>'; echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br>';
echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br>'; echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br>';
echo '<center><a href="manager_insurance.php"><input type="submit" style="width:150px;" value="Insurance Information" name="insuranceinfo"></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
              <a href="manager_department.php"><input type="submit" style="width:150px;" value="Department Information" name="departmentinfo"></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
echo '<a href="manager_manage.php"><input type="submit" style="width:150px;" value="Manage Information" name="manageinfo"></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
              <a href="manager_ticket.php"><input type="submit" style="width:150px;" value="Ticket Information" name="ticketinfo"></a></center>';


echo "&nbsp;<br>"; echo "&nbsp;<br>"; echo "&nbsp;<br>";

echo '<center><a href=bigsearch.php><input type=submit style=width:150px; value="Search Everything" name=ticketinfo></a></center>';

?>
<html>
<body background="img/Columbia University.JPG">
</body>
</html>
