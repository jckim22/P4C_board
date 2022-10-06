<?php
ini_set( 'display_errors', '0' );

session_start();
require_once("./lib/sql.php");
require_once("./lib/print.php");
$mysqli=connection();



if(!$_SESSION['UID']){
    $retun_data = array("result"=>"member");
    echo json_encode($retun_data);
    exit;
}

$memoid = $_POST['memoid'];

$result = $mysqli->query("select * from memo where memoid=".$memoid) or die("query error => ".$mysqli->error);
$rs = $result->fetch_object();

if($rs->userid!=$_SESSION['UID']){
    $retun_data = array("result"=>"my");
    echo json_encode($retun_data);
    exit;
}

$sql=
"DELETE
FROM memo
WHERE memoid=".$memoid;//status값을 바꿔주고 숨기는 방법이 있지만 일단은 삭제하겠다.

$result=$mysqli->query($sql) or die($mysqli->error);
if($result){
    $retun_data = array("result"=>"ok");
    echo json_encode($retun_data);
}else{
    $retun_data = array("result"=>"no");
    echo json_encode($retun_data);
}

?>