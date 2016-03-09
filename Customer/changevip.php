<?php

$vipErr ="";

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
  $viplevel=test_vip($user_id,$conn);
//  if($viplevel){
//    echo "Welcome VIP:".$viplevel."<br>";
//  }

echo "<br>";
echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="logOut.php"><input type="submit" style="width:90px;" value="Log Out '.$_COOKIE['user_id'].'" name="Regist"></a>';

  echo "&nbsp<br>"; echo "&nbsp<br>";
echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href=loged.php><input type=submit style=width:90px; color:black;font-size:13px; name=goBack value=back></a>";
  echo '<br>';

	echo '<center><font size=5>Revise VIP Information</font></center>';
  echo "<style>table, th, td {border: 2px solid black;border-collapse: collapse;}</style>";
// define variables and set to empty values




if ($_SERVER["REQUEST_METHOD"] == "POST") {


   if (empty($_POST["vip"])) {
     $vipErr = "This field is required";
   } else {
     $vip = test_input($_POST["vip"]);
   }
   if($vipErr==""){
    if($vip=="FALSE"){
        $sqlupdate="DELETE FROM VIP_PASSENGER WHERE P_ID = '$user_id'";
        mysql_query($sqlupdate,$conn);
    }elseif($viplevel){
        $sqlupdate="UPDATE VIP_PASSENGER SET VP_LEVEL = '$vip' WHERE P_ID = '$user_id'";
        mysql_query($sqlupdate,$conn);
    }else{
        $sqlupdate="INSERT INTO VIP_PASSENGER (P_ID,VP_LEVEL) VALUES ('$user_id','$vip')";
        mysql_query($sqlupdate,$conn);
    }
      $viplevel=test_vip($user_id,$conn);
        echo "&nbsp&nbspRevise succeeded!";
//        $home_url = 'success.php';
//        header('Location: '.$home_url);
   }


}

$sqluser = "SELECT * FROM Passenger WHERE P_ID='$user_id'";
$user = mysql_query( $sqluser,$conn);
if (mysql_num_rows($user) > 0) {
    // output data of each row
   echo "<br><br>";
   echo "<center><i>(Current Uesr Information)</i></center>";
   if(!$viplevel||$viplevel=="FALSE"){
     echo "<center>You are currently not a VIP membership.<br></center>";
   }else{
     echo "<center>You are currently a VIP of level: ".$viplevel."<br></center>";
   }
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


    echo "<br><br>";
    echo "<center><span class=intro>VIP Plan provides you a lot of benefit</span></center><br>";
    echo "<br>";
    echo "<center>VIP of level Member gets &nbsp&nbsp5% cut off tickets. The annual fee is $30. </center><br>";
    echo "<center>VIP of level Member gets 10% cut off tickets. The annual fee is $50. </center><br> ";
    echo "<center>VIP of level Member gets 20% cut off tickets. The annual fee is $80. </center><br> ";

    echo "<title><center>Welcome New Customer</center></title>";
    echo "<style>.error {color: #FF0000;}</style>";
    echo "<style>.intro {font-family:courier;font-size:160%;}</style>";
   echo "<form method=post action=changevip.php>";
   echo "<br><br>";
   echo "<center>Please Choose the VIP LEVEL you want to join:&nbsp&nbsp&nbsp";
//   echo "<input type=radio name=gender value=Female>Female";
//   echo "<input type=radio name=gender value=Male>Male";
   echo "<select name=vip >";
   echo "<option value = Member ";
   if($viplevel == 'Member'){echo "selected";}
   echo ">Member</option>";
   echo "<option value =EliteMember ";
   if($viplevel == 'EliteMember'){echo "selected";}
   echo ">EliteMember</option>";
   echo "<option value =SuperElite ";
   if($viplevel == 'SuperElite'){echo "selected";}
   echo ">SuperElite</option>";
   echo "<option value =FALSE ";
   if($viplevel == "FALSE"||!$viplevel){echo "selected";}
   echo ">Do Not Join VIP Plan</option>";
   echo "</center></select>";
   echo "<span class=error>*".$vipErr."</span>";
   echo "<br><br>";
   echo "<input type=submit name=submit style=width:90px; value=Revise>";
   echo "";
   echo "</form>";


}else{
  echo "invalid connection";
}
?>
