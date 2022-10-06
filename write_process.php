<?php
require_once("./lib/sql.php");
require_once("./lib/print.php");
$conn = connection();

if (!$_SESSION['UID']) {
    echo "<script>alert('회원 전용 게시판입니다.');history.back();</script>";
    exit;
}


$subject = $_POST["subject"];
$content = $_POST["content"];
$userid = $_SESSION['UID']; //userid는 없어서 임의로 넣어줬다.
$status = 1; //status는 1이면 true, 0이면 false이다.





$sql = "insert into board (userid,subject,content) values ('{$userid}','" . $subject . "','" . $content . "')";
$result = $conn->query($sql) or die($conn->error);
if(!isset($bid))$bid = $conn -> insert_id; //입력되는 bid값을 담는다

if ($_FILES["upfile"]["name"]) { //첨부한 파일이 있으면

    if ($_FILES['upfile']['size'] > 10240000) { //10메가
        echo "<script>alert('10메가 이하만 첨부할 수 있습니다.');history.back();</script>";
        exit;
    }

    // if ($_FILES['upfile']['type'] != 'image/jpeg' and $_FILES['upfile']['type'] != 'image/gif' and $_FILES['upfile']['type'] != 'image/png') { //이미지가 아니면, 다른 type은 and로 추가
    //     echo "<script>alert('이미지만 첨부할 수 있습니다.');history.back();</script>";
    //     exit;
    // }

    $save_dir = $_SERVER['DOCUMENT_ROOT'] . "./data"; //파일을 업로드할 디렉토리
    $filename = $_FILES["upfile"]["name"];
    $ext = pathinfo($filename, PATHINFO_EXTENSION); //확장자 구하기
    $newfilename = date("YmdHis") . substr(rand(), 0, 6);
    $upfile = $newfilename . "." . $ext; //새로운 파일이름과 확장자를 합친다

    if (move_uploaded_file($_FILES["upfile"]["tmp_name"], $save_dir . $upfile)) { //파일 등록에 성공하면 디비에 등록해준다.
        $sql = "INSERT INTO file_table (bid, userid, filename) VALUES(" . $bid . ", '" . $_SESSION['UID'] . "', '" . $upfile . "')";
        $result = $conn->query($sql) or die($conn->error);
    }
}


if ($result) {

    echo "<script>alert('성공했습니다.');
        location.href=\"index.php\"
        </script>";
} else {
    echo "<script>
    alert('에러가 발생했습니다. 관리자에게 문의 주세요. (010-2856-4221)');
    </script>";
    error_log(mysqli_error($conn));
}
