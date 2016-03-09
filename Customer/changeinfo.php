<?php

$nameErr = $genderErr = $telErr = "";
$name = $user_id = $gender = $tel = "";
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

if(isset($_COOKIE['user_id'])){

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
  $user_id=$_COOKIE['user_id'];

  echo 'You are Logged as '.$_COOKIE['user_id'].'<br/>';
  echo "&nbsp<br>";
  $viplevel=test_vip($user_id,$conn);
  if($viplevel){
    echo "Welcome VIP: ".$viplevel."<br>";
  }

  echo "<br>";
  echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="logOut.php"><input type="submit" style="width:90px;" value="Log Out '.$_COOKIE['user_id'].'" name="Regist"></a>';

  echo "&nbsp<br>"; echo "&nbsp<br>";
  echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href=loged.php><input type=submit style=width:90px; color:black;font-size:13px; name=goBack value=back></a>";
  echo '<br>';
  echo '&nbsp<br>';

	echo '<center><font size=5>Revise Customer Information</font></center>';

  echo "<style>table, th, td {border: 2px solid black;border-collapse: collapse;}</style>";
// define variables and set to empty values




if ($_SERVER["REQUEST_METHOD"] == "POST") {

   if (empty($_POST["name"])) {
     $nameErr = "Name is required";
   } else {
     $name = test_input($_POST["name"]);
   }
   $regex = '/^\d*$/';
   if (empty($_POST["tel"])) {
     $telErr = "Telephone number is required";
   } elseif((strlen($_POST["tel"])!=10)||!preg_match($regex, $_POST["tel"])) {
     $telErr = "Telephone number is not valid. Please input 10 digitals.";
   } else {
     $tel = test_input($_POST["tel"]);
   }
   if (empty($_POST["gender"])) {
     $genderErr = "Gender is required";
   } else {
     $gender = test_input($_POST["gender"]);
   }
   if($nameErr==""&&$genderErr==""&&$telErr==""){
        $sqlupdate="UPDATE Passenger SET P_name = '$name' WHERE P_ID = '$user_id'";
        mysql_query($sqlupdate,$conn);
        $sqlupdate="UPDATE Passenger SET P_Gender = '$gender' WHERE P_ID = '$user_id'";
        mysql_query($sqlupdate,$conn);
        $sqlupdate="UPDATE Passenger SET P_Tel = '$tel' WHERE P_ID = '$user_id'";
        mysql_query($sqlupdate,$conn);
        echo "&nbsp&nbspRevise succeeded!";
//        $home_url = 'success.php';
//        header('Location: '.$home_url);
   }

   if(isset($_POST["close"])){
        $sqldelete="DELETE FROM Passenger WHERE P_ID='$user_id'";
        mysql_query($sqldelete,$conn);
        $home_url = 'logOut.php';
        header('Location: '.$home_url);
   }

}

$sqluser = "SELECT * FROM Passenger WHERE P_ID='$user_id'";
$user = mysql_query( $sqluser,$conn);
if (mysql_num_rows($user) > 0) {
    // output data of each row
   echo "<br><br>";
   echo "<center>Current Uesr Information</center>";
   echo "&nbsp<br>";
   echo "<table align=center>
   <tr>
   <th>User ID</th>
   <th>Name</th>
   <th>Gender</th>
   <th>Tel</th>
   </tr>";

    while($row = mysql_fetch_array($user)) {
        echo "<td>" . $row['P_ID'] ." </td>";
        echo "<td>" . $row["P_name"]."</td>";
        $name=$row["P_name"];
        echo "<td>" . $row["P_Gender"]."</td>";
        $gender=$row["P_Gender"];
        echo "<td>" . $row["P_Tel"]."</td>";
        $tel=$row["P_Tel"];
     }
    echo "</table>";
}


    echo "<center><title>Welcome New Customer</title></center>";
    echo "<style>.error {color: #FF0000;}</style>";
   echo "<center><p><i><span class=error>*required field</span></i></p></center>";
    echo '<center>User ID:&nbsp&nbsp&nbsp&nbsp'.$_COOKIE['user_id'].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br><br></center>';
   echo "<form method=post action=changeinfo.php>";
   echo "<center>Name:&nbsp&nbsp&nbsp <input type=text name=name value=".$name.">";
   echo "<span class=error> *".$nameErr."</span></center>";
   echo "&nbsp<br>";
   echo "<center>&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTel:&nbsp&nbsp&nbsp&nbsp<input type=text name=tel value=".$tel.">";
   echo "<span class=error> *".$telErr."</span></center>";
   echo "<br><br>";
   echo "<center>Gender:&nbsp&nbsp&nbsp";
//   echo "<input type=radio name=gender value=Female>Female";
//   echo "<input type=radio name=gender value=Male>Male";
   echo "<select name=gender>";
   echo "<option value =Female ";
   if($gender == 'Female'){echo "selected";}
   echo ">Female</option>";
   echo "<option value =Male ";
   if($gender == 'Male'){echo "selected";}
   echo ">Male</option>";
   echo "</select>";
   echo "<span class=error>*".$genderErr."</span></center>";
   echo "<br><br>";
   echo "<center><input type=submit style=width:80px; name=submit value=Revise>";
   for($x=0; $x<=3; $x++){
   echo "&nbsp&nbsp";
   }
   echo "<input type=submit name=close style=width:90px; value=CloseAccount></center>";
   echo "";
   echo "</form>";


}else{
  echo "invalid connection";
}
?>
