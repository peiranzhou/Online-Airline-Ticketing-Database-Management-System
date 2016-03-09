<?php
//插入连接数据库的相关信息
require_once 'connectvars.php';

$error_msg = $user_id= $user_pwd=$user_role="";
$roleErr="";
echo "<style>.error {color: #FF0000;}</style>";
//判断用户是否已经设置cookie，如果未设置$_COOKIE['user_id']时，执行以下代码

if(!(isset($_COOKIE['user_id'])||isset($_COOKIE['m_id']))){

  if(isset($_POST['Regist'])){
    $home_url = 'regist.php';
    header('Location: '.$home_url);
  }

    if(isset($_POST['submit'])){//判断用户是否提交登录表单，如果是则执行如下代码
        $dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $user_id = test_input($_POST["user_id"]);
        $user_pwd = test_input($_POST["user_pwd"]);
        @$user_role = test_input($_POST["role"]);



        if(!empty($user_id)&&!empty($user_pwd)&&!empty($user_role)){

            if($user_role=="customer"){
                $query = "SELECT P_ID FROM Passenger WHERE P_ID = '$user_id' AND P_Tel = '$user_pwd'";
                //用用户名和密码进行查询
                $data = mysqli_query($dbc,$query);
                //若查到的记录正好为一条，则设置COOKIE，同时进行页面重定向
                if(mysqli_num_rows($data)==1){
                    $row = mysqli_fetch_array($data);
                    setcookie('user_id',$row['P_ID']);
                    $home_url = 'loged.php';
                    header('Location: '.$home_url);
                }else{//若查到的记录不对，则设置错误信息
                    $error_msg = 'Sorry, the user id or the password is uncorrect.';
                }

            }else if($user_role=="manager"){
                $query = "SELECT M_ID FROM MANAGER WHERE M_ID = '$user_id' AND M_PASSWORD = '$user_pwd'";
                //用用户名和密码进行查询
                $data = mysqli_query($dbc,$query);
                //若查到的记录正好为一条，则设置COOKIE，同时进行页面重定向
                if(mysqli_num_rows($data)==1){
                    $row = mysqli_fetch_array($data);
                    setcookie('m_id',$row['M_ID']);
                    $home_url = 'managerhome.php';
                    header('Location: '.$home_url);
                }else{//若查到的记录不对，则设置错误信息
                    $error_msg = 'Sorry, the user id or the password is uncorrect.';
                }
            }

        }else{
            $error_msg = 'Please enter user id password and choose user type.';
        }

    }
}elseif(isset($_COOKIE['user_id'])){//如果用户已经登录，则直接跳转到已经登录页面
    $home_url = 'loged.php';
    header('Location: '.$home_url);
}elseif(isset($_COOKIE['m_id'])){
    $home_url = 'managerhome.php';
    header('Location: '.$home_url);
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
        <title>Welcome to ZPRLX Airplane Company</title>
    </head>
    <body background="img/Columbia University.JPG">
      <p><font size="3" color="white">&nbsp;</font></p>
      <p><font size="3" color="white">&nbsp;</font></p>
      <p><center><font size="5" color="black">LX & ZPR &nbsp; Airplane &nbsp;  Corporation</font></center></p>
      <p><font size="3" color="white">&nbsp;</font></p>



        <!--通过$_COOKIE['user_id']进行判断，如果用户未登录，则显示登录表单，让用户输入用户名和密码-->
        <?php
        if(empty($_COOKIE['user_id'])||empty($_COOKIE['m_id'])){
            echo '<p class="error">'.$error_msg.'</p>';
        ?>
        <!-- $_SERVER['PHP_SELF']代表用户提交表单时，调用自身php文件 -->
        <form method = "post" action="<?php echo $_SERVER['PHP_SELF'];?>">

            <center><fieldset  style="width:250px;">
                <legend>Log In</legend><br>
                <label for="user_id">&nbsp;&nbsp;Username&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <!-- 如果用户已输过用户名，则回显用户名 -->
                <input type="text" name="user_id"><br>
                <br>
                <label for="password">&nbsp;&nbsp;Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <input type="password" name="user_pwd"><br>
                <br>

                <input type="radio" name="role" value="customer">&nbsp;Customer&nbsp;&nbsp;&nbsp;
                <input type="radio" name="role" value="manager">&nbsp;Manager <br>
                <br>
                <center><input type="submit" value="LAND" style="width:70px;" name="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" style="width:70px;" value="REGIST" name="Regist"></center>
            </fieldset></center>
        </form>

        <?php
        }
        ?>
    </body>
</html>

<?php
echo "&nbsp<br>";
echo "<center>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<img src=img/animated_20airplane.gif style=width:350px;height:240px;><center>";
?>

<!-- <html>
<body>
<img src=img/home.JPG>
</body>
</html> -->
