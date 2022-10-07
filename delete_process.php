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
$board='board';
$bid = $_POST["bid"];
$id = $_POST['id'];

if (isset($bid)) {



    //관리자 권한
    $sql = "select * from members where userid ='".$_SESSION['UID']."'";
    $resultAdmin = $conn->query($sql);
    $rsAdmin = $resultAdmin->fetch_object();

    if (isset($rsAdmin->whoadmin)) { //관리자라면
        if($id==2){
            $board='board2';
        }
        $sql = "DELETE FROM $board WHERE bid=$bid; "; //status값을 바꿔주고 숨기는 방법이 있지만 일단은 삭제하겠다.
        if($conn->query($sql)){
        echo "<script>alert('성공하였습니다(관리자 권한)');location.href=\"index.php\";</script>";
        exit;
        
        }else{
            echo "<script>alert('에러');history.back();</script>";
            
        }
        exit;
    }
    
    $board='board2';
    $result = $conn->query("select * from $board where bid=" . $bid) or die("query error => " . $conn->error);
    $rs = $result->fetch_object();

    //본인인지 확인
    if ($rs->userid != $_SESSION['UID']) {
        echo "<script>alert('본인 글이 아니면 삭제할 수 없습니다.');history.back();</script>";
        exit;
    }
}

$sql = "
DELETE
FROM $board
WHERE bid=$bid; 
"; //status값을 바꿔주고 숨기는 방법이 있지만 일단은 삭제하겠다.
Sqlexe($conn, $sql);
