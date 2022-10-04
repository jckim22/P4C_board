<?php
$to = trim($_POST['form_user']); // 받는사람 메일주소 
$subject = '메일 인증';
$message = '메일 인증되셨습니다! 회원가입 후 서비스를 이용해주시길 바랍니다.';


// html 메일을 보낼 때 꼭 이헤더가 붙어야한다.
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=utf-8';

// Additional headers
//$headers[] = 'To: Kim<받는사람@gmail.com>';
$headers[] = 'From: webmaster<받는사람@gmail.com>';
//$headers[] = 'Cc: Kim1<참조인1@naver.com>,Kim2<참조인2@gmail.com>';
//$headers[] = 'Bcc: 숨은참조인3@gmail.com';


mail($to, $subject, $message, implode("\r\n", $headers));
echo "편지를 보냈습니다.";
	echo "<script language=javascript> alert('메일인증성공!'); location.replace('./signup.php'); </script>";

	
?>
