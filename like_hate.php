<?php
ini_set( 'display_errors', '0' );
session_start();


require_once("./lib/sql.php");
require_once("./lib/print.php");

$mysqli=connection();

unset($rsc);    

if (!$_SESSION['UID']) {
    $retun_data = array("result" => "member");
    echo json_encode($retun_data);
    exit;
}

$bid = $_POST['bid'];
$type = $_POST['type'];


$resultcheck = $mysqli->query("select reid from recommend where userid='".$_SESSION['UID']."' and bid=".$bid) or die("query error => ".$mysqli->error);//동일한 게시물에 대해 추천이나 반대를 한 기록이 있는지 확인
$rsc = $resultcheck->fetch_object();

if($rsc->reid){
    $retun_data = array("result"=>"check");
    echo json_encode($retun_data);
    exit;
}

$sql = "INSERT INTO recommend
(bid, userid, type)
VALUES(" . $bid . ", '" . $_SESSION['UID'] . "', '" . $type . "')";
$mysqli->query($sql) or die($mysqli->error); //어떤 게시물에 누가 추천이나 반대를 했는지 저장

$result = $mysqli->query("select count(*) as cnt from recommend where type='" . $type . "' and bid=" . $bid) or die("query error => " . $mysqli->error); //해당 게시물에 추천이나 반대가 몇개인지 확인
$rs = $result->fetch_object();

if ($result) {
    $retun_data = array("result" => "ok", "cnt" => $rs->cnt);
    echo json_encode($retun_data);
} else {
    $retun_data = array("result" => "no");
    echo json_encode($retun_data);
}

?>