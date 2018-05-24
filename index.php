<?php

session_start();
include 'db.php';
if(isset($_POST['submit'])) {
//$_POST['username'];
//$_POST['password'];

$username = $_POST['username'];
$password = $_POST['password'];
$result = mySQL_Query("SELECT * FROM `users` WHERE `username`='$username' AND `password`='$password'");
if(mySQL_Num_Rows($result)==1)
{
  echo "Correct";
  $_SESSION['username']=$username;
  header("Location: map.php");
  exit;
}
else {
  echo "Wrong";
}
}

?>

<html>
<style>
body{
  background: #eee;
}

#frm{

    border: solid gray 1px;
    width: 20%;
    border-radius: 5px;
    background: white;
    padding: 50px;
}

#btn{
  color: #fff;
  background: #337ab7;
  padding: 5px;
  margin-left: 69%;

}

</style>
<body>
<div id="frm">
<h2> LOGIN FORM </h2>


<form action="index.php" method="POST">

USERNAME: <br><input type="username" id="username" value=""  name="username" ><br><br>
PASSWORD: <br><input type="password" id="pass" value="" name="password"><br><br>
<input type="submit" id="btn"  value="LoG In"  name="submit" >

 </form>

</div>
</body>
</html>
