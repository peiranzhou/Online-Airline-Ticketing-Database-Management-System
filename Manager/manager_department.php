<html>
<head>
</head>

<body>
<?php

$con = mysql_connect("cs4111.couswvsem0vf.us-east-1.rds.amazonaws.com","xl2523","databaseCS4111");
mysql_select_db('cs4111', $con);
// 和rds建立连接，并且选择所要用到的数据库名称


if(isset($_POST['update'])){
$UpdateQuery = "UPDATE DEPARTMENT SET D_NAME='$_POST[f_no]', D_SALARY='$_POST[f_start]', D_SCALE='$_POST[f_destiny]' WHERE D_NAME='$_POST[hidden]'";
mysql_query($UpdateQuery, $con);
};
// 判断，如果按下了update按钮，则对Passenger表内的数据进行修改。


if(isset($_POST['delete'])){
$DeleteQuery = "DELETE FROM DEPARTMENT WHERE D_NAME='$_POST[hidden]'";
mysql_query($DeleteQuery, $con);
};

if(isset($_POST['add'])){
$AddQuery = "INSERT INTO DEPARTMENT (D_NAME, D_SALARY, D_SCALE) VALUES ('$_POST[f_no]','$_POST[f_start]','$_POST[f_destiny]')";
mysql_query($AddQuery, $con);
};

if(isset($_POST['muliga'])){
$UpdateQuery1 = "UPDATE DEPARTMENT SET D_NAME='$_POST[no]', D_SALARY='$_POST[start]', D_SCALE='$_POST[destiny]' WHERE D_NAME='$_POST[hidden]'";
mysql_query($UpdateQuery1, $con);
};

// 插入数据进行更新
if(isset($_POST['thinkpad'])){
$DeleteQuery1 = "DELETE FROM DEPARTMENT WHERE D_NAME='$_POST[hidden]'";
mysql_query($DeleteQuery1, $con);
};
// 删除搜索到的数据

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------




$sql  = "SELECT * FROM DEPARTMENT";
$records = mysql_query($sql, $con);




echo "<a href=managerhome.php><input type=submit style=width:100px;background-color:LightSkyBlue;color:white;font-size:13px; name=goBack value=back></a>";
echo "<center><font size=4 color=black>Department Information Search Engine</font></center><br>";
echo "<font size=4 color=white>This is some text!</font>";
//通过白色文字来将表格尽量垂直居中； 如果不在第一行输入<br>，则两个echo都会输出在同一行

$flightnumber ="";

echo "<form action=manager_department.php method=post>";
echo "<center><font size=2 color=grey><i>(Please search by D_NAME)</i></font></center><br>";
echo "<center><input type=text style=width:400px; name=flightnumber></center><br>";
echo "<center><input type=submit style=width:150px; name=search value=search></center>";

//单纯为了做出空行的效果
echo "<font size=4 color=white>This is some text!</font><br>";
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



$sqll = "SELECT * FROM DEPARTMENT WHERE D_NAME LIKE '%$flightnumber%'";
$result = mysql_query( $sqll,$con);
$count=$result['count'];



if (mysql_num_rows($result) > 0 && isset($_POST['search'])) {

    echo "<table border=1 align=center>
    <tr>
    <th>D_NAME</th>
    <th>D_SALARY</th>
    <th>D_SCALE</th>
    </tr>";

    while($FLIGHT1 = mysql_fetch_array($result)) {
      echo "<form action=manager_department.php method=post>";
        echo "<tr>";
        echo "<td><input type = text name = no value=" . $FLIGHT1['D_NAME'] ." </td>";
        echo "<td><input type = text name = start value=" . $FLIGHT1['D_SALARY']." </td>";
        echo "<td><input type = text name = destiny value=" . $FLIGHT1['D_SCALE']." </td>";
        echo "<input type=hidden name=hidden value=" . $FLIGHT1['D_NAME'] . ">";
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


echo "<font size=4 color=white>This is some text!</font><br>";


echo "<center><font size=4 color=black>You Can Insert the Elements Whatever You Want</font></center><br>";
echo "<font size=4 color=white>This is some text!</font>";
//通过白色文字来将表格尽量垂直居中； 如果不在第一行输入<br>，则两个echo都会输出在同一行


echo "<table border=1 align=center>
<tr>
<th>D_NAME</th>
<th>D_SALARY</th>
<th>D_SCALE</th>
</tr>";
//建立一个专门用于删除修改信息的表格

echo "<form action=manager_department.php method=post>";
echo "<tr>";
echo "<td><input type=text name=f_no></td>";
echo "<td><input type=text name=f_start></td>";
echo "<td><input type=text name=f_destiny></td>";

echo "<td><input type=submit name=add value=add></td>";
echo "</form>";
echo "</table>";

//单纯为了做出空行的效果
echo "<font size=4 color=white>This is some text!</font><br>";
echo "<font size=4 color=white>This is some text!</font><br>";
echo "<font size=4 color=white>This is some text!</font><br>";
echo "<font size=4 color=white>This is some text!</font>";
//单纯为了做出空行的效果




//------------------------------------------------------------------------------

$showtable = $closetable ="";

echo "<form action=manager_department.php method=post>";
echo "<center><input type=submit style=width:150px; color=CornflowerBlue name=showtable value=ShowTable><font size=1 color=white>hahahaha</font><input type=submit style=width:150px; name=closetable value=CloseTable></center>";
echo "</form>";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   @$showtable = test_input($_POST['showtable']);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   @$closetable = test_input($_POST['closetable']);
}



if(isset($_POST['showtable'])) {



echo "<font size=4 color=white>This is some text!</font><br>";
echo "<font size=4 color=white>This is some text!</font>";
echo "<center><font size=4 color=black>Department Information Diagram</font></center><br>";
echo "<font size=4 color=white>This is some text!</font>";
//通过白色文字来将表格尽量垂直居中； 如果不在第一行加入<br>，则两个echo都会输出到同一行

echo "<table border=1 align=center>
<tr>
<th>D_NAME</th>
<th>D_SALARY</th>
<th>D_SCALE</th>
</tr>";


while($FLIGHT = mysql_fetch_array($records)){
echo "<form action=manager_department.php method=post>";
echo "<tr>";
echo "<td><input type = text name = f_no value=" . $FLIGHT['D_NAME'] ." </td>";
echo "<td><input type = text name = f_start value=" . $FLIGHT['D_SALARY']." </td>";
echo "<td><input type = text name = f_destiny value=" . $FLIGHT['D_SCALE']." </td>";
echo "<input type=hidden name=hidden value=" . $FLIGHT['D_NAME'] . ">";

echo "<td><input type=submit name=update value=update></td>";
echo "<td><input type=submit name=delete value=delete></td>";
echo "</tr>";
echo "</form>";
}
echo "</table>";
}
else if(isset($_POST['closetable'])){
   echo "<br>";
   echo "";
}




mysql_close($con);
?>

</body>
</html>
