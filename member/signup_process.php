<?php
require_once(".././lib/sql.php");
require_once(".././lib/print.php");
$conn = connection();

$userid=$_POST["userid"];
$username=$_POST["username"];
$email=$_POST["email"];
$passwd=$_POST["passwd"];
$passwd=hash('sha512',$passwd);


$sql="INSERT INTO members
        (userid, email, username, passwd)
        VALUES('".$userid."', '".$email."', '".$username."', '".$passwd."')";

SqlexeMember($conn,$sql);
?>