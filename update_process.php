<?php
require_once("./lib/sql.php");
require_once("./lib/print.php");
$conn = connection();
ini_set('display_errors', '0');
session_start();
if (!$_SESSION['UID']) {
    echo "<script>alert('회원 전용 게시판입니다.');history.back();</script>";
    exit;
}
$bid = $_POST["bid"];


$result = $conn->query("select * from board where bid=" . $bid) or die("query error => " . $conn->error);
$rs = $result->fetch_object();

//관리자 권한
$sql = "select * from members where userid ='" . $_SESSION['UID'] . "'";
$resultAdmin = $conn->query($sql);
$rsAdmin = $resultAdmin->fetch_object();

if (isset($rsAdmin->whoadmin)) { //관리자라면
    $sql = "UPDATE board SET subject = '$subject', content = '$content' WHERE bid=$bid";
    if ($conn->query($sql)) {
        echo "<script>alert('성공하였습니다(관리자 권한)');location.href=\"index.php\";</script>";
        exit;
    } else {
        echo "<script>alert('에러');history.back();</script>";
    }
    exit;
}

//본인인지 확인
if ($rs->userid != $_SESSION['UID']) {
    echo "<script>alert('본인 글이 아니면 삭제할 수 없습니다.');history.back();</script>";
    exit;
}



$subject = $_POST["subject"];
$content = $_POST["content"];

$userid = $_SESSION['UID']; //userid는 없어서 임의로 넣어줬다.
$status = 1; //status는 1이면 true, 0이면 false이다.

$sql = "UPDATE board
SET
subject = '$subject',
content = '$content'
WHERE
bid=$bid
";
SqlexeUpdate($conn, $sql);
