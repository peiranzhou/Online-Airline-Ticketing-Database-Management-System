<?php
	//Define variables
	$gate=$seat=$seatclass="";
	$line="";
	$seatposition="";
	$classErr=$seatErr=$lineErr="";


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

if(isset($_COOKIE['user_id'])&&isset($_COOKIE["date"])&&isset($_COOKIE["f_no"])){
	$f_no=$_COOKIE["f_no"];
	$date=$_COOKIE["date"];
	$user_id = $_COOKIE["user_id"];

  //Connect with database
  $servername = "cs4111.couswvsem0vf.us-east-1.rds.amazonaws.com";
  $username = "xl2523";
  $password = "databaseCS4111";
  $dbname = 'cs4111';
  $conn = mysql_connect($servername,$username,$password);
  mysql_select_db($dbname, $conn);

	echo 'You are logged as '.$_COOKIE['user_id'].'<br/>';
	echo "<br>";
	$viplevel=test_vip($user_id,$conn);
	if($viplevel){
		echo "Welcome VIP:&nbsp".$viplevel."<br>";
	}
	echo "<br>";
	echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="logOut.php"><input type="submit" style="width:90px;" value="Log Out '.$_COOKIE['user_id'].'" name="Regist"></a>';

    echo "&nbsp<br>"; echo "&nbsp<br>";
	echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href=searchFlight.php><input type=submit style=width:90px; color:black;font-size:13px; name=goBack value=back></a>";
    echo '<br>';
	echo "<center><h2 style=color:black>Please Confirm the information about the flight</h2></center>";
	echo "<style>table, th, td {border: 3px solid black;border-collapse: collapse;}</style>";
	//Select seat and class
  	$sqlflight = "SELECT * FROM FLIGHT WHERE F_NO='$f_no'";
 	$flight = mysql_query( $sqlflight,$conn);

if (mysql_num_rows($flight) > 0) {
    // output data of each row

   echo "<table align=center>
   <tr>
   <th>Flight Number</th>
   <th>Departure</th>
   <th>Destiny</th>
   <th>Date</th>
   <th>Departure Time</th>
   <th>Arrive Time</th>
   <th>Company</th>
   </tr>";

    while($row = mysql_fetch_array($flight)) {
        echo "<tr>";
        echo "<td>" . $row['F_NO'] ." </td>";
        echo "<td>" . $row["F_START"]."</td>";
        echo "<td>" . $row["F_DESTINY"]."</td>";
        echo "<td>" . $date."</td>";
        echo "<td>" . $row["F_DEPARTURETIME"]."</td>";
        echo "<td>" . $row["F_TIMEARR"]."</td>";
        echo "<td>" . $row["F_COMPANY"]."</td>";
        echo "</tr>";
        $original_price=$row["ORIGIANL_PRICE"];
     }
    echo "</table>";
}
echo "&nbsp <br>"; echo "&nbsp <br>";
//judge if everything is inputed
if (isset($_POST["choose"])) {
   if (empty($_POST["class"])) {
     $classErr = "Please choose the seat class";
   } else {
     $seatclass = test_input($_POST["class"]);
   }
   if (empty($_POST["seat"])) {
     $seatErr = "Please choose the seat position";
   } else {
     $seat = test_input($_POST["seat"]);
   }
   if (empty($_POST["line"])) {
     $lineErr = "Please choose the seat line";
   } else {
     $line = strval(test_input($_POST["line"]));
   }
//Judge whether the seat has been booked or not
   if($lineErr==""&&$seatErr==""){
   	 $seatposition=$line.$seat;
   	 $sqloverlap="SELECT * FROM Ticket WHERE T_SEAT='$seatposition' AND F_NO='$f_no' AND T_DATE='$date'";
     $overlap=mysql_query($sqloverlap,$conn);
     if(mysql_num_rows($overlap) != 0){
        $lineErr = "Seat".$seatposition." has been booked.";
        $seatErr = "Seat".$seatposition." has been booked.";
     }
   }
}


	echo "<style>.error {color: #FF0000;}</style>";
    echo "<center><span class=error><i>*required field</i></span></center>";
		echo "&nbsp <br>";
	//Select seat and class
	echo "<form action=booking.php method=post>";
	  echo "<center>Please Select Seat Class:&nbsp";
    echo "<input type=radio name=class value=F>First Class&nbsp&nbsp&nbsp";
    echo "<input type=radio name=class value=B>Business Class&nbsp&nbsp&nbsp";
    echo "<input type=radio name=class value=E>Economy Class&nbsp&nbsp";
    echo "<span class=error>*".$classErr." </span>";
    echo "</center><br><br>";

	  echo "<center>Please Select Seat Position:&nbsp";
    echo "<input type=radio name=seat value=A>A&nbsp&nbsp&nbsp";
    echo "<input type=radio name=seat  value=B>B&nbsp&nbsp&nbsp";
    echo "<input type=radio name=seat value=C>C&nbsp&nbsp&nbsp";
    echo "<input type=radio name=seat value=J>J&nbsp&nbsp&nbsp";
    echo "<input type=radio name=seat  value=K>K&nbsp&nbsp&nbsp";
    echo "<input type=radio name=seat value=L>L&nbsp&nbsp&nbsp";
    echo "<span class=error>*".$seatErr." </span>";
    echo "</center><br><br>";

    echo "<center>Please Select Seat Line:&nbsp(1~100)";
    echo "<input type=number name=line min=1 max=100>&nbsp&nbsp";
    echo "<span class=error>*".$lineErr." </span>";
    echo "</center><br><br>";
    echo "<center><input type=submit name=choose style=width:90px; value=CHOOSE ></center>";
    echo "</form>";

//After choose
if (isset($_POST["choose"])) {
	if($classErr==""&&$seatErr ==""&&$lineErr==""){
		echo "<center><fieldset style=width:250px>";
		if($seatclass=="F"){
			echo "Seat Class: First Class<br>";
			$tempprice = $original_price*1.5;
		}elseif($seatclass=="B"){
			echo "Seat Class: Business Class<br>";
			$tempprice = $original_price*1;
		}elseif($seatclass=="E"){
			echo "Seat Class: Economy Class<br>";
			$tempprice = $original_price*0.75;
		}
		echo "Seat Postion: ".$seatposition."<br>";
		//Calculate price
		if($viplevel=="Member"){
			$price = $tempprice*0.95;
		}elseif($viplevel=="EliteMember"){
			$price = $tempprice*0.9;
		}elseif($viplevel=="SuperElite"){
			$price = $tempprice*0.8;
		}else{
			$price=$tempprice;
		}
		$price=round($price);
		echo "Price: $".$price."<br>";
		echo "<form action=booking.php method=post>";
		echo "<input type=hidden name=seatclass value=".$seatclass.">";
		echo "<input type=hidden name=position value=".$seatposition.">";
		echo "<input type=hidden name=price value=".$price.">";
		echo "<br>";
    	echo "<input type=submit name=booking value=Booking>";
    	echo "</form></fieldset></center>";
	}
}

if (isset($_POST["booking"])) {
	$price=$_POST["price"];
	$seatclass=$_POST["seatclass"];
	$seatposition=$_POST["position"];
   	$sqlgate="SELECT * FROM Ticket WHERE T_DATE='$date' AND F_NO='$f_no'";
    $gateresult=mysql_query($sqlgate,$conn);
    if(mysql_num_rows($gateresult)>0){
		$rowgate = mysql_fetch_array($gateresult);
		$gate = $rowgate["T_GATE"];
	}else{
		$gate=strval(rand(1,50));
	}
   	$book="INSERT INTO Ticket (P_ID,F_NO,T_PRICE,T_GATE,T_SEAT,T_CLASS,T_DATE)
   	VALUES ('$user_id','$f_no','$price','$gate','$seatposition','$seatclass','$date')";
    mysql_query($book,$conn);
    $home_url = 'successTicket.php';
    header('Location: '.$home_url);
}


}else{
	echo "invalid connection";
}
?>
