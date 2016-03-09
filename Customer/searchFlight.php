<?php
// define variables and set to empty values
$departure=$destiny="";
$date="";

$servername = "cs4111.couswvsem0vf.us-east-1.rds.amazonaws.com";
$username = "xl2523";
$password = "databaseCS4111";
$dbname = 'cs4111';

// Create connection
$conn = mysql_connect($servername,$username,$password);

mysql_select_db($dbname, $conn);

if (!$conn) {
    die("Connection failed: " . mysql_connect_error());
}

if(isset($_COOKIE['user_id'])){

    echo "<a href=loged.php><input type=submit style=width:100px;background-color:LightSkyBlue;color:white;font-size:13px; name=goBack value=back></a>";
    echo "&nbsp;"; echo "&nbsp;<br>"; echo "&nbsp;<br>";
    echo '<center><font size=5>Welcome to ZPRLX Airplane Company</font></center>';
    echo '&nbsp;<br>'; echo '&nbsp;<br>';
    echo '<center>Welcome Back, Dear '.$_COOKIE['user_id'].' ! <br/></center>';
    $viplevel=test_vip($_COOKIE['user_id'],$conn);
    if($viplevel){
    echo "&nbsp;&nbsp;";
    echo "<center>Welcome VIP:".$viplevel."<br></center>";
    }
}
echo '<br>';


if (isset($_POST['search'])){
   $departure = test_input($_POST["departure"]);
   $destiny = test_input($_POST["destiny"]);
   $date = $_POST["date"];
   setcookie("date",$date);
}


function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
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

?>

<html>
<head>
<style>
table, th, td {
    border: 3px solid black;
    border-collapse: collapse;
}
</style>
</head>
<body>
<p><font size=4><center>Search flight</center></font></p>
<p><i><font size=3><center>Please input the departure and destiny of flight</center></font></i></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
   <center>Departure: &nbsp; <input type="text" name="departure"></center>
   <br>
   <center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Destiny:&nbsp&nbsp&nbsp<input type="text" name="destiny"></center>
   <br>
   <center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp&nbsp&nbsp;<input type="date" name="date"></center>
   <br>
   <center><input type="submit" name="search" value="search"></center>
</form>
</body>
</html>

<?php
if($destiny==""||$departure==""||$date==""){
}else{
echo "<center><font size=3>Result:</font></center>";
echo "<br>";
// echo "Departure: $departure ";
// echo "<br>";
// echo "&nbsp&nbsp&nbspDestiny:&nbsp&nbsp&nbsp$destiny";
// echo "<br>";
echo "<center>Date: $date</center>"; echo "<br>";



// Check connection

if(isset($_POST['search'])){
  $sql = "SELECT * FROM FLIGHT WHERE F_START LIKE '%$departure%' AND F_DESTINY LIKE '%$destiny%'";

  $result = mysql_query( $sql,$conn);

if (mysql_num_rows($result) > 0) {
    // output data of each row

   echo "<table align=center>
   <center><tr>
   <th>Flight Number</th>
   <th>Departure</th>
   <th>Destiny</th>
   <th>Departure Time</th>
   <th>Arrive Time</th>
   <th>Company</th>
   <th>Booking</th>
   </tr></center>";

    while($row = mysql_fetch_array($result)) {
        echo "<form action=searchFlight.php method=post>";
        echo "<tr>";
        echo "<td>" . $row['F_NO'] ." </td>";
        echo "<td>" . $row["F_START"]."</td>";
        echo "<td>" . $row["F_DESTINY"]."</td>";
        echo "<td>" . $row["F_DEPARTURETIME"]."</td>";
        echo "<td>" . $row["F_TIMEARR"]."</td>";
        echo "<td>" . $row["F_COMPANY"]."</td>";
        echo "<td><input type=submit name=add value=Booking></td>";
        echo "<input type=hidden name=hidden value=" . $row["F_NO"] . " >";
        echo "</tr>";
        echo "</form>";
     }
    echo "</table>";

} else {
  echo "<br>";
  echo "0 results";
}
}
}
if(isset($_POST['add'])){
  setcookie("f_no",$_POST["hidden"]);
  $home_url = 'booking.php';
  header('Location:'.$home_url);
}
echo "&nbsp;<br>";  echo "&nbsp;<br>";  echo "&nbsp;<br>";
if(isset($_COOKIE['user_id'])){
echo '<center><a href="logOut.php"><input type="submit" style="width:90px;" value="Log Out '.$_COOKIE['user_id'].'" name="Regist"></a></center>';
}
mysql_close($conn);

?>
