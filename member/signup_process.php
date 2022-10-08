<?php
session_start();
require_once(".././lib/sql.php");
require_once(".././lib/print.php");
$conn = connection();

include('PHPMailer/src/Exception.php');
include('PHPMailer/src/PHPMailer.php');
include('PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


ini_set('display_errors', '0');




$userid = $_POST["userid"];
$username = $_POST["username"];
$email = $_POST["email"];
$passwd = $_POST["passwd"];
$passwd = hash('sha512', $passwd);

if (isset($_POST['userid']) && !empty($_POST['userid']) and isset($_POST['email']) && !empty($_POST['email'])) {
    if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
        // Return Error - Invalid Email
        $msg = '이메일을 형식에 맞게 입력해주세요.';
    } else {
        // Return Success - Valid Email
        $msg = '회원님의 계정이 만들어졌습니다, 회원님의 이메일로 전송된 활성화 링크를 클릭하여 확인해주세요';
    }

    $hash = md5(rand(0, 1000));
}



$sql = "INSERT INTO members
        (userid, email, username, passwd, hash)
        VALUES('" . $userid . "', '" . $email . "', '" . $username . "', '" . $passwd . "', '" . $hash . "')";

$mail = new PHPMailer(true);
$mail->IsSMTP();



$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Port = 465;
$mail->SMTPSecure = "ssl";
$mail->Username   = "jckim229@gmail.com";
$mail->Password   = "weulayvxmlgdclsj";
$mail->CharSet = "utf-8";

$mail->SetFrom('uz.56764@gmail.com', 'email verify');
$mail->AddAddress($email, $userid);

$mail->Subject = 'Jckim2 P4C board 이메일 인증';       
$mail->MsgHTML("URL을 클릭하여 계정을 활성화 해주세요 ! 
http://jckim2.dothome.co.kr/member/verify.php?email=$email&hash=$hash");

$mail->send();





SqlexeMember($conn, $sql);

?>