<?php
$_host="localhost";
$_username="root";
$_password="";
$_name="assignment";


mySQL_Connect("$_host","$_username","$_password") or die ("not connected" );
mySQL_Select_Db("$_name") or die ("not found");


 ?>
