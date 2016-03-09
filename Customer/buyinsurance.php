<?php
	//Define variables
	$company=$itype="";
	$companyErr=$itypeErr="";


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

if(isset($_COOKIE['user_id'])&&isset($_COOKIE["t_no"])){
	$t_no=$_COOKIE["t_no"];
	$user_id = $_COOKIE["user_id"];

  //Connect with database
  $servername = "cs4111.couswvsem0vf.us-east-1.rds.amazonaws.com";
  $username = "xl2523";
  $password = "databaseCS4111";
  $dbname = 'cs4111';
  $conn = mysql_connect($servername,$username,$password);
  mysql_select_db($dbname, $conn);
echo '<center>Welcome Back, Dear '.$_COOKIE['user_id'].' !<br/></center>';
	echo '<center>You are Logged as '.$_COOKIE['user_id'].'</center><br/>';
	$viplevel=test_vip($user_id,$conn);
	if($viplevel){
		echo "Welcome VIP:".$viplevel."<br>";
	}
	echo '<a href="logOut.php"> Log Out('.$_COOKIE['user_id'].')</a>';
  echo '<br>';
  echo '<a href="loged.php"> Go back to homepage</a>';
  echo '<br>';
	echo "<h2 style=color:blue>Buy Insurance</h2>";
	echo "<style>table, th, td {border: 3px solid black;border-collapse: collapse;}</style>";
	//Select seat and class
  $sqlticket = "SELECT * FROM FLIGHT F, Ticket T WHERE F.F_NO=T.F_NO AND T.T_NO='$t_no'";
 	$ticket = mysql_query( $sqlticket,$conn);

if (mysql_num_rows($ticket) > 0) {
    // output data of each row

   echo "<table>
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
   </tr>";

    while($row = mysql_fetch_array($ticket)) {
        echo "<td>" . $row['F_NO'] ." </td>";
        echo "<td>" . $row["F_START"]."</td>";
        echo "<td>" . $row["F_DESTINY"]."</td>";
        echo "<td>" . $row["T_DATE"]."</td>";
        echo "<td>" . $row["F_DEPARTURETIME"]."</td>";
        echo "<td>" . $row["F_TIMEARR"]."</td>";
        echo "<td>" . $row["T_GATE"]."</td>";
        echo "<td>" . $row["T_SEAT"]."</td>";
        echo "<td>" . $row["T_CLASS"]."</td>";
        echo "<td>" . $row["T_PRICE"]."</td>";
        echo "<td>" . $row["F_COMPANY"]."</td>";
     }
    echo "</table>";
}
//judge if everything is inputed

if (isset($_POST["select"])) {
   if (empty($_POST["itype"])) {
     $itypeErr = "Please choose the insurance type";
   } else {
     $itype = test_input($_POST["itype"]);
   }
   if (empty($_POST["company"])) {
     $companyErr = "Please choose the insurance company";
   } else {
     $company = test_input($_POST["company"]);
   }

}


	echo "<style>.error {color: #FF0000;}</style>";
    echo "<span class=error>*required field</span>";
	//Select seat and class
	echo "<form action=buyinsurance.php method=post>";
	echo "Please Select Insurance Company:";
    echo "<input type=radio name=company value=AIG>AIG&nbsp&nbsp&nbsp";
    echo "<input type=radio name=company value=AIA>AIA&nbsp&nbsp&nbsp";
    echo "<input type=radio name=company value=GEICO>GEICO&nbsp&nbsp&nbsp";
    echo "<span class=error>*".$companyErr." </span>";
    echo "<br><br>";
	  echo "Please Select Insurance Type:";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo "<input type=radio name=itype value=A>A&nbsp&nbsp&nbsp";
    echo "<input type=radio name=itype value=B>B&nbsp&nbsp&nbsp";
    echo "<input type=radio name=itype value=C>C&nbsp&nbsp&nbsp";
    echo "<input type=radio name=itype value=D>D&nbsp&nbsp&nbsp";
    echo "<span class=error>*".$itypeErr." </span>";
    echo "<br><br>";
    echo "<input type=submit name=select value=SELECT >";
    echo "</form>";

//After select
if (isset($_POST["select"])) {
	if($companyErr==""&&$itypeErr ==""){
		echo "<fieldset  style=width:250px>";
		if($company=="AIG"){
			$tempprice = 2000;
		}elseif($company=="AIA"){
			$tempprice = 4000;
		}elseif($company=="GEICO"){
			$tempprice = 6000;
		}
		//Calculate price
		if($itype=="A"){
			$payback = $tempprice*5;
		}elseif($itype=="B"){
			$payback = $tempprice*10;
		}elseif($itype=="C"){
			$payback = $tempprice*15;
		}elseif($itype=="D"){
			$payback = $tempprice*20;
		}
    $iprice=$payback/2000;
    echo "Insurance Company:".$company."<br>";
    echo "Insurace type:".$itype."<br>";
		echo "Insurance Price:$".$iprice."<br>";
    echo "Insurance Payback:$".$payback."<br>";
		echo "<form action=buyinsurance.php method=post>";
		echo "<input type=hidden name=iprice value=".$iprice.">";
		echo "<input type=hidden name=payback value=".$payback.">";
    echo "<input type=hidden name=company value=".$company.">";
    echo "<input type=hidden name=itype value=".$itype.">";
    echo "<input type=submit name=buy value=ConfirmBuying>";
    echo "</form>";
    echo "</fieldset>";
	}
}

if (isset($_POST["buy"])) {
	$iprice=$_POST["iprice"];
	$payback=$_POST["payback"];
	$company=$_POST["company"];
  $itype=$_POST["itype"];

/*  echo "Insurance Company:".$company."<br>";
  echo "Insurace type:".$itype."<br>";
  echo "Insurance Price:$".$iprice."<br>";
  echo "Insurance Payback:$".$payback."<br>";*/
  $buy="INSERT INTO INSURANCE (T_NO,I_PRICE,I_COPORATION,I_PAYBACK,I_TYPE)
  VALUES ('$t_no','$iprice','$company','$payback','$itype')";
  mysql_query($buy,$conn);

  $home_url = 'successInsurance.php';
  header('Location: '.$home_url);
}


}else{
	echo "invalid connection";
}
?>
