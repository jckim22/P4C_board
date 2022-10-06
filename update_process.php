<?php
require_once("./lib/sql.php");
require_once("./lib/print.php");
$conn=connection();

if(!$_SESSION['UID']){
    echo "<script>alert('회원 전용 게시판입니다.');history.back();</script>";
    exit;
}


$subject=$_POST["subject"];
$content=$_POST["content"];
$bid=$_POST["bid"];
$userid=$_SESSION['UID'];//userid는 없어서 임의로 넣어줬다.
$status=1;//status는 1이면 true, 0이면 false이다.

$sql="UPDATE board
SET
subject = '$subject',
content = '$content'
WHERE
bid=$bid
";
SqlexeUpdate($conn,$sql);

?>