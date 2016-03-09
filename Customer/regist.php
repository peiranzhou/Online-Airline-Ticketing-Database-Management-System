<?php
  echo "<a href=logIn.php><input type=submit style=width:100px;background-color:LightSkyBlue;color:white;font-size:13px; name=goBack value=back></a>";
  echo "&nbsp;<br>";
	echo '<center><font size=5>Regist as a new customer</font></center>';
  echo "&nbsp;<br>";

// define variables and set to empty values
$nameErr = $user_idErr = $genderErr = $telErr = "";
$name = $user_id = $gender = $comment = $tel = "";

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   if (empty($_POST["user_id"])) {
     $user_idErr = "User id is required";
   } else {
     $user_id = test_input($_POST["user_id"]);
   }
   if (empty($_POST["name"])) {
     $nameErr = "Name is required";
   } else {
     $name = test_input($_POST["name"]);
   }
   $regex = '/^\d*$/';
   if (empty($_POST["tel"])) {
     $telErr = "Telephone number is required";
   } elseif((strlen($_POST["tel"])!=10)||!preg_match($regex, $_POST["tel"])) {
     $telErr = "Telephone number is not valid";
   } else {
     $tel = test_input($_POST["tel"]);
   }
   if (empty($_POST["gender"])) {
     $genderErr = "Gender is required";
   } else {
     $gender = test_input($_POST["gender"]);
   }
   if($nameErr==""&&$user_idErr ==""&&$genderErr==""&&$telErr==""){
     $sqloverlap="SELECT * FROM Passenger WHERE P_ID='$user_id'";
     $overlap=mysql_query($sqloverlap,$conn);
     if(mysql_num_rows($overlap) != 0){
        $user_idErr = "This user id has been used.";
     }else{
        $sqladd="INSERT INTO Passenger (P_ID,P_name,P_Gender,P_Tel) VALUES ('$user_id','$name','$gender','$tel')";
        $addcustomer=mysql_query($sqladd,$conn);
        setcookie('user_id',$user_id);
        $home_url = 'success.php';
        header('Location: '.$home_url);
     }
   }
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>
<html>
    <head>
        <title>Welcome New Customer</title>
        <style>
		.error {color: #FF0000;}
		</style>
    </head>
    <body>
<p><center><i><span class="error">* required field.</span></i></center></p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

	 <center>User_id:&nbsp; <input type="text" name="user_id">
   <span class="error">* <?php echo $user_idErr;?></span></center>
   <br><br>

   <center>Name:&nbsp&nbsp <input type="text" name="name">
   <span class="error">* <?php echo $nameErr;?></span></center>
   <br><br>

   <center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tel:&nbsp;&nbsp; <input type="text" name="tel">
   <span class="error">*<?php echo $telErr;?></span></center>
   <br><br>

   <center>Gender:&nbsp;
   <input type="radio" name="gender" value="Female">&nbsp;Female
   <input type="radio" name="gender" value="Male">&nbsp;Male
   <span class="error">* <?php echo $genderErr;?></span></center>
   <br><br>
   <center><input type="submit" name="submit" style="width:90px;" value="Submit"></center>
</form>
</body>
</html>

<?php
// echo "<h2>Your Input:</h2>";
// echo "User ID:".$user_id;
// echo "<br>";
// echo "Name:".$name;
// echo "<br>";
// echo "Tel:".$tel;
// echo "<br>";
// echo "Gender:".$gender;
?>
