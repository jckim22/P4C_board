<?php
ini_set('display_errors', '0');

session_start();


require_once(".././lib/sql.php");
require_once(".././lib/print.php");
$conn = connection();


$userid=$_POST["userid"];
$passwd=$_POST["passwd"];
$passwd=hash('sha512',$passwd);

$sql = "select * from members where userid='".$userid."' and passwd='".$passwd."'";

$result = $conn->query($sql);

$rs=$result->fetch_object();

if($rs){
    $_SESSION['UID']= $rs->userid;
    $_SESSION['UNAME']= $rs->username;

    echo "<script>alert('{$_SESSION['UID']} 님 반갑습니다 !'); location.href='/';</script>";
    exit;

}else{
    echo "<script>alert('아이디나 암호가 틀렸습니다. 다시한번 확인해주십시오.');history.back();</script>";
    exit;
}
?>
