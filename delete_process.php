<?php
require_once("./lib/sql.php");
require_once("./lib/print.php");
$conn=connection();

if(!$_SESSION['UID']){
    echo "<script>alert('회원 전용 게시판입니다.');history.back();</script>";
    exit;
}

$bid=$_POST["bid"];

if(isset($bid)){//bid가 있다는건 수정이라는 의미다.

    $result = $conn->query("select * from board where bid=".$bid) or die("query error => ".$conn->error);
    $rs = $result->fetch_object();

    if($rs->userid!=$_SESSION['UID']){
        echo "<script>alert('본인 글이 아니면 삭제할 수 없습니다.');history.back();</script>";
        exit;
    }

}





$sql="
DELETE
FROM board
WHERE bid=$bid; 
";//status값을 바꿔주고 숨기는 방법이 있지만 일단은 삭제하겠다.
Sqlexe($conn,$sql);
