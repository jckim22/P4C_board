<?php
ini_set('display_errors', '0');

session_start();
require_once("./lib/sql.php");
require_once("./lib/print.php");
$mysqli = connection();


$memoid = $_POST['memoid'];

// //관리자 권한
// $sql = "select * from members where userid ='" . $_SESSION['UID'] . "'";
// $resultAdmin = $mysqli->query($sql);
// $rsAdmin = $resultAdmin->fetch_object();

// if (isset($rsAdmin->whoadmin)) { //관리자라면
//     $sql = "DELETE FROM memo WHERE memoid=" . $memoid;
//     if ($conn->query($sql)) {
//         echo "<script>alert('성공하였습니다(관리자 권한)');location.href=\"index.php\";</script>";
//         $retun_data = array("result" => "ok");
//         echo json_encode($retun_data);
//     } else {
//         echo "<script>alert('에러');history.back();</script>";
//     }
//     exit;
// }

if (!$_SESSION['UID']) {
    $retun_data = array("result" => "member");
    echo json_encode($retun_data);
    exit;
}


$result = $mysqli->query("select * from memo where memoid=" . $memoid) or die("query error => " . $mysqli->error);
$rs = $result->fetch_object();

if ($rs->userid != $_SESSION['UID']) {
    $retun_data = array("result" => "my");
    echo json_encode($retun_data);
    exit;
}


$sql =
    "DELETE
FROM memo
WHERE memoid=" . $memoid; //status값을 바꿔주고 숨기는 방법이 있지만 일단은 삭제하겠다.

$result = $mysqli->query($sql) or die($mysqli->error);
if ($result) {
    $retun_data = array("result" => "ok");
    echo json_encode($retun_data);
} else {
    $retun_data = array("result" => "no");
    echo json_encode($retun_data);
}
