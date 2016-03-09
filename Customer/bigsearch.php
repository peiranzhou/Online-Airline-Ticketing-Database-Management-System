<html>
<head>

<style>
/*body {
    background-image: img("Columbia University.JPG");
}*/
</style>

</head>

<body>

<?php
echo "<a href=managerhome.php><input type=submit style=width:100px;background-color:LightSkyBlue;color:white;font-size:13px; name=goBack value=back></a>";


$con = mysql_connect("cs4111.couswvsem0vf.us-east-1.rds.amazonaws.com","xl2523","databaseCS4111");
mysql_select_db('cs4111', $con);
// 和rds建立连接，并且选择所要用到的数据库名称

if(isset($_POST['add'])){
$AddQuery = "INSERT INTO FLIGHT (F_NO, F_START, F_DESTINY, F_DEPARTURETIME, F_TIMEARR, F_COMPANY, ORIGIANL_PRICE) VALUES ('$_POST[f_no]','$_POST[f_start]','$_POST[f_destiny]','$_POST[f_departuretime]', '$_POST[f_timearr]', '$_POST[f_company]', '$_POST[original_price]')";
mysql_query($AddQuery, $con);
};

if(isset($_POST['muliga'])){
$UpdateQuery1 = "UPDATE FLIGHT SET F_NO='$_POST[no]', F_START='$_POST[start]', F_DESTINY='$_POST[destiny]', F_DEPARTURETIME='$_POST[departuretime]', F_TIMEARR='$_POST[timearr]', F_COMPANY='$_POST[company]', ORIGIANL_PRICE='$_POST[price]'  WHERE F_NO='$_POST[hidden]'";
mysql_query($UpdateQuery1, $con);
};

// 插入数据进行更新

if(isset($_POST['thinkpad'])){
$DeleteQuery1 = "DELETE FROM FLIGHT WHERE F_NO='$_POST[hidden]'";
mysql_query($DeleteQuery1, $con);
};
// 删除搜索到的数据

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------


echo "&nbsp;<br>";
echo "&nbsp;<br>";
echo "<center><i><font color=grey>(search by keywords)</font></i></center>";
echo "&nbsp;<br>";
//通过白色文字来将表格尽量垂直居中； 如果不在第一行输入<br>，则两个echo都会输出在同一行

$flightnumber ="";

echo "<form action=bigsearch.php method=post>";
echo "<center><input type=text style=width:400px; name=flightnumber></center><br>";
echo "<center><input type=submit style=width:120px; name=search value=search></center>";

//单纯为了做出空行的效果
echo "<font size=4 color=white>&nbsp;</font><br>";
//单纯为了做出空行的效果

echo "</form>";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   @$flightnumber = test_input($_POST['flightnumber']);

}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}



$sqll = "SELECT * FROM FLIGHT WHERE F_NO LIKE '%$flightnumber%'";
$result = mysql_query( $sqll,$con);
$count=$result['count'];

if (mysql_num_rows($result) > 0 && isset($_POST['search'])) {
  echo "<center><font size=4 color=black>Flight Information Diagram</font></center><br>";

    echo "<table border=1 align=center>
    <tr>
    <th>F_NO</th>
    <th>F_START</th>
    <th>F_DESTINY</th>
    <th>F_DEPARTURETIME</th>
    <th>F_TIMEARR</th>
    <th>F_COMPANY</th>
    <th>ORIGIANL_PRICE</th>
    </tr>";

    while($FLIGHT1 = mysql_fetch_array($result)) {
      echo "<form action=bigsearch.php method=post>";
        echo "<tr>";
        echo "<td><input type = text name = no value=" . $FLIGHT1['F_NO'] ." </td>";
        echo "<td><input type = text name = start value=" . $FLIGHT1['F_START']." </td>";
        echo "<td><input type = text name = destiny value=" . $FLIGHT1['F_DESTINY']." </td>";
        echo "<td><input type = text name = departuretime value=" . $FLIGHT1['F_DEPARTURETIME']." </td>";
        echo "<td><input type = text name = timearr value=" . $FLIGHT1['F_TIMEARR']." </td>";
        echo "<td><input type = text name = company value=" . $FLIGHT1['F_COMPANY']." </td>";
        echo "<td><input type = text name = price value=" . $FLIGHT1['ORIGIANL_PRICE']." </td>";
        echo "<input type=hidden name=hidden value=" . $FLIGHT1['F_NO'] . ">";
        echo "<td><input type=submit name=muliga value=update></td>";
        echo "<td><input type=submit name=thinkpad value=delete></td>";
        echo "</tr>";
     }

   echo "</table>";
   echo "<br>";
 } else {
    echo "<br>";
    echo "";
 }

 $sqlll = "SELECT * FROM CABINCREW WHERE CREW_NO LIKE '%$flightnumber%'";
 $result2 = mysql_query( $sqlll,$con);
 $count=$result2['count'];


 if (mysql_num_rows($result2) > 0 && isset($_POST['search'])) {
   echo "<center><font size=4 color=black>Cabincrew Information Diagram</font></center><br>";
     echo "<table border=1 align=center>
     <tr>
     <th>F_NO</th>
     <th>CREW_NO</th>
     <th>CREW_NAME</th>
     <th>CREW_OLD</th>
     <th>CREW_GENDER</th>
     </tr>";

     while($FLIGHT1 = mysql_fetch_array($result2)) {
       echo "<form action=bigsearch.php method=post>";
         echo "<tr>";
         echo "<td><input type = text name = no value=" . $FLIGHT1['F_NO'] ." </td>";
         echo "<td><input type = text name = start value=" . $FLIGHT1['CREW_NO']." </td>";
         echo "<td><input type = text name = destiny value=" . $FLIGHT1['CREW_NAME']." </td>";
         echo "<td><input type = text name = departuretime value=" . $FLIGHT1['CREW_OLD']." </td>";
         echo "<td><input type = text name = timearr value=" . $FLIGHT1['CREW_GENDER']." </td>";
         echo "<input type=hidden name=hidden value=" . $FLIGHT1['CREW_NO'] . ">";
         echo "<td><input type=submit name=muliga value=update></td>";
         echo "<td><input type=submit name=thinkpad value=fire!></td>";
         echo "</tr>";
      }

    echo "</table>";
    echo "<br>";
  } else {
     echo "<br>";
     echo "";
  }

  $sqll = "SELECT * FROM FEEDBACK WHERE CREW_NO LIKE '%$flightnumber%'";
  $result3 = mysql_query( $sqll,$con);
  $count=$result3['count'];



  if (mysql_num_rows($result3) > 0 && isset($_POST['search'])) {
    echo "<center><font size=4 color=black>Feedback Information Diagram</font></center><br>";
      echo "<table border=1 align=center>
      <tr>
      <th>CREW_NO</th>
      <th>P_ID</th>
      <th>FE_GRADE</th>
      <th>FE_MESSAGE</th>
      </tr>";

      while($FLIGHT1 = mysql_fetch_array($result3)) {
        echo "<form action=bigsearch.php method=post>";
          echo "<tr>";
          echo "<td><input type = text name = no value=" . $FLIGHT1['CREW_NO'] ." </td>";
          echo "<td><input type = text name = start value=" . $FLIGHT1['P_ID']." </td>";
          echo "<td><input type = text name = destiny value=" . $FLIGHT1['FE_GRADE']." </td>";
          echo "<td><input type = text name = departuretime value='" . $FLIGHT1['FE_MESSAGE']."' </td>";
          echo "<input type=hidden name=hidden value=" . $FLIGHT1['CREW_NO'] . ">";
          // echo "<td><input type=submit name=muliga value=update></td>";
          echo "<td><input type=submit name=thinkpad value=fire!></td>";
          echo "</tr>";
       }

     echo "</table>";
     echo "<br>";
   } else {
      echo "<br>";
      echo "";
   }

   $sqll = "SELECT * FROM INSURANCE WHERE I_NO LIKE '%$flightnumber%'";
   $result4 = mysql_query( $sqll,$con);
   $count=$result['count'];




   if (mysql_num_rows($result4) > 0 && isset($_POST['search'])) {
echo "<center><font size=4 color=black>Insurance Information Diagram</font></center><br>";
       echo "<table border=1 align=center>
       <tr>
       <th>I_NO</th>
       <th>T_NO</th>
       <th>I_PRICE</th>
       <th>I_COPORATION</th>
       <th>I_PAYBACK</th>
       <th>I_TYPE</th>
       </tr>";

       while($FLIGHT1 = mysql_fetch_array($result4)) {
         echo "<form action=manager_insurance.php method=post>";
           echo "<tr>";
           echo "<td><input type = text name = no value=" . $FLIGHT1['I_NO'] ." </td>";
           echo "<td><input type = text name = start value=" . $FLIGHT1['T_NO']." </td>";
           echo "<td><input type = text name = destiny value=" . $FLIGHT1['I_PRICE']." </td>";
           echo "<td><input type = text name = departuretime value=" . $FLIGHT1['I_COPORATION']." </td>";
           echo "<td><input type = text name = timearr value=" . $FLIGHT1['I_PAYBACK']." </td>";
           echo "<td><input type = text name = i_type value=" . $FLIGHT1['I_TYPE']." </td>";
           echo "<input type=hidden name=hidden value=" . $FLIGHT1['I_NO'] . ">";
           echo "<td><input type=submit name=muliga value=update></td>";
           echo "<td><input type=submit name=thinkpad value=delete></td>";
           echo "</tr>";
        }

      echo "</table>";
      echo "<br>";
    } else {
       echo "<br>";
       echo "";
    }


    $sqll = "SELECT * FROM DEPARTMENT WHERE D_NAME LIKE '%$flightnumber%'";
    $result5 = mysql_query( $sqll,$con);
    $count=$result5['count'];



    if (mysql_num_rows($result5) > 0 && isset($_POST['search'])) {
      echo "<center><font size=4 color=black>Department Information Diagram</font></center><br>";
        echo "<table border=1 align=center>
        <tr>
        <th>D_NAME</th>
        <th>D_SALARY</th>
        <th>D_SCALE</th>
        </tr>";

        while($FLIGHT1 = mysql_fetch_array($result5)) {
          echo "<form action=manager_department.php method=post>";
            echo "<tr>";
            echo "<td><input type = text name = no value=" . $FLIGHT1['D_NAME'] ." </td>";
            echo "<td><input type = text name = start value=" . $FLIGHT1['D_SALARY']." </td>";
            echo "<td><input type = text name = destiny value=" . $FLIGHT1['D_SCALE']." </td>";
            echo "<input type=hidden name=hidden value=" . $FLIGHT1['D_NAME'] . ">";
            echo "<td><input type=submit name=muliga value=update></td>";
            echo "<td><input type=submit name=thinkpad value=delete></td>";
            echo "</tr>";
         }

       echo "</table>";
       echo "<br>";
     } else {
        echo "<br>";
        echo "";
     }

     $sqll = "SELECT * FROM MANAGE WHERE CREW_NO LIKE '%$flightnumber%'";
     $result6 = mysql_query( $sqll,$con);
     $count=$result['count'];



     if (mysql_num_rows($result6) > 0 && isset($_POST['search'])) {
       echo "<center><font size=4 color=black>Manage Information Diagram</font></center><br>";
         echo "<table border=1 align=center>
         <tr>
         <th>D_NAME</th>
         <th>CREW_NO</th>
         <th>MANAGE_SINCE</th>
         </tr>";

         while($FLIGHT1 = mysql_fetch_array($result6)) {
           echo "<form action=manager_manage.php method=post>";
             echo "<tr>";
             echo "<td><input type = text name = no value=" . $FLIGHT1['D_NAME'] ." </td>";
             echo "<td><input type = text name = start value=" . $FLIGHT1['CREW_NO']." </td>";
             echo "<td><input type = text name = destiny value=" . $FLIGHT1['MANAGE_SINCE']." </td>";
             echo "<input type=hidden name=hidden value=" . $FLIGHT1['CREW_NO'] . ">";
             echo "<td><input type=submit name=muliga value=update></td>";
             echo "<td><input type=submit name=thinkpad value=delete></td>";
             echo "</tr>";
          }

        echo "</table>";
        echo "<br>";
      } else {
         echo "<br>";
         echo "";
      }

      $sqll = "SELECT * FROM Passenger WHERE P_ID LIKE '%$flightnumber%'";
      $result7 = mysql_query( $sqll,$con);
      $count=$result7['count'];



      if (mysql_num_rows($result7) > 0 && isset($_POST['search'])) {
            echo "<center><font size=4 color=black>Passenger Information Diagram</font></center><br>";
          echo "<table border=1 align=center>
          <tr>
          <th>P_ID</th>
          <th>P_name</th>
          <th>P_Gender</th>
          <th>P_Tel</th>
          </tr>";

          while($FLIGHT1 = mysql_fetch_array($result7)) {
            echo "<form action=manager_passenger.php method=post>";

              echo "<tr>";
              echo "<td><input type = text name = no value=" . $FLIGHT1['P_ID'] ." </td>";
              echo "<td><input type = text name = start value=" . $FLIGHT1['P_name']." </td>";
              echo "<td><input type = text name = destiny value=" . $FLIGHT1['P_Gender']." </td>";
              echo "<td><input type = text name = departuretime value=" . $FLIGHT1['P_Tel']." </td>";
              echo "<input type=hidden name=hidden value=" . $FLIGHT1['P_ID'] . ">";
              echo "<td><input type=submit name=muliga value=update></td>";
              echo "<td><input type=submit name=thinkpad value=delete></td>";
              echo "</tr>";
           }

         echo "</table>";
         echo "<br>";
       } else {
          echo "<br>";
          echo "";
       }



       $sqll = "SELECT * FROM Ticket WHERE T_NO LIKE '%$flightnumber%'";
       $result8 = mysql_query( $sqll,$con);
       $count=$result8['count'];



       if (mysql_num_rows($result8) > 0 && isset($_POST['search'])) {
echo "<center><font size=4 color=black>Ticket Information Diagram</font></center><br>";
           echo "<table border=1 align=center>
           <tr>
           <th>T_NO</th>
           <th>P_ID</th>
           <th>F_NO</th>
           <th>T_PRICE</th>
           <th>T_GATE</th>
           <th>T_SEAT</th>
           <th>T_CLASS</th>
           <th>T_DATE</th>
           </tr>";

           while($FLIGHT1 = mysql_fetch_array($result8)) {
             echo "<form action=manager_ticket.php method=post>";
               echo "<tr>";
               echo "<td><input type = text name = no value=" . $FLIGHT1['T_NO'] ." </td>";
               echo "<td><input type = text name = start value=" . $FLIGHT1['P_ID']." </td>";
               echo "<td><input type = text name = destiny value=" . $FLIGHT1['F_NO']." </td>";
               echo "<td><input type = text name = departuretime value=" . $FLIGHT1['T_PRICE']." </td>";
               echo "<td><input type = text name = t_gate value=" . $FLIGHT1['T_GATE']." </td>";
               echo "<td><input type = text name = t_seat value=" . $FLIGHT1['T_SEAT']." </td>";
               echo "<td><input type = text name = t_class value=" . $FLIGHT1['T_CLASS']." </td>";
               echo "<td><input type = text name = t_date value=" . $FLIGHT1['T_DATE']." </td>";
               echo "<input type=hidden name=hidden value=" . $FLIGHT1['T_NO'] . ">";
               echo "<td><input type=submit name=muliga value=update></td>";
               echo "<td><input type=submit name=thinkpad value=delete></td>";
               echo "</tr>";
               echo "</form>";
            }

          echo "</table>";
          echo "<br>";
        } else {
           echo "<br>";
           echo "";
        }





mysql_close($con);
?>

</body>
</html>
